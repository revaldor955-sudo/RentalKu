<?php

namespace App\Http\Controllers;

use App\Models\TipeMobil;
use Illuminate\Http\Request;

class TipeMobilController extends Controller
{
        public function index()
    {
        $tipeMobils = TipeMobil::all();
        return view('tipe_mobils.index', compact('tipeMobils'));
    }

        public function create()
    {
        //
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama tipe mobil wajib diisi',
            'name.max' => 'Nama tipe mobil maksimal 255 karakter',
        ]);

        TipeMobil::create($validated);

        return redirect()->route('tipe_mobils.index')
            ->with('success', 'Tipe Mobil berhasil ditambahkan.');
    }

        public function show(TipeMobil $tipeMobil)
    {
        //
    }

        public function edit(TipeMobil $tipeMobil)
    {
        //
    }

        public function update(Request $request, TipeMobil $tipeMobil)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama tipe mobil wajib diisi',
            'name.max' => 'Nama tipe mobil maksimal 255 karakter',
        ]);

        $tipeMobil->update($validated);

        return redirect()->route('tipe_mobils.index')
            ->with('success', 'Tipe Mobil berhasil diperbarui.');
    }

        public function destroy(TipeMobil $tipeMobil)
    {
        $tipeMobil->delete();

        return redirect()->route('tipe_mobils.index')
            ->with('success', 'Tipe Mobil berhasil dihapus.');
    }
}