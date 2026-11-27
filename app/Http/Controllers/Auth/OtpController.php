<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class OtpController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        return view('auth.otp', [
            'resendAvailableIn' => RateLimiter::availableIn('otp-resend-cooldown:'.$user->id),
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp_code' => ['required', 'digits:6'],
        ], [
            'otp_code.required' => 'Kode OTP wajib diisi.',
            'otp_code.digits' => 'Kode OTP harus 6 digit angka.',
        ]);

        $user = $request->user();

        if (! $user->otp_code || ! $user->otp_expires_at) {
            return back()->withErrors([
                'otp_code' => 'Belum ada kode OTP. Silakan klik "Kirim ulang".',
            ]);
        }

        if ($user->otp_expires_at->isPast()) {
            return back()->withErrors([
                'otp_code' => 'Kode OTP sudah kadaluwarsa. Silakan kirim ulang kode.',
            ]);
        }

        $attemptKey = 'otp-attempts:'.$user->id;

        if (! Hash::check($request->otp_code, $user->otp_code)) {
            RateLimiter::hit($attemptKey, 300);

            if (RateLimiter::tooManyAttempts($attemptKey, 5)) {
                $user->clearOtp();

                return back()->withErrors([
                    'otp_code' => 'Terlalu banyak percobaan. Kode OTP dibatalkan, silakan kirim ulang kode.',
                ]);
            }

            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid.']);
        }

        RateLimiter::clear($attemptKey);

        $user->forceFill([
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();

        event(new Verified($user));

        return redirect()->route('dashboard')->with('status', 'Akun berhasil diverifikasi.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        $cooldownKey = 'otp-resend-cooldown:'.$user->id;

        if (RateLimiter::tooManyAttempts($cooldownKey, 1)) {
            $seconds = RateLimiter::availableIn($cooldownKey);

            return back()->withErrors([
                'resend' => "Tunggu {$seconds} detik sebelum mengirim ulang kode.",
            ]);
        }

        $otpCode = $user->issueOtp();

        try {
            Mail::to($user->email)->send(new OtpMail($otpCode, $user->name));
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors(['resend' => 'Kode gagal dikirim. Silakan coba lagi.']);
        }

        RateLimiter::hit($cooldownKey, 60);

        return back()->with('status', 'Kode baru sudah dikirim ke email kamu.');
    }
}
