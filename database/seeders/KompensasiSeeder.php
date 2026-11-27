<?php

namespace Database\Seeders;

use App\Models\Kompensasi;
use App\Models\KompensasiBukti;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use RuntimeException;

class KompensasiSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'marker' => 'Demo: rental selesai vios',
                'slug' => 'vios',
                'jenis' => 'pengembalian_dana',
                'nominal' => 200000,
                'alasan' => 'Keterlambatan pengembalian deposit',
                'tanggal' => now()->subDays(14)->toDateString(),
                'catatan' => 'Dana dikembalikan via transfer bank.',
                'dibaca_at' => null,
            ],
            [
                'marker' => 'Demo: rental selesai triton',
                'slug' => 'triton',
                'jenis' => 'diskon',
                'nominal' => 100000,
                'alasan' => 'Diskon kompensasi perjalanan',
                'tanggal' => now()->subDays(21)->toDateString(),
                'catatan' => 'Diskon diberikan untuk rental berikutnya.',
                'dibaca_at' => now()->subDays(20),
            ],
            [
                'marker' => 'Demo: rental selesai evalia',
                'slug' => 'evalia',
                'jenis' => 'gratis_sewa',
                'nominal' => 0,
                'alasan' => 'Gratis sewa 1 hari',
                'tanggal' => now()->subDays(26)->toDateString(),
                'catatan' => 'Penggantian 1 hari sewa.',
                'dibaca_at' => now()->subDays(25),
            ],
        ];

        $staffId = User::where('email', 'staff@rentalku.test')->value('id');

        if (! $staffId) {
            throw new RuntimeException('User staff@rentalku.test tidak ditemukan untuk kompensasi demo.');
        }

        $sumber = public_path('images/mobils/AVANZA.jpg');

        foreach ($rows as $row) {
            $rental = Rental::where('catatan', $row['marker'])->first();

            if (! $rental) {
                throw new RuntimeException("Rental dengan catatan \"{$row['marker']}\" tidak ditemukan.");
            }

            $kompensasi = Kompensasi::updateOrCreate(
                ['rental_id' => $rental->id],
                [
                    'jenis' => $row['jenis'],
                    'nominal' => $row['nominal'],
                    'alasan' => $row['alasan'],
                    'tanggal' => $row['tanggal'],
                    'catatan' => $row['catatan'],
                    'dibaca_at' => $row['dibaca_at'],
                    'customer_id' => $rental->user_id,
                    'mobil_id' => $rental->mobil_id,
                    'staff_id' => $staffId,
                ]
            );

            foreach ([1, 2] as $urutan) {
                $path = "bukti_kompensasi/demo-{$row['slug']}-{$urutan}.jpg";
                $tujuan = storage_path('app/public/'.$path);

                if (! File::exists($tujuan)) {
                    File::ensureDirectoryExists(dirname($tujuan));
                    File::copy($sumber, $tujuan);
                }

                KompensasiBukti::firstOrCreate(
                    ['kompensasi_id' => $kompensasi->id, 'path' => $path],
                    ['original_name' => basename($path)]
                );
            }
        }
    }
}
