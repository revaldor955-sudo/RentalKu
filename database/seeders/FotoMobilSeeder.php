<?php

namespace Database\Seeders;

use App\Models\FotoMobil;
use App\Models\Mobil;
use Illuminate\Database\Seeder;

class FotoMobilSeeder extends Seeder
{
    public function run(): void
    {
        $galeri = [
            'B 1234 XYZ' => ['images/mobils/ALPHARD.jpg', 'images/mobils/HIACE.jpg'],
            'L 7890 JKL' => ['images/mobils/PAJERO.jpg', 'images/mobils/TRITON.jpg'],
            'KB 1001 AA' => ['images/mobils/AVANZA.jpg', 'images/mobils/INNOVA REBORN.jpg'],
            'B 5678 ABC' => ['images/mobils/HIACE.jpg', 'images/mobils/ALPHARD.jpg'],
            'KB 2002 DD' => ['images/mobils/BRIO.jpg', 'images/mobils/ERTIGA.jpg'],
        ];

        foreach ($galeri as $plate => $urls) {
            $mobil = Mobil::where('plate_number', $plate)->first();

            if (! $mobil) {
                continue;
            }

            foreach ($urls as $url) {
                FotoMobil::firstOrCreate([
                    'mobil_id' => $mobil->id,
                    'url' => $url,
                ]);
            }
        }
    }
}
