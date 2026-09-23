<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use Illuminate\Http\Request;

class MetodePembayaranController extends Controller
{
        public function index()
    {
        $metodePembayarans = MetodePembayaran::all();
        return view('metode_pembayarans.index', compact('metodePembayarans'));
    }

        public function create()
    {
        //
    }

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

        public function show(MetodePembayaran $metodePembayaran)
    {
        //
    }

        public function edit(MetodePembayaran $metodePembayaran)
    {
        //
    }

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

        public function destroy(MetodePembayaran $metodePembayaran)
    {
        $metodePembayaran->delete();

        return redirect()->route('metode_pembayarans.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}