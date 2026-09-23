<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
        public function index()
    {
        $cabangs = Cabang::all();
        return view('cabangs.index', compact('cabangs'));
    }

        public function create()
    {
        //
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama cabang wajib diisi',
            'address.required' => 'Alamat cabang wajib diisi',
            'address.max' => 'Alamat maksimal 255 karakter',
        ]);

        Cabang::create($validated);

        return redirect()->route('cabangs.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

        public function show(Cabang $cabang)
    {
        //
    }

        public function edit(Cabang $cabang)
    {
        //
    }

        public function update(Request $request, Cabang $cabang)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama cabang wajib diisi',
            'address.required' => 'Alamat cabang wajib diisi',
            'address.max' => 'Alamat maksimal 255 karakter',
        ]);

        $cabang->update($validated);

        return redirect()->route('cabangs.index')
            ->with('success', 'Cabang berhasil diperbarui.');
    }

        public function destroy(Cabang $cabang)
    {
        $cabang->delete();

        return redirect()->route('cabangs.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }
}