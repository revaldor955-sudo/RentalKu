<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Contoh banner promo untuk carousel landing.
     */
    public function run(): void
    {
        $banners = [
            [
                'judul' => 'Promo Rental Mingguan',
                'gambar' => 'images/banners/promo-rental-mingguan.jpg',
                'description' => 'Hemat hingga 15% untuk penyewaan mingguan di seluruh cabang Rentalku. Berlaku selama periode liburan.',
                'link' => '#mobil',
                'status' => 'aktif',
                'urutan' => 1,
            ],
            [
                'judul' => 'Jelajah Kalimantan Barat',
                'gambar' => 'images/banners/promo-wisata-kalbar.jpg',
                'description' => 'Paket mobil + supir lokal berpengalaman untuk wisata Pontianak, Singkawang, dan sekitarnya.',
                'link' => 'https://wa.me/6281234567890',
                'status' => 'aktif',
                'urutan' => 2,
            ],
            [
                'judul' => 'Gratis Antar-Jemput Bandara',
                'gambar' => 'images/banners/promo-antar-jemput.jpg',
                'description' => 'Ambil mobil langsung di bandara tanpa biaya tambahan pada rental minimal 3 hari.',
                'link' => '#cara-rental',
                'status' => 'aktif',
                'urutan' => 3,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(
                ['judul' => $banner['judul']],
                $banner
            );
        }
    }
}
