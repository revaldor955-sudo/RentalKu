<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Mobil;
use App\Models\Rental;
use App\Models\TipeMobil;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class MobilSlugTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;

    private Cabang $cabang;

    private Brand $brand;

    private TipeMobil $tipe;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $this->customer = User::where('email', 'customer@rentalku.test')->firstOrFail();
        $this->cabang = Cabang::create(['name' => 'A', 'address' => 'Jl A', 'phone' => '081']);
        $this->brand = Brand::create(['name' => 'Toyota']);
        $this->tipe = TipeMobil::create(['name' => 'MPV']);
    }

    private function buatMobil(array $extra = []): Mobil
    {
        return Mobil::create(array_merge([
            'brand_id' => $this->brand->id,
            'tipe_mobil_id' => $this->tipe->id,
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
        ], $extra));
    }

    public function test_detail_via_slug_200(): void
    {
        $mobil = $this->buatMobil();

        $this->get("/mobils/{$mobil->slug}")
            ->assertOk()
            ->assertSee('Avanza');

        $this->getJson("/mobils/{$mobil->slug}")->assertOk();
    }

    public function test_url_id_lama_404(): void
    {
        $mobil = $this->buatMobil();

        $this->get("/mobils/{$mobil->id}")->assertNotFound();
        $this->getJson("/mobils/{$mobil->id}")->assertNotFound();
    }

    public function test_duplikat_nama_plat_menghasilkan_slug_unik(): void
    {
        $pertama = $this->buatMobil();
        // Plat berbeda sebagai string, tetapi menghasilkan slug dasar yang sama.
        $kedua = $this->buatMobil(['plate_number' => 'D-1-A']);

        $this->assertSame('avanza-d-1-a', $pertama->slug);
        $this->assertSame('avanza-d-1-a-2', $kedua->slug);
        $this->assertNotSame($pertama->slug, $kedua->slug);
    }

    public function test_slug_berubah_saat_nama_plat_berubah(): void
    {
        $mobil = $this->buatMobil();
        $slugLama = $mobil->slug;

        $mobil->update(['name' => 'Xenia']);

        $this->assertNotSame($slugLama, $mobil->fresh()->slug);
        $this->assertSame(Str::slug('Xenia-D 1 A'), $mobil->fresh()->slug);
    }

    public function test_slug_stabil_saat_field_lain_disimpan(): void
    {
        $mobil = $this->buatMobil();
        $slugAwal = $mobil->slug;

        $mobil->update(['warna' => 'Putih', 'harga_perhari' => 350000]);

        $this->assertSame($slugAwal, $mobil->fresh()->slug);
    }

    public function test_sewa_via_slug_menyimpan_mobil_id_integer_yang_benar(): void
    {
        $mobil = $this->buatMobil();

        $this->actingAs($this->customer)->post("/customer/rental/{$mobil->slug}", [
            'tanggal_mulai' => now()->addDay()->toDateString(),
            'tanggal_selesai' => now()->addDays(3)->toDateString(),
            'cabang_ambil_id' => $this->cabang->id,
            'cabang_kembali_id' => $this->cabang->id,
        ])->assertRedirect();

        $rental = Rental::latest('id')->firstOrFail();
        $this->assertTrue(is_int($rental->mobil_id));
        $this->assertSame($mobil->id, $rental->mobil_id);
    }

    public function test_create_otomatis_menghasilkan_slug(): void
    {
        $mobil = $this->buatMobil();

        $this->assertNotEmpty($mobil->slug);
        $this->assertSame(Str::slug('Avanza-D 1 A'), $mobil->slug);
    }
}
