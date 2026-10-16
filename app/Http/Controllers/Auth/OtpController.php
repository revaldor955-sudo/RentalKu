<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

class OtpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ($request->user()->email_verified_at) {
            return redirect()->route('dashboard');
        }
        return view('auth.otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => ['required', 'string', 'size:6'],
        ]);

        $user = $request->user();

        if (!$user->otp_code || !$user->otp_expires_at || $user->otp_expires_at->isPast()) {
            return back()->withErrors(['otp_code' => 'Kode OTP sudah kadaluwarsa. Silahkan kirim ulang kode.']);
        }

        if (!Hash::check($request->otp_code, $user->otp_code)) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid.']);
        }

        $user
            ->forceFill([
                'email_verified_at' => now(),
                'otp_code' => null,
                'otp_expires_at' => null,
            ])
            ->save();

        return redirect()->route('dashboard')->with('status', 'Akun berhasil diverifikasi.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        $otp_code = (string) random_int(100000, 999999);

        $user
            ->forceFill([
                'otp_code' => Hash::make($otp_code),
                'otp_expires_at' => now()->addMinutes(5),
            ])
            ->save();

        Mail::to($user->email)->send(new OtpMail($otp_code, $user->name));

        return back()->with('status', 'Kode baru sudah dikirim ke email kamu.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
