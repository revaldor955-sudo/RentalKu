<?php

namespace Database\Seeders;

use App\Models\Supir;
use Illuminate\Database\Seeder;

class SupirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supirs = [
            // Cabang Bandung Dago (id=1)
            [
                'name' => 'Budi Santoso',
                'phone' => '081234567890',
                'image' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=0D8ABC&color=fff&size=200',
                'tarif_perhari' => 150000,
                'status' => 'tersedia',
                'cabang_id' => 1,
            ],
            [
                'name' => 'Dewi Lestari',
                'phone' => '081234567891',
                'image' => 'https://ui-avatars.com/api/?name=Dewi+Lestari&background=9B59B6&color=fff&size=200',
                'tarif_perhari' => 165000,
                'status' => 'tersedia',
                'cabang_id' => 1,
            ],
            [
                'name' => 'Rizky Pratama',
                'phone' => '081234567892',
                'image' => 'https://ui-avatars.com/api/?name=Rizky+Pratama&background=E67E22&color=fff&size=200',
                'tarif_perhari' => 145000,
                'status' => 'tidak tersedia',
                'cabang_id' => 1,
            ],

            // Cabang Jakarta Thamrin (id=2)
            [
                'name' => 'Slamet Riyadi',
                'phone' => '082345678901',
                'image' => 'https://ui-avatars.com/api/?name=Slamet+Riyadi&background=FF6B6B&color=fff&size=200',
                'tarif_perhari' => 175000,
                'status' => 'tersedia',
                'cabang_id' => 2,
            ],
            [
                'name' => 'Aldo Revaldo',
                'phone' => '083456789012',
                'image' => 'https://ui-avatars.com/api/?name=Aldo+Revaldo&background=4ECDC4&color=fff&size=200',
                'tarif_perhari' => 200000,
                'status' => 'tersedia',
                'cabang_id' => 2,
            ],
            [
                'name' => 'Putri Maharani',
                'phone' => '083456789013',
                'image' => 'https://ui-avatars.com/api/?name=Putri+Maharani&background=F39C12&color=fff&size=200',
                'tarif_perhari' => 190000,
                'status' => 'tersedia',
                'cabang_id' => 2,
            ],

            // Cabang Surabaya (id=3)
            [
                'name' => 'Agus Salim',
                'phone' => '084567890123',
                'image' => 'https://ui-avatars.com/api/?name=Agus+Salim&background=2ECC71&color=fff&size=200',
                'tarif_perhari' => 155000,
                'status' => 'tersedia',
                'cabang_id' => 3,
            ],
            [
                'name' => 'Siti Nurhaliza',
                'phone' => '084567890124',
                'image' => 'https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=E74C3C&color=fff&size=200',
                'tarif_perhari' => 160000,
                'status' => 'tersedia',
                'cabang_id' => 3,
            ],
            [
                'name' => 'Joko Widodo',
                'phone' => '084567890125',
                'image' => 'https://ui-avatars.com/api/?name=Joko+Widodo&background=3498DB&color=fff&size=200',
                'tarif_perhari' => 170000,
                'status' => 'tidak tersedia',
                'cabang_id' => 3,
            ],
        ];

        foreach ($supirs as $supir) {
            Supir::create($supir);
        }
    }
}
