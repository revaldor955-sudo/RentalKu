<?php

namespace Tests\Feature\Auth;

use App\Mail\OtpMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class EmailChangePageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();

        // CustomerMiddleware memeriksa roles_id === 3, jadi urutan role harus sama dengan seeder.
        Role::create(['name' => 'Admin', 'description' => 'Administrator.']);
        Role::create(['name' => 'Staff', 'description' => 'Staff.']);
        Role::create(['name' => 'Customer', 'description' => 'Customer.']);
    }

    private function customer(array $attributes = []): User
    {
        $user = User::factory()->unverified()->create($attributes);
        $user->roles_id = Role::where('name', 'Customer')->value('id');
        $user->save();

        return $user;
    }

    public function test_guest_is_redirected_from_email_change_page(): void
    {
        $this->get(route('profile.email.edit'))->assertRedirect(route('login'));
    }

    public function test_customer_sees_email_change_page_with_current_email(): void
    {
        $user = $this->customer();

        $this->actingAs($user)
            ->get(route('profile.email.edit'))
            ->assertOk()
            ->assertViewHas('user', fn (User $viewUser) => $viewUser->is($user))
            ->assertSee($user->email);
    }

    public function test_email_change_without_current_password_is_rejected(): void
    {
        Mail::fake();

        $user = $this->customer();
        $oldEmail = $user->email;

        $response = $this->actingAs($user)
            ->from(route('profile.email.edit'))
            ->patch(route('profile.email.update'), [
                'email' => 'tanpa-password@example.com',
            ]);

        $response->assertSessionHasErrors('current_password');

        $this->assertSame($oldEmail, $user->fresh()->email);
        Mail::assertNothingSent();
    }

    public function test_customer_email_change_issues_fresh_otp_to_new_address(): void
    {
        Mail::fake();

        $user = $this->customer(['email_verified_at' => now()]);
        $user->forceFill([
            'otp_code' => Hash::make('111111'),
            'otp_expires_at' => now()->addMinutes(5),
        ])->save();

        $newEmail = 'halaman-baru@example.com';

        $response = $this->actingAs($user)->patch(route('profile.email.update'), [
            'email' => $newEmail,
            'current_password' => 'password',
        ]);

        $response
            ->assertRedirect(route('otp.show'))
            ->assertSessionHas('status');

        $fresh = $user->fresh();
        $this->assertSame($newEmail, $fresh->email);
        $this->assertNull($fresh->email_verified_at);
        $this->assertNotNull($fresh->otp_code);
        $this->assertNotNull($fresh->otp_expires_at);
        $this->assertFalse(Hash::check('111111', $fresh->otp_code));

        $newCode = null;
        Mail::assertSent(OtpMail::class, function (OtpMail $mail) use ($newEmail, &$newCode) {
            $newCode = $mail->otp_code;

            return $mail->hasTo($newEmail);
        });

        $this->assertTrue(Hash::check($newCode, $fresh->otp_code));
    }

    public function test_same_email_returns_status_without_sending_mail(): void
    {
        Mail::fake();

        $user = $this->customer(['email_verified_at' => now()]);

        $response = $this->actingAs($user)
            ->from(route('profile.email.edit'))
            ->patch(route('profile.email.update'), [
                'email' => $user->email,
                'current_password' => 'password',
            ]);

        $response->assertSessionHas('status', 'Email tidak berubah.');

        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->assertSame(0, RateLimiter::attempts('profile-email-change:'.$user->id));
        Mail::assertNothingSent();
    }

    public function test_fourth_email_change_within_ten_minutes_is_rejected(): void
    {
        Mail::fake();

        $user = $this->customer();

        for ($i = 1; $i <= 3; $i++) {
            $this->actingAs($user)->patch(route('profile.email.update'), [
                'email' => "batas-{$i}@example.com",
                'current_password' => 'password',
            ])->assertRedirect(route('otp.show'));
        }

        $response = $this->actingAs($user)
            ->from(route('profile.email.edit'))
            ->patch(route('profile.email.update'), [
                'email' => 'batas-4@example.com',
                'current_password' => 'password',
            ]);

        $response->assertSessionHasErrors('email');

        $this->assertSame('batas-3@example.com', $user->fresh()->email);
        $this->assertArrayNotHasKey('current_password', session('_old_input', []));
    }
}
