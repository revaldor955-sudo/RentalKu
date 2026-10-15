<?php

namespace App\Http\Controllers;

use App\Models\Kompensasi;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class KompensasiController extends Controller
{
    public function index()
    {
        return view('kompensasis.index')->with('pageTitle', 'Kompensasi');
    }

    public function data(Request $request)
    {
        $query = Kompensasi::query()
            ->leftJoin('users as customer', 'kompensasis.customer_id', '=', 'customer.id')
            ->leftJoin('users as staff', 'kompensasis.staff_id', '=', 'staff.id')
            ->leftJoin('mobils', 'kompensasis.mobil_id', '=', 'mobils.id')
            ->select('kompensasis.*')
            ->with(['mobil', 'rental', 'customer', 'staff', 'buktis']);

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kompensasis.jenis', 'like', "%{$search}%")
                  ->orWhere('kompensasis.status', 'like', "%{$search}%")
                  ->orWhere('kompensasis.alasan', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('staff', function ($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mobil', function ($mq) use ($search) {
                      $mq->where('name', 'like', "%{$search}%")
                         ->orWhere('plate_number', 'like', "%{$search}%");
                  });
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'kompensasis.tanggal',
            2 => 'kompensasis.jenis',
            3 => 'customer.name',
            4 => 'mobils.name',
            5 => 'kompensasis.nominal',
            6 => 'kompensasis.status',
            7 => 'kompensasis.created_at',
        ];

        $orderColumn = $request->input('order.0.column', 7);
        $orderDir = strtolower($request->input('order.0.dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('kompensasis.created_at', 'desc');
        }

        $start = max(0, (int) $request->input('start', 0));
        $length = min(max((int) $request->input('length', 10), 1), 100);

        $kompensasis = $query->offset($start)->limit($length)->get();

        $data = $kompensasis->map(function ($item) {
            return [
                'id' => $item->id,
                'tanggal' => $item->tanggal?->format('d/m/Y'),
                'jenis' => $item->jenis,
                'customer_name' => $item->customer->name ?? '-',
                'customer_email' => $item->customer->email ?? '-',
                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',
                'nominal' => (float) $item->nominal,
                'alasan' => $item->alasan,
                'status' => $item->status,
                'staff_name' => $item->staff->name ?? '-',
                'catatan' => $item->catatan,
                'created_at' => $item->created_at?->format('d/m/Y H:i'),
                'bukti_urls' => $item->buktis->map(fn ($b) => asset('storage/'.$b->path))->values()->all(),
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
        // Jalur admin/staff (POST /kompensasis): customer_id wajib dari input
        // terverifikasi; jalur customer (POST /customer/kompensasi): milik sendiri.
        $isPetugas = auth()->user()->roles_id !== 3;

        // Cek kepemilikan didahulukan agar rental milik orang lain tetap 403
        // walau customer_id input lolos/gagal validasi peran.
        if ($isPetugas && $request->filled(['rental_id', 'customer_id'])) {
            $rentalCek = Rental::find($request->input('rental_id'));
            if ($rentalCek
                && User::where('id', $request->input('customer_id'))->exists()
                && (int) $rentalCek->user_id !== (int) $request->input('customer_id')) {
                abort(403, 'Rental ini bukan milik customer tersebut.');
            }
        }

        $rules = [
            'mobil_id' => 'nullable|exists:mobils,id',
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:pengembalian_dana,diskon,gratis_sewa',
            'nominal' => 'nullable|required_if:jenis,pengembalian_dana|numeric|min:0',
            'alasan' => 'required|string',
            'tanggal' => 'required|date|before_or_equal:today',
            'bukti' => $isPetugas ? 'nullable|array|min:2|max:5' : 'required|array|min:2|max:5',
            'bukti.*' => $isPetugas ? 'image|mimes:jpg,jpeg,png|max:2048' : 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];

        if ($isPetugas) {
            $rules['customer_id'] = ['required', Rule::exists('users', 'id')->where('roles_id', 3)];
        }

        $validated = $request->validate($rules, [
            'rental_id.required' => 'Rental wajib dipilih',
            'jenis.required' => 'Jenis kompensasi wajib dipilih',
            'nominal.required_if' => 'Nominal wajib diisi untuk pengembalian dana',
            'alasan.required' => 'Alasan wajib diisi',
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.before_or_equal' => 'Tanggal kejadian tidak boleh melebihi hari ini.',
            'customer_id.required' => 'Customer wajib dipilih',
            'customer_id.exists' => 'Customer tidak valid.',
            'bukti.required' => 'Bukti foto wajib diunggah (minimal 2, maksimal 5).',
            'bukti.array' => 'Bukti foto tidak valid.',
            'bukti.min' => 'Bukti foto minimal 2 file.',
            'bukti.max' => 'Bukti foto maksimal 5 file.',
            'bukti.*.required' => 'Setiap bukti foto wajib diisi.',
            'bukti.*.image' => 'Setiap bukti harus berupa gambar.',
            'bukti.*.mimes' => 'Bukti foto harus berformat jpg, jpeg, atau png.',
            'bukti.*.max' => 'Ukuran setiap bukti maksimal 2MB.',
        ]);

        if ($isPetugas) {
            // Klaim dibuatkan untuk customer: rental harus milik customer tersebut.
            $rental = Rental::where('id', $validated['rental_id'])
                ->where('user_id', $validated['customer_id'])
                ->first();
            if (! $rental) {
                abort(403, 'Rental ini bukan milik customer tersebut.');
            }

            $validated['customer_id'] = $rental->user_id;
        } else {
            $validated['customer_id'] = auth()->id();

            // Klaim hanya boleh atas rental milik sendiri; mobil mengikuti rental.
            $rental = Rental::where('id', $validated['rental_id'])
                ->where('user_id', auth()->id())
                ->first();
            if (! $rental) {
                abort(403, 'Rental ini bukan milik Anda.');
            }
        }

        // Klaim hanya boleh dibuat untuk rental yang sudah selesai.
        if ($rental->status !== 'Selesai') {
            $pesanSelesai = 'Klaim hanya bisa dibuat untuk rental yang sudah selesai.';
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $pesanSelesai,
                    'errors' => ['rental_id' => [$pesanSelesai]],
                ], 422);
            }

            return back()
                ->withErrors(['rental_id' => $pesanSelesai])
                ->withInput();
        }

        $validated['status'] = 'diajukan';

        // Satu rental hanya boleh punya satu klaim (klaim ditolak boleh diajukan ulang).
        $klaimAktif = Kompensasi::where('rental_id', $validated['rental_id'])
            ->whereIn('status', ['diajukan', 'disetujui', 'selesai'])
            ->exists();
        if ($klaimAktif) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Rental ini sudah memiliki klaim aktif.',
                    'errors' => ['rental_id' => ['Rental ini sudah memiliki klaim aktif.']],
                ], 422);
            }

            return back()
                ->withErrors(['rental_id' => 'Rental ini sudah memiliki klaim aktif.'])
                ->withInput();
        }
        $validated['mobil_id'] = $rental->mobil_id;

        // Nominal hanya bermakna untuk pengembalian dana; jenis lain dipaksa 0
        // agar tidak tersimpan angka sampah (kolom default 0, tidak nullable).
        if ($validated['jenis'] !== 'pengembalian_dana') {
            $validated['nominal'] = 0;
        }

        // File disimpan dulu ke disk; DB hanya di dalam transaksi. Bila transaksi
        // gagal, file yang sudah tersimpan dibersihkan agar tak jadi orphan.
        $paths = [];
        foreach ((array) $request->file('bukti', []) as $file) {
            $paths[] = [
                'path' => $file->store('bukti_kompensasi', 'public'),
                'original_name' => $file->getClientOriginalName(),
            ];
        }

        try {
            DB::transaction(function () use ($validated, $paths) {
                $data = $validated;
                unset($data['bukti']);
                $kompensasi = Kompensasi::create($data);
                foreach ($paths as $bukti) {
                    $kompensasi->buktis()->create($bukti);
                }
            });
        } catch (\Throwable $e) {
            Storage::disk('public')->delete(array_column($paths, 'path'));

            throw $e;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Klaim kompensasi berhasil diajukan.',
            ]);
        }

        if ($isPetugas) {
            return redirect()->route('kompensasis.index')
                ->with('success', 'Klaim kompensasi berhasil dibuat.');
        }

        return redirect()->route('customer.kompensasi.index')
            ->with('success', 'Klaim kompensasi berhasil diajukan.');
    }

    public function update(Request $request, Kompensasi $kompensasi)
    {
        if (auth()->user()->roles_id === 3) abort(403, 'Anda tidak memiliki akses.');
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak,selesai',
            'catatan' => 'nullable|string',
        ], [
            'status.required' => 'Status wajib dipilih',
        ]);

        // Transisi legal: diajukan -> disetujui/ditolak, disetujui -> selesai.
        // Status final tidak bisa diubah lagi.
        $transisi = [
            'diajukan' => ['disetujui', 'ditolak'],
            'disetujui' => ['selesai'],
        ];

        if ($kompensasi->status !== $validated['status']
            && ! in_array($validated['status'], $transisi[$kompensasi->status] ?? [], true)) {
            $pesan = 'Status kompensasi tidak dapat diubah dari '.$kompensasi->status.' ke '.$validated['status'].'.';

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => $pesan,
                    'errors' => ['status' => [$pesan]],
                ], 422);
            }

            return back()
                ->withErrors(['status' => $pesan])
                ->withInput();
        }

        $validated['staff_id'] = auth()->id();

        // Keputusan baru = belum dibaca customer; edit tanpa ubah status tidak picu notifikasi.
        if ($kompensasi->status !== $validated['status']) {
            $validated['dibaca_at'] = null;
        } else {
            unset($validated['dibaca_at']);
        }

        $kompensasi->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kompensasi berhasil diperbarui.',
            ]);
        }

        return redirect()->route('kompensasis.index')
            ->with('success', 'Kompensasi berhasil diperbarui.');
    }

    public function destroy(Request $request, Kompensasi $kompensasi)
    {
        if (auth()->user()->roles_id === 3) abort(403, 'Anda tidak memiliki akses.');
        $paths = $kompensasi->buktis->pluck('path')->all();
        $kompensasi->delete();
        Storage::disk('public')->delete($paths);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kompensasi berhasil dihapus.',
            ]);
        }

        return redirect()->route('kompensasis.index')
            ->with('success', 'Kompensasi berhasil dihapus.');
    }

    public function customerIndex()
    {
        $rentals = Rental::with('mobil')
            ->where('user_id', auth()->id())
            ->where('status', 'Selesai')
            ->whereNotExists(function ($query) {
                $query->selectRaw('1')
                    ->from('kompensasis')
                    ->whereColumn('kompensasis.rental_id', 'rentals.id')
                    ->whereIn('kompensasis.status', ['diajukan', 'disetujui', 'selesai']);
            })
            ->get();

        return view('kompensasis.customer-index', compact('rentals'));
    }

    public function customerData(Request $request)
    {
        $query = Kompensasi::query()
            ->leftJoin('mobils', 'kompensasis.mobil_id', '=', 'mobils.id')
            ->select('kompensasis.*')
            ->with(['mobil', 'rental', 'staff', 'buktis'])
            ->where('kompensasis.customer_id', auth()->id());

        $recordsTotal = $query->count();

        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kompensasis.jenis', 'like', "%{$search}%")
                  ->orWhere('kompensasis.status', 'like', "%{$search}%")
                  ->orWhere('kompensasis.alasan', 'like', "%{$search}%");
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'kompensasis.tanggal',
            2 => 'kompensasis.jenis',
            3 => 'mobils.name',
            4 => 'kompensasis.nominal',
            5 => 'kompensasis.status',
            6 => 'kompensasis.created_at',
        ];

        $orderColumn = $request->input('order.0.column', 6);
        $orderDir = strtolower($request->input('order.0.dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        if (isset($columns[$orderColumn]) && $columns[$orderColumn]) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('kompensasis.created_at', 'desc');
        }

        $start = max(0, (int) $request->input('start', 0));
        $length = min(max((int) $request->input('length', 10), 1), 100);

        $kompensasis = $query->offset($start)->limit($length)->get();

        // Tandai keputusan yang tampil sebagai sudah dibaca.
        $terbaca = $kompensasis->whereNull('dibaca_at')
            ->whereIn('status', ['disetujui', 'ditolak', 'selesai'])
            ->pluck('id');
        if ($terbaca->isNotEmpty()) {
            Kompensasi::whereIn('id', $terbaca)->update(['dibaca_at' => now()]);
        }

        $data = $kompensasis->map(function ($item) {
            return [
                'id' => $item->id,
                'tanggal' => $item->tanggal?->format('d/m/Y'),
                'jenis' => $item->jenis,
                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',
                'nominal' => (float) $item->nominal,
                'alasan' => $item->alasan,
                'status' => $item->status,
                'staff_name' => $item->staff->name ?? '-',
                'catatan' => $item->catatan,
                'created_at' => $item->created_at?->format('d/m/Y H:i'),
                'bukti_urls' => $item->buktis->map(fn ($b) => asset('storage/'.$b->path))->values()->all(),
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
     * Customer create claim page — retired: single flow via index popup.
     * Kept as redirect for old links/bookmarks.
     */
    public function customerCreate()
    {
        return redirect()->route('customer.kompensasi.index', ['baru' => 1]);
    }
}