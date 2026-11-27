@extends('layouts.landing')

@section('title', 'Checkout Rental - RentalKu')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <h3 class="fw-bold mb-4">
                        <i class="bi bi-receipt text-success me-2"></i>
                        Checkout RentalKu
                    </h3>

                    <div class="d-flex align-items-center gap-3 mb-4">
                        @if($mobil->image)
                            <img
                                src="{{ asset($mobil->image) }}"
                                width="110"
                                height="80"
                                class="rounded-3"
                                style="object-fit: cover;"
                                alt="{{ $mobil->name }}"
                            >
                        @endif

                        <div>
                            <h5 class="fw-bold mb-1">
                                {{ $mobil->name }}
                            </h5>

                            <small class="text-muted">
                                {{ $mobil->brand->name ?? '-' }}
                            </small>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3">
                        Detail Rental
                    </h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Cabang Pengambilan</span>
                        <strong class="text-end">
                            {{ $cabangAmbil->name ?? '-' }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Cabang Pengembalian</span>
                        <strong class="text-end">
                            {{ $cabangKembali->name ?? '-' }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tanggal Mulai</span>
                        <strong>
                            {{ \Carbon\Carbon::parse($checkout['tanggal_mulai'])->format('d/m/Y') }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tanggal Selesai</span>
                        <strong>
                            {{ \Carbon\Carbon::parse($checkout['tanggal_selesai'])->format('d/m/Y') }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Jumlah Hari</span>
                        <strong>
                            {{ $jumlahHari }} hari
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Harga Mobil</span>
                        <span>
                            Rp {{ number_format($subtotalMobil, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Supir</span>
                        <span class="text-end">
                            {{ $supir->nama ?? 'Tidak menggunakan supir' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya Supir</span>
                        <span>
                            Rp {{ number_format($subtotalSupir, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Deposit</span>
                        <span>
                            Rp {{ number_format($deposit, 0, ',', '.') }}
                        </span>
                    </div>

                    @if(!empty($checkout['catatan']))
                        <div class="mb-3">
                            <div class="fw-semibold mb-1">
                                Catatan Rental
                            </div>

                            <div class="p-3 rounded-3 bg-light">
                                {{ $checkout['catatan'] }}
                            </div>
                        </div>
                    @endif

                    <hr>

                    <div
                        class="p-3 rounded-3 mb-4"
                        style="background: #f0fff6; border: 1px solid #d5f5e3;"
                    >
                        <label
                            for="kode_promo"
                            class="form-label fw-bold"
                        >
                            <i class="bi bi-ticket-perforated text-success me-1"></i>
                            Gunakan Kode Promo
                        </label>

                        <form
                            action="{{ route('rentals.checkout.confirm', $mobil) }}"
                            method="POST"
                        >
                            @csrf

                            <input
                                type="text"
                                name="kode_promo"
                                id="kode_promo"
                                class="form-control"
                                placeholder="Contoh: HEMAT30"
                                maxlength="50"
                                autocomplete="off"
                                value="{{ $checkout['kode_promo'] ?? '' }}"
                            >

                            <small class="text-muted d-block mt-2">
                                Masukkan kode promo yang diberikan admin.
                            </small>

                            <input
                                type="hidden"
                                name="tanggal_mulai"
                                value="{{ $checkout['tanggal_mulai'] }}"
                            >

                            <input
                                type="hidden"
                                name="tanggal_selesai"
                                value="{{ $checkout['tanggal_selesai'] }}"
                            >

                            <input
                                type="hidden"
                                name="supir_id"
                                value="{{ $checkout['supir_id'] ?? '' }}"
                            >

                            <input
                                type="hidden"
                                name="cabang_ambil_id"
                                value="{{ $checkout['cabang_ambil_id'] }}"
                            >

                            <input
                                type="hidden"
                                name="cabang_kembali_id"
                                value="{{ $checkout['cabang_kembali_id'] }}"
                            >

                            <input
                                type="hidden"
                                name="catatan"
                                value="{{ $checkout['catatan'] ?? '' }}"
                            >

                            @if(isset($diskon) && $diskon > 0)
                                <div class="d-flex justify-content-between mt-3 text-success">
                                    <span>Diskon Promo</span>

                                    <strong>
                                        - Rp {{ number_format($diskon, 0, ',', '.') }}
                                    </strong>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                                <strong class="fs-5">
                                    Total Harga
                                </strong>

                                <strong class="fs-4 text-success">
                                    Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                </strong>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-success w-100 py-3 rounded-3 fw-bold"
                            >
                                <i class="bi bi-check-circle me-2"></i>
                                Konfirmasi Rental
                            </button>
                        </form>
                    </div>

                    <a
                        href="{{ route('customer.dashboard') }}"
                        class="btn btn-light w-100 mt-2 py-2"
                    >
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
