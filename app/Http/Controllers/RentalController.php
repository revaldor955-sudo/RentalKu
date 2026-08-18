<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{
    /**
     * Form pengajuan rental customer
     */
    public function create(Mobil $mobil)
    {
        if ($mobil->status !== 'Tersedia') {
            return redirect()
                ->route('mobils.show', $mobil->id)
                ->with('error', 'Mobil sedang tidak tersedia untuk disewa.');
        }

        return view('customer.rental.create', compact('mobil'));
    }


    /**
     * Simpan pengajuan rental customer
     */
    public function store(Request $request, Mobil $mobil)
    {
        if ($mobil->status !== 'Tersedia') {
            return back()
                ->with('error', 'Mobil sedang tidak tersedia.');
        }

        $validated = $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'catatan' => 'nullable|string|max:500',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
            'catatan.max' => 'Catatan maksimal 500 karakter.',
        ]);

        $tanggalMulai = Carbon::parse($validated['tanggal_mulai']);
        $tanggalSelesai = Carbon::parse($validated['tanggal_selesai']);

        $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai);

        $hargaRental = $jumlahHari * $mobil->harga_perhari;

        $subtotal = $hargaRental;

        $deposit = $mobil->deposit;

        $totalHarga = $subtotal + $deposit;

        Rental::create([
            'user_id' => auth()->id(),
            'mobil_id' => $mobil->id,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'jumlah_hari' => $jumlahHari,
            'harga_perhari' => $mobil->harga_perhari,
            'subtotal' => $subtotal,
            'deposit' => $deposit,
            'total_harga' => $totalHarga,
            'status' => 'Menunggu',
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Pengajuan sewa mobil berhasil dibuat.');
    }


    /**
     * Menampilkan semua rental untuk Admin
     */
    public function index()
    {
        $rentals = Rental::with([
            'user',
            'mobil'
        ])
        ->latest()
        ->get();

        return view('admin.rentals.index', compact('rentals'));
    }


    /**
     * Update status rental oleh Admin
     */
    public function updateStatus(Request $request, Rental $rental)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Selesai',
        ]);

        $status = $request->status;

        /*
        |--------------------------------------------------------------------------
        | DITOLAK
        |--------------------------------------------------------------------------
        */

        if ($status === 'Ditolak') {

            $rental->update([
                'status' => 'Ditolak',
            ]);

            // Mobil tetap tersedia
            $rental->mobil->update([
                'status' => 'Tersedia',
            ]);

            return back()->with(
                'success',
                'Pengajuan rental berhasil ditolak.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DISETUJUI
        |--------------------------------------------------------------------------
        */

        if ($status === 'Disetujui') {

            // Pastikan mobil masih tersedia
            if ($rental->mobil->status !== 'Tersedia') {

                return back()->with(
                    'error',
                    'Mobil sudah tidak tersedia.'
                );
            }

            $rental->update([
                'status' => 'Disetujui',
            ]);

            // Mobil menjadi disewa
            $rental->mobil->update([
                'status' => 'Disewa',
            ]);

            return back()->with(
                'success',
                'Rental berhasil disetujui. Mobil sekarang berstatus Disewa.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SELESAI
        |--------------------------------------------------------------------------
        */

        if ($status === 'Selesai') {

            $rental->update([
                'status' => 'Selesai',
            ]);

            // Mobil kembali tersedia
            $rental->mobil->update([
                'status' => 'Tersedia',
            ]);

            return back()->with(
                'success',
                'Rental telah selesai dan mobil kembali tersedia.'
            );
        }
    }
}
