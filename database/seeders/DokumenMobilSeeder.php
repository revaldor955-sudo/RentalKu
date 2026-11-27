<?php

namespace Database\Seeders;

use App\Models\DokumenMobil;
use App\Models\Mobil;
use Illuminate\Database\Seeder;

class DokumenMobilSeeder extends Seeder
{
    public function run(): void
    {
        $plates = ['B 1234 XYZ', 'L 7890 JKL', 'KB 1001 AA', 'B 5678 ABC', 'KB 2002 DD'];

        $prefix = [
            'stnk' => 'STNK',
            'asuransi' => 'ASR',
            'bpkb' => 'BPKB',
        ];

        $berlakuSampai = now()->addYear()->toDateString();

        foreach ($plates as $plate) {
            $mobil = Mobil::where('plate_number', $plate)->first();

            if (! $mobil) {
                continue;
            }

            $kode = preg_replace('/[^A-Za-z0-9]/', '', $plate);

            foreach ($prefix as $jenis => $awalan) {
                DokumenMobil::updateOrCreate(
                    ['mobil_id' => $mobil->id, 'jenis' => $jenis],
                    [
                        'nomor_dokumen' => $awalan . '-' . $kode,
                        'berlaku_sampai' => $berlakuSampai,
                        'file' => null,
                    ]
                );
            }
        }
    }
}
