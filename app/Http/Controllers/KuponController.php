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

    public function data(Request $request)
    {
        $query = Kupon::query();

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kupons.code', 'like', "%{$search}%")
                    ->orWhere('kupons.jenis', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'kupons.code',
            2 => 'kupons.jenis',
            3 => 'kupons.value',
            4 => 'kupons.kuota',
            5 => 'kupons.terpakai',
            6 => 'kupons.minimal_pembelian',
            7 => null,
            8 => 'kupons.expired_at',
            9 => null,
        ];

        $orderColumn = $request->input('order.0.column', 7);
        $orderDir = $request->input('order.0.dir', 'asc');

        if ($orderColumn == 7) {
            // status dihitung di PHP, urutkan dengan CASE agar Aktif > Belum Aktif > Tidak Aktif
            $query->orderByRaw("CASE
                WHEN NOW() < active_at THEN 2
                WHEN NOW() > expired_at OR terpakai >= kuota THEN 3
                ELSE 1
            END {$orderDir}")
                ->orderBy('kupons.code', 'asc');
        } elseif (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('kupons.code', 'asc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $kupons = $query->offset($start)->limit($length)->get();

        $now = now();

        $data = $kupons->map(function ($kupon) use ($now) {
            if ($now < $kupon->active_at) {
                $status = 'waiting';
                $statusText = 'Belum Aktif';
            } elseif ($now > $kupon->expired_at || $kupon->terpakai >= $kupon->kuota) {
                $status = 'expired';
                $statusText = 'Tidak Aktif';
            } else {
                $status = 'active';
                $statusText = 'Aktif';
            }

            return [
                'id' => $kupon->id,
                'code' => $kupon->code,
                'jenis' => $kupon->jenis,
                'value' => $kupon->value,
                'kuota' => $kupon->kuota,
                'terpakai' => $kupon->terpakai,
                'minimal_pembelian' => $kupon->minimal_pembelian,
                'active_at' => $kupon->active_at ? $kupon->active_at->format('Y-m-d\TH:i') : null,
                'expired_at' => $kupon->expired_at ? $kupon->expired_at->format('Y-m-d\TH:i') : null,
                'status' => $status,
                'status_text' => $statusText,
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
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

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Promo berhasil ditambahkan.',
            ]);
        }

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

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Promo berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('kupons.index')
            ->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Request $request, Kupon $kupon)
    {
        $kupon->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Promo berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('kupons.index')
            ->with('success', 'Promo berhasil dihapus.');
    }
}