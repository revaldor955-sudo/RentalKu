<?php

namespace App\Http\Controllers;

use App\Models\KerusakanMobil;
use App\Models\PemeriksaanMobil;
use App\Models\Rental;
use Illuminate\Http\Request;

class PemeriksaanKendaraanController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user', 'mobil'])
            ->whereIn('status', ['Disetujui', 'Selesai'])
            ->orderBy('created_at', 'desc')
            ->get();

        $kerusakanList = KerusakanMobil::orderBy('jenis_kerusakan')->get();

        return view('pemeriksaan_kendaraan.index', compact('rentals', 'kerusakanList'));
    }

    /**
     * Server-side DataTables: daftar pemeriksaan kendaraan
     */
    public function data(Request $request)
    {
        $query = PemeriksaanMobil::query()
            ->leftJoin('rentals', 'pemeriksaan_mobils.rental_id', '=', 'rentals.id')
            ->leftJoin('users', 'rentals.user_id', '=', 'users.id')
            ->leftJoin('mobils', 'rentals.mobil_id', '=', 'mobils.id')
            ->select(
                'pemeriksaan_mobils.*',
                'users.name as user_name',
                'users.email as user_email',
                'mobils.name as mobil_name',
                'mobils.plate_number as mobil_plate'
            );

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('mobils.name', 'like', "%{$search}%")
                    ->orWhere('mobils.plate_number', 'like', "%{$search}%")
                    ->orWhere('pemeriksaan_mobils.kondisi', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'users.name',
            2 => 'mobils.name',
            3 => 'pemeriksaan_mobils.jenis',
            4 => 'pemeriksaan_mobils.kondisi',
            5 => 'pemeriksaan_mobils.tanggal',
            6 => null,
            7 => null,
        ];

        $orderColumn = $request->input('order.0.column', 5);
        $orderDir = $request->input('order.0.dir', 'desc');

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('pemeriksaan_mobils.tanggal', 'desc');
        }

        $start = (int) $request->input('start', 0);
        $length = (int) $request->input('length', 10);

        $pemeriksaan = $query->offset($start)->limit($length)->get();

        // Muat relasi kerusakan untuk baris di halaman ini saja
        $ids = $pemeriksaan->pluck('id');
        $kerusakanMap = PemeriksaanMobil::whereIn('id', $ids)
            ->with('kerusakan')
            ->get()
            ->mapWithKeys(fn ($p) => [$p->id => $p->kerusakan->keyBy('id')]);

        $data = $pemeriksaan->map(function ($p) use ($kerusakanMap) {
            $kerusakan = $kerusakanMap->get($p->id, collect());

            return [
                'id' => $p->id,
                'rental_id' => $p->rental_id,
                'user_name' => $p->user_name ?? '-',
                'user_email' => $p->user_email ?? '-',
                'mobil_name' => $p->mobil_name ?? '-',
                'mobil_plate' => $p->mobil_plate ?? '-',
                'jenis' => $p->jenis,
                'kondisi' => $p->kondisi,
                'tanggal' => $p->tanggal?->format('d/m/Y H:i'),
             'kerusakan' => $kerusakan->pluck('jenis_kerusakan')->implode(', '),
                'kerusakan_ids' => $kerusakan->keys()->all(),
                'keterangan' => $kerusakan->mapWithKeys(fn ($k) => [$k->id => $k->pivot->keterangan])->all(),
                'catatan' => $p->catatan ?? '-',
                'foto_bukti' => $p->foto_bukti,
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    /**
     * Simpan pemeriksaan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:sebelum_sewa,setelah_sewa',
            'kondisi' => 'required|in:baik,rusak',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string|max:1000',
            'kerusakan' => 'nullable|array',
            'kerusakan.*' => 'exists:kerusakan_mobils,id',
            'keterangan' => 'nullable|array',
        ], [
            'rental_id.required' => 'Pilih rental terlebih dahulu.',
            'jenis.required' => 'Jenis pemeriksaan wajib diisi.',
            'kondisi.required' => 'Kondisi wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
        ]);

        $fotoBukti = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoBukti = $request->file('foto_bukti')->store('pemeriksaan', 'public');
        }

        $pemeriksaan = PemeriksaanMobil::create([
            'rental_id' => $validated['rental_id'],
            'mobil_id' => Rental::findOrFail($validated['rental_id'])->mobil_id,
            'jenis' => $validated['jenis'],
            'kondisi' => $validated['kondisi'],
            'catatan' => $validated['catatan'] ?? null,
            'foto_bukti' => $fotoBukti,
            'tanggal' => $validated['tanggal'],
        ]);

        $this->syncKerusakan($pemeriksaan, $request);

        return response()->json([
            'message' => 'Pemeriksaan berhasil ditambahkan.',
        ]);
    }

    /**
     * Update pemeriksaan
     */
    public function update(Request $request, PemeriksaanMobil $pemeriksaan)
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:sebelum_sewa,setelah_sewa',
            'kondisi' => 'required|in:baik,rusak',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string|max:1000',
            'kerusakan' => 'nullable|array',
            'kerusakan.*' => 'exists:kerusakan_mobils,id',
            'keterangan' => 'nullable|array',
        ], [
            'rental_id.required' => 'Pilih rental terlebih dahulu.',
            'jenis.required' => 'Jenis pemeriksaan wajib diisi.',
            'kondisi.required' => 'Kondisi wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
        ]);

        $data = [
            'rental_id' => $validated['rental_id'],
            'mobil_id' => Rental::findOrFail($validated['rental_id'])->mobil_id,
            'jenis' => $validated['jenis'],
            'kondisi' => $validated['kondisi'],
            'catatan' => $validated['catatan'] ?? null,
            'tanggal' => $validated['tanggal'],
        ];

        if ($request->hasFile('foto_bukti')) {
            $data['foto_bukti'] = $request->file('foto_bukti')->store('pemeriksaan', 'public');
        }

        $pemeriksaan->update($data);

        $this->syncKerusakan($pemeriksaan, $request);

        return response()->json([
            'message' => 'Pemeriksaan berhasil diperbarui.',
        ]);
    }

    public function destroy(Request $request, PemeriksaanMobil $pemeriksaan)
    {
        $pemeriksaan->delete();

        return response()->json([
            'message' => 'Pemeriksaan berhasil dihapus.',
        ]);
    }

    /**
     * Sinkronisasi pivot pemeriksaan_kerusakans
     */
    private function syncKerusakan(PemeriksaanMobil $pemeriksaan, Request $request): void
    {
        $kerusakanIds = $request->input('kerusakan', []);

        if (empty($kerusakanIds)) {
            $pemeriksaan->kerusakan()->detach();
            return;
        }

        $pivot = [];
        foreach ($kerusakanIds as $id) {
            $pivot[$id] = [
                'keterangan' => $request->input("keterangan.{$id}"),
            ];
        }

        $pemeriksaan->kerusakan()->sync($pivot);
    }
}