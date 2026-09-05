<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index');
    }

    /**
     * Server-side DataTables: daftar role (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = Role::query()->withCount('users');

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where('roles.name', 'like', "%{$search}%")
                  ->orWhere('roles.description', 'like', "%{$search}%");
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'roles.name',
            2 => 'roles.description',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('roles.name', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $roles = $query->offset($start)->limit($length)->get();

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

            return redirect()
                ->route('roles.index')
                ->with('error', 'Nama role tidak dapat diganti karena masih dipakai user.');
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

            return redirect()
                ->route('roles.index')
                ->with('error', 'Role tidak dapat dihapus karena masih dipakai user.');
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
