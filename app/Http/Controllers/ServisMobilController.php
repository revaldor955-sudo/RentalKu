<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\ServisMobil;
use Illuminate\Http\Request;

class ServisMobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::all();
        return view('servis_mobils.index', compact('mobils'))->with('pageTitle', 'Servis Kendaraan');
    }

    public function data(Request $request)
    {
        $query = ServisMobil::query()
            ->leftJoin('mobils', 'servis_mobils.mobil_id', '=', 'mobils.id')
            ->select('servis_mobils.*')
            ->with('mobil');

        $recordsTotal = $query->count();

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

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'servis_mobils.tanggal',
            2 => 'mobils.name',
            3 => 'servis_mobils.jenis',
            4 => 'servis_mobils.biaya',
            5 => 'servis_mobils.bengkel',
            6 => 'servis_mobils.created_at',
        ];

        $orderColumn = $request->input('order.0.column', 6);
        $orderDir = $request->input('order.0.dir', 'desc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('servis_mobils.created_at', 'desc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $servisMobils = $query->offset($start)->limit($length)->get();

        $data = $servisMobils->map(function ($item) {
            return [
                'id' => $item->id,
                'mobil_id' => $item->mobil_id,
                'tanggal' => $item->tanggal?->format('d/m/Y'),
                'tanggal_input' => $item->tanggal?->format('Y-m-d'),
                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',
                'jenis' => $item->jenis,
                'biaya' => (float) $item->biaya,
                'keterangan' => $item->keterangan,
                'bengkel' => $item->bengkel,
                'created_at' => $item->created_at?->format('d/m/Y H:i'),
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
            'biaya' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'bengkel' => 'nullable|string|max:100',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'tanggal.required' => 'Tanggal wajib diisi',
            'jenis.required' => 'Jenis servis wajib dipilih',
            'biaya.required' => 'Biaya wajib diisi',
            'biaya.min' => 'Biaya tidak boleh negatif',
            'bengkel.max' => 'Nama bengkel maksimal 100 karakter',
        ]);

        ServisMobil::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Servis mobil berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('servis_mobils.index')
            ->with('success', 'Servis mobil berhasil ditambahkan.');
    }

    public function update(Request $request, ServisMobil $servisMobil)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:rutin,perbaikan',
            'biaya' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'bengkel' => 'nullable|string|max:100',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'tanggal.required' => 'Tanggal wajib diisi',
            'jenis.required' => 'Jenis servis wajib dipilih',
            'biaya.required' => 'Biaya wajib diisi',
            'biaya.min' => 'Biaya tidak boleh negatif',
            'bengkel.max' => 'Nama bengkel maksimal 100 karakter',
        ]);

        $servisMobil->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Servis mobil berhasil diperbarui.',
            ]);
        }

        return redirect()->route('servis_mobils.index')
            ->with('success', 'Servis mobil berhasil diperbarui.');
    }

    public function destroy(Request $request, ServisMobil $servisMobil)
    {
        $servisMobil->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Servis mobil berhasil dihapus.',
            ]);
        }

        return redirect()->route('servis_mobils.index')
            ->with('success', 'Servis mobil berhasil dihapus.');
    }
}