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

class OtpLifecycleTest extends TestCase
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

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->roles_id = Role::where('name', 'Admin')->value('id');
        $user->save();

        return $user;
    }

    public function test_customer_email_change_issues_new_otp_and_redirects_to_verification(): void
    {
        Mail::fake();

        $user = $this->customer();
        $user->forceFill([
            'otp_code' => Hash::make('111111'),
            'otp_expires_at' => now()->addMinutes(5),
        ])->save();

        $newEmail = 'customer-baru@example.com';

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => $user->name,
            'email' => $newEmail,
            'current_password' => 'password',
        ]);

        $response->assertRedirect(route('otp.show'));

        $fresh = $user->fresh();
        $this->assertNull($fresh->email_verified_at);
        $this->assertNotNull($fresh->otp_code);
        $this->assertFalse(Hash::check('111111', $fresh->otp_code));

        $newCode = null;
        Mail::assertSent(OtpMail::class, function (OtpMail $mail) use ($newEmail, &$newCode) {
            $newCode = $mail->otp_code;

            return $mail->hasTo($newEmail);
        });

        $this->assertTrue(Hash::check($newCode, $fresh->otp_code));

        $this->actingAs($user)->post('/otp', ['otp_code' => $newCode])
            ->assertRedirect(route('dashboard'));

        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_customer_email_change_via_json_requests_verification_redirect(): void
    {
        Mail::fake();

        $user = $this->customer();

        $response = $this->actingAs($user)->patchJson('/profile', [
            'name' => $user->name,
            'email' => 'customer-json@example.com',
            'current_password' => 'password',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('requires_verification', true)
            ->assertJsonPath('redirect', route('otp.show'));
    }

    public function test_admin_created_user_is_marked_verified(): void
    {
        $admin = $this->admin();
        $customerRoleId = Role::where('name', 'Customer')->value('id');

        $response = $this->actingAs($admin)->postJson('/users', [
            'name' => 'Pelanggan Baru',
            'email' => 'pelanggan-baru@example.com',
            'password' => 'password123',
            'roles_id' => $customerRoleId,
        ]);

        $response->assertCreated();

        $this->assertNotNull(User::where('email', 'pelanggan-baru@example.com')->value('email_verified_at'));
    }

    public function test_admin_email_change_resets_verification_and_otp(): void
    {
        Mail::fake();

        $admin = $this->admin();
        $customerRoleId = Role::where('name', 'Customer')->value('id');
        $customer = $this->customer(['email_verified_at' => now()]);
        $customer->forceFill([
            'otp_code' => Hash::make('123456'),
            'otp_expires_at' => now()->addMinutes(5),
        ])->save();

        $response = $this->actingAs($admin)->putJson('/users/'.$customer->id, [
            'name' => $customer->name,
            'email' => 'email-baru@example.com',
            'roles_id' => $customerRoleId,
        ]);

        $response->assertOk();

        $fresh = $customer->fresh();
        $this->assertSame('email-baru@example.com', $fresh->email);
        $this->assertNull($fresh->email_verified_at);
        $this->assertNotNull($fresh->otp_code);
        $this->assertNotNull($fresh->otp_expires_at);

        Mail::assertSent(OtpMail::class, function (OtpMail $mail) {
            return $mail->hasTo('email-baru@example.com');
        });
    }

    public function test_non_customer_email_change_resets_verification_without_otp_redirect(): void
    {
        $staff = User::factory()->create();
        $staff->roles_id = Role::where('name', 'Staff')->value('id');
        $staff->save();

        $response = $this->actingAs($staff)->patch('/profile', [
            'name' => $staff->name,
            'email' => 'staff-baru@example.com',
            'current_password' => 'password',
        ]);

        $response->assertRedirect('/profile');

        $fresh = $staff->fresh();
        $this->assertSame('staff-baru@example.com', $fresh->email);
        $this->assertNull($fresh->email_verified_at);
    }

    public function test_customer_email_change_mail_failure_returns_json_warning(): void
    {
        $user = $this->customer();

        Mail::shouldReceive('to')->andReturnSelf();
        Mail::shouldReceive('send')->andThrow(new \RuntimeException('SMTP down'));

        $response = $this->actingAs($user)->patchJson('/profile', [
            'name' => $user->name,
            'email' => 'customer-gagal@example.com',
            'current_password' => 'password',
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('requires_verification', true)
            ->assertJsonPath('mail_failed', true)
            ->assertJsonPath('redirect', route('otp.show'));

        $this->assertStringContainsString('gagal dikirim', $response->json('message'));
    }

    public function test_customer_email_change_mail_failure_redirects_with_resend_error(): void
    {
        $user = $this->customer();

        Mail::shouldReceive('to')->andReturnSelf();
        Mail::shouldReceive('send')->andThrow(new \RuntimeException('SMTP down'));

        $response = $this->actingAs($user)->from('/profile')->patch('/profile', [
            'name' => $user->name,
            'email' => 'customer-gagal-2@example.com',
            'current_password' => 'password',
        ]);

        $response->assertRedirect(route('otp.show'));
        $response->assertSessionHasErrors('resend');
    }

    public function test_email_change_is_rate_limited_per_user(): void
    {
        Mail::fake();

        $user = $this->customer();

        for ($i = 1; $i <= 3; $i++) {
            $this->actingAs($user)->patchJson('/profile', [
                'name' => $user->name,
                'email' => "rate-{$i}@example.com",
                'current_password' => 'password',
            ])->assertOk();
        }

        $response = $this->actingAs($user)->patchJson('/profile', [
            'name' => $user->name,
            'email' => 'rate-4@example.com',
            'current_password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => ['email']]);
        $this->assertSame('rate-3@example.com', $user->fresh()->email);
    }

    public function test_resend_after_attempt_cap_allows_new_code_submission(): void
    {
        Mail::fake();

        $user = $this->customer();
        $user->forceFill([
            'otp_code' => Hash::make('111111'),
            'otp_expires_at' => now()->addMinutes(5),
        ])->save();

        for ($i = 0; $i < 5; $i++) {
            $this->actingAs($user)->from(route('otp.show'))->post('/otp', ['otp_code' => '000000']);
        }

        $this->assertNull($user->fresh()->otp_code);

        $this->actingAs($user)->post('/otp/resend')->assertRedirect(route('otp.show'));

        $newCode = null;
        Mail::assertSent(OtpMail::class, function (OtpMail $mail) use (&$newCode) {
            $newCode = $mail->otp_code;

            return true;
        });

        $this->actingAs($user)->post('/otp', ['otp_code' => $newCode])
            ->assertRedirect(route('dashboard'));

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
