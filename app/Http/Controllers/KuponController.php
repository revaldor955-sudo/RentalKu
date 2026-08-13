<?php

namespace App\Http\Controllers;

use App\Models\Kupon;
use Illuminate\Http\Request;

class KuponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kupons = Kupon::all();
        return view('kupons.index', compact('kupons'));
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
            'code' => 'required|string|max:255|unique:kupons,code',
            'jenis' => 'required|in:persen,nominal',
            'value' => 'required|numeric|min:0',
            'kuota' => 'nullable|integer|min:0',
            'minimal_pembelian' => 'nullable|numeric|min:0',
            'active_at' => 'nullable|date',
            'expired_at' => 'nullable|date',
        ], [
            'code.required' => 'Kode kupon wajib diisi',
            'code.unique' => 'Kode kupon sudah dipakai',
            'jenis.required' => 'Jenis kupon wajib diisi',
            'value.required' => 'Nilai kupon wajib diisi',
            'value.numeric' => 'Nilai kupon harus berupa angka',
        ]);

        Kupon::create($validated);

        return redirect()->route('kupons.index')
            ->with('success', 'Kupon berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kupon $kupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kupon $kupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kupon $kupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:kupons,code,' . $kupon->id,
            'jenis' => 'required|in:persen,nominal',
            'value' => 'required|numeric|min:0',
            'kuota' => 'nullable|integer|min:0',
            'minimal_pembelian' => 'nullable|numeric|min:0',
            'active_at' => 'nullable|date',
            'expired_at' => 'nullable|date',
        ], [
            'code.required' => 'Kode kupon wajib diisi',
            'code.unique' => 'Kode kupon sudah dipakai',
            'jenis.required' => 'Jenis kupon wajib diisi',
            'value.required' => 'Nilai kupon wajib diisi',
            'value.numeric' => 'Nilai kupon harus berupa angka',
        ]);

        $kupon->update($validated);

        return redirect()->route('kupons.index')
            ->with('success', 'Kupon berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kupon $kupon)
    {
        $kupon->delete();

        return redirect()->route('kupons.index')
            ->with('success', 'Kupon berhasil dihapus.');
    }
}