<?php

namespace App\Http\Controllers;

use App\Models\FotoMobil;
use App\Models\Mobil;
use Illuminate\Http\Request;

class FotoMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fotoMobils = FotoMobil::all();
        $mobils = Mobil::all();
        return view('foto_mobils.index', compact('fotoMobils', 'mobils'));
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
            'mobil_id' => 'required|exists:mobils,id',
            'url' => 'required|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'url.required' => 'Foto wajib diisi',
            'url.mimes' => 'Foto harus berupa gambar (jpg, png, svg)',
            'url.max' => 'Ukuran foto maksimal 2MB',
        ]);

        $image = $request->file('url');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images/foto_mobils'), $imageName);
        $validated['url'] = 'images/foto_mobils/' . $imageName;

        FotoMobil::create($validated);

        return redirect()->route('foto_mobils.index')
            ->with('success', 'Foto mobil berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FotoMobil $fotoMobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FotoMobil $fotoMobil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FotoMobil $fotoMobil)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'url' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'url.mimes' => 'Foto harus berupa gambar (jpg, png, svg)',
            'url.max' => 'Ukuran foto maksimal 2MB',
        ]);

        if ($request->hasFile('url')) {
            $image = $request->file('url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/foto_mobils'), $imageName);
            $validated['url'] = 'images/foto_mobils/' . $imageName;
        }

        $fotoMobil->update($validated);

        return redirect()->route('foto_mobils.index')
            ->with('success', 'Foto mobil berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FotoMobil $fotoMobil)
    {
        $fotoMobil->delete();

        return redirect()->route('foto_mobils.index')
            ->with('success', 'Foto mobil berhasil dihapus.');
    }
}