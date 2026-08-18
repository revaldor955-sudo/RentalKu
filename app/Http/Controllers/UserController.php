<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index()
    {
      $users = User::latest()->get();
$roles = \App\Models\Role::all();

return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
       $validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255|unique:users,email',
    'password' => 'required|string|min:6',
    'roles_id' => 'required|exists:roles,id',
    'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    'phone' => 'nullable|string|max:20',
    'address' => 'nullable|string',
], [
    'name.required' => 'Nama pengguna wajib diisi.',
    'email.required' => 'Email wajib diisi.',
    'email.email' => 'Format email tidak valid.',
    'email.unique' => 'Email sudah digunakan.',
    'password.required' => 'Password wajib diisi.',
    'password.min' => 'Password minimal 6 karakter.',
    'roles_id.required' => 'Role wajib dipilih.',
    'roles_id.exists' => 'Role tidak valid.',
    'photo.image' => 'Foto harus berupa gambar.',
    'photo.mimes' => 'Foto harus JPG, JPEG, atau PNG.',
    'photo.max' => 'Ukuran foto maksimal 2 MB.',
]);
        if ($request->hasFile('photo')) {

            $folder = public_path('images/users');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $photo = $request->file('photo');

            $photoName = time() . '_' . $photo->getClientOriginalName();

            $photo->move($folder, $photoName);

            $validated['photo'] = 'images/users/' . $photoName;
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'roles_id' => 'required|exists:roles,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {

            if ($user->photo && File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }

            $folder = public_path('images/users');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $photo = $request->file('photo');

            $photoName = time() . '_' . $photo->getClientOriginalName();

            $photo->move($folder, $photoName);

            $validated['photo'] = 'images/users/' . $photoName;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        if ($user->photo && File::exists(public_path($user->photo))) {
            File::delete(public_path($user->photo));
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
