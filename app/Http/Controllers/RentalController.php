<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Simpan pengajuan rental customer
     */
    public function store(Request $request, Mobil $mobil)
    {
        if ($mobil->status !== 'Tersedia') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mobil sedang tidak tersedia.',
                ], 422);
            }

            return back()
                ->with('error', 'Mobil sedang tidak tersedia.');
        }

        $validated = $request->validate([
            'cabang_ambil_id' => 'nullable|exists:cabangs,id',
            'cabang_kembali_id' => 'nullable|exists:cabangs,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'catatan' => 'nullable|string|max:500',
        ], [
            'cabang_ambil_id.exists' => 'Cabang ambil tidak valid.',
            'cabang_kembali_id.exists' => 'Cabang kembali tidak valid.',
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
            'cabang_ambil_id' => $validated['cabang_ambil_id'] ?? $mobil->cabang_id,
            'cabang_kembali_id' => $validated['cabang_kembali_id'] ?? $mobil->cabang_id,
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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan sewa mobil berhasil dibuat.',
            ]);
        }

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Pengajuan sewa mobil berhasil dibuat.');
    }

    /**
     * Menampilkan semua rental untuk Admin
     */
    public function index()
    {
        return view('admin.rentals.index');
    }

    /**
     * Server-side DataTables: daftar rental (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Rental::query()
            ->leftJoin('users', 'rentals.user_id', '=', 'users.id')
            ->leftJoin('mobils', 'rentals.mobil_id', '=', 'mobils.id')
            ->select(
                'rentals.*',
                'users.name as user_name',
                'users.email as user_email',
                'mobils.name as mobil_name',
                'mobils.plate_number as mobil_plate'
            );

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('mobils.name', 'like', "%{$search}%")
                    ->orWhere('mobils.plate_number', 'like', "%{$search}%")
                    ->orWhere('rentals.status', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'users.name',
            2 => 'mobils.name',
            3 => 'rentals.tanggal_mulai',
            4 => 'rentals.jumlah_hari',
            5 => 'rentals.total_harga',
            6 => 'rentals.status',
            7 => null,
        ];

        $orderColumn = $request->input('order.0.column', 3);
        $orderDir = $request->input('order.0.dir', 'desc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('rentals.tanggal_mulai', 'desc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $rentals = $query->offset($start)->limit($length)->get();

        $data = $rentals->map(function ($rental) {
            return [
                'id' => $rental->id,
                'user_name' => $rental->user_name ?? '-',
                'user_email' => $rental->user_email ?? '-',
                'mobil_name' => $rental->mobil_name ?? '-',
                'mobil_plate' => $rental->mobil_plate ?? '-',
                'tanggal_mulai' => $rental->tanggal_mulai?->format('d/m/Y'),
                'tanggal_selesai' => $rental->tanggal_selesai?->format('d/m/Y'),
                'jumlah_hari' => $rental->jumlah_hari,
                'total_harga' => (float) $rental->total_harga,
                'status' => $rental->status,
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
     * Detail rental untuk modal popup (AJAX)
     */
    public function detail(Rental $rental)
    {
        $rental->load([
            'user',
            'mobil',
            'cabangAmbil',
            'cabangKembali',
            'pembayaran',
        ]);

        return response()->json([
            'id' => $rental->id,
            'pelanggan' => $rental->user->name ?? '-',
            'email' => $rental->user->email ?? '-',
            'mobil' => $rental->mobil->name ?? '-',
            'plat' => $rental->mobil->plate_number ?? '-',
            'cabang_ambil' => $rental->cabangAmbil->name ?? '-',
            'cabang_kembali' => $rental->cabangKembali->name ?? '-',
            'tanggal_mulai' => $rental->tanggal_mulai?->format('d/m/Y'),
            'tanggal_selesai' => $rental->tanggal_selesai?->format('d/m/Y'),
            'jumlah_hari' => $rental->jumlah_hari,
            'harga_perhari' => (float) $rental->harga_perhari,
            'subtotal' => (float) $rental->subtotal,
            'deposit' => (float) $rental->deposit,
            'total_harga' => (float) $rental->total_harga,
            'status' => $rental->status,
            'catatan' => $rental->catatan ?? '-',
        ]);
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
