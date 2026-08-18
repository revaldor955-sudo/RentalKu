<?php

namespace App\Http\Controllers;

use App\Models\Kupon;
use Illuminate\Http\Request;

class KuponController extends Controller
{
    public function index()
    {
        $kupons = Kupon::latest()->get();

        return view('kupons.index', compact('kupons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:kupons,code',
            'jenis' => 'required|in:persen,nominal',
            'value' => 'required|numeric|min:1',
            'kuota' => 'required|integer|min:1',
            'minimal_pembelian' => 'required|numeric|min:0',
            'active_at' => 'required|date',
            'expired_at' => 'required|date|after_or_equal:active_at',
        ], [
            'code.required' => 'Kode promo wajib diisi.',
            'code.unique' => 'Kode promo sudah digunakan.',
            'jenis.required' => 'Jenis promo wajib dipilih.',
            'jenis.in' => 'Jenis promo tidak valid.',
            'value.required' => 'Nilai promo wajib diisi.',
            'value.min' => 'Nilai promo minimal 1.',
            'kuota.required' => 'Kuota wajib diisi.',
            'kuota.min' => 'Kuota minimal 1.',
            'minimal_pembelian.required' => 'Minimal pembelian wajib diisi.',
            'active_at.required' => 'Tanggal mulai wajib diisi.',
            'expired_at.required' => 'Tanggal berakhir wajib diisi.',
            'expired_at.after_or_equal' => 'Tanggal berakhir harus setelah tanggal mulai.',
        ]);

        $validated['terpakai'] = 0;

        Kupon::create($validated);

        return redirect()
            ->route('kupons.index')
            ->with('success', 'Promo berhasil ditambahkan.');
    }

    public function update(Request $request, Kupon $kupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:kupons,code,' . $kupon->id,
            'jenis' => 'required|in:persen,nominal',
            'value' => 'required|numeric|min:1',
            'kuota' => 'required|integer|min:1',
            'minimal_pembelian' => 'required|numeric|min:0',
            'active_at' => 'required|date',
            'expired_at' => 'required|date|after_or_equal:active_at',
        ]);

        $kupon->update($validated);

        return redirect()
            ->route('kupons.index')
            ->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Kupon $kupon)
    {
        $kupon->delete();

        return redirect()
            ->route('kupons.index')
            ->with('success', 'Promo berhasil dihapus.');
    }
}