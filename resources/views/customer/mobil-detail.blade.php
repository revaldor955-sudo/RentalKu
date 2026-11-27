<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $mobil->name ?? 'Detail Mobil' }} - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #F0EDEE;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            color: #1F2937;
        }

        :root {
            --primary: #2C666E;
            --dark: #111827;
        }

        .navbar {
            background: rgba(255, 255, 255, .96);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            padding: 16px 0;
        }

        .navbar-brand {
            font-size: 25px;
            font-weight: 800;
            color: var(--dark) !important;
        }

        .navbar-brand span {
            color: var(--primary);
        }

        .nav-link {
            color: #4b5563 !important;
            font-weight: 600;
            margin: 0 7px;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .navbar-nav .nav-link {
            transition: color .2s ease, background .2s ease;
            position: relative;
            border-radius: 10px;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary) !important;
            background: rgba(44, 102, 110, .1);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 2px;
            left: 50%;
            background-color: var(--primary);
            transition: width .2s ease, left .2s ease;
        }

        .navbar-nav .nav-link:hover::after {
            width: 60%;
            left: 20%;
        }

        .navbar-nav .nav-link.active {
            color: var(--primary) !important;
        }

        .navbar-nav .nav-link.active::after {
            width: 60%;
            left: 20%;
        }

        .nav-btn-ghost {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            color: var(--dark) !important;
            background: transparent !important;
            border-radius: 10px !important;
            transition: all .2s ease !important;
            position: relative;
        }

        .nav-btn-ghost:hover,
        .nav-btn-ghost:focus {
            background: rgba(44, 102, 110, .1) !important;
            color: var(--primary) !important;
        }

        .nav-btn-ghost::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 2px;
            left: 50%;
            background-color: var(--primary);
            transition: width .2s ease, left .2s ease;
        }

        .nav-btn-ghost:hover::after,
        .nav-btn-ghost:focus::after {
            width: 60%;
            left: 20%;
        }

        .page-wrap {
            max-width: 1120px;
            margin: 0 auto;
        }

        .pm-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }

        .pm-hero {
            position: relative;
            aspect-ratio: 16 / 10;
            background: #e9ecef;
            overflow: hidden;
        }

        .pm-hero img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .pm-hero-badges {
            position: absolute;
            top: 16px;
            left: 16px;
            right: 16px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }

        .badge-available,
        .badge-unavailable {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
        }

        .badge-available {
            color: #198754;
        }

        .badge-unavailable {
            color: #dc3545;
        }

        .pm-cabang-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #1F2937;
            color: #fff;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }

        .pm-body {
            padding: 28px;
        }

        .pm-title {
            font-size: 30px;
            font-weight: 800;
            margin: 0 0 6px;
            color: #1F2937;
        }

        .pm-subtitle {
            color: #6B7280;
            font-size: 15px;
            margin-bottom: 0;
        }

        .pm-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            margin-top: 22px;
            align-items: start;
        }

        .pm-specs {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .pm-spec {
            background: #f5f8f6;
            border: 1px solid #E5E7EB;
            border-radius: 14px;
            padding: 12px;
        }

        .pm-spec i {
            color: #198754;
            font-size: 18px;
        }

        .pm-spec-label {
            color: #6B7280;
            font-size: 12px;
            margin-top: 8px;
        }

        .pm-spec-value {
            font-weight: 700;
            font-size: 14px;
            color: #1F2937;
        }

        .pm-section-title {
            font-weight: 800;
            font-size: 18px;
            margin-bottom: 14px;
            color: #1F2937;
        }

        .pm-section {
            margin-top: 24px;
        }

        .pm-section p {
            color: #6B7280;
            margin-bottom: 0;
        }

        .pm-feature {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: #374151;
        }

        .pm-feature i {
            color: #198754;
        }

        .pm-book {
            position: sticky;
            top: 88px;
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }

        .pm-book-label {
            color: #6B7280;
            font-size: 13px;
        }

        .pm-book-price {
            color: #198754;
            font-size: 28px;
            font-weight: 800;
            line-height: 1.2;
        }

        .pm-book-price span {
            color: #6B7280;
            font-size: 14px;
            font-weight: 500;
        }

        .pm-book-deposit {
            color: #6B7280;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn-rental {
            background: #198754;
            color: #fff;
            border: none;
            border-radius: 13px;
            padding: 14px 25px;
            font-weight: 700;
            width: 100%;
        }

        .btn-rental:hover {
            background: #146c43;
            color: #fff;
        }

        .pm-trust {
            color: #6B7280;
            font-size: 13px;
        }

        .nav-btn-back {
            border: none;
            color: #374151;
            background: transparent;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            font-weight: 600;
            text-decoration: none;
            position: relative;
        }

        .nav-btn-back::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 4px;
            width: 0;
            height: 2px;
            border-radius: 1px;
            background: #198754;
            transform: translateX(-50%);
            transition: width .25s ease-out;
        }

        .nav-btn-back:hover {
            color: #198754;
        }

        .nav-btn-back:hover::after,
        .nav-btn-back:focus-visible::after {
            width: calc(100% - 24px);
        }

        .nav-btn-ghost {
            border: none;
            color: #374151;
            background: transparent;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
        }

        .nav-btn-ghost:hover {
            color: #198754;
        }

        .swal2-popup {
            border-radius: 18px !important;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif !important;
        }

        .swal2-html-container {
            margin: 1em !important;
        }

        @media (max-width: 991.98px) {
            .pm-grid {
                grid-template-columns: 1fr;
            }

            .pm-book {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .pm-hero {
                aspect-ratio: 4 / 3;
            }

            .pm-body {
                padding: 20px;
            }

            .pm-title {
                font-size: 24px;
            }

            .pm-specs {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>

@if(auth()->check() && (auth()->user()->role->name ?? '') === 'Customer')
    @include('layouts.partials.customer-nav')
@else
    @include('layouts.partials.navbar')
@endif

<div class="container py-4" style="padding-top: 84px !important;">
    <div class="page-wrap">

        <div class="mb-3">
            @php
                $kembaliKeKatalog = request('from') === 'katalog'
                    || str_contains(url()->previous(), '/katalog');
            @endphp

            @if($kembaliKeKatalog)
                <a href="{{ route('katalog.index') }}" class="nav-btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Katalog
                </a>
            @elseif(auth()->check())
                <a href="{{ route('customer.dashboard') }}" class="nav-btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Dashboard
                </a>
            @else
                <a href="{{ url('/') }}" class="nav-btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Beranda
                </a>
            @endif
        </div>

        <div class="pm-card">

            <div class="pm-hero">
                @if($mobil->image)
                    <img src="{{ asset($mobil->image) }}" alt="{{ $mobil->name }}">
                @else
                    <img src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg" alt="Mobil Rental">
                @endif

                <div class="pm-hero-badges">
                    @if($mobil->status === 'Tersedia')
                        <span class="badge-available">
                            <i class="bi bi-check-circle-fill"></i>
                            Tersedia untuk disewa
                        </span>
                    @else
                        <span class="badge-unavailable">
                            <i class="bi bi-x-circle-fill"></i>
                            Tidak Tersedia untuk disewa
                        </span>
                    @endif

                    <span class="pm-cabang-chip">
                        <i class="bi bi-geo-alt"></i>
                        {{ $mobil->cabang->name ?? '-' }}
                    </span>
                </div>
            </div>

            <div class="pm-body">

                <h1 class="pm-title">{{ $mobil->name }}</h1>

                <p class="pm-subtitle">
                    <i class="bi bi-car-front me-1"></i>
                    {{ $mobil->tipeMobil->name ?? '-' }}
                </p>

                <div class="pm-grid">

                    <div>
                        <div class="pm-specs">

                            <div class="pm-spec">
                                <i class="bi bi-award"></i>
                                <div class="pm-spec-label">Brand</div>
                                <div class="pm-spec-value">{{ $mobil->brand->name ?? '-' }}</div>
                            </div>

                            <div class="pm-spec">
                                <i class="bi bi-car-front"></i>
                                <div class="pm-spec-label">Tipe Mobil</div>
                                <div class="pm-spec-value">{{ $mobil->tipeMobil->name ?? '-' }}</div>
                            </div>

                            <div class="pm-spec">
                                <i class="bi bi-people"></i>
                                <div class="pm-spec-label">Kapasitas</div>
                                <div class="pm-spec-value">{{ $mobil->kapasitas }} Orang</div>
                            </div>

                            <div class="pm-spec">
                                <i class="bi bi-gear"></i>
                                <div class="pm-spec-label">Transmisi</div>
                                <div class="pm-spec-value">{{ $mobil->transmisi }}</div>
                            </div>

                            <div class="pm-spec">
                                <i class="bi bi-palette"></i>
                                <div class="pm-spec-label">Warna</div>
                                <div class="pm-spec-value">{{ $mobil->warna }}</div>
                            </div>

                            <div class="pm-spec">
                                <i class="bi bi-calendar3"></i>
                                <div class="pm-spec-label">Tahun</div>
                                <div class="pm-spec-value">{{ $mobil->tahun }}</div>
                            </div>

                            <div class="pm-spec">
                                <i class="bi bi-wallet2"></i>
                                <div class="pm-spec-label">Deposit</div>
                                <div class="pm-spec-value">Rp {{ number_format($mobil->deposit, 0, ',', '.') }}</div>
                            </div>

                            <div class="pm-spec">
                                <i class="bi bi-geo-alt"></i>
                                <div class="pm-spec-label">Cabang</div>
                                <div class="pm-spec-value">{{ $mobil->cabang->name ?? '-' }}</div>
                            </div>

                        </div>

                        <div class="pm-section">
                            <h4 class="pm-section-title">Tentang Mobil</h4>
                            <p>{{ $mobil->description ?? 'Belum ada deskripsi mobil.' }}</p>
                        </div>

                        <div class="pm-section">
                            <h4 class="pm-section-title">Fasilitas</h4>

                            @forelse($mobil->fasilitas as $fasilitas)
                                <div class="pm-feature">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $fasilitas->name }}
                                </div>
                            @empty
                                <p>Belum ada fasilitas.</p>
                            @endforelse
                        </div>
                    </div>

                    <aside class="pm-book">

                        <div class="pm-book-label">Harga sewa mulai dari</div>

                        <div class="pm-book-price">
                            Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}
                            <span>/ hari</span>
                        </div>

                        <div class="pm-book-deposit">
                            Deposit Rp {{ number_format($mobil->deposit, 0, ',', '.') }} ditambahkan ke total.
                        </div>

                        <div class="mt-3">
                            @if($mobil->status === 'Tersedia')
                                @auth
                                    <button
                                        type="button"
                                        class="btn btn-rental d-flex align-items-center justify-content-center"
                                        onclick="openSewaPopup()">
                                        <i class="bi bi-calendar-check me-2"></i>
                                        Sewa Sekarang
                                    </button>
                                @else
                                    <a
                                        href="{{ route('login', [
                                            'redirect' => request()->getPathInfo() . '?' . http_build_query(array_merge(
                                                request()->query(),
                                                ['open_sewa' => 1]
                                            ))
                                        ]) }}"
                                        class="btn btn-rental d-flex align-items-center justify-content-center text-decoration-none">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        Masuk untuk Sewa
                                    </a>
                                @endauth
                            @else
                                <button
                                    type="button"
                                    class="btn btn-secondary w-100"
                                    style="border-radius: 13px; padding: 14px 25px;"
                                    disabled>
                                    <i class="bi bi-x-circle me-2"></i>
                                    Mobil Tidak Tersedia
                                </button>
                            @endif
                        </div>

                        <div class="text-center mt-3">
                            <small class="pm-trust">
                                <i class="bi bi-shield-check me-1"></i>
                                Rental aman dan terpercaya bersama RentalKu
                            </small>
                        </div>

                    </aside>

                </div>

            </div>
        </div>
    </div>
</div>

<div id="sewaFormTemplate" class="d-none">

    <form
        action="{{ route('rentals.checkout', $mobil->slug) }}"
        method="POST"
        id="sewaForm">

        @csrf

        <div class="row g-3 text-start">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Cabang Ambil</label>

                <select name="cabang_ambil_id" class="form-select" required>
                    <option value="" disabled selected>Pilih cabang ambil</option>

                    @foreach($cabangs as $cabang)
                        <option
                            value="{{ $cabang->id }}"
                            @selected(old('cabang_ambil_id', $mobil->cabang_id) == $cabang->id)>
                            {{ $cabang->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Cabang Kembali</label>

                <select name="cabang_kembali_id" class="form-select" required>
                    <option value="" disabled selected>Pilih cabang kembali</option>

                    @foreach($cabangs as $cabang)
                        <option
                            value="{{ $cabang->id }}"
                            @selected(old('cabang_kembali_id', $mobil->cabang_id) == $cabang->id)>
                            {{ $cabang->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal Mulai</label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    class="form-control"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                    required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal Selesai</label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    class="form-control"
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    value="{{ old('tanggal_selesai', date('Y-m-d', strtotime('+1 day'))) }}"
                    required>
            </div>

            <div class="col-12">

                <label class="form-label fw-semibold">Pilih Supir (Opsional)</label>

                <select name="supir_id" class="form-select" id="supirSelect">
                    <option value="">Tanpa Supir (Lepas Kunci)</option>

                    @foreach($supirs as $supir)
                        <option
                            value="{{ $supir->id }}"
                            data-cabang-id="{{ $supir->cabang_id }}"
                            data-name="{{ $supir->name }}"
                            data-phone="{{ $supir->phone }}"
                            data-tarif="{{ number_format($supir->tarif_perhari, 0, ',', '.') }}"
                            data-image="{{ $supir->image ? asset($supir->image) : 'https://ui-avatars.com/api/?name='.urlencode($supir->name) }}">
                            {{ $supir->name }}
                        </option>
                    @endforeach
                </select>

                <div id="supirProfileCard" class="card mt-3 mb-3 shadow-sm border-primary" style="display:none;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <img
                                id="supirImg"
                                src=""
                                class="rounded-circle me-3"
                                style="width:70px;height:70px;object-fit:cover;border:2px solid var(--bs-primary);">

                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold text-primary" id="supirName"></h6>

                                <div class="small text-muted mb-2">
                                    <i class="bi bi-telephone me-1"></i>
                                    <span id="supirPhone"></span>
                                </div>

                                <div class="badge bg-light text-primary border border-primary">
                                    Tarif: Rp <span id="supirTarif"></span> /hari
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-text mt-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Pilih supir jika Anda membutuhkan bantuan pengemudi.
                </div>

            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Kode Promo</label>

                <input
                    type="text"
                    name="kode_promo"
                    class="form-control"
                    placeholder="Masukkan kode promo"
                    maxlength="50"
                    value="{{ old('kode_promo', $kodePromo ?? request()->query('kode_promo', '')) }}">

                <div class="invalid-feedback kode-promo-error"></div>
                <div class="valid-feedback kode-promo-success"></div>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Catatan</label>

                <textarea
                    name="catatan"
                    class="form-control"
                    rows="3"
                    placeholder="Catatan tambahan jika diperlukan...">{{ old('catatan') }}</textarea>
            </div>

            <div class="col-12">
                <div class="alert alert-success py-2 mb-0">
                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Harga: Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}/hari.
                        Deposit Rp {{ number_format($mobil->deposit, 0, ',', '.') }} ditambahkan ke total.
                    </small>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success w-100 py-2">
                    <i class="bi bi-credit-card me-1"></i>
                    Lanjut ke Checkout
                </button>
            </div>

        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function openSewaPopup() {
    var $template = $('#sewaFormTemplate');

    if (!$template.length) return;

    if ($('.badge-available').length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Mobil sedang tidak tersedia.'
        });
        return;
    }

    Swal.fire({
        title: 'Sewa {{ $mobil->name }}',
        html: $template.html(),
        width: 600,
        showConfirmButton: false,
        showCloseButton: true,
        didOpen: function() {
            var $form = $('#swal2-html-container form');
            var promoCheckTimer = null;
            var promoCheckXhr = null;

            function updateSupirProfile(select) {
                var option = select.options[select.selectedIndex];
                var card = document.getElementById('supirProfileCard');

                if (!select.value) {
                    card.style.display = 'none';
                    return;
                }

                document.getElementById('supirName').textContent = option.dataset.name || '';
                document.getElementById('supirPhone').textContent = option.dataset.phone || '-';
                document.getElementById('supirTarif').textContent = option.dataset.tarif || '0';
                document.getElementById('supirImg').src = option.dataset.image || '';
                card.style.display = 'block';
            }

            $form.on('change', '#supirSelect', function() {
                updateSupirProfile(this);
            });

            $form.on('change', 'select[name="cabang_ambil_id"]', function() {
                var cabangId = this.value;
                var kembali = $form.find('select[name="cabang_kembali_id"]');
                var supirSelect = $form.find('select[name="supir_id"]')[0];

                if (kembali.length && !kembali.val()) {
                    kembali.val(cabangId);
                }

                if (supirSelect) {
                    Array.from(supirSelect.options).forEach(function(option) {
                        if (option.value === '') return;
                        option.hidden = option.dataset.cabangId !== cabangId;
                    });

                    if (
                        supirSelect.value &&
                        supirSelect.options[supirSelect.selectedIndex].dataset.cabangId !== cabangId
                    ) {
                        supirSelect.value = '';
                        updateSupirProfile(supirSelect);
                    }
                }
            });

            function checkPromoCode($input) {
                var value = $.trim($input.val());

                if (!value) {
                    $input.removeClass('is-invalid is-valid');
                    $form.find('.kode-promo-error, .kode-promo-success').text('');
                    return;
                }

                if (promoCheckXhr) {
                    promoCheckXhr.abort();
                }

                promoCheckXhr = $.ajax({
                    url: '{{ route('rentals.promo.check') }}',
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        _token: $form.find('input[name="_token"]').val(),
                        kode_promo: value
                    }
                })
                .done(function(response) {
                    $input.removeClass('is-invalid').addClass('is-valid');
                    $form.find('.kode-promo-error').text('');
                    $form.find('.kode-promo-success').text(response.message || 'Kode promo valid.');
                })
                .fail(function(xhr) {
                    if (!xhr || xhr.status === 0 || xhr.statusText === 'abort') return;

                    var message = xhr.responseJSON?.message || 'Kode promo tidak valid.';

                    $input.removeClass('is-valid').addClass('is-invalid');
                    $form.find('.kode-promo-success').text('');
                    $form.find('.kode-promo-error').text(message);
                });
            }

            $form.on('input', 'input[name="kode_promo"]', function() {
                var $input = $(this);

                clearTimeout(promoCheckTimer);

                $input.removeClass('is-invalid is-valid');
                $form.find('.kode-promo-error, .kode-promo-success').text('');

                if (!$.trim($input.val())) return;

                promoCheckTimer = setTimeout(function() {
                    checkPromoCode($input);
                }, 500);
            });

            $form.on('blur', 'input[name="kode_promo"]', function() {
                var $input = $(this);

                clearTimeout(promoCheckTimer);

                if ($.trim($input.val())) {
                    checkPromoCode($input);
                }
            });

            $form.on('change', 'input[name="tanggal_mulai"]', function() {
                var mulai = this.value;
                var selesai = $form.find('input[name="tanggal_selesai"]')[0];

                if (mulai) {
                    selesai.min = mulai;
                    if (selesai.value && selesai.value <= mulai) {
                        var nextDate = new Date(mulai + 'T00:00:00');
                        nextDate.setDate(nextDate.getDate() + 1);
                        selesai.value = nextDate.toISOString().slice(0, 10);
                        selesai.min = selesai.value;
                    }
                }
            });

            $form.on('submit', function(event) {
                event.preventDefault();

                var mulai = $form.find('input[name="tanggal_mulai"]').val();
                var selesai = $form.find('input[name="tanggal_selesai"]').val();

                $form.find('.sewa-date-error').remove();

                if (!mulai || !selesai || selesai <= mulai) {
                    var note = $('<div class="sewa-date-error text-danger small mt-1">Tanggal selesai harus setelah tanggal mulai.</div>');
                    $form.find('input[name="tanggal_selesai"]').after(note);
                    return;
                }

                var formData = new FormData($form[0]);
                var $submit = $form.find('button[type="submit"]');
                var submitHtml = $submit.html();

                $form.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
                $form.find('.invalid-feedback.d-block').remove();
                $form.find('.kode-promo-error, .kode-promo-success').text('');

                $submit.prop('disabled', true);
                $submit.html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses Checkout...');

                Swal.showLoading();

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: formData,
                    processData: false,
                    contentType: false
                })
                .done(function(data, textStatus, xhr) {
                    if (xhr.status >= 200 && xhr.status < 300) {
                        window.location.href = '{{ route('rentals.checkout.show', $mobil->slug) }}';
                        return;
                    }

                    Swal.hideLoading();
                    $submit.prop('disabled', false);
                    $submit.html(submitHtml);

                    var errors = data.errors || {};

                    Object.keys(errors).forEach(function(key) {
                        var $input = $form.find('[name="' + key + '"]');

                        if ($input.length) {
                            $input.addClass('is-invalid');
                            $input.after('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Terjadi kesalahan saat memproses checkout.'
                    });
                })
                .fail(function(xhr) {
                    Swal.hideLoading();
                    $submit.prop('disabled', false);
                    $submit.html(submitHtml);

                    var response = xhr.responseJSON || {};
                    var errors = response.errors || {};
                    var promoMessage = errors.kode_promo ? errors.kode_promo[0] : null;

                    $form.find('.invalid-feedback.d-block').remove();

                    Object.keys(errors).forEach(function(key) {
                        if (key === 'kode_promo') return;

                        var $input = $form.find('[name="' + key + '"]');

                        if ($input.length) {
                            $input.addClass('is-invalid');
                            $input.after('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    });

                    if (promoMessage) {
                        var $promoInput = $form.find('input[name="kode_promo"]');

                        $promoInput.removeClass('is-valid').addClass('is-invalid');
                        $form.find('.kode-promo-success').text('');
                        $form.find('.kode-promo-error').text(promoMessage);
                        return;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: Object.keys(errors).length
                            ? Object.values(errors).flat()[0]
                            : response.message || 'Koneksi bermasalah. Silakan coba lagi.'
                    });
                });
            });
        }
    });
}

(function() {
    const params = new URLSearchParams(window.location.search);

    if (params.get('open_sewa') !== '1') return;

    params.delete('open_sewa');

    const query = params.toString();
    const cleanUrl = window.location.pathname + (query ? '?' + query : '');

    window.history.replaceState({}, '', cleanUrl);

    openSewaPopup();
})();

(function() {
    if (window.__sewaGoodUIInit) return;
    window.__sewaGoodUIInit = true;

    function sewaFormOf(element) {
        return element && element.closest ? element.closest('form') : null;
    }

    function clearDateError(form) {
        form.querySelectorAll('.sewa-date-error').forEach(function(element) {
            element.remove();
        });
    }

    document.addEventListener('change', function(event) {
        var element = event.target;

        if (!element.matches('select[name="cabang_ambil_id"]')) return;

        var form = sewaFormOf(element);
        if (!form) return;

        var kembali = form.querySelector('select[name="cabang_kembali_id"]');

        if (kembali && !kembali.value) {
            kembali.value = element.value;
        }
    });

    document.addEventListener('change', function(event) {
        var element = event.target;

        if (!element.matches('input[name="tanggal_mulai"], input[name="tanggal_selesai"]')) return;

        var form = sewaFormOf(element);

        if (form) clearDateError(form);
    });

    document.addEventListener('submit', function(event) {
        var form = event.target;

        if (!form || !form.querySelector) return;

        var mulai = form.querySelector('input[name="tanggal_mulai"]');
        var selesai = form.querySelector('input[name="tanggal_selesai"]');

        if (!mulai || !selesai) return;

        clearDateError(form);

        if (mulai.value && selesai.value && selesai.value <= mulai.value) {
            event.preventDefault();
            event.stopPropagation();

            var note = document.createElement('div');
            note.className = 'sewa-date-error text-danger small mt-1';
            note.textContent = 'Tanggal selesai harus setelah tanggal mulai.';

            selesai.after(note);
        }
    }, true);
})();
</script>

@auth
    @include('layouts.partials.profile-modal')
@endauth

</body>
</html>