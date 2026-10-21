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
}
