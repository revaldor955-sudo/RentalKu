<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Denda;
use App\Models\Kompensasi;
use App\Models\MetodePembayaran;
use App\Models\Mobil;
use App\Models\Rental;
use App\Models\TipeMobil;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerAlurTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    private Cabang $cabangA;

    private Cabang $cabangB;

    private Mobil $mobil;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $this->customer = User::where('email', 'customer@rentalku.test')->firstOrFail();
        $this->cabangA = Cabang::create(['name' => 'A', 'address' => 'Jl A', 'phone' => '081']);
        $this->cabangB = Cabang::create(['name' => 'B', 'address' => 'Jl B', 'phone' => '082']);

        $brand = Brand::create(['name' => 'Toyota']);
        $tipe = TipeMobil::create(['name' => 'MPV']);

        $this->mobil = Mobil::create([
            'brand_id' => $brand->id,
            'tipe_mobil_id' => $tipe->id,
            'cabang_id' => $this->cabangA->id,
            'name' => 'Avanza',
            'plate_number' => 'D 1 A',
            'tahun' => 2022,
            'transmisi' => 'Manual',
            'kapasitas' => 7,
            'warna' => 'Hitam',
            'harga_perhari' => 300000,
            'deposit' => 500000,
            'status' => 'Tersedia',
        ]);
    }

    private function buatRentalSelesai(): Rental
    {
        return Rental::create([
            'user_id' => $this->customer->id,
            'mobil_id' => $this->mobil->id,
            'cabang_ambil_id' => $this->cabangA->id,
            'cabang_kembali_id' => $this->cabangA->id,
            'tanggal_mulai' => now()->subDays(3)->toDateString(),
            'tanggal_selesai' => now()->subDay()->toDateString(),
            'jumlah_hari' => 2,
            'harga_perhari' => 300000,
            'subtotal' => 600000,
            'deposit' => 500000,
            'total_harga' => 1100000,
            'status' => 'Selesai',
        ]);
    }

    public function test_dashboard_customer_ok(): void
    {
        $this->actingAs($this->customer)
            ->get('/customer/dashboard')
            ->assertOk();
    }

    public function test_master_terkunci_untuk_tamu(): void
    {
        $this->get('/metode_pembayarans')->assertRedirect('/login');
    }

    public function test_customer_ditolak_akses_master(): void
    {
        $this->actingAs($this->customer)
            ->get('/metode_pembayarans')
            ->assertForbidden();
    }

    public function test_klaim_ganda_aktif_ditolak(): void
    {
        $rental = $this->buatRentalSelesai();

        Kompensasi::create([
            'mobil_id' => $this->mobil->id,
            'rental_id' => $rental->id,
            'customer_id' => $this->customer->id,
            'jenis' => 'pengembalian_dana',
            'nominal' => 100000,
            'alasan' => 'Coba.',
            'tanggal' => now()->toDateString(),
            'status' => 'diajukan',
        ]);

        $res = $this->actingAs($this->customer)
            ->postJson('/customer/kompensasi', [
                'rental_id' => $rental->id,
                'mobil_id' => $this->mobil->id,
                'jenis' => 'pengembalian_dana',
                'nominal' => 50000,
                'alasan' => 'Coba lagi.',
                'tanggal' => now()->toDateString(),
            ]);

        $res->assertStatus(422);
        $this->assertSame(1, Kompensasi::where('rental_id', $rental->id)->count());
    }

    public function test_bayar_denda_jadi_menunggu_verifikasi(): void
    {
        Storage::fake('public');

        $denda = Denda::create([
            'rental_id' => $this->buatRentalSelesai()->id,
            'jenis' => 'keterlambatan',
            'nominal' => 150000,
            'status' => 'belum bayar',
        ]);

        $this->actingAs($this->customer)
            ->post("/customer/dendas/{$denda->id}/bayar", [
                'bukti_bayar' => UploadedFile::fake()->image('bukti.jpg'),
                'tanggal_bayar' => now()->toDateString(),
            ])
            ->assertRedirect();

        $this->assertSame('menunggu verifikasi', $denda->fresh()->status);
        $this->assertNotNull($denda->fresh()->bukti_bayar);
    }

    public function test_metode_cabang_lain_ditolak(): void
    {
        Storage::fake('public');

        $metodeB = MetodePembayaran::create([
            'name' => 'BCA B',
            'nomor_akun' => '999',
            'cabang_id' => $this->cabangB->id,
        ]);

        $rental = Rental::create([
            'user_id' => $this->customer->id,
            'mobil_id' => $this->mobil->id,
            'cabang_ambil_id' => $this->cabangA->id,
            'cabang_kembali_id' => $this->cabangA->id,
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays(2)->toDateString(),
            'jumlah_hari' => 2,
            'harga_perhari' => 300000,
            'subtotal' => 600000,
            'deposit' => 500000,
            'total_harga' => 1100000,
            'status' => 'Disetujui',
        ]);

        $this->actingAs($this->customer)
            ->postJson("/customer/pembayaran/{$rental->id}", [
                'metode_pembayaran_id' => $metodeB->id,
                'tanggal_bayar' => now()->toDateString(),
            ])
            ->assertStatus(422);
    }

    public function test_halaman_kompensasi_customer_ok(): void
    {
        $this->actingAs($this->customer)
            ->get('/customer/kompensasi')
            ->assertOk();
    }
}
