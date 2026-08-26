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
            [
                'name' => 'Cabang Pontianak Kota',
                'address' => 'Jl. Gajah Mada No. 57, Taman Sari, Kota Pontianak, Kalimantan Barat 78112',
                'phone' => '+62 812-2001-1007',
            ],
            [
                'name' => 'Cabang Pontianak Supadio',
                'address' => 'Jl. Arteri Supadio, Sei Pinyuh, Kec. Sungai Kakap, Kab. Kubu Raya, Kalimantan Barat 78391',
                'phone' => '+62 812-2001-1008',
            ],
            [
                'name' => 'Cabang Singkawang',
                'address' => 'Jl. Diponegoro No. 31, Tengah, Kota Singkawang, Kalimantan Barat 79116',
                'phone' => '+62 812-2001-1009',
            ],
            [
                'name' => 'Cabang Banjarmasin',
                'address' => 'Jl. Pangeran Antasari No. 86, Banjarmasin Tengah, Kota Banjarmasin, Kalimantan Selatan 70236',
                'phone' => '+62 812-2001-1010',
            ],
            [
                'name' => 'Cabang Balikpapan',
                'address' => 'Jl. Jenderal Sudirman No. 51, Damai Bahagia, Kec. Balikpapan Selatan, Balikpapan, Kalimantan Timur 76114',
                'phone' => '+62 812-2001-1011',
            ],
            [
                'name' => 'Cabang Samarinda',
                'address' => 'Jl. Gajah Mada No. 9, Pelabuhan, Kec. Samarinda Kota, Samarinda, Kalimantan Timur 75242',
                'phone' => '+62 812-2001-1012',
            ],
        ];

        foreach ($cabangs as $cabang) {
            Cabang::updateOrCreate(['name' => $cabang['name']], $cabang);
        }
    }
}