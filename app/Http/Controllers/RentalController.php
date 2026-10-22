<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Rental;
use App\Models\Supir;
use App\Models\Kupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RentalController extends Controller
{
    /**
     * Simpan pengajuan rental customer
     */
    public function store(Request $request, Mobil $mobil)
    {
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.',
                ], 401);
            }

            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($mobil->status !== 'Tersedia') {
            return $this->errorResponse(
                $request,
                'Mobil sedang tidak tersedia.'
            );
        }

        $validated = $request->validate([
            'tanggal_mulai' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'tanggal_selesai' => [
                'required',
                'date',
                'after:tanggal_mulai',
            ],
            'supir_id' => [
                'nullable',
                'exists:supirs,id',
            ],
            'kode_promo' => [
                'nullable',
                'string',
                'max:50',
            ],
            'catatan' => [
                'nullable',
                'string',
                'max:500',
            ],
            'cabang_ambil_id' => [
                'required',
                'exists:cabangs,id',
            ],
            'cabang_kembali_id' => [
                'required',
                'exists:cabangs,id',
            ],
        ], [
            'tanggal_mulai.required' =>
                'Tanggal mulai wajib diisi.',
            'tanggal_mulai.after_or_equal' =>
                'Tanggal mulai tidak boleh sebelum hari ini.',
            'tanggal_selesai.required' =>
                'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after' =>
                'Tanggal selesai harus setelah tanggal mulai.',
            'supir_id.exists' =>
                'Supir yang dipilih tidak tersedia.',
            'catatan.max' =>
                'Catatan maksimal 500 karakter.',
            'cabang_ambil_id.required' =>
                'Cabang ambil wajib dipilih.',
            'cabang_ambil_id.exists' =>
                'Cabang ambil tidak valid.',
            'cabang_kembali_id.required' =>
                'Cabang kembali wajib dipilih.',
            'cabang_kembali_id.exists' =>
                'Cabang kembali tidak valid.',
        ]);

        $tanggalMulai = Carbon::parse(
            $validated['tanggal_mulai']
        );

        $tanggalSelesai = Carbon::parse(
            $validated['tanggal_selesai']
        );

        $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai);

        $rentalBertabrakan = Rental::where('mobil_id', $mobil->id)
            ->whereIn('status', [
                'Menunggu',
                'Disetujui',
                'Berjalan',
            ])
            ->where(function ($query) use (
                $tanggalMulai,
                $tanggalSelesai
            ) {
                $query->whereDate(
                    'tanggal_mulai',
                    '<',
                    $tanggalSelesai
                )->whereDate(
                    'tanggal_selesai',
                    '>',
                    $tanggalMulai
                );
            })
            ->exists();

        if ($rentalBertabrakan) {
            return $this->errorResponse(
                $request,
                'Mobil sudah memiliki jadwal rental pada tanggal tersebut.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Mengambil dan mengecek supir
        |--------------------------------------------------------------------------
        */

        $supir = null;

        if (!empty($validated['supir_id'])) {
            $supir = Supir::findOrFail(
                $validated['supir_id']
            );

            if (strtolower($supir->status) !== 'tersedia') {
                return $this->errorResponse(
                    $request,
                    'Supir yang dipilih sedang tidak tersedia.'
                );
            }

            $supirBertabrakan = Rental::whereHas(
                'supirs',
                function ($query) use ($supir) {
                    $query->where(
                        'supirs.id',
                        $supir->id
                    );
                }
            )
                ->whereIn('rentals.status', [
                    'Menunggu',
                    'Disetujui',
                    'Berjalan',
                ])
                ->where(function ($query) use (
                    $tanggalMulai,
                    $tanggalSelesai
                ) {
                    $query->whereDate(
                        'tanggal_mulai',
                        '<',
                        $tanggalSelesai
                    )->whereDate(
                        'tanggal_selesai',
                        '>',
                        $tanggalMulai
                    );
                })
                ->exists();

            if ($supirBertabrakan) {
                return $this->errorResponse(
                    $request,
                    'Supir sudah memiliki jadwal rental pada tanggal tersebut.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi stok mobil per tipe
        |--------------------------------------------------------------------------
        */

        $totalMobilSameType = Mobil::where('tipe_mobil_id', $mobil->tipe_mobil_id)->count();

        $rentalsSameTypeConflict = Rental::whereHas('mobil', function ($q) use ($mobil) {
            $q->where('tipe_mobil_id', $mobil->tipe_mobil_id);
        })
            ->whereIn('status', ['Menunggu', 'Disetujui', 'Berjalan'])
            ->where(function ($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->whereDate('tanggal_mulai', '<', $tanggalSelesai)
                    ->whereDate('tanggal_selesai', '>', $tanggalMulai);
            })
            ->count();

        if ($rentalsSameTypeConflict >= $totalMobilSameType) {
            return $this->errorResponse(
                $request,
                'Semua mobil tipe "' . ($mobil->tipe_mobil->name ?? $mobil->name) . '" sedang disewa.'
            );
        }

        $hargaPerhari = (float) $mobil->harga_perhari;

        $deposit = (float) (
            $mobil->deposit ?? 0
        );

        $subtotalMobil = $jumlahHari * $hargaPerhari;

        $subtotalSupir = 0;

        if ($supir) {
            $subtotalSupir =
                $jumlahHari * (float) $supir->tarif_perhari;
        }

        $subtotalSewa =
            $subtotalMobil + $subtotalSupir;

        $kodePromo = !empty($validated['kode_promo'])
            ? strtoupper(trim($validated['kode_promo']))
            : null;

        $diskon = 0;
        $kupon = null;

        /*
        |--------------------------------------------------------------------------
        | Validasi dan perhitungan promo
        |--------------------------------------------------------------------------
        */

        if ($kodePromo) {
            $promoResult = $this->calculatePromo(
                $kodePromo,
                $subtotalSewa
            );

            if (!$promoResult['success']) {
                return $this->errorResponse(
                    $request,
                    $promoResult['message']
                );
            }

            $kupon = $promoResult['kupon'];
            $diskon = $promoResult['diskon'];
        }

        $totalHarga = max(
            0,
            $subtotalSewa + $deposit - $diskon
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan rental dan promo
        |--------------------------------------------------------------------------
        */

        $rental = DB::transaction(function () use (
            $validated,
            $mobil,
            $tanggalMulai,
            $tanggalSelesai,
            $jumlahHari,
            $hargaPerhari,
            $deposit,
            $subtotalMobil,
            $subtotalSupir,
            $totalHarga,
            $diskon,
            $kodePromo,
            $supir,
            $kupon
        ) {
            $rental = Rental::create([
                'user_id' => auth()->id(),
                'mobil_id' => $mobil->id,
                'cabang_ambil_id' =>
                    $validated['cabang_ambil_id'],
                'cabang_kembali_id' =>
                    $validated['cabang_kembali_id'],
                'tanggal_mulai' =>
                    $tanggalMulai->format('Y-m-d'),
                'tanggal_selesai' =>
                    $tanggalSelesai->format('Y-m-d'),
                'jumlah_hari' => $jumlahHari,
                'harga_perhari' => $hargaPerhari,
                'subtotal' => $subtotalMobil,
                'deposit' => $deposit,
                'kode_promo' => $kodePromo,
                'diskon' => $diskon,
                'total_harga' => $totalHarga,
                'status' => 'Menunggu',
                'catatan' =>
                    $validated['catatan'] ?? null,
            ]);

            if ($supir) {
                $rental->supirs()->attach(
                    $supir->id,
                    [
                        'tarif_perhari' =>
                            $supir->tarif_perhari,
                        'sub_total' =>
                            $subtotalSupir,
                    ]
                );
            }

            if ($kupon) {
                $kuponLock = Kupon::where(
                    'id',
                    $kupon->id
                )
                    ->lockForUpdate()
                    ->first();

                if ($kuponLock) {
                    $kuponLock->increment('terpakai');
                }
            }

            return $rental;
        });

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' =>
                    'Pengajuan sewa mobil berhasil dibuat.',
                'rental_id' => $rental->id,
            ]);
        }

        return redirect()->route('customer.dashboard')->with('success', 'Pengajuan sewa mobil berhasil dibuat.');
    }

    /**
     * Menampilkan halaman checkout rental
     */
    public function checkout(
        Request $request,
        Mobil $mobil
    ) {
        $isAjax =
            $request->ajax() ||
            $request->expectsJson();

        $validator = Validator::make(
            $request->all(),
            [
                'tanggal_mulai' => [
                    'required',
                    'date',
                    'after_or_equal:today',
                ],
                'tanggal_selesai' => [
                    'required',
                    'date',
                    'after:tanggal_mulai',
                ],
                'supir_id' => [
                    'nullable',
                    'exists:supirs,id',
                ],
                'kode_promo' => [
                    'nullable',
                    'string',
                    'max:50',
                ],
                'catatan' => [
                    'nullable',
                    'string',
                    'max:500',
                ],
                'cabang_ambil_id' => [
                    'required',
                    'exists:cabangs,id',
                ],
                'cabang_kembali_id' => [
                    'required',
                    'exists:cabangs,id',
                ],
            ],
            [
                'tanggal_mulai.required' =>
                    'Tanggal mulai wajib diisi.',
                'tanggal_mulai.after_or_equal' =>
                    'Tanggal mulai tidak boleh sebelum hari ini.',
                'tanggal_selesai.required' =>
                    'Tanggal selesai wajib diisi.',
                'tanggal_selesai.after' =>
                    'Tanggal selesai harus setelah tanggal mulai.',
                'supir_id.exists' =>
                    'Supir yang dipilih tidak tersedia.',
                'catatan.max' =>
                    'Catatan maksimal 500 karakter.',
                'cabang_ambil_id.required' =>
                    'Cabang ambil wajib dipilih.',
                'cabang_ambil_id.exists' =>
                    'Cabang ambil tidak valid.',
                'cabang_kembali_id.required' =>
                    'Cabang kembali wajib dipilih.',
                'cabang_kembali_id.exists' =>
                    'Cabang kembali tidak valid.',
            ]
        );

        if ($validator->fails()) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data checkout belum valid.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $tanggalMulai = Carbon::parse(
            $validated['tanggal_mulai']
        );

        $tanggalSelesai = Carbon::parse(
            $validated['tanggal_selesai']
        );

        $jumlahHari = $tanggalMulai->diffInDays(
            $tanggalSelesai
        );

        $supir = null;

        if (!empty($validated['supir_id'])) {
            $supir = Supir::findOrFail(
                $validated['supir_id']
            );

            if (strtolower($supir->status) !== 'tersedia') {
                if ($isAjax) {
                    return response()->json([
                        'success' => false,
                        'message' =>
                            'Supir sedang tidak tersedia.',
                    ], 422);
                }

                return back()->with(
                    'error',
                    'Supir sedang tidak tersedia.'
                );
            }
        }

        $hargaPerhari = (float) $mobil->harga_perhari;

        $deposit = (float) (
            $mobil->deposit ?? 0
        );

        $subtotalMobil =
            $jumlahHari * $hargaPerhari;

        $subtotalSupir = $supir
            ? $jumlahHari * (float) $supir->tarif_perhari
            : 0;

        $subtotalSewa =
            $subtotalMobil + $subtotalSupir;

        $kodePromo = !empty($validated['kode_promo'])
            ? strtoupper(trim($validated['kode_promo']))
            : null;

        $diskon = 0;

        if ($kodePromo) {
            $promoResult = $this->calculatePromo(
                $kodePromo,
                $subtotalSewa
            );

            if (!$promoResult['success']) {
                if ($isAjax) {
                    return response()->json([
                        'success' => false,
                        'message' => $promoResult['message'],
                    ], 422);
                }

                return back()
                    ->with(
                        'error',
                        $promoResult['message']
                    )
                    ->withInput();
            }

            $diskon = $promoResult['diskon'];
        }

        $totalHarga = max(
            0,
            $subtotalSewa + $deposit - $diskon
        );

        session([
            'checkout_rental' => [
                'mobil_id' => $mobil->id,
                'cabang_ambil_id' =>
                    $validated['cabang_ambil_id'],
                'cabang_kembali_id' =>
                    $validated['cabang_kembali_id'],
                'tanggal_mulai' =>
                    $validated['tanggal_mulai'],
                'tanggal_selesai' =>
                    $validated['tanggal_selesai'],
                'jumlah_hari' =>
                    $jumlahHari,
                'supir_id' =>
                    $validated['supir_id'] ?? null,
                'kode_promo' =>
                    $kodePromo,
                'catatan' =>
                    $validated['catatan'] ?? null,
                'harga_perhari' =>
                    $hargaPerhari,
                'subtotal_mobil' =>
                    $subtotalMobil,
                'subtotal_supir' =>
                    $subtotalSupir,
                'deposit' =>
                    $deposit,
                'diskon' =>
                    $diskon,
                'total_harga' =>
                    $totalHarga,
            ],
        ]);

$checkoutUrl = route(
    'rentals.checkout.show',
    ['mobil' => $mobil->id]
);
        if ($isAjax) {
            $supirData = null;
            if ($supir) {
                $supirData = [
                    'id' => $supir->id,
                    'nama' => $supir->nama,
                    'tarif_perhari' => $supir->tarif_perhari,
                ];
            }

            $html = view('customer.partials.checkout-summary', [
                'mobil' => $mobil,
                'supir' => $supir,
                'jumlahHari' => $jumlahHari,
                'subtotalMobil' => $subtotalMobil,
                'subtotalSupir' => $subtotalSupir,
                'deposit' => $deposit,
                'diskon' => $diskon,
                'totalHarga' => $totalHarga,
                'checkout' => [
                    'tanggal_mulai' => $validated['tanggal_mulai'],
                    'tanggal_selesai' => $validated['tanggal_selesai'],
                    'supir_id' => $validated['supir_id'] ?? null,
                    'kode_promo' => $validated['kode_promo'] ?? '',
                    'catatan' => $validated['catatan'] ?? '',
                ],
            ])->render();

            return response()->json([
                'success' => true,
                'message' => 'Data checkout berhasil disiapkan.',
                'html' => $html,
            ]);
        }

        return view(
            'customer.checkout',
            compact(
                'mobil',
                'supir',
                'jumlahHari',
                'subtotalMobil',
                'subtotalSupir',
                'deposit',
                'diskon',
                'totalHarga'
            )
        );
    }


    /**
 * Menampilkan halaman checkout rental
 */
public function showCheckout(Mobil $mobil)
{
    $checkout = session('checkout_rental');

if (!$checkout) {
    return redirect()->route('customer.dashboard')->with('error', 'Data checkout tidak ditemukan. Silakan ulangi proses booking.');
}

    if ((int) ($checkout['mobil_id'] ?? 0) !== (int) $mobil->id) {
        return redirect()->route('home')->with('error', 'Data checkout tidak sesuai dengan mobil.');
    }

    $supir = null;

    if (!empty($checkout['supir_id'])) {
        $supir = Supir::find($checkout['supir_id']);
    }

    return view('customer.checkout', [
        'mobil' => $mobil,
        'checkout' => $checkout,
        'supir' => $supir,
        'jumlahHari' => $checkout['jumlah_hari'] ?? 0,
        'subtotalMobil' => $checkout['subtotal_mobil'] ?? 0,
        'subtotalSupir' => $checkout['subtotal_supir'] ?? 0,
        'deposit' => $checkout['deposit'] ?? 0,
        'diskon' => $checkout['diskon'] ?? 0,
        'totalHarga' => $checkout['total_harga'] ?? 0,
    ]);
}


 /**
 * Konfirmasi checkout dan simpan rental
 */
public function confirmCheckout(
    Request $request,
    Mobil $mobil
) {
    $checkout = session('checkout_rental');

    if (!$checkout) {
        return redirect()
            ->route('customer.dashboard')
            ->with(
                'error',
                'Data checkout tidak ditemukan.'
            );
    }

    if ((int) ($checkout['mobil_id'] ?? 0) !== (int) $mobil->id) {
        session()->forget('checkout_rental');

        return redirect()->route('home')->with('error', 'Data checkout tidak sesuai dengan mobil.');
    }

    /*
    |--------------------------------------------------------------
    | Ambil kode promo dari input checkout
    |--------------------------------------------------------------
    */

    $kodePromo = $request->input(
        'kode_promo',
        $checkout['kode_promo'] ?? null
    );

    $request->merge([
        'tanggal_mulai' =>
            $checkout['tanggal_mulai'],

        'tanggal_selesai' =>
            $checkout['tanggal_selesai'],

        'supir_id' =>
            $checkout['supir_id'] ?? null,

        'kode_promo' =>
            $kodePromo,

        'catatan' =>
            $checkout['catatan'] ?? null,

        'cabang_ambil_id' =>
            $checkout['cabang_ambil_id'] ?? null,

        'cabang_kembali_id' =>
            $checkout['cabang_kembali_id'] ?? null,
    ]);

    $response = $this->store(
        $request,
        $mobil
    );

    if (
        $response instanceof
        \Illuminate\Http\RedirectResponse
    ) {
        session()->forget('checkout_rental');
    }

    return $response;
}
    /**
     * Menampilkan halaman rental admin/staff
     */
    public function index()
    {
        return view('admin.rentals.index')->with('pageTitle', 'Transaksi Rental');
    }

    /**
     * DataTables rental
     */
  
/**
 * DataTables rental
 * Data rental terbaru ditampilkan paling atas secara default.
 */

/**
 * DataTables rental
 * Data rental terbaru selalu ditampilkan paling atas.
 */
public function data(Request $request)
{
    $query = Rental::query()
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
            'rentals.*',
            'users.name as user_name',
            'users.email as user_email',
            'mobils.name as mobil_name',
            'mobils.plate_number as mobil_plate'
        );

    /*
    |--------------------------------------------------------------------------
    | Filter status
    |--------------------------------------------------------------------------
    */
    if ($request->filled('status')) {
        $query->where(
            'rentals.status',
            $request->input('status')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Total data sebelum pencarian
    |--------------------------------------------------------------------------
    */
    $recordsTotal = Rental::when(
        $request->filled('status'),
        function ($q) use ($request) {
            $q->where(
                'status',
                $request->input('status')
            );
        }
    )->count();

    /*
    |--------------------------------------------------------------------------
    | Pencarian DataTables
    |--------------------------------------------------------------------------
    */
    $search = trim(
        (string) $request->input('search.value', '')
    );

    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where(
                'users.name',
                'like',
                "%{$search}%"
            )
            ->orWhere(
                'users.email',
                'like',
                "%{$search}%"
            )
            ->orWhere(
                'mobils.name',
                'like',
                "%{$search}%"
            )
            ->orWhere(
                'mobils.plate_number',
                'like',
                "%{$search}%"
            )
            ->orWhere(
                'rentals.status',
                'like',
                "%{$search}%"
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Jumlah data setelah pencarian
    |--------------------------------------------------------------------------
    */
    $recordsFiltered = (clone $query)->count(
        'rentals.id'
    );

    /*
    |--------------------------------------------------------------------------
    | Urutan data terbaru
    |--------------------------------------------------------------------------
    |
    | ID terbesar menjadi prioritas utama karena setiap rental
    | baru mendapatkan ID baru.
    |
    | created_at digunakan sebagai urutan tambahan.
    */
    $query->orderByDesc('rentals.id')
          ->orderByDesc('rentals.created_at');

    /*
    |--------------------------------------------------------------------------
    | Pagination DataTables
    |--------------------------------------------------------------------------
    */
    $start = max(
        0,
        (int) $request->input('start', 0)
    );

    $length = (int) $request->input('length', 10);

    if ($length === -1) {
        $length = 500;
    }

    $length = max(1, min($length, 500));

    $rentals = $query
        ->offset($start)
        ->limit($length)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Format respons JSON
    |--------------------------------------------------------------------------
    */
    $data = $rentals->map(function ($rental) {
        return [
            'id' => $rental->id,

            'user_name' =>
                $rental->user_name ?? '-',

            'user_email' =>
                $rental->user_email ?? '-',

            'mobil_name' =>
                $rental->mobil_name ?? '-',

            'mobil_plate' =>
                $rental->mobil_plate ?? '-',

            'tanggal_mulai' =>
                $rental->tanggal_mulai
                    ? Carbon::parse(
                        $rental->tanggal_mulai
                    )->format('d/m/Y')
                    : '-',

            'tanggal_selesai' =>
                $rental->tanggal_selesai
                    ? Carbon::parse(
                        $rental->tanggal_selesai
                    )->format('d/m/Y')
                    : '-',

            'jumlah_hari' =>
                $rental->jumlah_hari,

            'total_harga' =>
                (float) $rental->total_harga,

            'status' =>
                $rental->status,
        ];
    });

    return response()->json([
        'draw' =>
            (int) $request->input('draw', 0),

        'recordsTotal' =>
            $recordsTotal,

        'recordsFiltered' =>
            $recordsFiltered,

        'data' =>
            $data,
    ]);
}


    /**
     * Detail rental untuk AJAX
     */
    
/**
 * Menampilkan detail lengkap rental untuk modal Management Rental.
 */
public function detail(Rental $rental)
{
    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'message' => 'Silakan login terlebih dahulu.',
        ], 401);
    }

    // Customer hanya boleh melihat rental miliknya sendiri.
    if (
        (int) $user->roles_id === 3 &&
        (int) $rental->user_id !== (int) $user->id
    ) {
        return response()->json([
            'message' => 'Anda tidak berhak mengakses data rental ini.',
        ], 403);
    }

    $rental->load([
        'user',
        'mobil',
        'cabangAmbil',
        'cabangKembali',
        'pembayaran',
        'rating',
        'supirs',
    ]);

    $supirs = $rental->supirs->map(function ($supir) {
        return [
            'id' => $supir->id,
            'nama' => $supir->nama ?? '-',
            'tarif_perhari' => (float) (
                $supir->pivot->tarif_perhari
                ?? $supir->tarif_perhari
                ?? 0
            ),
            'subtotal' => (float) (
                $supir->pivot->sub_total
                ?? 0
            ),
        ];
    })->values();

    return response()->json([
        'id' => $rental->id,

        // Informasi pelanggan
        'pelanggan' => $rental->user->name ?? '-',
        'email' => $rental->user->email ?? '-',
        'telepon' => $rental->user->phone ?? '-',
        'alamat' => $rental->user->address ?? '-',

        // Informasi mobil
        'mobil' => $rental->mobil->name ?? '-',
        'plat' => $rental->mobil->plate_number ?? '-',
        'mobil_image' => (
            $rental->mobil && $rental->mobil->image
        ) ? asset($rental->mobil->image) : null,

        // Periode penyewaan
        'tanggal_mulai' => $rental->tanggal_mulai
            ? Carbon::parse($rental->tanggal_mulai)->format('d/m/Y')
            : '-',

        'tanggal_selesai' => $rental->tanggal_selesai
            ? Carbon::parse($rental->tanggal_selesai)->format('d/m/Y')
            : '-',

        'jumlah_hari' => (int) ($rental->jumlah_hari ?? 0),

        // Informasi cabang
        'cabang_ambil' => $rental->cabangAmbil->name ?? '-',
        'cabang_kembali' => $rental->cabangKembali->name ?? '-',

        // Rincian biaya
        'harga_perhari' => (float) ($rental->harga_perhari ?? 0),
        'subtotal' => (float) ($rental->subtotal ?? 0),
        'deposit' => (float) ($rental->deposit ?? 0),
        'kode_promo' => $rental->kode_promo ?? '-',
        'diskon' => (float) ($rental->diskon ?? 0),
        'total_harga' => (float) ($rental->total_harga ?? 0),

        // Informasi tambahan
        'status' => $rental->status,
        'catatan' => $rental->catatan ?? '-',
        'supirs' => $supirs,
        'pembayaran' => $rental->pembayaran,
        'rating' => $rental->rating,
    ]);
}


    /**
     * Update status rental
     */
    public function updateStatus(
        Request $request,
        Rental $rental
    ) {
        if (auth()->user()->roles_id === 3) {
            abort(403, 'Anda tidak berhak mengubah status rental.');
        }

        $request->validate([
            'status' => [
                'required',
                'in:Disetujui,Ditolak,Berjalan,Selesai',
            ],
        ]);

        $status = $request->status;

        // Transisi legal mengikuti tombol di UI: Menunggu -> Disetujui/Ditolak,
        // Disetujui -> Selesai. Status final tidak bisa diubah lagi.
        $transisi = [
            'Menunggu' => ['Disetujui', 'Ditolak'],
            'Disetujui' => ['Selesai'],
            'Berjalan' => ['Selesai'],
        ];

        if ($rental->status !== $status
            && ! in_array($status, $transisi[$rental->status] ?? [], true)) {
            return response()->json([
                'message' =>
                    'Status rental tidak dapat diubah dari '.$rental->status.' ke '.$status.'.',
            ], 422);
        }

        // Replay status sama = no-op (jangan tembak side-effect dua kali).
        if ($rental->status === $status) {
            return response()->json([
                'message' =>
                    'Status rental sudah '.$status.'.',
            ]);
        }

        if ($status === 'Disetujui') {
            if (
                $rental->mobil &&
                $rental->mobil->status !== 'Tersedia'
            ) {
                return response()->json([
                    'message' =>
                        'Mobil sedang tidak tersedia.',
                ], 422);
            }

            DB::transaction(function () use ($rental) {
                $rental->update([
                    'status' => 'Disetujui',
                ]);

                if ($rental->mobil) {
                    $rental->mobil->update([
                        'status' => 'Disewa',
                    ]);
                }
            });

            return response()->json([
                'message' =>
                    'Rental berhasil disetujui.',
            ]);
        }

        if ($status === 'Ditolak') {
            DB::transaction(function () use ($rental) {
                $rental->update([
                    'status' => 'Ditolak',
                ]);

                if ($rental->mobil) {
                    $rental->mobil->update([
                        'status' => 'Tersedia',
                    ]);
                }
            });

            return response()->json([
                'message' =>
                    'Pengajuan rental berhasil ditolak.',
            ]);
        }

        if ($status === 'Berjalan') {
            $rental->update([
                'status' => 'Berjalan',
            ]);

            return response()->json([
                'message' =>
                    'Rental sekarang berstatus berjalan.',
            ]);
        }

        if ($status === 'Selesai') {
            DB::transaction(function () use ($rental) {
                $rental->update([
                    'status' => 'Selesai',
                ]);

                if ($rental->mobil) {
                    $rental->mobil->update([
                        'status' => 'Tersedia',
                    ]);
                }
            });

            return response()->json([
                'message' =>
                    'Rental berhasil diselesaikan.',
            ]);
        }

        return response()->json([
            'message' => 'Status tidak valid.',
        ], 422);
    }

    /**
     * Validasi dan hitung promo
     */
    private function calculatePromo(
        string $kodePromo,
        float $subtotalSewa
    ): array {
        $kupon = Kupon::whereRaw(
            'UPPER(code) = ?',
            [$kodePromo]
        )->first();

        if (!$kupon) {
            return [
                'success' => false,
                'message' => 'Kode promo tidak ditemukan.',
            ];
        }

        $sekarang = Carbon::now();

        if (
            $kupon->active_at &&
            $sekarang->lt($kupon->active_at)
        ) {
            return [
                'success' => false,
                'message' => 'Kode promo belum aktif.',
            ];
        }

        if (
            $kupon->expired_at &&
            $sekarang->gt($kupon->expired_at)
        ) {
            return [
                'success' => false,
                'message' => 'Kode promo sudah kedaluwarsa.',
            ];
        }

        if (
            $kupon->kuota !== null &&
            $kupon->terpakai >= $kupon->kuota
        ) {
            return [
                'success' => false,
                'message' => 'Kuota promo sudah habis.',
            ];
        }

        if (
            $subtotalSewa <
            (float) $kupon->minimal_pembelian
        ) {
            return [
                'success' => false,
                'message' =>
                    'Minimal pembelian untuk promo belum terpenuhi.',
            ];
        }

        if ($kupon->jenis === 'persen') {
            $persentase = min(
                100,
                max(0, (float) $kupon->value)
            );

            $diskon =
                $subtotalSewa * ($persentase / 100);
        } else {
            $diskon = (float) $kupon->value;
        }

        $diskon = min(
            $diskon,
            $subtotalSewa
        );

        return [
            'success' => true,
            'kupon' => $kupon,
            'diskon' => $diskon,
        ];
    }

    /**
     * Response error JSON atau redirect
     */
    private function errorResponse(
        Request $request,
        string $message
    ) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }

        return back()->with(
            'error',
            $message
        );
    }
}