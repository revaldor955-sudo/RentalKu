<?php

namespace Database\Seeders;

use App\Models\LokasiMobil;
use App\Models\Rental;
use App\Models\RiwayatLokasiMobil;
use Illuminate\Database\Seeder;
use RuntimeException;

class PelacakanGpsSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'marker' => 'Demo: rental berjalan alphard',
                'lokasi' => [-6.2088, 106.8456],
                'riwayat' => [
                    [-6.2088, 106.8456],
                    [-6.2100, 106.8470],
                    [-6.2115, 106.8485],
                    [-6.2130, 106.8500],
                    [-6.2145, 106.8515],
                ],
            ],
            [
                'marker' => 'Demo: rental berjalan rush',
                'lokasi' => [-0.0263, 109.3425],
                'riwayat' => [
                    [-0.0263, 109.3425],
                    [-0.0270, 109.3440],
                    [-0.0280, 109.3455],
                    [-0.0290, 109.3470],
                    [-0.0300, 109.3485],
                ],
            ],
        ];

        foreach ($rows as $row) {
            $rental = Rental::where('catatan', $row['marker'])->first();

            if (! $rental) {
                throw new RuntimeException("Rental dengan catatan \"{$row['marker']}\" tidak ditemukan.");
            }

            LokasiMobil::updateOrCreate(
                ['rental_id' => $rental->id],
                [
                    'mobil_id' => $rental->mobil_id,
                    'latitude' => $row['lokasi'][0],
                    'longitude' => $row['lokasi'][1],
                ]
            );

            foreach ($row['riwayat'] as [$latitude, $longitude]) {
                RiwayatLokasiMobil::updateOrCreate(
                    [
                        'rental_id' => $rental->id,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                    ],
                    ['mobil_id' => $rental->mobil_id]
                );
            }
        }
    }
}
