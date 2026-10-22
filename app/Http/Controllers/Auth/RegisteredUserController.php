<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $phone = preg_replace('/[\s\-().]+/', '', (string) $request->input('phone'));

        if (str_starts_with($phone, '+62')) {
            $phone = '0'.substr($phone, 3);
        } elseif (str_starts_with($phone, '62')) {
            $phone = '0'.substr($phone, 2);
        }

        $request->merge([
            'name' => preg_replace('/\s+/u', ' ', trim((string) $request->input('name'))),
            'email' => strtolower(trim((string) $request->input('email'))),
            'phone' => $phone,
            'address' => trim((string) $request->input('address')),
        ]);

        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255', 'regex:/[\p{L}]/u'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:25', 'regex:/^08\d{8,11}$/'],
            'address' => ['required', 'string', 'min:10', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 2 karakter.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'name.regex' => 'Nama lengkap harus mengandung huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'phone.regex' => 'Format nomor HP tidak valid. Contoh: 081234567890.',
            'address.required' => 'Alamat wajib diisi.',
            'address.min' => 'Alamat minimal 10 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $customerRole = Role::where('name', 'Customer')->first();

        if (! $customerRole) {
            throw ValidationException::withMessages([
                'email' => 'Role Customer belum tersedia di database.',
            ]);
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);
        // roles_id di luar Fillable User: set eksplisit (roles_id selalu Customer).
        $user->roles_id = $customerRole->id;
        $user->save();

        $code = $user->issueOtp();

        $mailSent = true;

        try {
            Mail::to($user->email)->send(new OtpMail($code, $user->name));
        } catch (\Throwable $e) {
            $mailSent = false;
            report($e);
        }

        event(new Registered($user));

        Auth::login($user);

        if (! $mailSent) {
            return redirect(route('otp.show'))->withErrors([
                'resend' => 'Akun berhasil dibuat, tapi kode OTP gagal dikirim. Silahkan klik "Kirim ulang".',
            ]);
        }

        return redirect(route('otp.show'))->with('status', 'Akun berhasil dibuat. Silahkan cek email untuk kode OTP.');
    }
}
