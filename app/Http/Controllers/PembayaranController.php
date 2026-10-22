<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use App\Models\Pembayaran;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        return view('admin.pembayaran.index')
            ->with('pageTitle', 'Pembayaran');
    }

    /**
     * Data pembayaran untuk DataTables.
     * Pembayaran yang baru dibuat ditampilkan terlebih dahulu.
     */
    public function data(Request $request)
    {
        $query = Pembayaran::query()
            ->leftJoin(
                'rentals',
                'pembayarans.rental_id',
                '=',
                'rentals.id'
            )
            ->leftJoin(
                'users',
                'rentals.user_id',
                '=',
                'users.id'
            )
            ->leftJoin(
                'mobils',
                'rentals.mobil_id',
                '=',
                'mobils.id'
            )
            ->leftJoin(
                'metode_pembayarans',
                'pembayarans.metode_pembayaran_id',
                '=',
                'metode_pembayarans.id'
            )
            ->select(
                'pembayarans.*',
                'users.name as user_name',
                'mobils.name as mobil_name',
                'metode_pembayarans.name as metode_name'
            );

        // Total semua data pembayaran.
        $recordsTotal = Pembayaran::count();

        // Pencarian.
        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where(
                    'users.name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'mobils.name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'metode_pembayarans.name',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'pembayarans.status',
                    'like',
                    "%{$search}%"
                );
            });
        }

        // Total data setelah pencarian.
        $recordsFiltered = (clone $query)->count(
            'pembayarans.id'
        );

        /*
         * Default selalu berdasarkan pembayaran yang terakhir dibuat.
         * Urutan DataTables dari browser tidak digunakan agar tidak
         * mengalahkan urutan pembayaran terbaru.
         */
        $query->reorder()
            ->orderByDesc('pembayarans.created_at')
            ->orderByDesc('pembayarans.id');

        // Pagination DataTables.
        $start = max(
            0,
            (int) $request->input('start', 0)
        );

        $length = (int) $request->input('length', 10);

        $length = min(max($length, 1), 100);

        $pembayarans = $query
            ->offset($start)
            ->limit($length)
            ->get();

        $data = $pembayarans->map(function ($pembayaran) {
            return [
                'id' => $pembayaran->id,

                'user_name' => $pembayaran->user_name ?? '-',

                'mobil_name' => $pembayaran->mobil_name ?? '-',

                'metode_name' => $pembayaran->metode_name ?? '-',

                'tanggal_bayar' => $pembayaran->tanggal_bayar
                    ? \Illuminate\Support\Carbon::parse(
                        $pembayaran->tanggal_bayar
                    )->format('d/m/Y')
                    : '-',

                'jumlah' => (float) $pembayaran->jumlah,

                'bukti' => $pembayaran->bukti,

                'status' => $pembayaran->status,
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
     * Detail pembayaran untuk modal popup.
     */
   

public function detail(Pembayaran $pembayaran)
{
    $pembayaran->load([
        'rental.user',
        'rental.mobil',
        'rental.cabangAmbil',
        'rental.cabangKembali',
        'metodePembayaran',
    ]);

    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'message' => 'Silakan login terlebih dahulu.',
        ], 401);
    }

    if (
        (int) $user->roles_id === 3 &&
        (int) $pembayaran->rental->user_id !== (int) $user->id
    ) {
        return response()->json([
            'message' => 'Anda tidak berhak mengakses pembayaran ini.',
        ], 403);
    }

    $rental = $pembayaran->rental;

    return response()->json([
        'pelanggan' => $rental->user->name ?? '-',
        'email' => $rental->user->email ?? '-',
        'mobil' => $rental->mobil->name ?? '-',
        'plat' => $rental->mobil->plate_number ?? '-',
        'metode' => $pembayaran->metodePembayaran->nama ?? '-',
        'tanggal_bayar' => $pembayaran->tanggal_bayar
            ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d/m/Y')
            : '-',
        'jumlah' => (float) $pembayaran->jumlah,
        'status' => $pembayaran->status,
        'bukti_url' => $pembayaran->bukti
            ? asset('storage/' . $pembayaran->bukti)
            : null,

        'rental' => [
            'id' => $rental->id,
            'status' => $rental->status,
            'tanggal_mulai' => $rental->tanggal_mulai
                ? \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y')
                : '-',
            'tanggal_selesai' => $rental->tanggal_selesai
                ? \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y')
                : '-',
            'jumlah_hari' => (int) ($rental->jumlah_hari ?? 0),
            'harga_perhari' => (float) ($rental->harga_perhari ?? 0),
            'cabang_ambil' => $rental->cabangAmbil->name ?? '-',
            'cabang_kembali' => $rental->cabangKembali->name ?? '-',
            'subtotal' => (float) ($rental->subtotal ?? 0),
            'deposit' => (float) ($rental->deposit ?? 0),
            'diskon' => (float) ($rental->diskon ?? 0),
            'total_harga' => (float) ($rental->total_harga ?? 0),
        ],
    ]);
}


    /**
     * Mengambil metode pembayaran milik cabang.
     * Jika cabang belum memiliki metode, gunakan metode pusat.
     */
    private function metodeUntukCabang($cabangId)
    {
        $milikCabang = MetodePembayaran::where(
            'cabang_id',
            $cabangId
        )
            ->orderBy('name')
            ->get();

        if ($milikCabang->isNotEmpty()) {
            return $milikCabang;
        }

        return MetodePembayaran::whereNull('cabang_id')
            ->orderBy('name')
            ->get();
    }

    /**
     * Halaman pembayaran customer.
     */
    public function create(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        if ($rental->status !== 'Disetujui') {
            return redirect()
                ->route('customer.dashboard')
                ->with('error', 'Rental belum disetujui.');
        }

        $metodePembayarans = $this->metodeUntukCabang(
            $rental->cabang_ambil_id
        );

        return view(
            'customer.pembayaran.create',
            compact('rental', 'metodePembayarans')
        );
    }

    /**
     * Menyimpan pembayaran customer.
     */
    public function store(Request $request, Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        // Pembayaran hanya untuk rental yang disetujui.
        if ($rental->status !== 'Disetujui') {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Rental belum disetujui.',
                ], 422);
            }

            return redirect()
                ->route('customer.dashboard')
                ->with('error', 'Rental belum disetujui.');
        }

        // Satu pembayaran aktif per rental.
        // Upload ulang dapat dilakukan setelah pembayaran ditolak.
        $adaAktif = Pembayaran::where(
            'rental_id',
            $rental->id
        )
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->exists();

        if ($adaAktif) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' =>
                        'Rental ini sudah memiliki pembayaran aktif.',
                ], 422);
            }

            return redirect()
                ->route('customer.dashboard')
                ->with(
                    'error',
                    'Rental ini sudah memiliki pembayaran aktif.'
                );
        }

        $validated = $request->validate([
            'metode_pembayaran_id' =>
                'required|exists:metode_pembayarans,id',

            'tanggal_bayar' =>
                'required|date|before_or_equal:today',

            'bukti' =>
                'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'metode_pembayaran_id.required' =>
                'Metode pembayaran wajib dipilih.',

            'metode_pembayaran_id.exists' =>
                'Metode pembayaran tidak valid.',

            'tanggal_bayar.required' =>
                'Tanggal pembayaran wajib diisi.',

            'tanggal_bayar.date' =>
                'Tanggal pembayaran tidak valid.',

            'tanggal_bayar.before_or_equal' =>
                'Tanggal pembayaran tidak boleh melebihi hari ini.',

            'bukti.required' =>
                'Bukti pembayaran wajib diupload.',

            'bukti.image' =>
                'File bukti harus berupa gambar.',

            'bukti.mimes' =>
                'Bukti harus berformat JPG, JPEG, atau PNG.',

            'bukti.max' =>
                'Ukuran bukti maksimal 2 MB.',
        ]);

        // Pastikan metode pembayaran sesuai cabang rental.
        $metodeAllowed = $this->metodeUntukCabang(
            $rental->cabang_ambil_id
        )->contains(
            'id',
            (int) $validated['metode_pembayaran_id']
        );

        if (! $metodeAllowed) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' =>
                        'Metode pembayaran tidak tersedia untuk cabang ini.',

                    'errors' => [
                        'metode_pembayaran_id' => [
                            'Metode pembayaran tidak tersedia untuk cabang ini.',
                        ],
                    ],
                ], 422);
            }

            return back()
                ->withErrors([
                    'metode_pembayaran_id' =>
                        'Metode pembayaran tidak tersedia untuk cabang ini.',
                ])
                ->withInput();
        }

        // Simpan bukti pembayaran.
        $path = $request->file('bukti')->store(
            'bukti_pembayaran',
            'public'
        );

        // created_at akan diisi otomatis oleh Eloquent jika
        // timestamps aktif pada model Pembayaran.
        Pembayaran::create([
            'rental_id' => $rental->id,

            'metode_pembayaran_id' =>
                $validated['metode_pembayaran_id'],

            'tanggal_bayar' => $validated['tanggal_bayar'],

            'jumlah' => $rental->total_harga,

            'bukti' => $path,

            'status' => 'Menunggu',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Bukti pembayaran berhasil dikirim.',
            ]);
        }

        return redirect()
            ->route('customer.dashboard')
            ->with(
                'success',
                'Bukti pembayaran berhasil dikirim.'
            );
    }

    /**
     * Memperbarui status pembayaran.
     */
    public function updateStatus(
        Request $request,
        Pembayaran $pembayaran
    ) {
        // Customer tidak boleh mengubah status pembayaran.
        if (auth()->user()->roles_id === 3) {
            abort(
                403,
                'Anda tidak memiliki akses untuk mengubah status pembayaran.'
            );
        }

        $validated = $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        // Status yang sudah diputuskan tidak dapat diubah lagi.
        if ($pembayaran->status !== 'Menunggu') {
            return response()->json([
                'message' =>
                    'Pembayaran yang sudah diputuskan tidak dapat diubah lagi.',
            ], 422);
        }

        $pembayaran->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' =>
                'Status pembayaran berhasil diperbarui menjadi '
                . $validated['status'] . '.',
        ]);
    }
}
