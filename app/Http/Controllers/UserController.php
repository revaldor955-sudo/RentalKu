<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Rental;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('users.index', compact('roles'))->with('pageTitle', 'Pengguna');
    }

    /**
     * Server-side DataTables: daftar pengguna (search, sort, pagination)
     */
  
/**
 * Server-side DataTables: daftar pengguna.
 * Pengguna terbaru ditampilkan paling atas secara default.
 */
public function data(Request $request)
{
    $query = User::query()
        ->leftJoin('roles', 'users.roles_id', '=', 'roles.id')
        ->select(
            'users.*',
            'roles.name as role_name'
        );

    // Total pengguna sebelum pencarian.
    $recordsTotal = User::count();

    // Pencarian pengguna.
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

    // Total pengguna setelah pencarian.
    $recordsFiltered = (clone $query)
        ->distinct()
        ->count('users.id');

    /*
     * Pengurutan default:
     * pengguna yang baru dibuat tampil paling atas.
     */
    $orderColumn = $request->input('order.0.column');
    $orderDir = strtolower(
        (string) $request->input('order.0.dir', 'desc')
    ) === 'asc' ? 'asc' : 'desc';

    $columns = [
        0 => null,
        1 => 'users.name',
        2 => 'users.email',
        3 => 'roles.name',
        4 => 'users.phone',
        5 => 'users.address',
        6 => null,
    ];

    // Jika DataTables tidak meminta pengurutan kolom,
    // tampilkan pengguna terbaru terlebih dahulu.
    if (
        $orderColumn === null ||
        !isset($columns[(int) $orderColumn]) ||
        $columns[(int) $orderColumn] === null
    ) {
        $query->orderByDesc('users.created_at')
              ->orderByDesc('users.id');
    } else {
        // Tetap mendukung pengurutan ketika judul kolom diklik.
        $query->orderBy(
            $columns[(int) $orderColumn],
            $orderDir
        );

        // Pengurutan tambahan jika nilai kolom sama.
        $query->orderByDesc('users.created_at')
              ->orderByDesc('users.id');
    }

    // Pagination DataTables.
    $start = max(0, (int) $request->input('start', 0));
    $length = (int) $request->input('length', 10);

    if ($length === -1) {
        $length = 100;
    } else {
        $length = min(max($length, 1), 100);
    }

    $users = $query
        ->offset($start)
        ->limit($length)
        ->get();

    // Format data untuk DataTables.
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

        // Defense-in-depth: hanya Admin yang boleh memberi role Admin.
        if ((int) $validated['roles_id'] === 1 && auth()->user()->roles_id !== 1) {
            abort(403, 'Hanya Admin yang boleh memberi role Admin.');
        }

        // roles_id di luar Fillable: set eksplisit pasca-gate.
        $rolesId = $validated['roles_id'];
        unset($validated['roles_id']);

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

        $user = User::create($validated);
        $user->roles_id = $rolesId;
        // Admin membuat akun, jadi email dianggap tepercaya tanpa OTP.
        $user->email_verified_at = now();
        $user->save();

        return response()->json([
            'message' => 'Pengguna berhasil ditambahkan.',
        ], 201);
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
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'roles_id.required' => 'Role wajib dipilih.',
            'roles_id.exists' => 'Role tidak valid.',
            'photo.image' => 'Foto harus berupa gambar.',
            'photo.mimes' => 'Foto harus JPG, JPEG, atau PNG.',
            'photo.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        // Defense-in-depth: akun Admin hanya boleh diubah Admin;
        // hanya Admin yang boleh memberi atau mencabut role Admin.
        if (auth()->user()->roles_id !== 1 && ($user->roles_id === 1 || (int) $validated['roles_id'] === 1)) {
            abort(403, 'Hanya Admin yang boleh mengubah akun Admin.');
        }

        // roles_id di luar Fillable: set eksplisit pasca-gate.
        $rolesId = $validated['roles_id'];
        unset($validated['roles_id']);

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

        $emailChanged = $user->email !== $validated['email'];

        $user->fill($validated);
        $user->roles_id = $rolesId;

        $isCustomer = (int) $user->roles_id === 3;

        // Email baru harus diverifikasi ulang oleh customer.
        if ($emailChanged) {
            $user->email_verified_at = null;

            if ($isCustomer) {
                $user->otp_code = null;
                $user->otp_expires_at = null;
            }
        }

        $user->save();

        $mailFailed = false;

        if ($emailChanged && $isCustomer) {
            $otpCode = $user->issueOtp();
            RateLimiter::clear('otp-attempts:'.$user->id);

            try {
                Mail::to($user->email)->send(new OtpMail($otpCode, $user->name));
                RateLimiter::hit('otp-resend-cooldown:'.$user->id, 60);
            } catch (\Throwable $e) {
                $mailFailed = true;
                report($e);
            }
        }

        return response()->json([
            'message' => $mailFailed
                ? 'Pengguna berhasil diperbarui, tapi kode OTP gagal dikirim. Minta pengguna klik "Kirim ulang".'
                : 'Pengguna berhasil diperbarui.',
            'mail_failed' => $mailFailed,
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'message' => 'Akun yang sedang digunakan tidak dapat dihapus.',
            ], 422);
        }

        // Defense-in-depth: akun Admin hanya boleh dihapus Admin.
        if ($user->roles_id === 1 && auth()->user()->roles_id !== 1) {
            abort(403, 'Hanya Admin yang boleh menghapus akun Admin.');
        }

        // Hapus user = cascade hapus rentals + pembayaran/denda/klaim — cegah bila ada riwayat.
        if (Rental::where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'Pengguna tidak dapat dihapus karena masih memiliki riwayat rental.',
            ], 422);
        }

        if ($user->photo && File::exists(public_path($user->photo))) {
            File::delete(public_path($user->photo));
        }

        $user->delete();

        return response()->json([
            'message' => 'Pengguna berhasil dihapus.',
        ]);
    }
}
