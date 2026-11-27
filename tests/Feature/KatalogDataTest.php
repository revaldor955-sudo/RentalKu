<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Cabang;
use App\Models\Mobil;
use App\Models\TipeMobil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KatalogDataTest extends TestCase
{
    use RefreshDatabase;

    private Cabang $cabangA;

    private Cabang $cabangB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cabangA = Cabang::create(['name' => 'A', 'address' => 'Jl A', 'phone' => '081']);
        $this->cabangB = Cabang::create(['name' => 'B', 'address' => 'Jl B', 'phone' => '082']);

        $brand = Brand::create(['name' => 'Toyota']);
        $tipe = TipeMobil::create(['name' => 'MPV']);

        $this->buatMobil($brand, $tipe, $this->cabangA, 'Avanza', 'D 1 A', 'Manual', 300000);
        $this->buatMobil($brand, $tipe, $this->cabangB, 'Innova', 'D 2 B', 'Matic', 500000);
        $this->buatMobil($brand, $tipe, $this->cabangA, 'Xenia', 'D 3 C', 'Manual', 250000, 'Disewa');
    }

    private function buatMobil($brand, $tipe, $cabang, $nama, $plat, $transmisi, $harga, $status = 'Tersedia'): Mobil
    {
        return Mobil::create([
            'brand_id' => $brand->id,
            'tipe_mobil_id' => $tipe->id,
            'cabang_id' => $cabang->id,
            'name' => $nama,
            'plate_number' => $plat,
            'tahun' => 2022,
            'transmisi' => $transmisi,
            'kapasitas' => 7,
            'warna' => 'Hitam',
            'harga_perhari' => $harga,
            'deposit' => 500000,
            'status' => $status,
        ]);
    }

    public function test_mengembalikan_field_aman_saja(): void
    {
        $response = $this->getJson('/katalog/data');

        $response->assertOk();
        $item = $response->json('data.0');

        $this->assertEquals(
            ['slug', 'name', 'foto_url', 'transmisi', 'kapasitas', 'harga_perhari', 'deposit', 'cabang', 'populer'],
            array_keys($item)
        );
        $this->assertArrayNotHasKey('plate_number', $item);
        $this->assertArrayHasKey('meta', $response->json());
    }

    public function test_filter_default_hanya_tersedia(): void
    {
        $response = $this->getJson('/katalog/data');

        $this->assertSame(2, $response->json('meta.total'));
    }

    public function test_filter_kata_kunci_cabang_transmisi_status(): void
    {
        $this->getJson('/katalog/data?q=innova')->assertJsonPath('meta.total', 1);
        $this->getJson('/katalog/data?cabang=' . $this->cabangB->id)->assertJsonPath('meta.total', 1);
        $this->getJson('/katalog/data?transmisi=matic')->assertJsonPath('meta.total', 1);
        $this->getJson('/katalog/data?status=tidak_tersedia')->assertJsonPath('meta.total', 1);
    }

    public function test_sort_harga_dan_terbaru(): void
    {
        $asc = $this->getJson('/katalog/data?sort=harga_asc&per_page=100')->json('data');
        $this->assertSame(['Avanza', 'Innova'], array_column($asc, 'name'));

        $desc = $this->getJson('/katalog/data?sort=harga_desc&per_page=100')->json('data');
        $this->assertSame(['Innova', 'Avanza'], array_column($desc, 'name'));

        $this->getJson('/katalog/data?sort=sembarang')->assertOk()->assertJsonPath('meta.current_page', 1);
    }

    public function test_per_page_custom_dijepit(): void
    {
        $this->getJson('/katalog/data?per_page=999')->assertJsonPath('meta.per_page', 100);
        $this->getJson('/katalog/data?per_page=7')->assertJsonPath('meta.per_page', 7);
        $this->getJson('/katalog/data?per_page=0')->assertJsonPath('meta.per_page', 1);
    }

    public function test_halaman_di_luar_jangkauan_dijepit(): void
    {
        $response = $this->getJson('/katalog/data?page=99');

        $response->assertOk()->assertJsonPath('meta.current_page', 1);
        $this->assertNotEmpty($response->json('data'));
    }
}
