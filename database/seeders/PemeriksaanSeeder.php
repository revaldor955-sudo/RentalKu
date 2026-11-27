<?php

namespace Database\Seeders;

use App\Models\KerusakanMobil;
use App\Models\PemeriksaanMobil;
use App\Models\Rental;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use RuntimeException;

class PemeriksaanSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'marker' => 'Demo: rental selesai ertiga',
                'jenis' => 'sebelum_sewa',
                'kondisi' => 'baik',
                'jam' => 8,
                'catatan' => 'Kondisi awal baik.',
                'foto_bukti' => 'pemeriksaan/demo-pemeriksaan-1.jpg',
                'kerusakan' => [],
            ],
            [
                'marker' => 'Demo: rental selesai ertiga',
                'jenis' => 'setelah_sewa',
                'kondisi' => 'rusak',
                'jam' => 17,
                'catatan' => 'Ban depan aus dan kampas rem tipis.',
                'foto_bukti' => 'pemeriksaan/demo-pemeriksaan-2.jpg',
                'kerusakan' => [
                    [
                        'jenis' => 'Ban',
                        'keterangan' => 'Ban depan aus',
                        'foto_bukti' => 'pemeriksaan/demo-kerusakan-ban.jpg',
                        'catatan' => 'Ganti ban',
                    ],
                    [
                        'jenis' => 'Rem',
                        'keterangan' => 'Kampas rem tipis',
                        'foto_bukti' => 'pemeriksaan/demo-kerusakan-rem.jpg',
                        'catatan' => 'Ganti kampas rem',
                    ],
                ],
            ],
            [
                'marker' => 'Demo: rental selesai terios',
                'jenis' => 'sebelum_sewa',
                'kondisi' => 'baik',
                'jam' => 8,
                'catatan' => 'Kondisi awal baik.',
                'foto_bukti' => 'pemeriksaan/demo-pemeriksaan-3.jpg',
                'kerusakan' => [],
            ],
            [
                'marker' => 'Demo: rental selesai vios',
                'jenis' => 'setelah_sewa',
                'kondisi' => 'baik',
                'jam' => 17,
                'catatan' => 'Mobil kembali dalam kondisi baik.',
                'foto_bukti' => 'pemeriksaan/demo-pemeriksaan-4.jpg',
                'kerusakan' => [],
            ],
        ];

        $kerusakanIds = [
            'Ban' => KerusakanMobil::where('jenis_kerusakan', 'Ban')->value('id'),
            'Rem' => KerusakanMobil::where('jenis_kerusakan', 'Rem')->value('id'),
        ];

        if (! $kerusakanIds['Ban'] || ! $kerusakanIds['Rem']) {
            throw new RuntimeException('Data kerusakan Ban/Rem tidak ditemukan untuk pemeriksaan demo.');
        }

        $sumber = public_path('images/mobils/AVANZA.jpg');

        foreach ($rows as $row) {
            $rental = Rental::where('catatan', $row['marker'])->first();

            if (! $rental) {
                throw new RuntimeException("Rental dengan catatan \"{$row['marker']}\" tidak ditemukan.");
            }

            $tanggal = ($row['jenis'] === 'sebelum_sewa' ? $rental->tanggal_mulai : $rental->tanggal_selesai)
                ->copy()
                ->setTime($row['jam'], 0);

            $pemeriksaan = PemeriksaanMobil::updateOrCreate(
                ['rental_id' => $rental->id, 'jenis' => $row['jenis']],
                [
                    'mobil_id' => $rental->mobil_id,
                    'kondisi' => $row['kondisi'],
                    'catatan' => $row['catatan'],
                    'foto_bukti' => $row['foto_bukti'],
                    'tanggal' => $tanggal,
                ]
            );

            $fotos = [$row['foto_bukti']];
            $pivot = [];

            foreach ($row['kerusakan'] as $kerusakan) {
                $fotos[] = $kerusakan['foto_bukti'];
                $pivot[$kerusakanIds[$kerusakan['jenis']]] = [
                    'keterangan' => $kerusakan['keterangan'],
                    'foto_bukti' => $kerusakan['foto_bukti'],
                    'catatan' => $kerusakan['catatan'],
                ];
            }

            $pemeriksaan->kerusakan()->sync($pivot);

            foreach ($fotos as $foto) {
                $tujuan = storage_path('app/public/'.$foto);

                if (! File::exists($tujuan)) {
                    File::ensureDirectoryExists(dirname($tujuan));
                    File::copy($sumber, $tujuan);
                }
            }
        }
    }
}
