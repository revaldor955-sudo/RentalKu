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

                    {{-- Informasi Mobil --}}
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

                    {{-- Detail Rental --}}
                    <h5 class="fw-bold mb-3">
                        Detail Rental
                    </h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Cabang</span>
                        <strong class="text-end">
                            {{ $cabang->name ?? '-' }}
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

                    <div class="d-flex justify-content-between mb-3">
                        <span>Durasi Rental</span>
                        <strong>
                            {{ $jumlahHari }} hari
                        </strong>
                    </div>

                    <hr>

                    {{-- Rincian Biaya --}}
                    <h5 class="fw-bold mb-3">
                        Rincian Biaya
                    </h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Harga Rental</span>
                        <span>
                            Rp {{ number_format($subtotalMobil, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Supir</span>
                        <span class="text-end">
                            {{ $supir->name ?? 'Tidak menggunakan supir' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Biaya Supir</span>
                        <span>
                            Rp {{ number_format($subtotalSupir, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-3 fw-semibold">
                        <span>Subtotal Rental</span>
                        <span>
                            Rp {{ number_format($subtotalMobil + $subtotalSupir, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Catatan Rental --}}
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

                    {{-- Promo --}}
                    <div
                        class="p-3 rounded-3 mb-4"
                        style="background: #f0fff6; border: 1px solid #d5f5e3;"
                    >
                        <label
                            for="kode_promo"
                            class="form-label fw-bold"
                        >
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
                                value="{{ old('kode_promo', $checkout['kode_promo'] ?? '') }}"
                            >

                            <div id="promo-message" class="mt-2 small"></div>

                            @if($errors->has('kode_promo'))
                                <div class="alert alert-danger mt-2 mb-0 py-2">
                                    {{ $errors->first('kode_promo') }}
                                </div>
                            @endif

                            {{-- Data Rental --}}
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
                                name="catatan"
                                value="{{ $checkout['catatan'] ?? '' }}"
                            >

                            {{-- Diskon --}}
                            @if(isset($diskon) && $diskon > 0)
                                <div class="d-flex justify-content-between mt-3 text-success">
                                    <span>Diskon Promo</span>

                                    <strong>
                                        - Rp {{ number_format($diskon, 0, ',', '.') }}
                                    </strong>
                                </div>
                            @endif

                            {{-- Total Rental Setelah Diskon --}}
                            <div class="d-flex justify-content-between mt-3">
                                <span class="fw-semibold">
                                    Total Rental Setelah Diskon
                                </span>

                                <strong class="text-success">
                                    Rp {{ number_format(($subtotalMobil + $subtotalSupir) - $diskon, 0, ',', '.') }}
                                </strong>
                            </div>

                            {{-- Deposit --}}
                            <div class="d-flex justify-content-between mt-2 mb-3">
                                <span>
                                    Deposit (Uang Jaminan)
                                </span>

                                <strong>
                                    Rp {{ number_format($deposit, 0, ',', '.') }}
                                </strong>
                            </div>

                            <hr>

                            {{-- Total Pembayaran --}}
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <strong class="fs-5">
                                        Total Pembayaran
                                    </strong>

                                    <small class="d-block text-muted">
                                        Rental setelah diskon + deposit
                                    </small>
                                </div>

                                <strong class="fs-4 text-success text-end">
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

                    {{-- Tombol Kembali --}}
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

{{-- Validasi Kode Promo --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputPromo = document.getElementById('kode_promo');
    const promoMessage = document.getElementById('promo-message');

    if (!inputPromo || !promoMessage) return;

    let timeout = null;

    inputPromo.addEventListener('input', function () {
        clearTimeout(timeout);

        const kode = inputPromo.value.trim();

        promoMessage.innerHTML = '';
        inputPromo.classList.remove('is-valid', 'is-invalid');

        if (kode === '') {
            return;
        }

        timeout = setTimeout(function () {
            fetch('{{ route('rentals.promo.check') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    kode_promo: kode
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    inputPromo.classList.add('is-valid');

                    promoMessage.textContent = data.message;
                    promoMessage.className = 'mt-2 small text-success fw-semibold';
                } else {
                    inputPromo.classList.add('is-invalid');

                    promoMessage.textContent = data.message;
                    promoMessage.className = 'mt-2 small text-danger fw-semibold';
                }
            })
            .catch(() => {
                inputPromo.classList.add('is-invalid');

                promoMessage.textContent = 'Gagal memeriksa kode promo. Silakan coba lagi.';
                promoMessage.className = 'mt-2 small text-danger';
            });
        }, 500);
    });
});
</script>

@endsection
