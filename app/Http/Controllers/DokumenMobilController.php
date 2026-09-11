<?php

namespace App\Http\Controllers;

use App\Models\DokumenMobil;
use App\Models\Mobil;
use Illuminate\Http\Request;

class DokumenMobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::all();
        return view('dokumen_mobils.index', compact('mobils'));
    }

    /**
     * Server-side DataTables: daftar dokumen mobil (search, sort, pagination)
     */
    public function data(Request $request)
    {
        $query = DokumenMobil::query()
            ->leftJoin('mobils', 'dokumen_mobils.mobil_id', '=', 'mobils.id')
            ->select('dokumen_mobils.*')
            ->with('mobil');

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('dokumen_mobils.nomor_dokumen', 'like', "%{$search}%")
                  ->orWhere('dokumen_mobils.jenis', 'like', "%{$search}%")
                  ->orWhereHas('mobil', function ($mq) use ($search) {
                      $mq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'mobils.name',
            2 => 'dokumen_mobils.jenis',
            3 => 'dokumen_mobils.nomor_dokumen',
            4 => 'dokumen_mobils.berlaku_sampai',
        ];

        $orderColumn = $request->input('order.0.column', 1);
        $orderDir = $request->input('order.0.dir', 'asc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('dokumen_mobils.created_at', 'desc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $dokumenMobils = $query->offset($start)->limit($length)->get();

        $data = $dokumenMobils->map(function ($item) {
            return [
                'id' => $item->id,
                'mobil_id' => $item->mobil_id,
                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',
                'jenis' => $item->jenis,
                'nomor_dokumen' => $item->nomor_dokumen,
                'berlaku_sampai' => $item->berlaku_sampai,
                'file' => $item->file,
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
            'jenis' => 'required|in:stnk,asuransi,bpkb',
            'nomor_dokumen' => 'required|string|max:50',
            'berlaku_sampai' => 'required|date',
            'file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'jenis.required' => 'Jenis dokumen wajib dipilih',
            'nomor_dokumen.required' => 'Nomor dokumen wajib diisi',
            'berlaku_sampai.required' => 'Berlaku sampai wajib diisi',
            'file.mimes' => 'File harus berupa gambar atau pdf',
            'file.max' => 'Ukuran file maksimal 2MB',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/dokumen_mobils'), $fileName);
            $validated['file'] = 'images/dokumen_mobils/' . $fileName;
        }

        DokumenMobil::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Dokumen mobil berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('dokumen_mobils.index')
            ->with('success', 'Dokumen mobil berhasil ditambahkan.');
    }

    public function show(DokumenMobil $dokumenMobil)
    {
        //
    }

    public function edit(DokumenMobil $dokumenMobil)
    {
        //
    }

    public function update(Request $request, DokumenMobil $dokumenMobil)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'jenis' => 'required|in:stnk,asuransi,bpkb',
            'nomor_dokumen' => 'required|string|max:50',
            'berlaku_sampai' => 'required|date',
            'file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:2048',
        ], [
            'mobil_id.required' => 'Mobil wajib dipilih',
            'jenis.required' => 'Jenis dokumen wajib dipilih',
            'nomor_dokumen.required' => 'Nomor dokumen wajib diisi',
            'berlaku_sampai.required' => 'Berlaku sampai wajib diisi',
            'file.mimes' => 'File harus berupa gambar atau pdf',
            'file.max' => 'Ukuran file maksimal 2MB',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/dokumen_mobils'), $fileName);
            $validated['file'] = 'images/dokumen_mobils/' . $fileName;
        }

        $dokumenMobil->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Dokumen mobil berhasil diperbarui.',
            ]);
        }

        return redirect()->route('dokumen_mobils.index')
            ->with('success', 'Dokumen mobil berhasil diperbarui.');
    }

    public function destroy(Request $request, DokumenMobil $dokumenMobil)
    {
        $dokumenMobil->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Dokumen mobil berhasil dihapus.',
            ]);
        }

        return redirect()->route('dokumen_mobils.index')
            ->with('success', 'Dokumen mobil berhasil dihapus.');
    }
}