<?php

namespace App\Console\Commands;

use App\Models\Rental;
use App\Support\DendaKeterlambatan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateLateDendas extends Command
{
    protected $signature = 'dendas:generate-late';

    protected $description = 'Membuat atau memperbarui denda keterlambatan rental';

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
            match (DendaKeterlambatan::sync($rental, $hariIni)) {
                'dibuat' => $jumlahDibuat++,
                'diperbarui' => $jumlahDiperbarui++,
                'dilewati' => $dendaDilewati++,
                default => null,
            };
        }

        $this->info("Denda baru dibuat: {$jumlahDibuat}");
        $this->info("Denda belum dibayar diperbarui: {$jumlahDiperbarui}");
        $this->info("Denda dilewati karena statusnya bukan belum bayar: {$dendaDilewati}");

        return self::SUCCESS;
    }
}
