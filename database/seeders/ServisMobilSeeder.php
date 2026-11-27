<?php

namespace Database\Seeders;

use App\Models\Mobil;
use App\Models\ServisMobil;
use Illuminate\Database\Seeder;
use RuntimeException;

class ServisMobilSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'plate' => 'KB 1001 AA',
                'tanggal' => now()->subDays(20)->toDateString(),
                'jenis' => 'rutin',
                'biaya' => 750000,
                'keterangan' => 'Servis berkala 10.000 km',
                'bengkel' => 'Auto2000 Pontianak',
            ],
            [
                'plate' => 'L 7890 JKL',
                'tanggal' => now()->subDays(45)->toDateString(),
                'jenis' => 'perbaikan',
                'biaya' => 2500000,
                'keterangan' => 'Ganti kampas rem dan tune up',
                'bengkel' => 'Mitsubishi Yogyakarta',
            ],
            [
                'plate' => 'B 5678 ABC',
                'tanggal' => now()->subDays(60)->toDateString(),
                'jenis' => 'rutin',
                'biaya' => 1200000,
                'keterangan' => 'Servis rutin dan ganti oli',
                'bengkel' => 'Toyota Bandung',
            ],
        ];

        foreach ($rows as $row) {
            $mobil = Mobil::where('plate_number', $row['plate'])->first();

            if (! $mobil) {
                throw new RuntimeException("Mobil dengan plat {$row['plate']} tidak ditemukan (servis: {$row['keterangan']}).");
            }

            ServisMobil::updateOrCreate(
                ['mobil_id' => $mobil->id, 'keterangan' => $row['keterangan']],
                [
                    'tanggal' => $row['tanggal'],
                    'jenis' => $row['jenis'],
                    'biaya' => $row['biaya'],
                    'bengkel' => $row['bengkel'],
                ]
            );
        }
    }
}
