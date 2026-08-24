<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Seed the application's car brands.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Toyota',
                'description' => 'Merek asal Jepang yang dikenal dengan keandalan, efisiensi bahan bakar, dan layanan purna jual yang luas di Indonesia.',
            ],
            [
                'name' => 'Honda',
                'description' => 'Merek asal Jepang yang menawarkan kenyamanan berkendara dan teknologi mesin yang efisien.',
            ],
            [
                'name' => 'Daihatsu',
                'description' => 'Merek asal Jepang yang populer untuk mobil keluarga dan niaga ringan dengan harga terjangkau.',
            ],
            [
                'name' => 'Suzuki',
                'description' => 'Merek asal Jepang yang dikenal dengan mobil compact dan MPV yang lincah serta irit.',
            ],
            [
                'name' => 'Mitsubishi',
                'description' => 'Merek asal Jepang yang menawarkan SUV tangguh dan MPV lega untuk kebutuhan keluarga.',
            ],
            [
                'name' => 'Nissan',
                'description' => 'Merek asal Jepang dengan desain modern dan teknologi berkendara yang canggih.',
            ],
            [
                'name' => 'Hyundai',
                'description' => 'Merek asal Korea Selatan yang dikenal dengan fitur lengkap dan garansi panjang.',
            ],
            [
                'name' => 'Wuling',
                'description' => 'Merek asal China yang menawarkan MPV dan mobil listrik dengan harga kompetitif.',
            ],
            [
                'name' => 'KIA',
                'description' => 'Merek asal Korea Selatan dengan desain premium dan teknologi keselamatan terkini.',
            ],
            [
                'name' => 'Mazda',
                'description' => 'Merek asal Jepang yang dikenal dengan desain KODO dan pengalaman berkendara yang dinamis.',
            ],
            [
                'name' => 'BMW',
                'description' => 'Merek asal Jerman yang dikenal dengan performa mesin, kemewahan, dan teknologi berkendara premium.',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(['name' => $brand['name']], $brand);
        }
    }
}