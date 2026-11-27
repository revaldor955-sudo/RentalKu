<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara menyewa mobil di RentalKu?',
                'jawaban' => 'Pilih mobil yang diinginkan, tentukan tanggal sewa, lalu isi data pemesanan. Setelah pesanan dikirim, tim kami akan menghubungi Anda untuk konfirmasi dan instruksi pembayaran.',
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'Dokumen apa saja yang dibutuhkan untuk menyewa mobil?',
                'jawaban' => 'Anda cukup menyiapkan KTP, SIM A yang masih berlaku, dan kartu identitas pendukung lain bila diperlukan. Dokumen ditunjukkan saat pengambilan mobil.',
                'urutan' => 2,
            ],
            [
                'pertanyaan' => 'Metode pembayaran apa yang tersedia?',
                'jawaban' => 'Kami menerima transfer bank, QRIS, serta dompet digital seperti GoPay, OVO, dan DANA. Detail rekening akan ditampilkan saat Anda melakukan pembayaran.',
                'urutan' => 3,
            ],
            [
                'pertanyaan' => 'Bagaimana ketentuan denda keterlambatan pengembalian?',
                'jawaban' => 'Denda keterlambatan dihitung Rp200.000 per hari dan akan ditagihkan melalui halaman pesanan Anda. Pengembalian tepat waktu membantu menghindari biaya tambahan.',
                'urutan' => 4,
            ],
            [
                'pertanyaan' => 'Bagaimana cara mengembalikan mobil setelah masa sewa selesai?',
                'jawaban' => 'Kembalikan mobil ke cabang pengambilan sesuai tanggal yang disepakati. Petugas akan memeriksa kondisi kendaraan sebelum proses penyelesaian sewa.',
                'urutan' => 5,
            ],
            [
                'pertanyaan' => 'Apakah bisa menyewa mobil beserta supir?',
                'jawaban' => 'Bisa. Sebagian unit tersedia dengan opsi supir. Silakan sampaikan kebutuhan Anda saat pemesanan agar tim kami dapat menyiapkan supir yang sesuai.',
                'urutan' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['pertanyaan' => $faq['pertanyaan']],
                [
                    'jawaban' => $faq['jawaban'],
                    'urutan' => $faq['urutan'],
                    'is_active' => true,
                ]
            );
        }
    }
}
