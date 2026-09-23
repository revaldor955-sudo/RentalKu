<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
        public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

        public function create()
    {
        //
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|in:Admin,Staff,Customer',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama role wajib diisi',
            'name.in' => 'Role harus Admin, Staff, atau Customer',
        ]);

        Role::create($validated);

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
            'name' => 'required|string|in:Admin,Staff,Customer',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama role wajib diisi',
            'name.in' => 'Role harus Admin, Staff, atau Customer',
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

        public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
