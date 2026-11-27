<?php

namespace Database\Seeders;

use App\Models\LandingSetting;
use Illuminate\Database\Seeder;

class LandingSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'hero_badge' => 'Rental Mobil Terpercaya',
            'hero_title' => 'Perjalanan nyaman dimulai dari sini.',
            'hero_description' => 'Sewa mobil harian, mingguan, atau bulanan dengan armada terawat dan proses cepat. Pilih mobil, tentukan tanggal, dan biarkan tim kami mengurus sisanya.',

            'about_badge' => 'Tentang Kami',
            'about_title' => 'Rental mobil tanpa ribet.',
            'about_description' => 'RentalKu membantu Anda menemukan mobil yang tepat untuk kebutuhan perjalanan, mulai dari urusan bisnis hingga liburan keluarga.',

            'about_feature_1_title' => 'Armada Terawat',
            'about_feature_1_desc' => 'Setiap unit diperiksa secara berkala agar aman dan nyaman digunakan.',
            'about_feature_1_icon' => 'bi-shield-check',

            'about_feature_2_title' => 'Proses Cepat',
            'about_feature_2_desc' => 'Pemesanan online yang ringkas, tanpa antre dan tanpa prosedur berbelit.',
            'about_feature_2_icon' => 'bi-lightning-charge',

            'about_feature_3_title' => 'Harga Transparan',
            'about_feature_3_desc' => 'Biaya sewa jelas sejak awal, tanpa biaya tersembunyi.',
            'about_feature_3_icon' => 'bi-wallet2',

            'about_feature_4_title' => 'Dukungan 24 Jam',
            'about_feature_4_desc' => 'Tim kami siap membantu Anda kapan pun selama masa sewa.',
            'about_feature_4_icon' => 'bi-headset',

            'stats_mobil_label' => 'Mobil Tersedia',
            'stats_pelanggan_label' => 'Pelanggan Puas',

            'promo_title' => 'Promo Spesial',
            'promo_description' => 'Gunakan kode kupon pilihan untuk mendapatkan potongan harga pada penyewaan berikutnya.',
            'promo_button_label' => 'Lihat Mobil',
            'promo_button_url' => '#mobil',

            'brand_badge' => 'Pilihan Mobil',
            'brand_title' => 'Temukan mobil yang sesuai kebutuhan.',
            'brand_description' => 'Dari city car hemat bahan bakar hingga MPV keluarga, semua tersedia dengan kondisi prima.',

            'steps_badge' => 'Cara Sewa',
            'steps_title' => 'Sewa mobil dalam tiga langkah.',
            'steps_description' => 'Pilih mobil, isi data pemesanan, lalu lakukan pembayaran. Tim kami akan menghubungi Anda untuk konfirmasi.',

            'testimonial_badge' => 'Testimoni',
            'testimonial_title' => 'Cerita dari pelanggan kami.',
            'testimonial_description' => 'Pengalaman pelanggan yang telah mempercayakan perjalanan mereka kepada RentalKu.',

            'faq_title' => 'Pertanyaan yang sering ditanyakan',
            'faq_description' => 'Belum menemukan jawaban? Hubungi tim kami melalui halaman kontak.',
        ];

        foreach ($settings as $key => $value) {
            LandingSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
