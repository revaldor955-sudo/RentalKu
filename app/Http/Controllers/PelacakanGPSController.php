<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\LokasiMobil;
use App\Models\RiwayatLokasiMobil;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PelacakanGPSController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $rentalIds = LokasiMobil::select('rental_id');

        $rentals = Rental::with(['mobil', 'user'])
            ->where('status', 'Berjalan')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->whereIn('id', $rentalIds)
            ->latest()
            ->get();

        $lokasis = LokasiMobil::with(['mobil', 'rental.user'])
            ->whereIn('rental_id', $rentals->pluck('id'))
            ->get();

        return view('pelacakan_gps.index', compact('rentals', 'lokasis'));
    }

    public function store(Request $request, Rental $rental)
    {
        $today = now()->toDateString();

        if (
            $rental->status !== 'Berjalan' ||
            $rental->tanggal_mulai->toDateString() > $today ||
            $rental->tanggal_selesai->toDateString() < $today
        ) {
            return redirect()->route('pelacakan-gps.index')
                ->with('error', 'Mobil tidak sedang dalam masa rental.');
        }

        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        LokasiMobil::updateOrCreate(
            ['rental_id' => $rental->id],
            [
                'mobil_id' => $rental->mobil_id,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]
        );

        RiwayatLokasiMobil::create([
            'rental_id' => $rental->id,
            'mobil_id' => $rental->mobil_id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return redirect()->route('pelacakan-gps.index')
            ->with('success', 'Koordinat berhasil disimpan.');
    }

    public function riwayat(Rental $rental)
    {
        $rental->load(['mobil', 'user']);

        $riwayats = RiwayatLokasiMobil::where('rental_id', $rental->id)
            ->latest()
            ->get();

        return view('pelacakan_gps.riwayat', compact('rental', 'riwayats'));
    }

    public function terimaLokasi(Request $request, Rental $rental)
    {
        $today = now()->toDateString();

        if (
            (int) $rental->user_id !== (int) auth()->id() ||
            $rental->status !== 'Berjalan' ||
            $rental->tanggal_mulai->toDateString() > $today ||
            $rental->tanggal_selesai->toDateString() < $today
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Rental tidak aktif atau bukan milik Anda.'
            ], 403);
        }

        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        LokasiMobil::updateOrCreate(
            ['rental_id' => $rental->id],
            [
                'mobil_id' => $rental->mobil_id,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]
        );

        RiwayatLokasiMobil::create([
            'rental_id' => $rental->id,
            'mobil_id' => $rental->mobil_id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lokasi berhasil diperbarui.'
        ]);
    }

    public function pengirim(Rental $rental)
    {
        $today = now()->toDateString();

        if (
            (int) $rental->user_id !== (int) auth()->id() ||
            $rental->status !== 'Berjalan' ||
            $rental->tanggal_mulai->toDateString() > $today ||
            $rental->tanggal_selesai->toDateString() < $today
        ) {
            abort(403, 'Rental tidak aktif atau bukan milik Anda.');
        }

        $rental->load(['mobil', 'user']);

        return view('pelacakan_gps.pengirim', compact('rental'));
    }

    public function data()
    {
        $today = now()->toDateString();
        $sekarang = now();

        $rentals = Rental::with(['mobil', 'user'])
            ->where('status', 'Berjalan')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->whereIn('id', LokasiMobil::select('rental_id'))
            ->latest()
            ->get();

        $lokasis = LokasiMobil::whereIn(
            'rental_id',
            $rentals->pluck('id')
        )->get()->keyBy('rental_id');

        $data = $rentals->map(function ($rental) use ($lokasis, $sekarang) {
            $lokasi = $lokasis->get($rental->id);

            $aktif = $lokasi &&
                $lokasi->updated_at &&
                $lokasi->updated_at->gte($sekarang->copy()->subSeconds(30));

            return [
                'rental_id' => $rental->id,
                'latitude' => $lokasi ? (float) $lokasi->latitude : null,
                'longitude' => $lokasi ? (float) $lokasi->longitude : null,
                'mobil' => $rental->mobil->name ?? 'Mobil',
                'plat' => $rental->mobil->plate_number ?? '-',
                'customer' => $rental->user->name ?? '-',
                'updated_at' => $lokasi ? $lokasi->updated_at : null,
                'gps_status' => $aktif ? 'aktif' : 'tidak_ada_pembaruan',
            ];
        });

        return response()->json($data->values())
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    public function hapusData($rentalId)
    {
        Rental::findOrFail($rentalId);

        DB::transaction(function () use ($rentalId) {
            RiwayatLokasiMobil::where('rental_id', $rentalId)->delete();

            LokasiMobil::where('rental_id', $rentalId)->delete();
        });

        return redirect()
            ->route('pelacakan-gps.index')
            ->with('success', 'Data GPS dan riwayat lokasi berhasil dihapus.');
    }
}
