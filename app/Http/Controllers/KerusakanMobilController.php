<?php

namespace App\Http\Controllers;

use App\Models\KerusakanMobil;
use Illuminate\Http\Request;

class KerusakanMobilController extends Controller
{
        public function index()
    {
        $kerusakanMobils = KerusakanMobil::all();
        return view('kerusakan_mobils.index', compact('kerusakanMobils'));
    }

        public function create()
    {
        //
    }

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

        public function show(KerusakanMobil $kerusakanMobil)
    {
        //
    }

        public function edit(KerusakanMobil $kerusakanMobil)
    {
        //
    }

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

        public function destroy(KerusakanMobil $kerusakanMobil)
    {
        $kerusakanMobil->delete();

        return redirect()->route('kerusakan_mobils.index')
            ->with('success', 'Kerusakan mobil berhasil dihapus.');
    }
}