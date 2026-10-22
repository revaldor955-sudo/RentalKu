<?php

namespace App\Http\Controllers;

use App\Models\Rental;

class PengembalianController extends Controller
{
    public function index()
    {
        return view('pengembalian.index', [
            'pageTitle' => 'Pengembalian',
        ]);
    }

    public function detail(Rental $rental)
    {
        $rental->load([
            'user',
            'mobil',
            'cabangAmbil',
            'cabangKembali',
            'pembayaran',
            'supirs',
        ]);

        return response()->json([
            'id' => $rental->id,

            'pelanggan' => $rental->user->name ?? '-',
            'email' => $rental->user->email ?? '-',
            'telepon' => $rental->user->phone ?? '-',
            'alamat' => $rental->user->address ?? '-',

            'mobil' => $rental->mobil->name ?? '-',
            'plat' => $rental->mobil->plate_number ?? '-',

            'tanggal_mulai' => $rental->tanggal_mulai
                ? \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y')
                : '-',

            'tanggal_selesai' => $rental->tanggal_selesai
                ? \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y')
                : '-',

            'jumlah_hari' => $rental->jumlah_hari ?? 0,

            'cabang_ambil' => $rental->cabangAmbil->name ?? '-',
            'cabang_kembali' => $rental->cabangKembali->name ?? '-',

            'harga_perhari' => $rental->harga_perhari ?? 0,
            'subtotal' => $rental->subtotal ?? 0,
            'deposit' => $rental->deposit ?? 0,
            'kode_promo' => $rental->kode_promo ?? '-',
            'diskon' => $rental->diskon ?? 0,
            'total_harga' => $rental->total_harga ?? 0,

            'status' => $rental->status,
            'catatan' => $rental->catatan ?? '-',

            'supirs' => $rental->supirs->map(function ($supir) {
                return $supir->nama;
            })->values(),

            'pembayaran' => $rental->pembayaran ? [
                'metode' => $rental->pembayaran->metodePembayaran->nama ?? '-',
                'status' => $rental->pembayaran->status ?? '-',
                'jumlah' => $rental->pembayaran->jumlah ?? 0,
            ] : null,
        ]);
    }
}
