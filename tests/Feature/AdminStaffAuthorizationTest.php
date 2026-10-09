<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminStaffAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $staff;

    private int $adminRoleId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RoleSeeder::class, UserSeeder::class]);

        $this->admin = User::where('email', 'admin@rentalku.test')->firstOrFail();
        $this->staff = User::where('email', 'staff@rentalku.test')->firstOrFail();
        $this->adminRoleId = Role::where('name', 'Admin')->value('id');
    }

    public function test_staff_ditolak_buka_index_master(): void
    {
        foreach (['/roles', '/brands', '/tipe_mobils', '/cabangs', '/fasilitas', '/metode_pembayarans', '/supirs', '/kupons', '/users'] as $uri) {
            $this->actingAs($this->staff)->get($uri)->assertForbidden();
        }
    }

    public function test_staff_ditolak_mutasi_master(): void
    {
        $brand = Brand::create(['name' => 'Toyota']);

        $this->actingAs($this->staff)->post('/brands', ['name' => 'Honda'])->assertForbidden();
        $this->actingAs($this->staff)->put("/brands/{$brand->id}", ['name' => 'Daihatsu'])->assertForbidden();
        $this->actingAs($this->staff)->delete("/brands/{$brand->id}")->assertForbidden();
        $this->assertDatabaseMissing('brands', ['name' => 'Honda']);
    }

    public function test_staff_ditolak_buat_user_admin(): void
    {
        $this->actingAs($this->staff)->post('/users', [
            'name' => 'Admin Gadungan',
            'email' => 'gadungan@rentalku.test',
            'password' => 'password123',
            'roles_id' => $this->adminRoleId,
        ])->assertForbidden();

        $this->assertDatabaseMissing('users', ['email' => 'gadungan@rentalku.test']);
    }

    public function test_staff_ditolak_naikkan_role_sendiri_jadi_admin(): void
    {
        $this->actingAs($this->staff)->put("/users/{$this->staff->id}", [
            'name' => $this->staff->name,
            'email' => $this->staff->email,
            'roles_id' => $this->adminRoleId,
        ])->assertForbidden();

        $this->assertNotEquals($this->adminRoleId, $this->staff->fresh()->roles_id);
    }

    public function test_staff_ditolak_hapus_admin(): void
    {
        $this->actingAs($this->staff)->delete("/users/{$this->admin->id}")->assertForbidden();

        $this->assertDatabaseHas('users', ['email' => 'admin@rentalku.test']);
    }

    public function test_admin_tetap_boleh_kelola_master_dan_user(): void
    {
        $this->actingAs($this->admin)->get('/brands')->assertOk();
        $this->actingAs($this->admin)->get('/users')->assertOk();
        $this->actingAs($this->admin)->post('/brands', ['name' => 'Honda'])->assertRedirect();
        $this->assertDatabaseHas('brands', ['name' => 'Honda']);
    }

    public function test_staff_tetap_boleh_operasi_rental(): void
    {
        $this->actingAs($this->staff)->get('/rentals')->assertOk();
        $this->actingAs($this->staff)->get('/pembayaran')->assertOk();
        $this->actingAs($this->staff)->get('/dendas')->assertOk();
    }
}
