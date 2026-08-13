<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;

class SupirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supirs = Supir::all();
        return view('supirs.index', compact('supirs'));
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
            'phone' => 'required|string|max:20',
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'tarif_perhari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
        ], [
            'name.required' => 'Nama supir wajib diisi',
            'phone.required' => 'Nomor HP wajib diisi',
            'phone.max' => 'Nomor HP maksimal 20 karakter',
            'image.mimes' => 'Foto harus berupa gambar (jpg, png, svg)',
            'image.max' => 'Ukuran foto maksimal 2MB',
            'tarif_perhari.required' => 'Tarif per hari wajib diisi',
            'tarif_perhari.numeric' => 'Tarif per hari harus berupa angka',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/supirs'), $imageName);
            $validated['image'] = 'images/supirs/' . $imageName;
        }

        Supir::create($validated);

        return redirect()->route('supirs.index')
            ->with('success', 'Supir berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supir $supir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supir $supir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supir $supir)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'tarif_perhari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
        ], [
            'name.required' => 'Nama supir wajib diisi',
            'phone.required' => 'Nomor HP wajib diisi',
            'phone.max' => 'Nomor HP maksimal 20 karakter',
            'image.mimes' => 'Foto harus berupa gambar (jpg, png, svg)',
            'image.max' => 'Ukuran foto maksimal 2MB',
            'tarif_perhari.required' => 'Tarif per hari wajib diisi',
            'tarif_perhari.numeric' => 'Tarif per hari harus berupa angka',
            'status.required' => 'Status wajib dipilih',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/supirs'), $imageName);
            $validated['image'] = 'images/supirs/' . $imageName;
        }

        $supir->update($validated);

        return redirect()->route('supirs.index')
            ->with('success', 'Supir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supir $supir)
    {
        $supir->delete();

        return redirect()->route('supirs.index')
            ->with('success', 'Supir berhasil dihapus.');
    }
}