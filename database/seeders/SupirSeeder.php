<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Supir;
use Illuminate\Database\Seeder;

class SupirSeeder extends Seeder
{
    /**
     * Seed the application's drivers.
     */
    public function run(): void
    {
        // Lookup FK berdasarkan nama agar idempotent terhadap urutan auto-increment
        $cabangs = Cabang::pluck('id', 'name');

        $supirs = [
            [
                'name' => 'Budi Santoso',
                'cabang' => 'Cabang Bandung Dago',
                'phone' => '081234567890',
                'image' => 'https://ui-avatars.com/api/?name=Budi+Santoso&background=0D8ABC&color=fff&size=200',
                'tarif_perhari' => 150000,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Dewi Lestari',
                'cabang' => 'Cabang Bandung Dago',
                'phone' => '081234567891',
                'image' => 'https://ui-avatars.com/api/?name=Dewi+Lestari&background=9B59B6&color=fff&size=200',
                'tarif_perhari' => 165000,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Rizky Pratama',
                'cabang' => 'Cabang Bandung Dago',
                'phone' => '081234567892',
                'image' => 'https://ui-avatars.com/api/?name=Rizky+Pratama&background=E67E22&color=fff&size=200',
                'tarif_perhari' => 145000,
                'status' => 'tidak tersedia',
            ],
            [
                'name' => 'Slamet Riyadi',
                'cabang' => 'Cabang Jakarta Thamrin',
                'phone' => '082345678901',
                'image' => 'https://ui-avatars.com/api/?name=Slamet+Riyadi&background=FF6B6B&color=fff&size=200',
                'tarif_perhari' => 175000,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Aldo Revaldo',
                'cabang' => 'Cabang Jakarta Thamrin',
                'phone' => '083456789012',
                'image' => 'https://ui-avatars.com/api/?name=Aldo+Revaldo&background=4ECDC4&color=fff&size=200',
                'tarif_perhari' => 200000,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Putri Maharani',
                'cabang' => 'Cabang Jakarta Thamrin',
                'phone' => '083456789013',
                'image' => 'https://ui-avatars.com/api/?name=Putri+Maharani&background=F39C12&color=fff&size=200',
                'tarif_perhari' => 190000,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Agus Salim',
                'cabang' => 'Cabang Surabaya',
                'phone' => '084567890123',
                'image' => 'https://ui-avatars.com/api/?name=Agus+Salim&background=2ECC71&color=fff&size=200',
                'tarif_perhari' => 155000,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'cabang' => 'Cabang Surabaya',
                'phone' => '084567890124',
                'image' => 'https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=E74C3C&color=fff&size=200',
                'tarif_perhari' => 160000,
                'status' => 'tersedia',
            ],
            [
                'name' => 'Joko Widodo',
                'cabang' => 'Cabang Surabaya',
                'phone' => '084567890125',
                'image' => 'https://ui-avatars.com/api/?name=Joko+Widodo&background=3498DB&color=fff&size=200',
                'tarif_perhari' => 170000,
                'status' => 'tidak tersedia',
            ],
        ];

        foreach ($supirs as $supir) {
            Supir::updateOrCreate(
                ['name' => $supir['name']],
                [
                    'cabang_id' => $cabangs[$supir['cabang']] ?? null,
                    'phone' => $supir['phone'],
                    'image' => $supir['image'],
                    'tarif_perhari' => $supir['tarif_perhari'],
                    'status' => $supir['status'],
                ]
            );
        }
    }
}
