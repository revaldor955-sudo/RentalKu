<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        $message = match ($status) {
            Password::RESET_LINK_SENT => 'Tautan reset password sudah dikirim ke email Anda.',
            Password::INVALID_USER => 'Email tidak terdaftar.',
            Password::RESET_THROTTLED => 'Tunggu sebentar sebelum meminta tautan lagi.',
            default => 'Gagal mengirim tautan reset password.',
        };

        return $status === Password::RESET_LINK_SENT
                    ? back()->with('status', $message)
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => $message]);
    }
}
