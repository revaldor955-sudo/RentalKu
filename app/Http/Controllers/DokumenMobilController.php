<?php

namespace App\Http\Controllers;

use App\Models\DokumenMobil;
use App\Models\Mobil;
use Illuminate\Http\Request;

class DokumenMobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::orderByDesc('id')->get();

        return view('dokumen_mobils.index', compact('mobils'))
            ->with('pageTitle', 'Dokumen Kendaraan');
    }

    /**
     * DataTables: pencarian, pengurutan, dan pagination dokumen mobil.
     * Secara default, dokumen terbaru ditampilkan paling atas.
     */
    public function data(Request $request)
    {
        $query = DokumenMobil::query()
            ->leftJoin(
                'mobils',
                'dokumen_mobils.mobil_id',
                '=',
                'mobils.id'
            )
            ->select('dokumen_mobils.*')
            ->with('mobil');

        // Total data sebelum pencarian.
        $recordsTotal = DokumenMobil::count();

        // Pencarian.
        $search = $request->input('search.value');

        if ($search !== null && trim($search) !== '') {
            $query->where(function ($q) use ($search) {
                $q->where(
                    'dokumen_mobils.nomor_dokumen',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'dokumen_mobils.jenis',
                    'like',
                    "%{$search}%"
                )
                ->orWhereHas('mobil', function ($mq) use ($search) {
                    $mq->where('name', 'like', "%{$search}%")
                       ->orWhere('plate_number', 'like', "%{$search}%");
                });
            });
        }

        // Total data setelah pencarian.
        $recordsFiltered = (clone $query)
            ->count('dokumen_mobils.id');

        // Sesuaikan indeks dengan kolom pada tabel Blade.
        $columns = [
            0 => null, // Nomor urut
            1 => 'mobils.name',
            2 => 'dokumen_mobils.jenis',
            3 => 'dokumen_mobils.nomor_dokumen',
            4 => 'dokumen_mobils.berlaku_sampai',
            5 => null, // File
            6 => null, // Aksi
        ];

        $orderColumn = $request->input('order.0.column');
        $orderDir = strtolower(
            $request->input('order.0.dir', 'desc')
        ) === 'asc' ? 'asc' : 'desc';

        // Jika pengguna memilih pengurutan kolom, ikuti pilihannya.
        // Jika tidak, tampilkan dokumen dengan ID terbaru terlebih dahulu.
        if (
            $orderColumn !== null
            && isset($columns[$orderColumn])
            && $columns[$orderColumn] !== null
        ) {
            $query->orderBy($columns[$orderColumn], $orderDir);

            // Jika nilainya sama, data dengan ID terbaru lebih dahulu.
            $query->orderByDesc('dokumen_mobils.id');
        } else {
            $query->orderByDesc('dokumen_mobils.id');
        }

        // Pagination DataTables.
        $start = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 10);

        if ($length < 1) {
            $length = 10;
        }

        $length = min($length, 100);

        $dokumenMobils = $query
            ->offset($start)
            ->limit($length)
            ->get();

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
     * Menyimpan dokumen mobil baru.
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
            'file.mimes' => 'File harus berupa gambar atau PDF',
            'file.max' => 'Ukuran file maksimal 2MB',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(
                public_path('images/dokumen_mobils'),
                $fileName
            );

            $validated['file'] = 'images/dokumen_mobils/' . $fileName;
        }

        DokumenMobil::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Dokumen mobil berhasil ditambahkan.',
            ], 201);
        }

        return redirect()
            ->route('dokumen_mobils.index')
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

    /**
     * Memperbarui dokumen mobil.
     */
    public function update(
        Request $request,
        DokumenMobil $dokumenMobil
    ) {
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
            'file.mimes' => 'File harus berupa gambar atau PDF',
            'file.max' => 'Ukuran file maksimal 2MB',
        ]);

        if ($request->hasFile('file')) {
            if (
                $dokumenMobil->file
                && file_exists(public_path($dokumenMobil->file))
            ) {
                unlink(public_path($dokumenMobil->file));
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(
                public_path('images/dokumen_mobils'),
                $fileName
            );

            $validated['file'] = 'images/dokumen_mobils/' . $fileName;
        }

        $dokumenMobil->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Dokumen mobil berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('dokumen_mobils.index')
            ->with('success', 'Dokumen mobil berhasil diperbarui.');
    }

    /**
     * Menghapus dokumen mobil.
     */
    public function destroy(
        Request $request,
        DokumenMobil $dokumenMobil
    ) {
        if (
            $dokumenMobil->file
            && file_exists(public_path($dokumenMobil->file))
        ) {
            unlink(public_path($dokumenMobil->file));
        }

        $dokumenMobil->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Dokumen mobil berhasil dihapus.',
            ]);
        }

        return redirect()
            ->route('dokumen_mobils.index')
            ->with('success', 'Dokumen mobil berhasil dihapus.');
    }
}
