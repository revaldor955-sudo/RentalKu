<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DendaController extends Controller
{
    private const TARIF_DENDA = [
        'kehilangan' => 500000,
        'kerusakan' => 300000,
        'keterlambatan' => 200000,
    ];

    public function index()
    {
        $rentals = Rental::with(['mobil', 'user'])
            ->where('status', 'Selesai')
            ->latest('id')
            ->get();

        return view('dendas.index', compact('rentals'))
            ->with('pageTitle', 'Denda');
    }

    public function data(Request $request)
    {
        $query = Denda::query()
            ->leftJoin('rentals', 'dendas.rental_id', '=', 'rentals.id')
            ->leftJoin('users', 'rentals.user_id', '=', 'users.id')
            ->leftJoin('mobils', 'rentals.mobil_id', '=', 'mobils.id')
            ->select('dendas.*')
            ->with(['rental.mobil', 'rental.user']);

        $recordsTotal = Denda::count();
        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('dendas.jenis', 'like', "%{$search}%")
                    ->orWhere('dendas.status', 'like', "%{$search}%")
                    ->orWhere('dendas.deskripsi', 'like', "%{$search}%")
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

        $recordsFiltered = (clone $query)->count('dendas.id');

        $columns = [
            0 => null,
            1 => 'users.name',
            2 => 'mobils.name',
            3 => 'dendas.jenis',
            4 => null,
            5 => 'dendas.nominal',
            6 => 'dendas.status',
            7 => 'dendas.created_at',
            8 => null,
            9 => null,
        ];

        $orderColumn = $request->input('order.0.column');
        $direction = strtolower((string) $request->input('order.0.dir', 'desc'));
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        if (
            $orderColumn !== null &&
            isset($columns[$orderColumn]) &&
            $columns[$orderColumn] !== null
        ) {
            $query->orderBy($columns[$orderColumn], $direction);
        }

        $query->orderByDesc('dendas.created_at')
            ->orderByDesc('dendas.id');

        $start = max(0, (int) $request->input('start', 0));
        $requestedLength = (int) $request->input('length', 10);
        $length = $requestedLength === -1
            ? 100
            : min(max($requestedLength, 1), 100);

        $dendas = $query->offset($start)->limit($length)->get();

        $data = $dendas->map(function ($item) {
            return [
                'id' => $item->id,
                'rental_id' => $item->rental_id,
                'mobil_name' => $item->rental?->mobil?->name ?? '-',
                'mobil_plate' => $item->rental?->mobil?->plate_number ?? '-',
                'pelanggan' => $item->rental?->user?->name ?? '-',
                'jenis' => $item->jenis,
                'nominal' => (float) $item->nominal,
                'deskripsi' => $item->deskripsi
                    ?? $item->syarat_dan_ketentuan
                    ?? '-',
                'foto_bukti' => $item->foto_bukti,
                'syarat_dan_ketentuan' => $item->syarat_dan_ketentuan,
                'status' => $item->status,
                'bukti_bayar_url' => $item->bukti_bayar
                    ? asset('storage/' . $item->bukti_bayar)
                    : null,
                'tanggal_bayar' => $item->tanggal_bayar
                    ? Carbon::parse($item->tanggal_bayar)->format('d/m/Y')
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:keterlambatan,kerusakan,kehilangan',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'syarat_dan_ketentuan' => 'nullable|string',
            'status' => 'required|in:belum bayar',
            'deskripsi' => 'required|string|max:2000',
        ], [
            'rental_id.required' => 'Rental wajib dipilih.',
            'rental_id.exists' => 'Rental yang dipilih tidak ditemukan.',
            'jenis.required' => 'Jenis denda wajib dipilih.',
            'jenis.in' => 'Jenis denda tidak valid.',
            'foto_bukti.image' => 'Foto bukti harus berupa gambar.',
            'foto_bukti.mimes' => 'Foto bukti harus JPG, JPEG, atau PNG.',
            'foto_bukti.max' => 'Ukuran foto maksimal 2 MB.',
            'status.in' => 'Denda baru harus berstatus belum bayar.',
            'deskripsi.required' => 'Deskripsi denda wajib diisi.',
        ]);

        $rental = Rental::findOrFail($validated['rental_id']);

        if ($rental->status !== 'Selesai') {
            return response()->json([
                'message' => 'Denda manual hanya bisa dibuat untuk rental yang sudah selesai.',
            ], 422);
        }

        // Tarif ditentukan sistem, bukan dari input pengguna.
        $validated['nominal'] = self::TARIF_DENDA[$validated['jenis']];

        if ($validated['jenis'] === 'keterlambatan') {
            $validated['deskripsi'] =
                'Tarif keterlambatan Rp200.000 per hari. '
                . $validated['deskripsi'];
        }

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

        return response()->json([
            'message' => 'Denda berhasil ditambahkan.',
        ], 201);
    }

    public function update(Request $request, Denda $denda)
    {
        if ($denda->status === 'lunas') {
            return response()->json([
                'message' => 'Denda yang sudah lunas tidak dapat diedit.',
            ], 422);
        }

        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:keterlambatan,kerusakan,kehilangan',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'syarat_dan_ketentuan' => 'nullable|string',
            'status' => 'required|in:belum bayar,menunggu verifikasi',
            'deskripsi' => 'required|string|max:2000',
        ], [
            'rental_id.required' => 'Rental wajib dipilih.',
            'rental_id.exists' => 'Rental tidak ditemukan.',
            'jenis.required' => 'Jenis denda wajib dipilih.',
            'jenis.in' => 'Jenis denda tidak valid.',
            'foto_bukti.image' => 'Foto bukti harus berupa gambar.',
            'foto_bukti.mimes' => 'Foto bukti harus JPG, JPEG, atau PNG.',
            'foto_bukti.max' => 'Ukuran foto maksimal 2 MB.',
            'status.in' => 'Status denda tidak valid.',
            'deskripsi.required' => 'Deskripsi denda wajib diisi.',
        ]);

        if (
            $validated['status'] === 'menunggu verifikasi' &&
            !$denda->bukti_bayar
        ) {
            return response()->json([
                'message' => 'Status menunggu verifikasi memerlukan bukti pembayaran.',
            ], 422);
        }

        $rental = Rental::findOrFail($validated['rental_id']);

        if ($rental->status !== 'Selesai') {
            return response()->json([
                'message' => 'Pilih rental yang sudah selesai.',
            ], 422);
        }

        $jenisLama = $denda->jenis;
        $jenisBaru = $validated['jenis'];

        if ($jenisBaru === 'keterlambatan') {
            // Pertahankan hasil hitung harian jika denda ini
            // memang sudah merupakan denda keterlambatan.
            $validated['nominal'] = $jenisLama === 'keterlambatan'
                ? $denda->nominal
                : self::TARIF_DENDA['keterlambatan'];

            if (
                $jenisLama !== 'keterlambatan' &&
                !str_contains(
                    $validated['deskripsi'],
                    'Tarif keterlambatan Rp200.000 per hari.'
                )
            ) {
                $validated['deskripsi'] =
                    'Tarif keterlambatan Rp200.000 per hari. '
                    . $validated['deskripsi'];
            }
        } else {
            $validated['nominal'] = self::TARIF_DENDA[$jenisBaru];
        }

        if ($request->hasFile('foto_bukti')) {
            $directory = public_path('images/dendas');

            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $file = $request->file('foto_bukti');
            $fileName = uniqid('denda_', true)
                . '.' . $file->getClientOriginalExtension();

            $file->move($directory, $fileName);

            if (
                $denda->foto_bukti &&
                File::exists(public_path($denda->foto_bukti))
            ) {
                File::delete(public_path($denda->foto_bukti));
            }

            $validated['foto_bukti'] = 'images/dendas/' . $fileName;
        }

        $denda->update($validated);

        return response()->json([
            'message' => 'Denda berhasil diperbarui.',
        ]);
    }

    public function destroy(Request $request, Denda $denda)
    {
        if ($denda->status === 'lunas') {
            return response()->json([
                'message' => 'Denda yang sudah lunas tidak dapat dihapus.',
            ], 422);
        }

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

        return response()->json([
            'message' => 'Denda berhasil dihapus.',
        ]);
    }

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
            return back()->withErrors([
                'denda' => 'Denda sudah dibayar atau sedang diverifikasi.',
            ]);
        }

        $validated = $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_bayar' => 'required|date|before_or_equal:today',
        ], [
            'bukti_bayar.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_bayar.image' => 'Bukti harus berupa gambar.',
            'bukti_bayar.mimes' => 'Bukti harus JPG, JPEG, atau PNG.',
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

        return redirect()->route('customer.dashboard')
            ->with('success', 'Bukti pembayaran denda berhasil dikirim.');
    }

    public function updateStatus(Request $request, Denda $denda)
    {
        $user = auth()->user();

        if (!$user || (int) $user->roles_id === 3) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah status denda.');
        }

        $validated = $request->validate([
            'status' => 'required|in:belum bayar,lunas',
        ]);

        if (
            $validated['status'] === 'lunas' &&
            !$denda->bukti_bayar
        ) {
            return response()->json([
                'message' => 'Denda belum bisa dilunaskan karena belum ada bukti pembayaran.',
            ], 422);
        }

        $denda->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => $validated['status'] === 'lunas'
                ? 'Pembayaran denda berhasil diverifikasi.'
                : 'Bukti pembayaran ditolak. Pelanggan dapat mengunggah ulang.',
        ]);
    }
}
