<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('users.index', compact('roles'));
    }

    /**
     * Server-side DataTables: daftar pengguna (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = User::query()
            ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
            ->select(
                'users.*',
                'roles.name as role_name'
            );

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('users.phone', 'like', "%{$search}%")
                    ->orWhere('users.address', 'like', "%{$search}%")
                    ->orWhere('roles.name', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'users.name',
            2 => 'users.email',
            3 => 'roles.name',
            4 => 'users.phone',
            5 => 'users.address',
            6 => null,
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('users.name', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $users = $query->offset($start)->limit($length)->get();

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles_id' => $user->roles_id,
                'role_name' => $user->role_name ?? 'Belum Ada Role',
                'phone' => $user->phone ?? '-',
                'address' => $user->address ?? '-',
                'photo' => $user->photo,
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    /**
     * Detail pengguna untuk modal popup (AJAX)
     */
    public function detail(User $user)
    {
        $user->load('role');

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles_id' => $user->roles_id,
            'role_name' => $user->role->name ?? 'Belum Ada Role',
            'phone' => $user->phone ?? '-',
            'address' => $user->address ?? '-',
            'photo' => $user->photo,
            'photo_url' => $user->photo ? asset($user->photo) : null,
        ]);
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

            if (! File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $photo = $request->file('photo');

            $photoName = time().'_'.$photo->getClientOriginalName();

            $photo->move($folder, $photoName);

            $validated['photo'] = 'images/users/'.$photoName;
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
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
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

            if (! File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $photo = $request->file('photo');

            $photoName = time().'_'.$photo->getClientOriginalName();

            $photo->move($folder, $photoName);

            $validated['photo'] = 'images/users/'.$photoName;
        }

        if (! empty($validated['password'])) {
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
