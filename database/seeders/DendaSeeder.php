<?php

namespace Database\Seeders;

use App\Models\Denda;
use App\Models\Rental;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use RuntimeException;

class DendaSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'marker' => 'Demo: rental selesai ertiga',
                'jenis' => 'keterlambatan',
                'nominal' => 200000,
                'status' => Denda::STATUS_LUNAS,
                'deskripsi' => 'Denda keterlambatan 1 hari.',
                'foto_bukti' => 'images/dendas/demo-denda-1.jpg',
                'bukti_bayar' => 'bukti_denda/demo-denda-bayar-1.jpg',
                'tanggal_bayar' => now()->subDays(4)->toDateString(),
            ],
            [
                'marker' => 'Demo: rental selesai terios',
                'jenis' => 'kerusakan',
                'nominal' => 750000,
                'status' => Denda::STATUS_BELUM_BAYAR,
                'deskripsi' => 'Kerusakan bodi pintu belakang.',
                'foto_bukti' => 'images/dendas/demo-denda-2.jpg',
                'bukti_bayar' => null,
                'tanggal_bayar' => null,
            ],
            [
                'marker' => 'Demo: rental selesai vios',
                'jenis' => 'keterlambatan',
                'nominal' => 400000,
                'status' => Denda::STATUS_MENUNGGU_VERIFIKASI,
                'deskripsi' => 'Denda keterlambatan 2 hari.',
                'foto_bukti' => null,
                'bukti_bayar' => 'bukti_denda/demo-denda-bayar-3.jpg',
                'tanggal_bayar' => now()->subDays(14)->toDateString(),
            ],
            [
                'marker' => 'Demo: rental selesai evalia',
                'jenis' => 'kehilangan',
                'nominal' => 1500000,
                'status' => Denda::STATUS_LUNAS,
                'deskripsi' => 'Kehilangan kunci cadangan.',
                'foto_bukti' => null,
                'bukti_bayar' => 'bukti_denda/demo-denda-bayar-4.jpg',
                'tanggal_bayar' => now()->subDays(26)->toDateString(),
            ],
            [
                'marker' => 'Demo: rental selesai triton',
                'jenis' => 'keterlambatan',
                'nominal' => 400000,
                'status' => Denda::STATUS_BELUM_BAYAR,
                'deskripsi' => 'Denda keterlambatan 2 hari.',
                'foto_bukti' => null,
                'bukti_bayar' => null,
                'tanggal_bayar' => null,
            ],
            [
                'marker' => 'Demo: rental selesai triton',
                'jenis' => 'kerusakan',
                'nominal' => 750000,
                'status' => Denda::STATUS_MENUNGGU_VERIFIKASI,
                'deskripsi' => 'Lecet bumper belakang, bukti transfer menunggu verifikasi.',
                'foto_bukti' => 'images/dendas/demo-denda-5.jpg',
                'bukti_bayar' => 'bukti_denda/demo-denda-bayar-5.jpg',
                'tanggal_bayar' => now()->subDays(2)->toDateString(),
            ],
            [
                'marker' => 'Demo: rental selesai triton',
                'jenis' => 'kehilangan',
                'nominal' => 1200000,
                'status' => Denda::STATUS_LUNAS,
                'deskripsi' => 'Kehilangan dongkrak dan kunci roda, sudah dibayar.',
                'foto_bukti' => null,
                'bukti_bayar' => 'bukti_denda/demo-denda-bayar-6.jpg',
                'tanggal_bayar' => now()->subDays(21)->toDateString(),
            ],
        ];

        $rentals = Rental::whereIn('catatan', array_column($rows, 'marker'))->get()->keyBy('catatan');
        $sumber = public_path('images/mobils/AVANZA.jpg');

        foreach ($rows as $row) {
            $rental = $rentals[$row['marker']] ?? null;

            if (! $rental) {
                throw new RuntimeException("Rental dengan catatan \"{$row['marker']}\" tidak ditemukan.");
            }

            if ($row['foto_bukti'] !== null) {
                $tujuan = public_path($row['foto_bukti']);

                if (! File::exists($tujuan)) {
                    File::ensureDirectoryExists(dirname($tujuan));
                    File::copy($sumber, $tujuan);
                }
            }

            if ($row['bukti_bayar'] !== null) {
                $tujuan = storage_path('app/public/'.$row['bukti_bayar']);

                if (! File::exists($tujuan)) {
                    File::ensureDirectoryExists(dirname($tujuan));
                    File::copy($sumber, $tujuan);
                }
            }

            Denda::updateOrCreate(
                ['rental_id' => $rental->id, 'jenis' => $row['jenis']],
                [
                    'nominal' => $row['nominal'],
                    'deskripsi' => $row['deskripsi'],
                    'foto_bukti' => $row['foto_bukti'],
                    'status' => $row['status'],
                    'bukti_bayar' => $row['bukti_bayar'],
                    'tanggal_bayar' => $row['tanggal_bayar'],
                ]
            );
        }
    }
}
