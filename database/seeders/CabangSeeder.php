<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    /**
     * Seed the application's branches.
     */
    public function run(): void
    {
        $cabangs = [
            [
                'name' => 'Cabang Bandung Dago',
                'address' => 'Jl. Ir. H. Juanda No. 123, Dago, Kec. Coblong, Kota Bandung, Jawa Barat 40135',
                'phone' => '+62 812-2001-1001',
            ],
            [
                'name' => 'Cabang Jakarta Thamrin',
                'address' => 'Jl. M.H. Thamrin No. 45, Menteng, Jakarta Pusat, DKI Jakarta 10350',
                'phone' => '+62 812-2001-1002',
            ],
            [
                'name' => 'Cabang Surabaya',
                'address' => 'Jl. Basuki Rahmat No. 88, Embong Kaliasin, Kec. Genteng, Surabaya, Jawa Timur 60271',
                'phone' => '+62 812-2001-1003',
            ],
            [
                'name' => 'Cabang Semarang',
                'address' => 'Jl. Pemuda No. 150, Sekayu, Kec. Semarang Tengah, Semarang, Jawa Tengah 50132',
                'phone' => '+62 812-2001-1004',
            ],
            [
                'name' => 'Cabang Yogyakarta',
                'address' => 'Jl. Malioboro No. 76, Suryatmajan, Kec. Danurejan, Yogyakarta 55213',
                'phone' => '+62 812-2001-1005',
            ],
            [
                'name' => 'Cabang Denpasar',
                'address' => 'Jl. Raya Kuta No. 210, Kuta, Kab. Badung, Bali 80361',
                'phone' => '+62 812-2001-1006',
            ],
        ];

        foreach ($cabangs as $cabang) {
            Cabang::updateOrCreate(['name' => $cabang['name']], $cabang);
        }
    }
}