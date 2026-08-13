<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metodePembayarans = MetodePembayaran::all();
        return view('metode_pembayarans.index', compact('metodePembayarans'));
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
            'nomor_akun' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama metode pembayaran wajib diisi',
            'nomor_akun.required' => 'Nomor akun wajib diisi',
        ]);

        MetodePembayaran::create($validated);

        return redirect()->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MetodePembayaran $metodePembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MetodePembayaran $metodePembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MetodePembayaran $metodePembayaran)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nomor_akun' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama metode pembayaran wajib diisi',
            'nomor_akun.required' => 'Nomor akun wajib diisi',
        ]);

        $metodePembayaran->update($validated);

        return redirect()->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MetodePembayaran $metodePembayaran)
    {
        $metodePembayaran->delete();

        return redirect()->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}