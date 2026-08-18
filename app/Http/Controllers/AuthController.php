<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:25',
            'address' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $customerRole = Role::where('name', 'Customer')->first();

        if (!$customerRole) {
            return back()->withInput()->withErrors([
                'email' => 'Role Customer belum tersedia di database.'
            ]);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'roles_id' => $customerRole->id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect('/login')->with(
            'success',
            'Pendaftaran berhasil. Silakan masuk.'
        );
    }
    public function showLogin()
{
    return view('auth.login');
}

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ], [
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'password.required' => 'Password wajib diisi.',
    ]);

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user();

        // Admin
        if ($user->roles_id == 1) {
            return redirect()->route('admin.dashboard');
        }

        // Staff Rental
        if ($user->roles_id == 2) {
            return redirect()->route('staff.dashboard');
        }

        // Customer
        if ($user->roles_id == 3) {
            return redirect()->route('customer.dashboard');
        }

        // Jika role tidak dikenali
        Auth::logout();

        return redirect()->route('login')->withErrors([
            'email' => 'Role akun tidak dikenali.',
        ]);
    }

    return back()
        ->withInput($request->only('email'))
        ->withErrors([
            'email' => 'Email atau password salah.',
        ]);
}
public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with(
        'success',
        'Kamu berhasil keluar dari akun.'
    );
}
}