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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:25'],
            'address' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.required' => 'Nomor HP wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
        ]);

        $code = (string) random_int(100000, 999999);

        $customerRole = Role::where('name', 'Customer')->first();

        if (! $customerRole) {
            throw ValidationException::withMessages([
                'email' => 'Role Customer belum tersedia di database.',
            ]);
        }

        // roles_id di luar Fillable User: set eksplisit (selalu Customer).
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'otp_code' => Hash::make($code),
            'otp_expires_at' => now()->addMinutes(5),
        ]);
        $user->roles_id = $customerRole->id;
        $user->save();

        Mail::to($user->email)->send(new OtpMail($code, $user->name));

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('otp.show'))->with('status', 'Akun berhasil dibuat. Silahkan cek email untuk kode OTP.');
    }
}
