<?php

namespace Tests\Feature\Auth;

use App\Mail\OtpMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Cache::flush();
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        Role::create(['name' => 'Customer']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Test No. 1',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('otp.show', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'roles_id' => Role::where('name', 'Customer')->first()->id,
        ]);

        $user = User::where('email', 'test@example.com')->firstOrFail();

        $code = null;
        Mail::assertSent(OtpMail::class, function (OtpMail $mail) use ($user, &$code) {
            $code = $mail->otp_code;

            return $mail->hasTo($user->email);
        });

        $this->assertTrue(Hash::check($code, $user->otp_code));
        $this->assertTrue($user->otp_expires_at->between(now()->addMinutes(4), now()->addMinutes(6)));
    }

    public function test_registration_is_throttled_after_five_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/register', []);
        }

        $this->post('/register', [])->assertStatus(429);
    }

    public function test_registration_requires_all_fields(): void
    {
        $this->post('/register', [])->assertSessionHasErrors([
            'name',
            'email',
            'phone',
            'address',
            'password',
        ]);

        $this->assertGuest();
    }

    public function test_name_must_be_long_enough(): void
    {
        $this->registerCustomerRole();

        $this->post('/register', $this->payload(['name' => 'A']))
            ->assertSessionHasErrors(['name' => 'Nama lengkap minimal 2 karakter.']);
    }

    public function test_name_must_contain_a_letter(): void
    {
        $this->registerCustomerRole();

        $this->post('/register', $this->payload(['name' => '12345']))
            ->assertSessionHasErrors(['name' => 'Nama lengkap harus mengandung huruf.']);
    }

    public function test_address_must_be_at_least_ten_characters(): void
    {
        $this->registerCustomerRole();

        $this->post('/register', $this->payload(['address' => 'Jl. A']))
            ->assertSessionHasErrors(['address' => 'Alamat minimal 10 karakter.']);
    }

    public function test_invalid_email_is_rejected(): void
    {
        $this->registerCustomerRole();

        $this->post('/register', $this->payload(['email' => 'bukan-email']))
            ->assertSessionHasErrors(['email' => 'Format email tidak valid.']);
    }

    public function test_duplicate_email_is_rejected(): void
    {
        $this->registerCustomerRole();
        User::factory()->create(['email' => 'taken@example.com']);

        $this->post('/register', $this->payload(['email' => 'taken@example.com']))
            ->assertSessionHasErrors(['email' => 'Email sudah digunakan oleh akun lain.']);

        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
    }

    public function test_invalid_phone_is_rejected(): void
    {
        $this->registerCustomerRole();

        $this->post('/register', $this->payload(['phone' => '12345']))
            ->assertSessionHasErrors(['phone' => 'Format nomor HP tidak valid. Contoh: 081234567890.']);
    }

    public function test_phone_with_letters_is_rejected(): void
    {
        $this->registerCustomerRole();

        $this->post('/register', $this->payload(['phone' => '0812abc3456']))
            ->assertSessionHasErrors(['phone' => 'Format nomor HP tidak valid. Contoh: 081234567890.']);
    }

    public function test_email_and_phone_are_normalized_before_saving(): void
    {
        $this->registerCustomerRole();

        $this->post('/register', $this->payload([
            'email' => '  Test@Example.COM ',
            'phone' => '+62 812-3456-7890',
        ]))->assertRedirect(route('otp.show', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'phone' => '081234567890',
        ]);
    }

    public function test_password_must_match_confirmation(): void
    {
        $this->registerCustomerRole();

        $this->post('/register', $this->payload([
            'password' => 'password',
            'password_confirmation' => 'password-beda',
        ]))->assertSessionHasErrors(['password' => 'Konfirmasi password tidak cocok.']);

        $this->assertGuest();
    }

    public function test_password_must_be_at_least_eight_characters(): void
    {
        $this->registerCustomerRole();

        $this->post('/register', $this->payload([
            'password' => 'pendek',
            'password_confirmation' => 'pendek',
        ]))->assertSessionHasErrors(['password']);

        $this->assertGuest();
    }

    public function test_role_cannot_be_injected_during_registration(): void
    {
        $this->registerCustomerRole();
        $adminRole = Role::create(['name' => 'Admin']);

        $this->post('/register', $this->payload([
            'roles_id' => $adminRole->id,
            'role' => 'Admin',
        ]))->assertRedirect(route('otp.show', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'roles_id' => Role::where('name', 'Customer')->value('id'),
        ]);
    }

    private function registerCustomerRole(): Role
    {
        return Role::firstOrCreate(['name' => 'Customer']);
    }

    /**
     * @return array<string, string>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567890',
            'address' => 'Jl. Test No. 1',
            'password' => 'password',
            'password_confirmation' => 'password',
        ], $overrides);
    }
}
