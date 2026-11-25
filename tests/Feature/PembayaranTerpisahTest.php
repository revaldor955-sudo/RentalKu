<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Denda;
use App\Models\MetodePembayaran;
use App\Models\Mobil;
use App\Models\Pembayaran;
use App\Models\Rental;
use App\Models\TipeMobil;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PembayaranTerpisahTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    private User $staff;

    private Cabang $cabang;

    private MetodePembayaran $metode;

    private Mobil $mobil;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $this->customer = User::where('email', 'customer@rentalku.test')->firstOrFail();
        $this->staff = User::where('email', 'staff@rentalku.test')->firstOrFail();
        $this->cabang = Cabang::create(['name' => 'A', 'address' => 'Jl A', 'phone' => '081']);
        $this->metode = MetodePembayaran::create([
            'name' => 'Transfer Bank',
            'nomor_akun' => '123',
            'cabang_id' => null,
        ]);

        $brand = Brand::create(['name' => 'Toyota']);
        $tipe = TipeMobil::create(['name' => 'MPV']);

        $this->mobil = Mobil::create([
            'brand_id' => $brand->id,
            'tipe_mobil_id' => $tipe->id,
            'cabang_id' => $this->cabang->id,
            'name' => 'Avanza',
            'plate_number' => 'D 1 A',
            'tahun' => 2022,
            'transmisi' => 'Manual',
            'kapasitas' => 7,
            'warna' => 'Hitam',
            'harga_perhari' => 300000,
            'deposit' => 500000,
            'status' => 'Disewa',
        ]);
    }

    private function buatRental(string $status = 'Disetujui'): Rental
    {
        return Rental::create([
            'user_id' => $this->customer->id,
            'mobil_id' => $this->mobil->id,
            'cabang_ambil_id' => $this->cabang->id,
            'cabang_kembali_id' => $this->cabang->id,
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(2)->toDateString(),
            'jumlah_hari' => 2,
            'harga_perhari' => 300000,
            'subtotal' => 600000,
            'deposit' => 500000,
            'total_harga' => 1100000,
            'status' => $status,
        ]);
    }

    private function lunasiSewa(Rental $rental): void
    {
        Pembayaran::create([
            'rental_id' => $rental->id,
            'metode_pembayaran_id' => $this->metode->id,
            'tanggal_bayar' => now()->toDateString(),
            'jumlah' => $rental->total_harga,
            'bukti' => 'bukti_pembayaran/test.jpg',
            'status' => 'Disetujui',
        ]);
    }

    private function dataBayar(): array
    {
        return [
            'metode_pembayaran_id' => $this->metode->id,
            'tanggal_bayar' => now()->toDateString(),
            'bukti' => UploadedFile::fake()->image('bukti.jpg'),
        ];
    }

    public function test_denda_ditolak_jika_biaya_sewa_belum_lunas(): void
    {
        Storage::fake('public');

        $rental = $this->buatRental();
        $denda = Denda::create([
            'rental_id' => $rental->id,
            'jenis' => 'kerusakan',
            'nominal' => 500000,
            'status' => 'belum bayar',
        ]);

        $res = $this->actingAs($this->customer)
            ->postJson("/customer/dendas/{$denda->id}/bayar", [
                'bukti_bayar' => UploadedFile::fake()->image('bukti.jpg'),
                'tanggal_bayar' => now()->toDateString(),
            ]);

        $res->assertStatus(422)
            ->assertJsonPath('message', 'Lunasi biaya rental terlebih dahulu sebelum membayar denda.')
            ->assertJsonPath('errors.denda.0', 'Lunasi biaya rental terlebih dahulu sebelum membayar denda.');

        $this->assertSame('belum bayar', $denda->fresh()->status);
    }

    public function test_denda_bisa_dibayar_setelah_upload_ulang_disetujui(): void
    {
        Storage::fake('public');

        $rental = $this->buatRental();

        Pembayaran::create([
            'rental_id' => $rental->id,
            'metode_pembayaran_id' => $this->metode->id,
            'tanggal_bayar' => now()->toDateString(),
            'jumlah' => $rental->total_harga,
            'bukti' => 'bukti_pembayaran/lama.jpg',
            'status' => 'Ditolak',
        ]);

        $this->lunasiSewa($rental);

        $this->assertSame('Disetujui', $rental->fresh()->pembayaran->status);
        $this->assertTrue($rental->fresh()->pembayaranLunas());

        $denda = Denda::create([
            'rental_id' => $rental->id,
            'jenis' => 'kerusakan',
            'nominal' => 500000,
            'status' => 'belum bayar',
        ]);

        $this->actingAs($this->customer)
            ->postJson("/customer/dendas/{$denda->id}/bayar", [
                'bukti_bayar' => UploadedFile::fake()->image('bukti.jpg'),
                'tanggal_bayar' => now()->toDateString(),
            ])
            ->assertOk()
            ->assertJsonPath('status', 'menunggu verifikasi');

        $this->assertSame('menunggu verifikasi', $denda->fresh()->status);
    }

    public function test_bayar_sewa_menyimpan_pembayaran_menunggu(): void
    {
        Storage::fake('public');

        $rental = $this->buatRental();

        $this->actingAs($this->customer)
            ->postJson("/customer/pembayaran/{$rental->id}", $this->dataBayar())
            ->assertOk()
            ->assertJsonPath('message', 'Bukti pembayaran berhasil dikirim.');

        $this->assertDatabaseHas('pembayarans', [
            'rental_id' => $rental->id,
            'status' => 'Menunggu',
            'jumlah' => 1100000,
        ]);
    }

    public function test_bayar_sewa_ditolak_jika_sudah_ada_pembayaran_aktif(): void
    {
        Storage::fake('public');

        $rental = $this->buatRental();
        $this->lunasiSewa($rental);

        $this->actingAs($this->customer)
            ->postJson("/customer/pembayaran/{$rental->id}", $this->dataBayar())
            ->assertStatus(422)
            ->assertJsonPath('message', 'Rental ini sudah memiliki pembayaran aktif.');
    }

    public function test_bayar_semua_menyimpan_pembayaran_dan_denda(): void
    {
        Storage::fake('public');

        $rental = $this->buatRental();
        $denda = Denda::create([
            'rental_id' => $rental->id,
            'jenis' => 'keterlambatan',
            'nominal' => 200000,
            'status' => 'belum bayar',
        ]);

        $this->actingAs($this->customer)
            ->postJson("/customer/pembayaran/{$rental->id}/semua", $this->dataBayar())
            ->assertOk()
            ->assertJsonPath('message', 'Bukti pembayaran sewa dan denda berhasil dikirim.');

        $this->assertDatabaseHas('pembayarans', [
            'rental_id' => $rental->id,
            'status' => 'Menunggu',
            'jumlah' => 1100000,
        ]);

        $this->assertSame('menunggu verifikasi', $denda->fresh()->status);
        $this->assertNotNull($denda->fresh()->bukti_bayar);
    }

    public function test_bayar_semua_ditolak_jika_tidak_ada_denda(): void
    {
        Storage::fake('public');

        $rental = $this->buatRental();

        $this->actingAs($this->customer)
            ->postJson("/customer/pembayaran/{$rental->id}/semua", $this->dataBayar())
            ->assertStatus(422)
            ->assertJsonPath('message', 'Tidak ada denda yang perlu dibayar.');
    }

    public function test_staff_menandai_pengembalian_mobil(): void
    {
        $rental = $this->buatRental();

        $this->actingAs($this->staff)
            ->putJson("/pengembalian/{$rental->id}/verifikasi")
            ->assertOk()
            ->assertJsonPath('message', 'Mobil ditandai sudah dikembalikan.');

        $rental->refresh();

        $this->assertNotNull($rental->tanggal_dikembalikan);
        $this->assertSame($this->staff->id, (int) $rental->dikembalikan_oleh);
    }

    public function test_status_selesai_ditolak_jika_mobil_belum_dikembalikan(): void
    {
        $rental = $this->buatRental();
        $this->lunasiSewa($rental);

        $this->actingAs($this->staff)
            ->putJson("/rentals/{$rental->id}/status", ['status' => 'Selesai'])
            ->assertStatus(422)
            ->assertJsonPath('message', 'Mobil belum ditandai dikembalikan oleh Staff.');

        $this->assertSame('Disetujui', $rental->fresh()->status);
    }
}
