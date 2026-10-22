<?php

namespace Tests\Feature\Auth;

use App\Mail\OtpMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OtpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
    }

    private function customer(array $attributes = []): User
    {
        // CustomerMiddleware memeriksa roles_id === 3, jadi urutan role harus sama dengan seeder.
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Staff']);
        $role = Role::firstOrCreate(['name' => 'Customer']);

        $user = User::factory()->unverified()->create($attributes);
        $user->roles_id = $role->id;
        $user->save();

        return $user;
    }

    private function setOtp(User $user, string $code = '123456', ?Carbon $expires = null): void
    {
        $user->forceFill([
            'otp_code' => Hash::make($code),
            'otp_expires_at' => $expires ?? now()->addMinutes(5),
        ])->save();
    }

    public function test_guest_cannot_view_otp_page(): void
    {
        $this->get('/otp')->assertRedirect(route('login'));
    }

    public function test_verified_customer_is_redirected_to_dashboard(): void
    {
        $user = $this->customer(['email_verified_at' => now()]);

        $this->actingAs($user)->get('/otp')->assertRedirect(route('dashboard'));
    }

    public function test_unverified_customer_is_redirected_to_otp_page(): void
    {
        $user = $this->customer();

        $this->actingAs($user)->get('/customer/dashboard')->assertRedirect(route('otp.show'));
    }

    public function test_valid_otp_verifies_email_and_clears_otp(): void
    {
        Event::fake([Verified::class]);

        $user = $this->customer();
        $this->setOtp($user, '123456');

        $response = $this->actingAs($user)->post('/otp', ['otp_code' => '123456']);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('status', 'Akun berhasil diverifikasi.');
        Event::assertDispatched(Verified::class, fn (Verified $event) => $event->user->is($user));

        $fresh = $user->fresh();
        $this->assertNotNull($fresh->email_verified_at);
        $this->assertNull($fresh->otp_code);
        $this->assertNull($fresh->otp_expires_at);
    }

    public function test_wrong_otp_keeps_user_unverified(): void
    {
        $user = $this->customer();
        $this->setOtp($user, '123456');

        $response = $this->actingAs($user)->from(route('otp.show'))->post('/otp', ['otp_code' => '000000']);

        $response->assertSessionHasErrors('otp_code');
        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_expired_otp_is_rejected(): void
    {
        $user = $this->customer();
        $this->setOtp($user, '123456', now()->subMinute());

        $response = $this->actingAs($user)->from(route('otp.show'))->post('/otp', ['otp_code' => '123456']);

        $response->assertSessionHasErrors('otp_code');
        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_non_digit_otp_fails_validation(): void
    {
        $user = $this->customer();
        $this->setOtp($user, '123456');

        $response = $this->actingAs($user)->from(route('otp.show'))->post('/otp', ['otp_code' => 'abcdef']);

        $response->assertSessionHasErrors('otp_code');
        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_resend_sends_new_code_and_invalidates_old_code(): void
    {
        Mail::fake();

        $user = $this->customer();
        $this->setOtp($user, '111111');

        $this->actingAs($user)->post('/otp/resend')->assertRedirect();

        $newCode = null;
        Mail::assertSent(OtpMail::class, function (OtpMail $mail) use ($user, &$newCode) {
            $newCode = $mail->otp_code;

            return $mail->hasTo($user->email);
        });

        $this->assertSame(6, strlen($newCode));
        $this->assertTrue(Hash::check($newCode, $user->fresh()->otp_code));
        $this->assertFalse(Hash::check('111111', $user->fresh()->otp_code));
    }

    public function test_verify_attempts_do_not_block_resend(): void
    {
        Mail::fake();

        $user = $this->customer();
        $this->setOtp($user, '123456');

        for ($i = 0; $i < 3; $i++) {
            $this->actingAs($user)->from(route('otp.show'))->post('/otp', ['otp_code' => '000000']);
        }

        $response = $this->actingAs($user)->post('/otp/resend');

        $response->assertSessionHasNoErrors();
        Mail::assertSent(OtpMail::class);
    }

    public function test_five_wrong_attempts_clear_otp_code(): void
    {
        $user = $this->customer();
        $this->setOtp($user, '123456');

        for ($i = 0; $i < 5; $i++) {
            $this->actingAs($user)->from(route('otp.show'))->post('/otp', ['otp_code' => '000000']);
        }

        $this->assertNull($user->fresh()->otp_code);
        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_legacy_verify_email_route_is_gone(): void
    {
        $user = $this->customer();

        $this->actingAs($user)->get('/verify-email')->assertNotFound();
    }

    public function test_resend_mail_failure_returns_error_instead_of_server_error(): void
    {
        $user = $this->customer();

        Mail::shouldReceive('to')->andReturnSelf();
        Mail::shouldReceive('send')->andThrow(new \RuntimeException('SMTP down'));

        $response = $this->actingAs($user)->from(route('otp.show'))->post('/otp/resend');

        $response->assertRedirect(route('otp.show'));
        $response->assertSessionHasErrors('resend');
    }

    public function test_verify_route_throttle_redirects_with_friendly_error(): void
    {
        $user = $this->customer();
        $this->setOtp($user, '123456');

        for ($i = 0; $i < 10; $i++) {
            $this->actingAs($user)->from(route('otp.show'))->post('/otp', ['otp_code' => '000000']);
        }

        $response = $this->actingAs($user)->from(route('otp.show'))->post('/otp', ['otp_code' => '000000']);

        $response->assertRedirect(route('otp.show'));
        $response->assertSessionHasErrors('otp_code');
    }

    public function test_resend_cooldown_blocks_second_request(): void
    {
        Mail::fake();

        $user = $this->customer();

        $this->actingAs($user)->from(route('otp.show'))->post('/otp/resend')->assertRedirect();

        $response = $this->actingAs($user)->from(route('otp.show'))->post('/otp/resend');

        $response->assertRedirect(route('otp.show'));
        $response->assertSessionHasErrors('resend');
        Mail::assertSent(OtpMail::class, 1);
    }
}
