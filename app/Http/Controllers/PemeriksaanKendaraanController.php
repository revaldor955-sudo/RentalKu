<?php

namespace App\Http\Controllers;

use App\Models\KerusakanMobil;
use App\Models\PemeriksaanMobil;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PemeriksaanKendaraanController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user', 'mobil'])
            ->whereIn('status', ['Disetujui', 'Selesai'])
            ->orderByDesc('created_at')
            ->get();

        $kerusakanList = KerusakanMobil::orderBy('jenis_kerusakan')
            ->get();

        return view('pemeriksaan_kendaraan.index', compact(
            'rentals',
            'kerusakanList'
        ))->with('pageTitle', 'Pemeriksaan Kendaraan');
    }

    public function data(Request $request)
    {
        $recordsTotal = PemeriksaanMobil::count();

        $query = PemeriksaanMobil::query()
            ->leftJoin(
                'rentals',
                'pemeriksaan_mobils.rental_id',
                '=',
                'rentals.id'
            )
            ->leftJoin(
                'users',
                'rentals.user_id',
                '=',
                'users.id'
            )
            ->leftJoin(
                'mobils',
                'rentals.mobil_id',
                '=',
                'mobils.id'
            )
            ->select(
                'pemeriksaan_mobils.*',
                'users.name as user_name',
                'users.email as user_email',
                'mobils.name as mobil_name',
                'mobils.plate_number as mobil_plate'
            );

        $search = trim((string) $request->input('search.value', ''));

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('mobils.name', 'like', "%{$search}%")
                    ->orWhere(
                        'mobils.plate_number',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'pemeriksaan_mobils.jenis',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'pemeriksaan_mobils.kondisi',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        $recordsFiltered = (clone $query)
            ->distinct()
            ->count('pemeriksaan_mobils.id');

        $start = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 10);
        $length = $length === -1
            ? 100
            : min(max($length, 1), 100);

        $pemeriksaan = $query
            ->orderByDesc('pemeriksaan_mobils.created_at')
            ->orderByDesc('pemeriksaan_mobils.id')
            ->offset($start)
            ->limit($length)
            ->get();

        $kerusakanMap = PemeriksaanMobil::whereIn(
            'id',
            $pemeriksaan->pluck('id')
        )->with('kerusakan')->get()->mapWithKeys(function ($item) {
            return [
                $item->id => $item->kerusakan->keyBy('id')
            ];
        });

        $data = $pemeriksaan->map(function ($p) use ($kerusakanMap) {
            $kerusakan = $kerusakanMap->get($p->id, collect());

            $fotoUmum = $p->foto_bukti;

            return [
                'id' => $p->id,
                'rental_id' => $p->rental_id,

                'user_name' => $p->user_name ?? '-',
                'user_email' => $p->user_email ?? '-',
                'mobil_name' => $p->mobil_name ?? '-',
                'mobil_plate' => $p->mobil_plate ?? '-',

                'jenis' => $p->jenis,
                'kondisi' => $p->kondisi,

                'tanggal' => $p->tanggal
                    ? Carbon::parse($p->tanggal)->format('d/m/Y H:i')
                    : '-',

                // Dibutuhkan oleh form Edit.
                'tanggal_input' => $p->tanggal
                    ? Carbon::parse($p->tanggal)->format('Y-m-d\TH:i')
                    : '',

                // Nama file dan URL foto bukti umum.
                'foto_bukti' => $fotoUmum,
                'foto_bukti_url' => $fotoUmum
                    ? Storage::disk('public')->url($fotoUmum)
                    : null,

                'kerusakan' => $kerusakan
                    ->pluck('jenis_kerusakan')
                    ->values()
                    ->all(),

                'kerusakan_ids' => $kerusakan
                    ->keys()
                    ->values()
                    ->all(),

                'detail_kerusakan' => $kerusakan->mapWithKeys(
                    function ($k) {
                        $fotoBagian = $k->pivot->foto_bukti ?? null;

                        return [
                            $k->id => [
                                'keterangan' => $k->pivot->keterangan ?? '',
                                'catatan' => $k->pivot->catatan ?? '',
                                'foto_bukti' => $fotoBagian,
                                'foto_url' => $fotoBagian
                                    ? Storage::disk('public')->url(
                                        $fotoBagian
                                    )
                                    : null,
                            ],
                        ];
                    }
                )->all(),

                'keterangan' => $kerusakan->mapWithKeys(
                    function ($k) {
                        return [
                            $k->id => $k->pivot->keterangan ?? ''
                        ];
                    }
                )->all(),

                'catatan' => $p->catatan ?? '',
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw', 0),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePemeriksaan($request);

        DB::transaction(function () use ($request, $validated) {
            $rental = Rental::findOrFail($validated['rental_id']);

            $fotoBukti = $request->hasFile('foto_bukti')
                ? $request->file('foto_bukti')->store(
                    'pemeriksaan',
                    'public'
                )
                : null;

            $pemeriksaan = PemeriksaanMobil::create([
                'rental_id' => $rental->id,
                'mobil_id' => $rental->mobil_id,
                'jenis' => $validated['jenis'],
                'kondisi' => $validated['kondisi'],
                'tanggal' => $validated['tanggal'],
                'catatan' => $validated['catatan'] ?? null,
                'foto_bukti' => $fotoBukti,
            ]);

            $this->syncKerusakan($pemeriksaan, $request);
        });

        return response()->json([
            'message' => 'Pemeriksaan berhasil ditambahkan.',
        ]);
    }

    public function update(
        Request $request,
        PemeriksaanMobil $pemeriksaan
    ) {
        $validated = $this->validatePemeriksaan($request);

        DB::transaction(function () use (
            $request,
            $validated,
            $pemeriksaan
        ) {
            // Ambil ulang data yang akan diperbarui.
            $pemeriksaan = PemeriksaanMobil::whereKey($pemeriksaan->id)
                ->lockForUpdate()
                ->firstOrFail();

            $rental = Rental::findOrFail($validated['rental_id']);

            $data = [
                'rental_id' => $rental->id,
                'mobil_id' => $rental->mobil_id,
                'jenis' => $validated['jenis'],
                'kondisi' => $validated['kondisi'],
                'tanggal' => $validated['tanggal'],
                'catatan' => $validated['catatan'] ?? null,
            ];

            // Jika tidak memilih foto baru, foto lama tetap dipertahankan.
            if ($request->hasFile('foto_bukti')) {
                $oldPhoto = $pemeriksaan->foto_bukti;

                $newPhoto = $request->file('foto_bukti')->store(
                    'pemeriksaan',
                    'public'
                );

                $data['foto_bukti'] = $newPhoto;

                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            $pemeriksaan->update($data);

            $this->syncKerusakan($pemeriksaan, $request);
        });

        return response()->json([
            'message' => 'Pemeriksaan berhasil diperbarui.',
        ]);
    }

    public function destroy(
        Request $request,
        PemeriksaanMobil $pemeriksaan
    ) {
        DB::transaction(function () use ($pemeriksaan) {
            $pemeriksaan->load('kerusakan');

            foreach ($pemeriksaan->kerusakan as $kerusakan) {
                if ($kerusakan->pivot->foto_bukti) {
                    Storage::disk('public')->delete(
                        $kerusakan->pivot->foto_bukti
                    );
                }
            }

            if ($pemeriksaan->foto_bukti) {
                Storage::disk('public')->delete(
                    $pemeriksaan->foto_bukti
                );
            }

            $pemeriksaan->kerusakan()->detach();
            $pemeriksaan->delete();
        });

        return response()->json([
            'message' => 'Pemeriksaan berhasil dihapus.',
        ]);
    }

    private function validatePemeriksaan(Request $request): array
    {
        $validated = $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:sebelum_sewa,setelah_sewa',
            'kondisi' => 'required|in:baik,rusak',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string|max:1000',

            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'kerusakan' => 'nullable|array',
            'kerusakan.*' => 'required|integer|distinct|exists:kerusakan_mobils,id',

            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string|max:1000',

            'catatan_kerusakan' => 'nullable|array',
            'catatan_kerusakan.*' => 'nullable|string|max:1000',

            'foto_kerusakan' => 'nullable|array',
            'foto_kerusakan.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'rental_id.required' => 'Pilih rental terlebih dahulu.',
            'jenis.required' => 'Jenis pemeriksaan wajib diisi.',
            'kondisi.required' => 'Kondisi wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',

            'foto_bukti.image' => 'Foto bukti umum harus berupa gambar.',
            'foto_bukti.mimes' => 'Foto bukti umum harus berformat JPG, JPEG, atau PNG.',
            'foto_bukti.max' => 'Ukuran foto bukti umum maksimal 2 MB.',

            'foto_kerusakan.*.image' => 'Foto setiap bagian harus berupa gambar.',
            'foto_kerusakan.*.mimes' => 'Foto setiap bagian harus berformat JPG, JPEG, atau PNG.',
            'foto_kerusakan.*.max' => 'Ukuran setiap foto maksimal 2 MB.',
        ]);

        $selectedIds = array_map(
            'strval',
            $validated['kerusakan'] ?? []
        );

        foreach (
            ['keterangan', 'catatan_kerusakan', 'foto_kerusakan']
            as $field
        ) {
            foreach (array_keys($request->input($field, [])) as $id) {
                if (!in_array((string) $id, $selectedIds, true)) {
                    throw ValidationException::withMessages([
                        $field . '.' . $id =>
                            'Data harus sesuai dengan bagian yang dipilih.',
                    ]);
                }
            }

            foreach (
                array_keys($request->allFiles()[$field] ?? [])
                as $id
            ) {
                if (!in_array((string) $id, $selectedIds, true)) {
                    throw ValidationException::withMessages([
                        $field . '.' . $id =>
                            'Foto harus sesuai dengan bagian yang dipilih.',
                    ]);
                }
            }
        }

        return $validated;
    }

    private function syncKerusakan(
        PemeriksaanMobil $pemeriksaan,
        Request $request
    ): void {
        $ids = array_values(array_unique(
            array_map(
                'intval',
                $request->input('kerusakan', [])
            )
        ));

        $existing = $pemeriksaan->kerusakan()
            ->get()
            ->keyBy('id');

        $pivot = [];

        foreach ($ids as $id) {
            $old = $existing->get($id);
            $oldPhoto = $old?->pivot?->foto_bukti;
            $newPhoto = $request->file("foto_kerusakan.{$id}");
            $photoPath = $oldPhoto;

            // Foto lama tetap digunakan jika tidak memilih foto baru.
            if ($newPhoto) {
                $photoPath = $newPhoto->store(
                    'pemeriksaan/kerusakan',
                    'public'
                );

                if ($oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            $pivot[$id] = [
                'keterangan' => $request->input(
                    "keterangan.{$id}"
                ),
                'catatan' => $request->input(
                    "catatan_kerusakan.{$id}"
                ),
                'foto_bukti' => $photoPath,
            ];
        }

        // Hapus foto bagian yang tidak lagi dipilih.
        foreach ($existing as $id => $kerusakan) {
            if (
                !in_array((int) $id, $ids, true)
                && $kerusakan->pivot->foto_bukti
            ) {
                Storage::disk('public')->delete(
                    $kerusakan->pivot->foto_bukti
                );
            }
        }

        $pemeriksaan->kerusakan()->sync($pivot);
    }
}
