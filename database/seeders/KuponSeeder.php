<?php

namespace Database\Seeders;

use App\Models\Kupon;
use Illuminate\Database\Seeder;

class KuponSeeder extends Seeder
{
    public function run(): void
    {
        $kupons = [
            [
                'code' => 'HEMAT10',
                'jenis' => 'persen',
                'value' => 10,
                'kuota' => 100,
                'terpakai' => 1,
                'minimal_pembelian' => 500000,
                'active_at' => now()->subDays(30),
                'expired_at' => now()->addDays(30),
            ],
            [
                'code' => 'CASH50',
                'jenis' => 'nominal',
                'value' => 50000,
                'kuota' => 50,
                'terpakai' => 0,
                'minimal_pembelian' => 300000,
                'active_at' => now()->subDays(10),
                'expired_at' => now()->addDays(20),
            ],
            [
                'code' => 'WEEKEND15',
                'jenis' => 'persen',
                'value' => 15,
                'kuota' => 30,
                'terpakai' => 0,
                'minimal_pembelian' => 1000000,
                'active_at' => now()->subDays(5),
                'expired_at' => now()->addDays(10),
            ],
            [
                'code' => 'EXPIRED20',
                'jenis' => 'persen',
                'value' => 20,
                'kuota' => 20,
                'terpakai' => 3,
                'minimal_pembelian' => 400000,
                'active_at' => now()->subDays(60),
                'expired_at' => now()->subDay(),
            ],
            [
                'code' => 'COMINGSOON',
                'jenis' => 'nominal',
                'value' => 100000,
                'kuota' => 40,
                'terpakai' => 0,
                'minimal_pembelian' => 750000,
                'active_at' => now()->addDays(7),
                'expired_at' => now()->addDays(37),
            ],
            [
                'code' => 'HABIS',
                'jenis' => 'nominal',
                'value' => 25000,
                'kuota' => 5,
                'terpakai' => 5,
                'minimal_pembelian' => 250000,
                'active_at' => now()->subDays(40),
                'expired_at' => now()->addDays(5),
            ],
        ];

        foreach ($kupons as $kupon) {
            Kupon::updateOrCreate(
                ['code' => $kupon['code']],
                $kupon
            );
        }
    }
}
