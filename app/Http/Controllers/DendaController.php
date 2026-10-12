<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DendaController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['mobil', 'user'])
            ->where('status', 'Selesai')
            ->latest('id')
            ->get();

        return view('dendas.index', compact('rentals'))
            ->with('pageTitle', 'Denda');
    }

    /**
     * Server-side DataTables:
     * pencarian, pengurutan, dan pagination.
     * Data terbaru tampil paling atas secara default.
     */
    public function data(Request $request)
    {
        $query = Denda::query()
            ->leftJoin('rentals', 'dendas.rental_id', '=', 'rentals.id')
            ->leftJoin('users', 'rentals.user_id', '=', 'users.id')
            ->leftJoin('mobils', 'rentals.mobil_id', '=', 'mobils.id')
            ->select('dendas.*')
            ->with(['rental.mobil', 'rental.user']);

        // Total seluruh data sebelum pencarian.
        $recordsTotal = Denda::count();

        // Pencarian.
        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('dendas.jenis', 'like', "%{$search}%")
                    ->orWhere('dendas.status', 'like', "%{$search}%")
                    ->orWhereHas('rental.user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('rental.mobil', function ($mq) use ($search) {
                        $mq->where('name', 'like', "%{$search}%")
                            ->orWhere('plate_number', 'like', "%{$search}%");
                    });
            });
        }

        // Total data setelah pencarian.
        $recordsFiltered = (clone $query)->count('dendas.id');

        // Kolom yang boleh digunakan untuk pengurutan.
        $columns = [
            0 => null,
            1 => 'users.name',
            2 => 'mobils.name',
            3 => 'dendas.jenis',
            4 => 'dendas.nominal',
            5 => 'dendas.status',
            6 => 'dendas.created_at',
            7 => null,
            8 => null,
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDirection = strtolower(
            (string) $request->input('order.0.dir', 'desc')
        );

        $orderDirection = $orderDirection === 'asc' ? 'asc' : 'desc';

        // Jika pengguna memilih kolom yang dapat diurutkan,
        // ikuti pilihan tersebut.
        if (
            $orderColumn !== null &&
            isset($columns[$orderColumn]) &&
            $columns[$orderColumn] !== null
        ) {
            $query->orderBy($columns[$orderColumn], $orderDirection);

            // Jika nilai kolom sama, tampilkan data terbaru dahulu.
            $query->orderByDesc('dendas.created_at')
                ->orderByDesc('dendas.id');
        } else {
            // Urutan default: data terbaru terlebih dahulu.
            $query->orderByDesc('dendas.created_at')
                ->orderByDesc('dendas.id');
        }

        // Pagination DataTables.
        $start = max(0, (int) $request->input('start', 0));

        $requestedLength = (int) $request->input('length', 10);
        $length = $requestedLength === -1
            ? 100
            : min(max($requestedLength, 1), 100);

        $dendas = $query
            ->offset($start)
            ->limit($length)
            ->get();

        // Format data untuk DataTables.
        $data = $dendas->map(function ($item) {
            return [
                'id' => $item->id,
                'rental_id' => $item->rental_id,

                'mobil_name' => $item->rental?->mobil?->name ?? '-',
                'mobil_plate' => $item->rental?->mobil?->plate_number ?? '-',
                'pelanggan' => $item->rental?->user?->name ?? '-',

                'jenis' => $item->jenis,
                'nominal' => (float) $item->nominal,

                'foto_bukti' => $item->foto_bukti,
                'syarat_dan_ketentuan' => $item->syarat_dan_ketentuan,
                'status' => $item->status,

                'bukti_bayar_url' => $item->bukti_bayar
                    ? asset('storage/' . $item->bukti_bayar)
                    : null,

                'tanggal_bayar' => $item->tanggal_bayar
                    ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y')
                    : null,

                'created_at' => $item->created_at
                    ? $item->created_at->format('d/m/Y H:i')
                    : '-',
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    /**
     * Tambah denda.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:keterlambatan,kerusakan,kehilangan',
            'nominal' => 'required|numeric|min:0',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'syarat_dan_ketentuan' => 'nullable|string',
            'status' => 'required|in:belum bayar',
        ], [
            'rental_id.required' => 'Rental wajib dipilih.',
            'rental_id.exists' => 'Rental yang dipilih tidak ditemukan.',
            'jenis.required' => 'Jenis denda wajib dipilih.',
            'jenis.in' => 'Jenis denda tidak valid.',
            'nominal.required' => 'Nominal denda wajib diisi.',
            'nominal.numeric' => 'Nominal denda harus berupa angka.',
            'nominal.min' => 'Nominal denda tidak boleh negatif.',
            'foto_bukti.image' => 'Foto bukti harus berupa gambar.',
            'foto_bukti.mimes' => 'Foto bukti harus berformat JPG, JPEG, atau PNG.',
            'foto_bukti.max' => 'Ukuran foto maksimal 2 MB.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Denda baru harus berstatus belum bayar.',
        ]);

        // Denda hanya boleh dibuat untuk rental yang selesai.
        $rental = Rental::findOrFail($validated['rental_id']);

        if ($rental->status !== 'Selesai') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Denda hanya bisa dibuat untuk rental yang sudah selesai.',
                ], 422);
            }

            return back()
                ->withErrors([
                    'rental_id' => 'Denda hanya bisa dibuat untuk rental yang sudah selesai.',
                ])
                ->withInput();
        }

        // Upload foto bukti denda.
        if ($request->hasFile('foto_bukti')) {
            $directory = public_path('images/dendas');

            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $file = $request->file('foto_bukti');

            $fileName = uniqid('denda_', true)
                . '.' . $file->getClientOriginalExtension();

            $file->move($directory, $fileName);

            $validated['foto_bukti'] = 'images/dendas/' . $fileName;
        }

        Denda::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Denda berhasil ditambahkan.',
            ], 201);
        }

        return redirect()->route('dendas.index')
            ->with('success', 'Denda berhasil ditambahkan.');
    }

    /**
     * Perbarui data denda.
     */
    public function update(Request $request, Denda $denda)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:keterlambatan,kerusakan,kehilangan',
            'nominal' => 'required|numeric|min:0',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'syarat_dan_ketentuan' => 'nullable|string',
            'status' => 'required|in:belum bayar,lunas',
        ], [
            'rental_id.required' => 'Rental wajib dipilih.',
            'rental_id.exists' => 'Rental yang dipilih tidak ditemukan.',
            'jenis.required' => 'Jenis denda wajib dipilih.',
            'jenis.in' => 'Jenis denda tidak valid.',
            'nominal.required' => 'Nominal denda wajib diisi.',
            'nominal.numeric' => 'Nominal denda harus berupa angka.',
            'nominal.min' => 'Nominal denda tidak boleh negatif.',
            'foto_bukti.image' => 'Foto bukti harus berupa gambar.',
            'foto_bukti.mimes' => 'Foto bukti harus berformat JPG, JPEG, atau PNG.',
            'foto_bukti.max' => 'Ukuran foto maksimal 2 MB.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status denda tidak valid.',
        ]);

        // Status lunas harus memiliki bukti pembayaran.
        if ($validated['status'] === 'lunas' && !$denda->bukti_bayar) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Denda belum bisa dilunaskan karena belum ada bukti bayar.',
                ], 422);
            }

            return back()
                ->withErrors([
                    'status' => 'Denda belum bisa dilunaskan karena belum ada bukti bayar.',
                ])
                ->withInput();
        }

        // Ganti foto jika ada foto baru.
        if ($request->hasFile('foto_bukti')) {
            $directory = public_path('images/dendas');

            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $file = $request->file('foto_bukti');

            $fileName = uniqid('denda_', true)
                . '.' . $file->getClientOriginalExtension();

            $file->move($directory, $fileName);

            // Hapus foto lama setelah foto baru berhasil diunggah.
            if (
                $denda->foto_bukti &&
                File::exists(public_path($denda->foto_bukti))
            ) {
                File::delete(public_path($denda->foto_bukti));
            }

            $validated['foto_bukti'] = 'images/dendas/' . $fileName;
        }

        $denda->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Denda berhasil diperbarui.',
            ]);
        }

        return redirect()->route('dendas.index')
            ->with('success', 'Denda berhasil diperbarui.');
    }

    /**
     * Hapus denda.
     */
    public function destroy(Request $request, Denda $denda)
    {
        if (
            $denda->foto_bukti &&
            File::exists(public_path($denda->foto_bukti))
        ) {
            File::delete(public_path($denda->foto_bukti));
        }

        if ($denda->bukti_bayar) {
            Storage::disk('public')->delete($denda->bukti_bayar);
        }

        $denda->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Denda berhasil dihapus.',
            ]);
        }

        return redirect()->route('dendas.index')
            ->with('success', 'Denda berhasil dihapus.');
    }

    /**
     * Customer mengirim bukti pembayaran denda.
     */
    public function customerBayar(Request $request, Denda $denda)
    {
        $denda->load('rental');

        if (
            !$denda->rental ||
            (int) $denda->rental->user_id !== (int) auth()->id()
        ) {
            abort(403, 'Anda tidak memiliki akses ke denda ini.');
        }

        if ($denda->status !== 'belum bayar') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Denda ini sudah dibayar atau sedang diverifikasi.',
                ], 422);
            }

            return back()->withErrors([
                'denda' => 'Denda ini sudah dibayar atau sedang diverifikasi.',
            ]);
        }

        $validated = $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_bayar' => 'required|date|before_or_equal:today',
        ], [
            'bukti_bayar.required' => 'Bukti pembayaran denda wajib diunggah.',
            'bukti_bayar.image' => 'File bukti harus berupa gambar.',
            'bukti_bayar.mimes' => 'Bukti harus berformat JPG, JPEG, atau PNG.',
            'bukti_bayar.max' => 'Ukuran bukti maksimal 2 MB.',
            'tanggal_bayar.required' => 'Tanggal pembayaran wajib diisi.',
            'tanggal_bayar.date' => 'Tanggal pembayaran tidak valid.',
            'tanggal_bayar.before_or_equal' => 'Tanggal pembayaran tidak boleh melebihi hari ini.',
        ]);

        $path = $request->file('bukti_bayar')
            ->store('bukti_denda', 'public');

        $denda->update([
            'bukti_bayar' => $path,
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'status' => 'menunggu verifikasi',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Bukti pembayaran denda berhasil dikirim.',
            ]);
        }

        return redirect()->route('customer.dashboard')
            ->with('success', 'Bukti pembayaran denda berhasil dikirim.');
    }

    /**
     * Admin atau staff memverifikasi pembayaran denda.
     */
    public function updateStatus(Request $request, Denda $denda)
    {
        $user = auth()->user();

        if (!$user || (int) $user->roles_id === 3) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah status denda.');
        }

        $validated = $request->validate([
            'status' => 'required|in:belum bayar,lunas',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        if (
            $validated['status'] === 'lunas' &&
            !$denda->bukti_bayar
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Denda belum bisa dilunaskan karena belum ada bukti bayar.',
                ], 422);
            }

            return back()
                ->withErrors([
                    'status' => 'Denda belum bisa dilunaskan karena belum ada bukti bayar.',
                ])
                ->withInput();
        }

        $denda->update([
            'status' => $validated['status'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Status denda berhasil diperbarui menjadi '
                    . $validated['status'] . '.',
            ]);
        }

        return redirect()->back()
            ->with(
                'success',
                'Status denda berhasil diperbarui menjadi '
                    . $validated['status'] . '.'
            );
    }
}
