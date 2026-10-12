<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index')->with('pageTitle', 'Role');
    }

    /**
     * Server-side DataTables: daftar role (search, sort, pagination)
     */
   
/**
 * Server-side DataTables: daftar role.
 * Role terbaru tampil paling atas secara default.
 */
public function data(Request $request)
{
    $query = Role::query()->withCount('users');

    // Jumlah seluruh role sebelum pencarian.
    $recordsTotal = Role::count();

    // Pencarian role.
    $search = $request->input('search.value');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('roles.name', 'like', "%{$search}%")
                ->orWhere('roles.description', 'like', "%{$search}%");
        });
    }

    // Jumlah role setelah pencarian.
    $recordsFiltered = (clone $query)->count('roles.id');

    // Kolom yang boleh digunakan untuk pengurutan.
    $columns = [
        0 => null,
        1 => 'roles.name',
        2 => 'roles.description',
        3 => null,
    ];

    $orderColumn = $request->input('order.0.column');
    $orderDir = strtolower(
        (string) $request->input('order.0.dir', 'desc')
    ) === 'asc' ? 'asc' : 'desc';

    /*
     * Jika tidak ada pengurutan kolom dari DataTables,
     * tampilkan role terbaru terlebih dahulu.
     */
    if (
        $orderColumn === null ||
        !isset($columns[(int) $orderColumn]) ||
        $columns[(int) $orderColumn] === null
    ) {
        $query->orderByDesc('roles.created_at')
              ->orderByDesc('roles.id');
    } else {
        // Tetap mendukung pengurutan ketika kolom diklik.
        $query->orderBy(
            $columns[(int) $orderColumn],
            $orderDir
        );

        $query->orderByDesc('roles.created_at')
              ->orderByDesc('roles.id');
    }

    // Pagination.
    $start = max(0, (int) $request->input('start', 0));
    $length = (int) $request->input('length', 10);

    if ($length === -1) {
        $length = 100;
    } else {
        $length = min(max($length, 1), 100);
    }

    $roles = $query
        ->offset($start)
        ->limit($length)
        ->get();

    // Data untuk DataTables.
    $data = $roles->map(function ($item) {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'users_count' => $item->users_count,
        ];
    });

    return response()->json([
        'draw' => (int) $request->input('draw'),
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $data,
    ]);
}


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|in:Admin,Staff,Customer|unique:roles,name',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama role wajib diisi',
            'name.in' => 'Role harus Admin, Staff, atau Customer',
            'name.unique' => 'Role tersebut sudah ada',
        ]);

        Role::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Role berhasil dibuat.',
            ]);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dibuat.');
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        //
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|in:Admin,Staff,Customer|unique:roles,name,'.$role->id,
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama role wajib diisi',
            'name.in' => 'Role harus Admin, Staff, atau Customer',
            'name.unique' => 'Role tersebut sudah ada',
        ]);

        // Nama role dipakai middleware akses — jangan diganti selagi dipakai user.
        if ($validated['name'] !== $role->name && $role->users()->exists()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Nama role tidak dapat diganti karena masih dipakai user.',
                ], 422);
            }

            return redirect()->route('roles.index')->with('error', 'Nama role tidak dapat diganti karena masih dipakai user.');
        }

        $role->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Role berhasil diperbarui.',
            ]);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Request $request, Role $role)
    {
        // Hapus role = user kehilangan akses (FK nullOnDelete) — cegah bila dipakai.
        if ($role->users()->exists()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Role tidak dapat dihapus karena masih dipakai user.',
                ], 422);
            }

            return redirect()->route('roles.index')->with('error', 'Role tidak dapat dihapus karena masih dipakai user.');
        }

        $role->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Role berhasil dihapus.',
            ]);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
