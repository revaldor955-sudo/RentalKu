<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['AC', 'GPS', 'Audio Bluetooth', 'Airbag', 'Central Lock', 'Kamera Mundur'] as $name) {
            Fasilitas::firstOrCreate(['name' => $name]);
        }
    }
}
