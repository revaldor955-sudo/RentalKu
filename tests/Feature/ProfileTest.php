<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'current_password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }

    public function test_photo_can_be_removed(): void
    {
        $user = User::factory()->create();

        $folder = public_path('images/users');
        if (! is_dir($folder)) {
            mkdir($folder, 0755, true);
        }
        $path = 'images/users/test_hapus.jpg';
        copy(__DIR__ . '/../../public/favicon.ico', public_path($path));
        $user->forceFill(['photo' => $path])->save();

        $response = $this
            ->actingAs($user)
            ->patchJson('/profile', [
                'name' => $user->name,
                'email' => $user->email,
                'remove_photo' => '1',
            ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('user.photo_url', null);

        $this->assertNull($user->fresh()->photo);
        $this->assertFileDoesNotExist(public_path($path));
    }

    public function test_profile_email_field_is_editable(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response->assertOk();
        $response->assertDontSee('readonly', false);
    }

    public function test_email_change_requires_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->patch('/profile', [
                'name' => $user->name,
                'email' => 'new-email@example.com',
            ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertSame($user->email, $user->fresh()->email);
    }

    public function test_email_change_rejects_incorrect_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->patch('/profile', [
                'name' => $user->name,
                'email' => 'new-email@example.com',
                'current_password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertSame($user->email, $user->fresh()->email);
    }

    public function test_name_update_with_empty_current_password_is_allowed_when_email_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->patch('/profile', [
                'name' => 'Nama Baru',
                'email' => $user->email,
                'current_password' => '',
            ]);

        $response->assertRedirect('/profile');
        $this->assertSame('Nama Baru', $user->fresh()->name);
    }

    public function test_email_case_change_is_normalized_without_current_password(): void
    {
        $user = User::factory()->create(['email' => 'case@example.com']);

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->patch('/profile', [
                'name' => $user->name,
                'email' => 'CASE@EXAMPLE.COM',
            ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('case@example.com', $user->email);
        $this->assertNotNull($user->email_verified_at);
    }
}
