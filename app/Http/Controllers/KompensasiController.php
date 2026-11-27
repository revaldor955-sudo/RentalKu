<?php

namespace App\Http\Controllers;

use App\Models\Kompensasi;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class KompensasiController extends Controller
{
    public function index()
    {
        $customers = User::where('roles_id', 3)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('kompensasis.index', compact('customers'))->with('pageTitle', 'Kompensasi');
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
                    ->orWhere('kompensasis.alasan', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('staff', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('mobil', function ($mq) use ($search) {
                        $mq->where('name', 'like', "%{$search}%")->orWhere('plate_number', 'like', "%{$search}%");
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
            5 => null,
            6 => 'kompensasis.nominal',
        ];

        $orderColumn = $request->input('order.0.column', 1);
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
                'staff_name' => $item->staff->name ?? '-',
                'catatan' => $item->catatan,
                'created_at' => $item->created_at?->format('d/m/Y H:i'),

                'rental' => [
                    'id' => $item->rental?->id,
                    'tanggal_mulai' => $item->rental?->tanggal_mulai?->format('d/m/Y'),
                    'tanggal_selesai' => $item->rental?->tanggal_selesai?->format('d/m/Y'),
                    'jumlah_hari' => (int) ($item->rental?->jumlah_hari ?? 0),
                    'harga_perhari' => (float) ($item->rental?->harga_perhari ?? 0),
                    'deposit' => (float) ($item->rental?->deposit ?? 0),
                    'diskon' => (float) ($item->rental?->diskon ?? 0),
                    'total_harga' => (float) ($item->rental?->total_harga ?? 0),
                ],

                'bukti_urls' => $item->buktis->map(fn($b) => asset('storage/' . $b->path))->values()->all(),
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function rentalsForCustomer(Request $request)
    {
        $validated = $request->validate(
            [
                'customer_id' => ['required', Rule::exists('users', 'id')->where('roles_id', 3)],
            ],
            [
                'customer_id.required' => 'Customer wajib dipilih',
                'customer_id.exists' => 'Customer tidak valid.',
            ],
        );

        $rentals = Rental::with('mobil', 'user')
            ->where('user_id', $validated['customer_id'])
            ->where('status', 'Selesai')
            ->whereNotExists(function ($query) {
                $query->selectRaw('1')->from('kompensasis')->whereColumn('kompensasis.rental_id', 'rentals.id');
            })
            ->orderByDesc('tanggal_selesai')
            ->get()
            ->map(
                fn($rental) => [
                    'id' => $rental->id,
                    'mobil_id' => $rental->mobil_id,
                    'mobil_name' => $rental->mobil->name ?? '-',
                    'plate_number' => $rental->mobil->plate_number ?? '-',
                    'pelanggan' => $rental->user->name ?? '-',
                    'status' => $rental->status,
                    'tanggal_mulai' => $rental->tanggal_mulai?->format('d/m/Y'),
                    'tanggal_selesai' => $rental->tanggal_selesai?->format('d/m/Y'),
                    'jumlah_hari' => (int) $rental->jumlah_hari,
                    'harga_perhari' => (float) $rental->harga_perhari,
                    'subtotal' => (float) $rental->subtotal,
                    'deposit' => (float) $rental->deposit,
                    'diskon' => (float) $rental->diskon,
                    'total_harga' => (float) $rental->total_harga,
                ],
            );

        return response()->json($rentals);
    }

    public function store(Request $request)
    {
        $rules = [
            'customer_id' => ['required', Rule::exists('users', 'id')->where('roles_id', 3)],
            'rental_id' => 'required|exists:rentals,id',
            'jenis' => 'required|in:pengembalian_dana,diskon,gratis_sewa',
            'nominal' => ['nullable', 'required_if:jenis,pengembalian_dana', 'numeric', Rule::when($request->input('jenis') === 'pengembalian_dana', ['min:1'], ['min:0'])],
            'alasan' => 'required|string',
            'catatan' => 'nullable|string',
            'tanggal' => 'required|date|before_or_equal:today',
            'bukti' => 'required|array|min:2|max:5',
            'bukti.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validated = $request->validate($rules, [
            'rental_id.required' => 'Rental wajib dipilih',
            'jenis.required' => 'Jenis kompensasi wajib dipilih',
            'nominal.required_if' => 'Nominal wajib diisi untuk pengembalian dana',
            'nominal.min' => 'Nominal tidak valid: pengembalian dana minimal Rp 1, jenis lain tidak boleh negatif.',
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

        // Kompensasi dibuatkan untuk customer: rental harus milik customer tersebut.
        $rental = Rental::where('id', $validated['rental_id'])->where('user_id', $validated['customer_id'])->first();
        if (!$rental) {
            abort(403, 'Rental ini bukan milik customer tersebut.');
        }

        // Kompensasi hanya boleh dibuat untuk rental yang sudah selesai.
        if ($rental->status !== 'Selesai') {
            $pesanSelesai = 'Kompensasi hanya bisa dibuat untuk rental yang sudah selesai.';
            if ($request->wantsJson()) {
                return response()->json(
                    [
                        'message' => $pesanSelesai,
                        'errors' => ['rental_id' => [$pesanSelesai]],
                    ],
                    422,
                );
            }

            return back()
                ->withErrors(['rental_id' => $pesanSelesai])
                ->withInput();
        }

        $validated['staff_id'] = auth()->id();

        // Satu rental hanya boleh punya satu kompensasi.
        $sudahAda = Kompensasi::where('rental_id', $validated['rental_id'])->exists();
        if ($sudahAda) {
            if ($request->wantsJson()) {
                return response()->json(
                    [
                        'message' => 'Rental ini sudah memiliki kompensasi.',
                        'errors' => ['rental_id' => ['Rental ini sudah memiliki kompensasi.']],
                    ],
                    422,
                );
            }

            return back()
                ->withErrors(['rental_id' => 'Rental ini sudah memiliki kompensasi.'])
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
        } catch (UniqueConstraintViolationException $e) {
            // Dua submit bersamaan lolos pengecekan di atas; unique index rental_id yang menahan.
            Storage::disk('public')->delete(array_column($paths, 'path'));

            $pesan = 'Rental ini sudah memiliki kompensasi.';
            if ($request->wantsJson()) {
                return response()->json(
                    [
                        'message' => $pesan,
                        'errors' => ['rental_id' => [$pesan]],
                    ],
                    422,
                );
            }

            return back()
                ->withErrors(['rental_id' => $pesan])
                ->withInput();
        } catch (\Throwable $e) {
            Storage::disk('public')->delete(array_column($paths, 'path'));

            throw $e;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kompensasi berhasil dibuat.',
            ]);
        }

        return redirect()->route('kompensasis.index')->with('success', 'Kompensasi berhasil dibuat.');
    }

    public function destroy(Request $request, Kompensasi $kompensasi)
    {
        if ((int) auth()->user()->roles_id === 3) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $paths = $kompensasi->buktis->pluck('path')->all();
        $kompensasi->delete();
        Storage::disk('public')->delete($paths);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Kompensasi berhasil dihapus.',
            ]);
        }

        return redirect()->route('kompensasis.index')->with('success', 'Kompensasi berhasil dihapus.');
    }

    public function customerIndex()
    {
        // Tandai SEMUA kompensasi milik customer ini sebagai sudah dibaca,
        // bukan hanya baris yang tampil di DataTables.
        Kompensasi::where('customer_id', auth()->id())
            ->whereNull('dibaca_at')
            ->update(['dibaca_at' => now()]);

        return view('kompensasis.customer-index');
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
                    ->orWhere('kompensasis.alasan', 'like', "%{$search}%")
                    ->orWhereHas('staff', fn($sq) => $sq->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('mobil', fn($mq) => $mq->where('name', 'like', "%{$search}%")->orWhere('plate_number', 'like', "%{$search}%"));
            });
        }

        $recordsFiltered = $query->count();

        $columns = [
            0 => null,
            1 => 'kompensasis.tanggal',
            2 => 'kompensasis.jenis',
            3 => 'mobils.name',
            4 => null,
            5 => 'kompensasis.nominal',
        ];

        $orderColumn = $request->input('order.0.column', 1);
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
                'mobil_name' => $item->mobil->name ?? '-',
                'mobil_plate' => $item->mobil->plate_number ?? '-',
                'nominal' => (float) $item->nominal,
                'alasan' => $item->alasan,
                'staff_name' => $item->staff->name ?? '-',
                'catatan' => $item->catatan,
                'created_at' => $item->created_at?->format('d/m/Y H:i'),

                'rental' => [
                    'id' => $item->rental?->id,
                    'tanggal_mulai' => $item->rental?->tanggal_mulai?->format('d/m/Y'),
                    'tanggal_selesai' => $item->rental?->tanggal_selesai?->format('d/m/Y'),
                    'jumlah_hari' => (int) ($item->rental?->jumlah_hari ?? 0),
                    'harga_perhari' => (float) ($item->rental?->harga_perhari ?? 0),
                    'deposit' => (float) ($item->rental?->deposit ?? 0),
                    'diskon' => (float) ($item->rental?->diskon ?? 0),
                    'total_harga' => (float) ($item->rental?->total_harga ?? 0),
                ],

                'bukti_urls' => $item->buktis->map(fn($b) => asset('storage/' . $b->path))->values()->all(),
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
