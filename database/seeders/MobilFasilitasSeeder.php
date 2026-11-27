<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use App\Models\Mobil;
use Illuminate\Database\Seeder;

class MobilFasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitas = Fasilitas::pluck('id', 'name');

        $urutan = ['AC', 'GPS', 'Audio Bluetooth', 'Airbag', 'Central Lock', 'Kamera Mundur'];
        $names = array_values(array_filter($urutan, fn ($name) => $fasilitas->has($name)));

        if (empty($names)) {
            return;
        }

        $total = count($names);

        foreach (Mobil::orderBy('id')->get() as $index => $mobil) {
            $jumlah = min(4 + ($index % 3), $total);
            $ids = [];

            for ($i = 0; $i < $jumlah; $i++) {
                $ids[] = $fasilitas[$names[($index + $i) % $total]];
            }

            $mobil->fasilitas()->syncWithoutDetaching(array_values(array_unique($ids)));
        }
    }
}
