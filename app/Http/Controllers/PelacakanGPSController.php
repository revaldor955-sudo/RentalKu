<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\LokasiMobil;
use App\Models\RiwayatLokasiMobil;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PelacakanGPSController extends Controller
{
    public const ZONA_WIB = 'Asia/Jakarta';

    public function index()
    {
        $pageTitle = 'Pelacakan GPS';

        $rentals = Rental::with(['mobil', 'user'])
            ->where('status', 'Berjalan')
            ->latest()
            ->get();

        $lokasis = LokasiMobil::with(['mobil', 'rental.user'])
            ->whereIn('rental_id', $rentals->pluck('id'))
            ->get();

        return view('pelacakan_gps.index', compact('rentals', 'lokasis', 'pageTitle'));
    }

    public function riwayat(Rental $rental)
    {
        $pageTitle = 'Riwayat Lokasi Mobil';

        $rental->load(['mobil', 'user']);

        $totalRiwayat = RiwayatLokasiMobil::where('rental_id', $rental->id)->count();

        return view('pelacakan_gps.riwayat', compact('rental', 'totalRiwayat', 'pageTitle'));
    }

    public function riwayatData(Request $request, Rental $rental)
    {
        $query = RiwayatLokasiMobil::where('rental_id', $rental->id);

        $recordsTotal = (clone $query)->count();

        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            [$ekspresiWib, $bindingWib] = $this->ekspresiCariWib($search);

            $query->where(function ($q) use ($search, $ekspresiWib, $bindingWib) {
                $q->where('latitude', 'like', "%{$search}%")
                    ->orWhere('longitude', 'like', "%{$search}%")
                    ->orWhereRaw($ekspresiWib, $bindingWib);
            });
        }

        $recordsFiltered = (clone $query)->count();

        $kolomUrut = [
            1 => 'latitude',
            2 => 'longitude',
            3 => 'created_at',
            4 => 'created_at',
        ];

        $kolom = (int) $request->input('order.0.column', 3);
        $arah = strtolower((string) $request->input('order.0.dir', 'desc')) === 'asc'
            ? 'asc'
            : 'desc';

        $query->orderBy($kolomUrut[$kolom] ?? 'created_at', $arah);

        $start = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 10);

        if ($length === -1) {
            $length = 500;
        }

        $length = max(1, min($length, 500));

        $data = $query->skip($start)->take($length)->get()
            ->map(function ($riwayat) {
                return [
                    'latitude' => $riwayat->latitude,
                    'longitude' => $riwayat->longitude,
                    'tanggal' => $riwayat->created_at->copy()->setTimezone(self::ZONA_WIB)->format('d-m-Y'),
                    'waktu' => $riwayat->created_at->copy()->setTimezone(self::ZONA_WIB)->format('H:i:s'),
                    'maps_url' => 'https://www.google.com/maps?q='
                        . $riwayat->latitude . ',' . $riwayat->longitude,
                ];
            });

        return response()->json([
            'draw' => (int) $request->input('draw', 0),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    private function ekspresiCariWib(string $search): array
    {
        $pola = '%' . $search . '%';
        $offset = now(self::ZONA_WIB)->format('P');
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            return [
                "DATE_FORMAT(CONVERT_TZ(created_at, '+00:00', ?), '%d-%m-%Y %H:%i:%s') LIKE ?",
                [$offset, $pola],
            ];
        }

        if ($driver === 'sqlite') {
            return [
                "strftime('%d-%m-%Y %H:%M:%S', created_at, ?) LIKE ?",
                [$offset, $pola],
            ];
        }

        return ['created_at LIKE ?', [$pola]];
    }

    public function terimaLokasi(Request $request, Rental $rental)
    {
        if (
            (int) $rental->user_id !== (int) auth()->id() ||
            $rental->status !== 'Berjalan'
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
        if (
            (int) $rental->user_id !== (int) auth()->id() ||
            $rental->status !== 'Berjalan'
        ) {
            abort(403, 'Rental tidak aktif atau bukan milik Anda.');
        }

        $rental->load(['mobil', 'user']);

        $lokasi = LokasiMobil::where('rental_id', $rental->id)->first();

        return view('pelacakan_gps.pengirim', compact('rental', 'lokasi'));
    }

    public function data()
    {
        $sekarang = now();

        $rentals = Rental::with(['mobil', 'user'])
            ->where('status', 'Berjalan')
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
