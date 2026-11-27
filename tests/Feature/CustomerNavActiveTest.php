<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerNavActiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_top_nav_active(): void
    {
        $this->seed([RoleSeeder::class, UserSeeder::class]);
        $customer = User::where('email', 'customer@rentalku.test')->firstOrFail();

        $dash = $this->actingAs($customer)->get(route('customer.dashboard'))->assertOk()->content();
        $this->assertMatchesRegularExpression('/class="nav-link fw-semibold active"[^>]*data-nav="mobil"/', $dash);

        $komp = $this->actingAs($customer)->get(route('customer.kompensasi.index'))->assertOk()->content();
        $this->assertMatchesRegularExpression('/class="nav-link fw-semibold active"[^>]*>Kompensasi<\/a>/', $komp);
    }
}
