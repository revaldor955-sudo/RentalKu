<?php

namespace App\Http\Controllers;

use App\Models\KerusakanMobil;
use Illuminate\Http\Request;

class KerusakanMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kerusakanMobils = KerusakanMobil::all();
        return view('kerusakan_mobils.index', compact('kerusakanMobils'));
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
            'jenis_kerusakan' => 'required|in:Mesin,Ban,Body,Interior,Rem,Kelistrikan,AC,Transmisi,Suspensi,Kaca,Lainnya',
            'description' => 'nullable|string',
        ], [
            'jenis_kerusakan.required' => 'Jenis kerusakan wajib diisi',
        ]);

        KerusakanMobil::create($validated);

        return redirect()->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KerusakanMobil $kerusakanMobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KerusakanMobil $kerusakanMobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KerusakanMobil $kerusakanMobil)
    {
        $validated = $request->validate([
            'jenis_kerusakan' => 'required|in:Mesin,Ban,Body,Interior,Rem,Kelistrikan,AC,Transmisi,Suspensi,Kaca,Lainnya',
            'description' => 'nullable|string',
        ], [
            'jenis_kerusakan.required' => 'Jenis kerusakan wajib diisi',
        ]);

        $kerusakanMobil->update($validated);

        return redirect()->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KerusakanMobil $kerusakanMobil)
    {
        $kerusakanMobil->delete();

        return redirect()->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil dihapus.');
    }
}