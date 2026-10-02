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
        return view('admin.pembayaran.index')->with('pageTitle', 'Pembayaran');
    }

    public function data(Request $request)
    {
        $query = Pembayaran::query()
            ->leftJoin('rentals', 'pembayarans.rental_id', '=', 'rentals.id')
            ->leftJoin('users', 'rentals.user_id', '=', 'users.id')
            ->leftJoin('mobils', 'rentals.mobil_id', '=', 'mobils.id')
            ->leftJoin('metode_pembayarans', 'pembayarans.metode_pembayaran_id', '=', 'metode_pembayarans.id')
            ->select(
                'pembayarans.*',
                'users.name as user_name',
                'mobils.name as mobil_name',
                'metode_pembayarans.name as metode_name'
            );

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('mobils.name', 'like', "%{$search}%")
                    ->orWhere('metode_pembayarans.name', 'like', "%{$search}%")
                    ->orWhere('pembayarans.status', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'users.name',
            2 => null,
            3 => 'mobils.name',
            4 => 'metode_pembayarans.name',
            5 => 'pembayarans.tanggal_bayar',
            6 => 'pembayarans.jumlah',
            7 => 'pembayarans.status',
            8 => null,
        ];

        $orders = $request->input('order', [['column' => 5, 'dir' => 'desc']]);
        $applied = false;

        foreach ($orders as $o) {
            $c = $o['column'] ?? null;
            $d = (($o['dir'] ?? 'asc') === 'desc') ? 'desc' : 'asc';

            if (isset($columns[$c]) && $columns[$c]) {
                $query->orderBy($columns[$c], $d);
                $applied = true;
            }
        }

        if (! $applied) {
            $query->orderBy('pembayarans.tanggal_bayar', 'desc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $pembayarans = $query->offset($start)->limit($length)->get();

        $data = $pembayarans->map(function ($pembayaran) {
            return [
                'id' => $pembayaran->id,
                'user_name' => $pembayaran->user_name ?? '-',
                'mobil_name' => $pembayaran->mobil_name ?? '-',
                'metode_name' => $pembayaran->metode_name ?? '-',
                'tanggal_bayar' => $pembayaran->tanggal_bayar?->format('d/m/Y'),
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
     * Detail pembayaran untuk modal popup (AJAX)
     */
    public function detail(Pembayaran $pembayaran)
    {
        // Ownership check: customer hanya bisa lihat pembayaran rental sendiri
        if (auth()->user()->roles_id === 3 && $pembayaran->rental->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pembayaran ini.');
        }

        $pembayaran->load([
            'rental.user',
            'rental.mobil',
            'rental.cabangAmbil',
            'rental.cabangKembali',
            'metodePembayaran',
        ]);

        return response()->json([
            'id' => $pembayaran->id,
            'pelanggan' => $pembayaran->rental->user->name ?? '-',
            'email' => $pembayaran->rental->user->email ?? '-',
            'mobil' => $pembayaran->rental->mobil->name ?? '-',
            'plat' => $pembayaran->rental->mobil->plate_number ?? '-',
            'metode' => $pembayaran->metodePembayaran->name ?? '-',
            'tanggal_bayar' => $pembayaran->tanggal_bayar?->format('d/m/Y'),
            'jumlah' => (float) $pembayaran->jumlah,
            'bukti_url' => $pembayaran->bukti
                ? asset('storage/' . $pembayaran->bukti)
                : null,
            'status' => $pembayaran->status,
        ]);
    }

    /**
     * Rekening yang boleh dipakai untuk satu cabang: milik cabang itu;
     * kalau cabang belum punya, pakai milik pusat.
     */
    private function metodeUntukCabang($cabangId)
    {
        $milikCabang = MetodePembayaran::where('cabang_id', $cabangId)
            ->orderBy('name')
            ->get();

        if ($milikCabang->isNotEmpty()) {
            return $milikCabang;
        }

        return MetodePembayaran::whereNull('cabang_id')
            ->orderBy('name')
            ->get();
    }

    public function create(Rental $rental)
    {
        if ($rental->user_id != Auth::id()) {
            abort(403);
        }

        if ($rental->status !== 'Disetujui') {
            return redirect()->route('customer.dashboard')->with('error', 'Rental belum disetujui.');
        }

        $metodePembayarans = $this->metodeUntukCabang($rental->cabang_ambil_id);

        return view('customer.pembayaran.create', compact(
            'rental',
            'metodePembayarans'
        ));
    }

    public function store(Request $request, Rental $rental)
    {
        if ($rental->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
            'tanggal_bayar' => 'required|date',
            'bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'metode_pembayaran_id.required' => 'Metode pembayaran wajib dipilih.',
            'metode_pembayaran_id.exists' => 'Metode pembayaran tidak valid.',
            'tanggal_bayar.required' => 'Tanggal pembayaran wajib diisi.',
            'tanggal_bayar.date' => 'Tanggal pembayaran tidak valid.',
            'bukti.required' => 'Bukti pembayaran wajib diupload.',
            'bukti.image' => 'File bukti harus berupa gambar.',
            'bukti.mimes' => 'Bukti harus berformat JPG, JPEG, atau PNG.',
            'bukti.max' => 'Ukuran bukti maksimal 2 MB.',
        ]);

        $path = $request->file('bukti')->store(
            'bukti_pembayaran',
            'public'
        );

        // Metode harus milik cabang rental (atau pusat bila cabang belum punya).
        $metodeAllowed = $this->metodeUntukCabang($rental->cabang_ambil_id)
            ->contains('id', (int) $validated['metode_pembayaran_id']);

        if (! $metodeAllowed) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Metode pembayaran tidak tersedia untuk cabang ini.',
                    'errors' => ['metode_pembayaran_id' => ['Metode pembayaran tidak tersedia untuk cabang ini.']],
                ], 422);
            }

            return back()
                ->withErrors(['metode_pembayaran_id' => 'Metode pembayaran tidak tersedia untuk cabang ini.'])
                ->withInput();
        }

        Pembayaran::create([
            'rental_id' => $rental->id,
            'metode_pembayaran_id' => $validated['metode_pembayaran_id'],
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

        return redirect()->route('customer.dashboard')->with('success', 'Bukti pembayaran berhasil dikirim.');
    }

    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
        // Ownership check: customer tidak boleh update status
        if (auth()->user()->roles_id === 3) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah status pembayaran.');
        }

        $validated = $request->validate([
            'status' => 'required|in:Disetujui,Ditolak'
        ]);

        $pembayaran->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'message' => 'Status pembayaran berhasil diperbarui menjadi ' . $validated['status'] . '.',
        ]);
    }
}
