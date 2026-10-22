<?php

namespace App\Console\Commands;

use App\Models\Denda;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateLateDendas extends Command
{
    protected $signature = 'dendas:generate-late';

    protected $description = 'Membuat atau memperbarui denda keterlambatan rental';

    /**
     * Tarif denda keterlambatan per hari.
     */
    private const TARIF_DENDA_PER_HARI = 200000;

    public function handle(): int
    {
        $hariIni = Carbon::today();

        $rentalsTerlambat = Rental::query()
            ->whereIn('status', ['Disetujui', 'Berjalan'])
            ->whereDate('tanggal_selesai', '<', $hariIni)
            ->get();

        $jumlahDibuat = 0;
        $jumlahDiperbarui = 0;
        $dendaDilewati = 0;

        foreach ($rentalsTerlambat as $rental) {
            $tanggalSelesai = Carbon::parse(
                $rental->tanggal_selesai
            )->startOfDay();

            $hariTerlambat = (int) $tanggalSelesai
                ->diffInDays($hariIni);

            if ($hariTerlambat < 1) {
                continue;
            }

            $nominal = self::TARIF_DENDA_PER_HARI
                * $hariTerlambat;

            $deskripsi = 'Denda keterlambatan pengembalian mobil selama '
                . $hariTerlambat
                . ' hari. Tarif Rp200.000 per hari. '
                . 'Batas pengembalian: '
                . $tanggalSelesai->format('d/m/Y')
                . '. Total denda: Rp'
                . number_format($nominal, 0, ',', '.')
                . '.';

            DB::transaction(function () use (
                $rental,
                $nominal,
                $deskripsi,
                &$jumlahDibuat,
                &$jumlahDiperbarui,
                &$dendaDilewati
            ) {
                $denda = Denda::where('rental_id', $rental->id)
                    ->where('jenis', 'keterlambatan')
                    ->lockForUpdate()
                    ->first();

                if (!$denda) {
                    Denda::create([
                        'rental_id' => $rental->id,
                        'jenis' => 'keterlambatan',
                        'nominal' => $nominal,
                        'deskripsi' => $deskripsi,
                        'syarat_dan_ketentuan' => $deskripsi,
                        'status' => 'belum bayar',
                    ]);

                    $jumlahDibuat++;
                    return;
                }

                // Jangan mengubah denda yang sudah lunas
                // atau yang sedang menunggu verifikasi.
                if ($denda->status !== 'belum bayar') {
                    $dendaDilewati++;
                    return;
                }

                $denda->update([
                    'nominal' => $nominal,
                    'deskripsi' => $deskripsi,
                    'syarat_dan_ketentuan' => $deskripsi,
                ]);

                $jumlahDiperbarui++;
            });
        }

        $this->info("Denda baru dibuat: {$jumlahDibuat}");
        $this->info("Denda belum dibayar diperbarui: {$jumlahDiperbarui}");
        $this->info("Denda dilewati karena statusnya bukan belum bayar: {$dendaDilewati}");

        return self::SUCCESS;
    }
}
