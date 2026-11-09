<?php

namespace App\Support;

use App\Models\Denda;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DendaKeterlambatan
{
    public const DENDA_PER_HARI = 200000;

    public static function sync(Rental $rental, ?Carbon $sampai = null): string
    {
        $batas = Carbon::parse($rental->tanggal_selesai)->startOfDay();
        $sampai = ($sampai ?? Carbon::today())->copy()->startOfDay();

        $hariTerlambat = (int) $batas->diffInDays($sampai);

        if ($hariTerlambat < 1) {
            return 'tidak_terlambat';
        }

        $nominal = self::DENDA_PER_HARI * $hariTerlambat;

        $deskripsi = 'Denda keterlambatan pengembalian mobil selama ' . $hariTerlambat . ' hari. Tarif Rp200.000 per hari. ' . 'Batas pengembalian: ' . $batas->format('d/m/Y') . '. Total denda: Rp' . number_format($nominal, 0, ',', '.') . '.';
        return DB::transaction(function () use ($rental, $nominal, $deskripsi) {
            $denda = Denda::where('rental_id', $rental->id)->where('jenis', 'keterlambatan')->lockForUpdate()->first();

            if (!$denda) {
                Denda::create([
                    'rental_id' => $rental->id,
                    'jenis' => 'keterlambatan',
                    'nominal' => $nominal,
                    'deskripsi' => $deskripsi,
                    'status' => 'belum bayar',
                ]);
                return 'dibuat';
            }
            if ($denda->status !== 'belum bayar') {
                return 'dilewati';
            }

            $denda->update([
                'nominal' => $nominal,
                'deskripsi' => $deskripsi,
            ]);

            return 'diperbarui';
        });
    }
}
