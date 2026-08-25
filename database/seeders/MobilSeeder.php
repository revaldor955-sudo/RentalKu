<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Mobil;
use App\Models\TipeMobil;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    /**
     * Seed the application's cars.
     */
    public function run(): void
    {
        // Lookup FK berdasarkan nama agar idempotent terhadap urutan auto-increment
        $brands = Brand::pluck('id', 'name');
        $tipes  = TipeMobil::pluck('id', 'name');
        $cabangs = Cabang::pluck('id', 'name');

        $mobils = [
            [
                'brand' => 'Toyota',
                'tipe' => 'MPV',
                'cabang' => 'Cabang Jakarta Thamrin',
                'name' => 'Toyota Alphard',
                'plate_number' => 'B 1234 XYZ',
                'tahun' => 2023,
                'transmisi' => 'Matic',
                'kapasitas' => 7,
                'warna' => 'Hitam',
                'harga_perhari' => 1500000,
                'deposit' => 2000000,
                'image' => 'images/mobils/ALPHARD.jpg',
                'description' => 'MPV premium untuk perjalanan keluarga dan eksekutif, dilengkapi kursi kapten yang nyaman.',
            ],
            [
                'brand' => 'Toyota',
                'tipe' => 'Van',
                'cabang' => 'Cabang Bandung Dago',
                'name' => 'Toyota Hiace',
                'plate_number' => 'B 5678 ABC',
                'tahun' => 2022,
                'transmisi' => 'Manual',
                'kapasitas' => 14,
                'warna' => 'Putih',
                'harga_perhari' => 1200000,
                'deposit' => 1500000,
                'image' => 'images/mobils/HIACE.jpg',
                'description' => 'Van berkapasitas besar, cocok untuk rombongan, wisata, dan antar-jemput grup.',
            ],
            [
                'brand' => 'Toyota',
                'tipe' => 'MPV',
                'cabang' => 'Cabang Surabaya',
                'name' => 'Toyota Innova Reborn',
                'plate_number' => 'D 3456 GHI',
                'tahun' => 2021,
                'transmisi' => 'Matic',
                'kapasitas' => 7,
                'warna' => 'Silver',
                'harga_perhari' => 500000,
                'deposit' => 500000,
                'image' => 'images/mobils/INNOVA REBORN.jpg',
                'description' => 'MPV andal Toyota dengan kabin lega dan mesin irit, pas untuk perjalanan jauh.',
            ],
            [
                'brand' => 'Toyota',
                'tipe' => 'MPV',
                'cabang' => 'Cabang Semarang',
                'name' => 'Toyota Kijang Innova',
                'plate_number' => 'D 9012 DEF',
                'tahun' => 2019,
                'transmisi' => 'Manual',
                'kapasitas' => 7,
                'warna' => 'Abu-abu',
                'harga_perhari' => 400000,
                'deposit' => 500000,
                'image' => 'images/mobils/TOYOTA KIJANG INNOVA.jpg',
                'description' => 'Kijang Innova generasi sebelumnya yang tetap tangguh dan nyaman untuk keluarga.',
            ],
            [
                'brand' => 'Mitsubishi',
                'tipe' => 'SUV',
                'cabang' => 'Cabang Yogyakarta',
                'name' => 'Mitsubishi Pajero Sport',
                'plate_number' => 'L 7890 JKL',
                'tahun' => 2020,
                'transmisi' => 'Matic',
                'kapasitas' => 7,
                'warna' => 'Hitam',
                'harga_perhari' => 900000,
                'deposit' => 1000000,
                'image' => 'images/mobils/PAJERO.jpg',
                'description' => 'SUV diesel bertenaga dengan ground clearance tinggi, siap menaklukkan medan berat.',
            ],
        ];

        foreach ($mobils as $mobil) {
            Mobil::updateOrCreate(
                ['plate_number' => $mobil['plate_number']],
                [
                    'brand_id' => $brands[$mobil['brand']],
                    'tipe_mobil_id' => $tipes[$mobil['tipe']],
                    'cabang_id' => $cabangs[$mobil['cabang']],
                    'name' => $mobil['name'],
                    'tahun' => $mobil['tahun'],
                    'transmisi' => $mobil['transmisi'],
                    'kapasitas' => $mobil['kapasitas'],
                    'warna' => $mobil['warna'],
                    'harga_perhari' => $mobil['harga_perhari'],
                    'deposit' => $mobil['deposit'],
                    'image' => $mobil['image'],
                    'status' => 'Tersedia',
                    'description' => $mobil['description'],
                ]
            );
        }
    }
}
