<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Kunci behavior baru dev_farrel sebelum deslop: tidak ada fixture domain,
// hanya pin wiring route + guard + validasi.
class DevFarrelRegressionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    public function test_tamu_ratings_dialihkan_ke_login_checkout_binding_dulu(): void
    {
        // ratings pakai param polos: guest kena auth redirect
        $this->get(route('customer.ratings.create', 1))->assertRedirect(route('login'));
        // checkout pakai implicit binding Mobil: binding jalan sebelum auth → 404
        $this->get(route('rentals.checkout.show', 999999))->assertNotFound();
    }

    public function test_ratings_rental_tidak_ada_404(): void
    {
        $customer = User::factory()->create(['roles_id' => 3]);

        $this->actingAs($customer)->get(route('customer.ratings.create', 999999))->assertNotFound();
        $this->actingAs($customer)->post(
            route('customer.ratings.store', 999999),
            ['rating' => 5, 'komentar' => 'Bagus']
        )->assertNotFound();
    }

    public function test_checkout_mobil_tidak_ada_404(): void
    {
        $customer = User::factory()->create(['roles_id' => 3]);

        $this->actingAs($customer)->get(route('rentals.checkout.show', 999999))->assertNotFound();
    }

    public function test_landing_settings_edit_200_dan_update_validasi(): void
    {
        // Rute ini tanpa middleware (temuan: halaman admin terbuka untuk tamu —
        // layout 500 saat tamu karena baca auth()->user()->name). Pin alur admin.
        $admin = User::factory()->create(['roles_id' => 1]);

        $this->actingAs($admin)->get(route('admin.landing-settings.edit'))->assertOk();

        $this->actingAs($admin)->put(route('admin.landing-settings.update'), [
            'hero_title' => str_repeat('x', 300),
        ])->assertSessionHasErrors('hero_title');

        $this->actingAs($admin)->put(route('admin.landing-settings.update'), [
            'hero_title' => 'Sewa Mobil Mudah',
        ])->assertRedirect(route('admin.landing-settings.edit'));

        $this->assertDatabaseHas('landing_settings', [
            'key' => 'hero_title',
            'value' => 'Sewa Mobil Mudah',
        ]);
    }
}
