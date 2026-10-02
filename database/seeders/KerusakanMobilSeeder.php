<?php

namespace Database\Seeders;

use App\Models\KerusakanMobil;
use Illuminate\Database\Seeder;

class KerusakanMobilSeeder extends Seeder
{
    public function run(): void
    {
        $jenis = ['Mesin', 'Ban', 'Body', 'Interior', 'Rem', 'Kelistrikan', 'AC', 'Transmisi', 'Suspensi', 'Kaca', 'Lainnya'];

        foreach ($jenis as $j) {
            KerusakanMobil::firstOrCreate(['jenis_kerusakan' => $j]);
        }
    }
}