<?php

namespace Database\Seeders;

use App\Models\TipeMobil;
use Illuminate\Database\Seeder;

class TipeMobilSeeder extends Seeder
{
    /**
     * Seed the application's car types.
     */
    public function run(): void
    {
        $tipeMobils = [
            [
                'name' => 'MPV',
                'description' => 'Multi Purpose Vehicle: mobil penumpang serbaguna dengan kabin lega, cocok untuk keluarga.',
            ],
            [
                'name' => 'SUV',
                'description' => 'Sport Utility Vehicle: mobil dengan ground clearance tinggi, cocok untuk segala medan.',
            ],
            [
                'name' => 'Sedan',
                'description' => 'Mobil penumpang dengan bagasi terpisah, nyaman untuk perjalanan dinas.',
            ],
            [
                'name' => 'Hatchback',
                'description' => 'Mobil compact dengan pintu bagasi menyatu, lincah untuk berkendara di perkotaan.',
            ],
            [
                'name' => 'City Car',
                'description' => 'Mobil berukuran kecil dan irit, ideal untuk mobilitas harian di dalam kota.',
            ],
            [
                'name' => 'LCGC',
                'description' => 'Low Cost Green Car: mobil hemat bahan bakar dengan harga terjangkau.',
            ],
            [
                'name' => 'Double Cabin',
                'description' => 'Mobil pikap dengan kabin ganda, cocok untuk kebutuhan angkut barang dan penumpang.',
            ],
            [
                'name' => 'Van',
                'description' => 'Mobil penumpang berkapasitas besar, cocok untuk rombongan dan wisata.',
            ],
        ];

        foreach ($tipeMobils as $tipeMobil) {
            TipeMobil::updateOrCreate(['name' => $tipeMobil['name']], $tipeMobil);
        }
    }
}