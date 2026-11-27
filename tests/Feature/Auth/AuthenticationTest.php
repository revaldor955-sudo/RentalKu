<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('customer.dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_login_requires_email_and_password(): void
    {
        $this->post('/login', [])->assertSessionHasErrors([
            'email' => 'Email wajib diisi.',
            'password' => 'Password wajib diisi.',
        ]);

        $this->assertGuest();
    }

    public function test_login_rejects_invalid_email_format(): void
    {
        $this->post('/login', [
            'email' => 'bukan-email',
            'password' => 'password',
        ])->assertSessionHasErrors(['email' => 'Format email tidak valid.']);

        $this->assertGuest();
    }

    public function test_login_normalizes_email_case(): void
    {
        $user = User::factory()->create(['email' => 'mixed@example.com']);

        $this->post('/login', [
            'email' => '  MIXED@EXAMPLE.COM ',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_use_a_generic_message(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors(['email' => 'Email atau password salah.']);

        $this->assertGuest();
    }

    public function test_login_is_rate_limited_after_five_failures(): void
    {
        Cache::flush();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'limit@example.com',
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'limit@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString('Terlalu banyak percobaan masuk', session('errors')->first('email'));
        $this->assertGuest();
    }

    public function test_unverified_customer_is_redirected_to_otp_after_login(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Staff']);
        Role::create(['name' => 'Customer']);

        $user = User::factory()->unverified()->create();
        $user->roles_id = Role::where('name', 'Customer')->value('id');
        $user->save();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('otp.show', absolute: false));

        $this->assertAuthenticatedAs($user);
    }
}
