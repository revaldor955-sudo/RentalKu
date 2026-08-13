<?php

namespace App\Http\Controllers;

use App\Models\TipeMobil;
use Illuminate\Http\Request;

class TipeMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipeMobils = TipeMobil::all();
        return view('tipe_mobils.index', compact('tipeMobils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(TipeMobil $tipeMobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipeMobil $tipeMobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipeMobil $tipeMobil)
    {
        $tipeMobil->delete();

        return redirect()->route('tipe_mobils.index')
            ->with('success', 'Tipe Mobil berhasil dihapus.');
    }
}