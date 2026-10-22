<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (AJAX from profile modal).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $emailChanged = $user->email !== $validated['email'];
        $isCustomer = (int) $user->roles_id === 3;
        $emailChangeKey = 'profile-email-change:'.$user->id;

        // Cek limit sebelum side effect foto; request yang ditolak tidak boleh mengubah file.
        if ($emailChanged && RateLimiter::tooManyAttempts($emailChangeKey, 3)) {
            $seconds = RateLimiter::availableIn($emailChangeKey);
            $message = "Terlalu banyak perubahan email. Coba lagi dalam {$seconds} detik.";

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => $message,
                    'errors' => ['email' => [$message]],
                ], 422);
            }

            return back()->withErrors(['email' => $message]);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->photo && File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }

            $folder = public_path('images/users');
            if (!File::isDirectory($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move($folder, $photoName);
            $validated['photo'] = 'images/users/' . $photoName;
        }

        // Remove photo key if no file uploaded (don't null existing)
        if (!$request->hasFile('photo') && !$request->has('remove_photo')) {
            unset($validated['photo']);
        }

        // Handle remove photo
        if ($request->has('remove_photo') && $request->remove_photo) {
            if ($user->photo && File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }
            $validated['photo'] = null;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;

            if ($isCustomer) {
                $user->otp_code = null;
                $user->otp_expires_at = null;
            }
        }

        $user->save();

        if ($emailChanged) {
            RateLimiter::hit($emailChangeKey, 600);
        }

        $requiresVerification = $emailChanged && $isCustomer;
        $mailSent = true;

        if ($requiresVerification) {
            $mailSent = $this->sendEmailChangeOtp($user);
        }

        $verificationMessage = $mailSent
            ? 'Email berubah. Kode OTP baru sudah dikirim ke email baru.'
            : 'Email berubah, tapi kode OTP gagal dikirim. Silakan klik "Kirim ulang" di halaman verifikasi.';

        // AJAX request → JSON response
        if ($request->ajax() || $request->wantsJson()) {
            $payload = [
                'success' => true,
                'mail_sent' => $mailSent,
                'message' => $requiresVerification ? $verificationMessage : 'Profil berhasil diperbarui.',
                'user'    => [
                    'name'      => $user->name,
                    'email'     => $user->email,
                    'phone'     => $user->phone,
                    'address'   => $user->address,
                    'photo_url' => $user->photo ? asset($user->photo) : null,
                ],
            ];

            if ($requiresVerification) {
                $payload['requires_verification'] = true;
                $payload['mail_failed'] = ! $mailSent;
                $payload['redirect'] = route('otp.show');
            }

            return response()->json($payload);
        }

        if ($requiresVerification) {
            return $mailSent
                ? redirect()->route('otp.show')->with('status', $verificationMessage)
                : redirect()->route('otp.show')->withErrors(['resend' => $verificationMessage]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Display the dedicated change-email form.
     */
    public function editEmail(Request $request): View
    {
        return view('profile.change-email', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's email from the dedicated change-email form.
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'current_password' => ['required', 'current_password'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'current_password.required' => 'Konfirmasi password wajib diisi untuk mengubah email.',
            'current_password.current_password' => 'Password yang Anda masukkan salah.',
        ]);

        if ($validated['email'] === $user->email) {
            return back()->with('status', 'Email tidak berubah.');
        }

        $emailChangeKey = 'profile-email-change:'.$user->id;

        if (RateLimiter::tooManyAttempts($emailChangeKey, 3)) {
            $seconds = RateLimiter::availableIn($emailChangeKey);

            return back()
                ->withErrors(['email' => "Terlalu banyak perubahan email. Coba lagi dalam {$seconds} detik."])
                ->withInput($request->only('email'));
        }

        $isCustomer = (int) $user->roles_id === 3;

        $user->email = $validated['email'];
        $user->email_verified_at = null;

        if ($isCustomer) {
            $user->otp_code = null;
            $user->otp_expires_at = null;
        }

        $user->save();

        RateLimiter::hit($emailChangeKey, 600);

        if (! $isCustomer) {
            return Redirect::route('profile.edit')->with('status', 'Email berhasil diperbarui.');
        }

        $mailSent = $this->sendEmailChangeOtp($user);

        $verificationMessage = $mailSent
            ? 'Email berubah. Kode OTP baru sudah dikirim ke email baru.'
            : 'Email berubah, tapi kode OTP gagal dikirim. Silakan klik "Kirim ulang" di halaman verifikasi.';

        return $mailSent
            ? redirect()->route('otp.show')->with('status', $verificationMessage)
            : redirect()->route('otp.show')->withErrors(['resend' => $verificationMessage]);
    }

    private function sendEmailChangeOtp(User $user): bool
    {
        $otpCode = $user->issueOtp();

        RateLimiter::clear('otp-attempts:'.$user->id);

        try {
            Mail::to($user->email)->send(new OtpMail($otpCode, $user->name));
            RateLimiter::hit('otp-resend-cooldown:'.$user->id, 60);
        } catch (\Throwable $e) {
            report($e);

            return false;
        }

        return true;
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
