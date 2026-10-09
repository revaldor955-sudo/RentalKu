<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Kompensasi;
use App\Models\Kupon;
use App\Models\MetodePembayaran;
use App\Models\Mobil;
use App\Models\Rental;
use App\Models\Role;
use App\Models\TipeMobil;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuditFindingsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $staff;

    private User $customer;

    private User $customerB;

    private Mobil $mobil;

    private Cabang $cabang;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $this->admin = User::where('email', 'admin@rentalku.test')->firstOrFail();
        $this->staff = User::where('email', 'staff@rentalku.test')->firstOrFail();
        $this->customer = User::where('email', 'customer@rentalku.test')->firstOrFail();
        $this->customerB = User::create([
            'name' => 'Customer B',
            'email' => 'b@rentalku.test',
            'password' => 'password123',
            'roles_id' => Role::where('name', 'Customer')->value('id'),
        ]);

        $this->cabang = Cabang::create(['name' => 'A', 'address' => 'Jl A', 'phone' => '081']);
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
            'status' => 'Tersedia',
        ]);
    }

    private function buatRental(User $user, string $status = 'Selesai'): Rental
    {
        return Rental::create([
            'user_id' => $user->id,
            'mobil_id' => $this->mobil->id,
            'cabang_ambil_id' => $this->cabang->id,
            'cabang_kembali_id' => $this->cabang->id,
            'tanggal_mulai' => now()->subDays(3)->toDateString(),
            'tanggal_selesai' => now()->subDay()->toDateString(),
            'jumlah_hari' => 2,
            'harga_perhari' => 300000,
            'subtotal' => 600000,
            'deposit' => 500000,
            'total_harga' => 1100000,
            'status' => $status,
        ]);
    }

    private function klaimPayload(Rental $rental, array $extra = []): array
    {
        return array_merge([
            'mobil_id' => $this->mobil->id,
            'rental_id' => $rental->id,
            'jenis' => 'pengembalian_dana',
            'nominal' => 50000,
            'alasan' => 'Mobil mogok',
            'tanggal' => now()->toDateString(),
        ], $extra);
    }

    // U-02: admin/staff bisa buatkan klaim untuk customer yang valid.
    public function test_admin_buat_klaim_untuk_customer_ok(): void
    {
        $rental = $this->buatRental($this->customer);

        $this->actingAs($this->admin)
            ->post('/kompensasis', $this->klaimPayload($rental, ['customer_id' => $this->customer->id]))
            ->assertRedirect(route('kompensasis.index'));

        $this->assertDatabaseHas('kompensasis', [
            'rental_id' => $rental->id,
            'customer_id' => $this->customer->id,
            'status' => 'diajukan',
        ]);
    }

    public function test_staff_buat_klaim_untuk_customer_ok(): void
    {
        $rental = $this->buatRental($this->customer);

        $this->actingAs($this->staff)
            ->post('/kompensasis', $this->klaimPayload($rental, ['customer_id' => $this->customer->id]))
            ->assertRedirect(route('kompensasis.index'));

        $this->assertDatabaseHas('kompensasis', [
            'rental_id' => $rental->id,
            'customer_id' => $this->customer->id,
        ]);
    }

    public function test_admin_ditolak_rental_bukan_milik_customer(): void
    {
        $rental = $this->buatRental($this->customer);

        $this->actingAs($this->admin)
            ->post('/kompensasis', $this->klaimPayload($rental, ['customer_id' => $this->customerB->id]))
            ->assertForbidden();

        $this->assertDatabaseMissing('kompensasis', ['rental_id' => $rental->id]);
    }

    public function test_customer_ditolak_klaim_milik_orang(): void
    {
        $rental = $this->buatRental($this->customer);

        $this->actingAs($this->customerB)
            ->post('/customer/kompensasi', $this->klaimPayload($rental))
            ->assertForbidden();

        $this->assertDatabaseMissing('kompensasis', ['rental_id' => $rental->id]);
    }

    // U-03: kuota tidak boleh di bawah terpakai.
    private function kuponPayload(Kupon $kupon, array $extra = []): array
    {
        return array_merge([
            'code' => $kupon->code,
            'jenis' => 'nominal',
            'value' => 10000,
            'kuota' => 10,
            'minimal_pembelian' => 0,
            'active_at' => now()->subDay()->format('Y-m-d\TH:i'),
            'expired_at' => now()->addDays(10)->format('Y-m-d\TH:i'),
        ], $extra);
    }

    public function test_kupon_belum_digunakan_bisa_edit(): void
    {
        $kupon = Kupon::create([
            'code' => 'HEMAT10', 'jenis' => 'nominal', 'value' => 10000,
            'kuota' => 10, 'terpakai' => 0, 'minimal_pembelian' => 0,
            'active_at' => now()->subDay(), 'expired_at' => now()->addDays(10),
        ]);

        $this->actingAs($this->admin)
            ->put("/kupons/{$kupon->id}", $this->kuponPayload($kupon, ['value' => 15000]))
            ->assertRedirect();

        $this->assertEquals(15000, $kupon->fresh()->value);
    }

    public function test_kupon_tolak_kuota_di_bawah_terpakai(): void
    {
        $kupon = Kupon::create([
            'code' => 'HEMAT10', 'jenis' => 'nominal', 'value' => 10000,
            'kuota' => 10, 'terpakai' => 3, 'minimal_pembelian' => 0,
            'active_at' => now()->subDay(), 'expired_at' => now()->addDays(10),
        ]);

        $this->actingAs($this->admin)
            ->putJson("/kupons/{$kupon->id}", $this->kuponPayload($kupon, ['kuota' => 2]))
            ->assertStatus(422);

        $this->assertEquals(10, $kupon->fresh()->kuota);
    }

    public function test_kupon_tolak_terpakai_melebihi_kuota(): void
    {
        $kupon = Kupon::create([
            'code' => 'HEMAT10', 'jenis' => 'nominal', 'value' => 10000,
            'kuota' => 10, 'terpakai' => 3, 'minimal_pembelian' => 0,
            'active_at' => now()->subDay(), 'expired_at' => now()->addDays(10),
        ]);

        $this->actingAs($this->admin)
            ->putJson("/kupons/{$kupon->id}", $this->kuponPayload($kupon, ['terpakai' => 11]))
            ->assertStatus(422);
    }

    // U-04: nominal non-dana dipaksa 0; dana negatif/tanpa nominal ditolak.
    public function test_nominal_diskon_disimpan_nol(): void
    {
        $rental = $this->buatRental($this->customer);

        $this->actingAs($this->customer)->post('/customer/kompensasi', $this->klaimPayload($rental, [
            'jenis' => 'diskon', 'nominal' => 99999,
        ]))->assertRedirect();

        $this->assertEquals(0, Kompensasi::where('rental_id', $rental->id)->value('nominal'));
    }

    public function test_nominal_negatif_ditolak(): void
    {
        $rental = $this->buatRental($this->customer);

        $this->actingAs($this->customer)->postJson('/customer/kompensasi', $this->klaimPayload($rental, [
            'nominal' => -1000,
        ]))->assertStatus(422);
    }

    public function test_dana_tanpa_nominal_ditolak(): void
    {
        $rental = $this->buatRental($this->customer);
        $payload = $this->klaimPayload($rental);
        unset($payload['nominal']);

        $this->actingAs($this->customer)->postJson('/customer/kompensasi', $payload)->assertStatus(422);
    }

    // U-06: endpoint publik tetap untuk modal tamu, tanpa data sensitif.
    public function test_tamu_bisa_buka_modal_mobil_tanpa_data_sensitif(): void
    {
        $this->get("/mobils/{$this->mobil->id}")
            ->assertOk()
            ->assertSee('Avanza')
            ->assertDontSee('admin@rentalku.test');

        $this->getJson("/mobils/{$this->mobil->id}")->assertOk();
    }

    // U-07: field liar diabaikan, server penentu nilai sensitif.
    public function test_rental_abaikan_status_dan_total_bawaan_request(): void
    {
        $this->actingAs($this->customer)->post("/customer/rental/{$this->mobil->id}", [
            'tanggal_mulai' => now()->addDay()->toDateString(),
            'tanggal_selesai' => now()->addDays(3)->toDateString(),
            'cabang_ambil_id' => $this->cabang->id,
            'cabang_kembali_id' => $this->cabang->id,
            'status' => 'Selesai',
            'total_harga' => 1,
        ])->assertRedirect();

        $rental = Rental::latest('id')->firstOrFail();
        $this->assertEquals('Menunggu', $rental->status);
        $this->assertNotEquals(1, (int) $rental->total_harga);
        $this->assertEquals($this->customer->id, $rental->user_id);
        $this->assertEquals($this->cabang->id, $rental->cabang_ambil_id);
    }

    public function test_kompensasi_abaikan_customer_id_palsu(): void
    {
        $rental = $this->buatRental($this->customer);

        $this->actingAs($this->customerB)->post('/customer/kompensasi', $this->klaimPayload($rental, [
            'customer_id' => $this->customerB->id,
        ]))->assertForbidden();
    }

    public function test_pembayaran_abaikan_jumlah_dan_status_bawaan_request(): void
    {
        Storage::fake('public');
        $rental = $this->buatRental($this->customer, 'Disetujui');
        $metode = MetodePembayaran::create([
            'name' => 'Transfer', 'nomor_akun' => '123', 'cabang_id' => null, 'atas_nama' => 'RentalKu',
        ]);

        $this->actingAs($this->customer)->post("/customer/pembayaran/{$rental->id}", [
            'metode_pembayaran_id' => $metode->id,
            'tanggal_bayar' => now()->toDateString(),
            'bukti' => UploadedFile::fake()->image('bukti.jpg'),
            'jumlah' => 1,
            'status' => 'Disetujui',
        ])->assertRedirect();

        $bayar = $rental->pembayaran()->firstOrFail();
        $this->assertEquals((float) $rental->total_harga, (float) $bayar->jumlah);
        $this->assertEquals('Menunggu', $bayar->status);
    }

    // U-08: banner & faq khusus admin.
    public function test_staff_ditolak_banners_faqs_admin_boleh(): void
    {
        $this->actingAs($this->staff)->get('/banners')->assertForbidden();
        $this->actingAs($this->staff)->get('/faqs')->assertForbidden();
        $this->actingAs($this->admin)->get('/banners')->assertOk();
        $this->actingAs($this->admin)->get('/faqs')->assertOk();
    }
}
