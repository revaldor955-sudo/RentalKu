<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\ServisMobil;
use Illuminate\Http\Request;

class ServisMobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::orderByDesc('id')->get();

        return view('servis_mobils.index', compact('mobils'))
            ->with('pageTitle', 'Servis Kendaraan');
    }

    public function data(Request $request)
    {
        $query = ServisMobil::query()
            ->leftJoin(
                'mobils',
                'servis_mobils.mobil_id',
                '=',
                'mobils.id'
            )
            ->select('servis_mobils.*')
            ->with('mobil');

        // Total seluruh data sebelum pencarian.
        $recordsTotal = ServisMobil::count();

        // Pencarian.
        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('servis_mobils.jenis', 'like', "%{$search}%")
                    ->orWhere('servis_mobils.bengkel', 'like', "%{$search}%")
                    ->orWhere('servis_mobils.keterangan', 'like', "%{$search}%")
                    ->orWhereHas('mobil', function ($mq) use ($search) {
                        $mq->where('name', 'like', "%{$search}%")
                            ->orWhere('plate_number', 'like', "%{$search}%");
                    });
            });
        }

        // Total data setelah pencarian.
        $recordsFiltered = (clone $query)->count('servis_mobils.id');

        // Pemetaan kolom sesuai urutan kolom pada tabel Blade.
        $columns = [
            0 => null,                      // No
            1 => 'servis_mobils.tanggal',    // Tanggal
            2 => 'mobils.name',              // Mobil
            3 => 'servis_mobils.jenis',      // Jenis
            4 => 'servis_mobils.biaya',      // Biaya
            5 => 'servis_mobils.bengkel',    // Bengkel
            6 => null,                      // Keterangan
            7 => null,                      // Aksi
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDir = strtolower(
            $request->input('order.0.dir', 'desc')
        ) === 'asc' ? 'asc' : 'desc';

        // Gunakan kolom yang dipilih pengguna jika valid.
        if (
            $orderColumn !== null &&
            isset($columns[$orderColumn]) &&
            $columns[$orderColumn]
        ) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            // Default: servis terbaru berada paling atas.
            $query->orderByDesc('servis_mobils.created_at');
        }

        // Jika waktu pencatatan sama, gunakan ID terbesar lebih dahulu.
        $query->orderByDesc('servis_mobils.id');

        // Pagination DataTables.
        $start = max(0, (int) $request->input('start', 0));

        $length = (int) $request->input('length', 10);
        $length = min(max($length, 1), 100);

        $servisMobils = $query
            ->offset($start)
            ->limit($length)
            ->get();

        // Format data untuk DataTables.
        $data = $servisMobils->map(function ($item) {
            return [
                'id' => $item->id,
                'mobil_id' => $item->mobil_id,

                'tanggal' => $item->tanggal
                    ? $item->tanggal->format('d/m/Y')
                    : '-',

                'tanggal_input' => $item->tanggal
                    ? $item->tanggal->format('Y-m-d')
                    : '',

                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',

                'jenis' => $item->jenis,
                'biaya' => (float) $item->biaya,
                'keterangan' => $item->keterangan,
                'bengkel' => $item->bengkel,

                'created_at' => $item->created_at
                    ? $item->created_at->format('d/m/Y H:i')
                    : '-',
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
            'mobil_id' => 'required|exists:mobils,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:rutin,perbaikan',
            'biaya' => 'required|numeric|min:0|max:9999999999.99',
            'keterangan' => 'nullable|string',
            'bengkel' => 'nullable|string|max:100',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih.',
            'mobil_id.exists' => 'Mobil yang dipilih tidak ditemukan.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'jenis.required' => 'Jenis servis wajib dipilih.',
            'biaya.required' => 'Biaya wajib diisi.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
            'biaya.min' => 'Biaya tidak boleh negatif.',
            'biaya.max' => 'Biaya maksimal Rp 9.999.999.999.',
            'bengkel.max' => 'Nama bengkel maksimal 100 karakter.',
        ]);

        ServisMobil::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Servis mobil berhasil ditambahkan.',
            ], 201);
        }

        return redirect()
            ->route('servis_mobils.index')
            ->with('success', 'Servis mobil berhasil ditambahkan.');
    }

    public function update(Request $request, ServisMobil $servisMobil)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:rutin,perbaikan',
            'biaya' => 'required|numeric|min:0|max:9999999999.99',
            'keterangan' => 'nullable|string',
            'bengkel' => 'nullable|string|max:100',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih.',
            'mobil_id.exists' => 'Mobil yang dipilih tidak ditemukan.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'jenis.required' => 'Jenis servis wajib dipilih.',
            'biaya.required' => 'Biaya wajib diisi.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
            'biaya.min' => 'Biaya tidak boleh negatif.',
            'biaya.max' => 'Biaya maksimal Rp 9.999.999.999.',
            'bengkel.max' => 'Nama bengkel maksimal 100 karakter.',
        ]);

        $servisMobil->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Servis mobil berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('servis_mobils.index')
            ->with('success', 'Servis mobil berhasil diperbarui.');
    }

    public function destroy(Request $request, ServisMobil $servisMobil)
    {
        $servisMobil->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Servis mobil berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('servis_mobils.index')
            ->with('success', 'Servis mobil berhasil dihapus.');
    }
}
