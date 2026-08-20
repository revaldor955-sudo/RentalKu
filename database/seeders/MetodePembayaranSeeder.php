<?php

namespace Database\Seeders;

use App\Models\MetodePembayaran;
use Illuminate\Database\Seeder;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Seed the application's payment methods.
     */
    public function run(): void
    {
        $metodePembayarans = [
            [
                'name' => 'Bank BCA',
                'nomor_akun' => '8830123456',
            ],
            [
                'name' => 'Bank Mandiri',
                'nomor_akun' => '1370012345678',
            ],
            [
                'name' => 'Bank BNI',
                'nomor_akun' => '0123456789',
            ],
            [
                'name' => 'Bank BRI',
                'nomor_akun' => '002101234567890',
            ],
            [
                'name' => 'QRIS',
                'nomor_akun' => '081234567890',
            ],
            [
                'name' => 'GoPay',
                'nomor_akun' => '081234567890',
            ],
            [
                'name' => 'OVO',
                'nomor_akun' => '081234567890',
            ],
            [
                'name' => 'DANA',
                'nomor_akun' => '081234567890',
            ],
        ];

        foreach ($metodePembayarans as $metodePembayaran) {
            MetodePembayaran::updateOrCreate(
                ['name' => $metodePembayaran['name']],
                $metodePembayaran
            );
        }
    }
}