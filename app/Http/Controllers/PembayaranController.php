<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use App\Models\Pembayaran;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * MANAGEMENT PEMBAYARAN ADMIN
     */
    public function index()
    {
        return view('admin.pembayaran.index');
    }

    /**
     * Server-side DataTables: daftar pembayaran (search, sort, pagination)
     */
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
            2 => 'mobils.name',
            3 => 'metode_pembayarans.name',
            4 => 'pembayarans.tanggal_bayar',
            5 => 'pembayarans.jumlah',
            6 => null,
            7 => 'pembayarans.status',
            8 => null,
        ];

        $orderColumn = $request->input('order.0.column', 4);
        $orderDir = $request->input('order.0.dir', 'desc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
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
     * FORM PEMBAYARAN CUSTOMER
     */
    public function create(Rental $rental)
    {
        if ($rental->user_id != Auth::id()) {
            abort(403);
        }

        if ($rental->status !== 'Disetujui') {
            return redirect()
                ->route('customer.dashboard')
                ->with('error', 'Rental belum disetujui.');
        }

        $metodePembayarans = MetodePembayaran::all();

        return view('customer.pembayaran.create', compact(
            'rental',
            'metodePembayarans'
        ));
    }

    /**
     * SIMPAN PEMBAYARAN CUSTOMER
     */
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

        Pembayaran::create([
            'rental_id' => $rental->id,
            'metode_pembayaran_id' => $validated['metode_pembayaran_id'],
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'jumlah' => $rental->total_harga,
            'bukti' => $path,
            'status' => 'Menunggu',
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Bukti pembayaran berhasil dikirim.');
    }

    /**
     * UPDATE STATUS PEMBAYARAN ADMIN
     */
    public function updateStatus(Request $request, Pembayaran $pembayaran)
    {
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
