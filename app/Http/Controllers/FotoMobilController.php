<?php

namespace App\Http\Controllers;

use App\Models\FotoMobil;
use App\Models\Mobil;
use Illuminate\Http\Request;

class FotoMobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::all();
        return view('foto_mobils.index', compact('mobils'))->with('pageTitle', 'Foto Kendaraan');
    }

    /**
     * Server-side DataTables: daftar foto mobil (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = FotoMobil::query()
            ->leftJoin('mobils', 'foto_mobils.mobil_id', '=', 'mobils.id')
            ->select('foto_mobils.*')
            ->with('mobil');

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->whereHas('mobil', function ($mq) use ($search) {
                $mq->where('name', 'like', "%{$search}%")
                   ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'mobils.name',
            2 => 'mobils.plate_number',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = strtolower($request->input('order.0.dir', 'asc')) === 'desc' ? 'desc' : 'asc';

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('foto_mobils.created_at', 'desc');
        }

        $start = max(0, (int) $request->input('start', 0));
        $length = min(max((int) $request->input('length', 10), 1), 100);

        $fotoMobils = $query->offset($start)->limit($length)->get();

        $data = $fotoMobils->map(function ($item) {
            return [
                'id' => $item->id,
                'mobil_id' => $item->mobil_id,
                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',
                'url' => $item->url,
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

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

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Foto mobil berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('foto_mobils.index')
            ->with('success', 'Foto mobil berhasil ditambahkan.');
    }

    public function show(FotoMobil $fotoMobil)
    {
        //
    }

    public function edit(FotoMobil $fotoMobil)
    {
        //
    }

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
            if ($fotoMobil->url && file_exists(public_path($fotoMobil->url))) {
                unlink(public_path($fotoMobil->url));
            }

            $image = $request->file('url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/foto_mobils'), $imageName);
            $validated['url'] = 'images/foto_mobils/' . $imageName;
        }

        $fotoMobil->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Foto mobil berhasil diperbarui.',
            ]);
        }

        return redirect()->route('foto_mobils.index')
            ->with('success', 'Foto mobil berhasil diperbarui.');
    }

    public function destroy(Request $request, FotoMobil $fotoMobil)
    {
        if ($fotoMobil->url && file_exists(public_path($fotoMobil->url))) {
            unlink(public_path($fotoMobil->url));
        }

        $fotoMobil->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Foto mobil berhasil dihapus.',
            ]);
        }

        return redirect()->route('foto_mobils.index')
            ->with('success', 'Foto mobil berhasil dihapus.');
    }
}