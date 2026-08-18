<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Rental;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * MANAGEMENT PEMBAYARAN ADMIN
     */
    public function index()
    {
        $pembayarans = Pembayaran::with([
            'rental.user',
            'rental.mobil',
            'metodePembayaran'
        ])
        ->latest()
        ->get();

        return view('admin.pembayaran.index', compact('pembayarans'));
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
            'status' => 'required|in:Disetujui,Ditolak',
        ]);

        $pembayaran->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('pembayarans.index')
            ->with(
                'success',
                'Status pembayaran berhasil diperbarui menjadi ' .
                $validated['status'] . '.'
            );
    }
}