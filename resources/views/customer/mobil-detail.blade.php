<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
       {{ $mobil->name ?? 'Detail Mobil' }} - RentalKu
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

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
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
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
            transition: color 0.2s ease, background 0.2s ease !important;
            position: relative;
            border-radius: 10px !important;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary) !important;
            background: rgba(44, 102, 110, 0.1) !important;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 2px;
            left: 50%;
            background-color: var(--primary);
            transition: width 0.2s ease, left 0.2s ease;
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
            transition: all 0.2s ease !important;
            position: relative;
        }

        .nav-btn-ghost:hover,
        .nav-btn-ghost:focus {
            background: rgba(44, 102, 110, 0.1) !important;
            color: var(--primary) !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .nav-btn-ghost::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 2px;
            left: 50%;
            background-color: var(--primary);
            transition: width 0.2s ease, left 0.2s ease;
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
            box-shadow: 0 10px 30px rgba(0,0,0,.06);
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

        .badge-available {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            color: #198754;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
        }

        .badge-unavailable {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            color: #dc3545;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,.04);
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
            box-shadow: 0 10px 30px rgba(0,0,0,.06);
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
            transition: width 0.25s ease-out;
        }

        .nav-btn-back:hover {
            color: #198754;
        }

        .nav-btn-back:hover::after,
        .nav-btn-back:focus-visible::after {
            width: calc(100% - 24px);
        }

        @media (prefers-reduced-motion: reduce) {
            .nav-btn-back::after {
                transition: none;
            }
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

@if(auth()->check() && (auth()->user()->role->name ?? '') === 'Customer')
@include('layouts.partials.customer-nav')
@else
@include('layouts.partials.navbar')
@endif

<div class="container py-4" style="padding-top: 84px !important;">

    <div class="page-wrap">

        {{-- KEMBALI: dari katalog → katalog, customer → dashboard, guest → beranda --}}
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
                    <img
                        src="{{ asset($mobil->image) }}"
                        alt="{{ $mobil->name }}"
                    >
                @else
                    <img
                        src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg"
                        alt="Mobil Rental"
                    >
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
                                        href="{{ route('login') }}"
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

{{-- FORM SEWA (server-rendered, di-inject ke SweetAlert) --}}
<div id="sewaFormTemplate" class="d-none">

    <form
        action="{{ route('rentals.store', $mobil->slug) }}"
        method="POST"
        id="sewaForm">

        @csrf

        <div class="row g-3 text-start">

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Cabang Ambil
                </label>

                <select
                    name="cabang_ambil_id"
                    class="form-select"
                    required>

                    <option value="" disabled selected>
                        Pilih cabang ambil
                    </option>

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

                <label class="form-label fw-semibold">
                    Cabang Kembali
                </label>

                <select
                    name="cabang_kembali_id"
                    class="form-select"
                    required>

                    <option value="" disabled selected>
                        Pilih cabang kembali
                    </option>

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

                <label class="form-label fw-semibold">
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    class="form-control"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                    required>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Tanggal Selesai
                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    class="form-control"
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    value="{{ old('tanggal_selesai', date('Y-m-d', strtotime('+1 day'))) }}"
                    required>

            </div>

            <div class="col-12">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Supir (Opsional)</label>
                    <select name="supir_id" class="form-select" id="supirSelect" onchange="updateSupirProfile(this)">
                        <option value="">Tanpa Supir (Lepas Kunci)</option>
                        @foreach($supirs as $supir)
                            <option value="{{ $supir->id }}"
                                    data-cabang-id="{{ $supir->cabang_id }}"
                                    data-name="{{ $supir->name }}"
                                    data-phone="{{ $supir->phone }}"
                                    data-tarif="{{ number_format($supir->tarif_perhari, 0, ',', '.') }}"
                                    data-image="{{ $supir->image ?? 'https://ui-avatars.com/api/?name='.urlencode($supir->name) }}">
                                {{ $supir->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Profile Supir Card (Hidden by default) -->
                <div id="supirProfileCard" class="card mb-3 shadow-sm border-primary" style="display: none;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <img id="supirImg" src="" class="rounded-circle me-3" style="width: 70px; height: 70px; object-fit: cover; border: 2px solid var(--bs-primary);">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold text-primary" id="supirName"></h6>
                                <div class="small text-muted mb-2">
                                    <i class="bi bi-telephone me-1"></i> <span id="supirPhone"></span>
                                </div>
                                <div class="badge bg-light text-primary border border-primary">
                                    Tarif: Rp <span id="supirTarif"></span> /hari
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <script>
                    function updateSupirProfile(select) {
                        const card = document.getElementById('supirProfileCard');
                        const opt = select.options[select.selectedIndex];

                        if (select.value === "") {
                            card.style.display = 'none';
                        } else {
                            document.getElementById('supirName').innerText = opt.dataset.name;
                            document.getElementById('supirPhone').innerText = opt.dataset.phone;
                            document.getElementById('supirTarif').innerText = opt.dataset.tarif;
                            document.getElementById('supirImg').src = opt.dataset.image;
                            card.style.display = 'block';
                        }
                        updateSewaButton();
                    }

                    function updateSewaButton() {
                        const tglMulai = document.querySelector('input[name="tanggal_mulai"]').value;
                        const tglSelesai = document.querySelector('input[name="tanggal_selesai"]').value;
                        const btn = document.querySelector('button[type="submit"]');

                        // Disable if dates empty
                        btn.disabled = !(tglMulai && tglSelesai);
                    }

                    document.addEventListener('DOMContentLoaded', () => {
                        const dateInputs = document.querySelectorAll('input[name="tanggal_mulai"], input[name="tanggal_selesai"]');
                        dateInputs.forEach(i => i.addEventListener('change', updateSewaButton));
                        updateSewaButton();
                    });
                </script> --}}

                <div class="form-text mt-2">
                   <i class="bi bi-info-circle me-1"></i>
                   Pilih supir jika Anda membutuhkan bantuan pengemudi.
                </div>

            </div>

            <div class="col-12">

                <label class="form-label fw-semibold">
                    Catatan
                </label>

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
                        Deposit Rp {{ number_format($mobil->deposit, 0, ',', '.') }}
                        ditambahkan ke total.
                    </small>

                </div>

            </div>

            <div class="col-12">

                <button type="submit" class="btn btn-success w-100 py-2">
                    <i class="bi bi-calendar-check me-1"></i>
                    Ajukan Sewa
                </button>

            </div>

        </div>

    </form>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function openSewaPopup() {
        var $template = $('#sewaFormTemplate');
        if (!$template.length) return;

        if ($('.badge-available').length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Mobil sedang tidak tersedia.',
            });
            return;
        }

        Swal.fire({
            title: 'Sewa {{ $mobil->name }}',
            html: $template.html(),
            width: 600,
            showConfirmButton: false,
            didOpen: function() {
                var $form = $('#swal2-html-container form');

                $form.on('submit', function(event) {
                    event.preventDefault();

                    var formData = new FormData($form[0]);
                    var $submit = $form.find('button[type="submit"]');
                    var submitHtml = $submit.html();
                    $form.find('.is-invalid').removeClass('is-invalid');
                    $form.find('.invalid-feedback').remove();
                    $submit.prop('disabled', true);
                    $submit.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengirim...');
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
                        Swal.hideLoading();

                        if (xhr.status !== 200) {
                            $submit.prop('disabled', false);
                            $submit.html(submitHtml);
                            var errs = data.errors || {};
                            Object.keys(errs).forEach(function(key) {
                                var $input = $form.find('[name="' + key + '"]');
                                if ($input.length) {
                                    $input.addClass('is-invalid');
                                    $input.after('<div class="invalid-feedback d-block">' + errs[key][0] + '</div>');
                                }
                            });
                            var firstError = data.errors
                                ? Object.values(data.errors).flat()[0]
                                : (data.message || 'Terjadi kesalahan.');

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: firstError,
                            });
                            return;
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Pengajuan sewa mobil berhasil dibuat.',
                            confirmButtonText: 'OK',
                        }).then(function() {
                            window.location.href = '{{ route('customer.dashboard') }}';
                        });
                    })
                    .fail(function(xhr) {
                        Swal.hideLoading();
                        $submit.prop('disabled', false);
                        $submit.html(submitHtml);
                        var r = (xhr && xhr.responseJSON) || {};
                        var errs = r.errors || {};
                        Object.keys(errs).forEach(function(key) {
                            var $input = $form.find('[name="' + key + '"]');
                            if ($input.length) {
                                $input.addClass('is-invalid');
                                $input.after('<div class="invalid-feedback d-block">' + errs[key][0] + '</div>');
                            }
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: errs && Object.keys(errs).length ? Object.values(errs).flat()[0] : (r.message || 'Koneksi bermasalah. Silakan coba lagi.'),
                        });
                    });
                });
            }
        });
    }

</script>

{{-- GoodUI #13/#28/#33: client-side convenience untuk form sewa (validasi server tetap sumber kebenaran).
     Delegated agar jalan di konten dinamis (inject SweetAlert via $template.html());
     tidak bind saat load ke elemen di dalam #sewaFormTemplate. --}}
<script>
(function () {
    if (window.__sewaGoodUIInit) return;
    window.__sewaGoodUIInit = true;

    function sewaFormOf(el) {
        return el && el.closest ? el.closest('form') : null;
    }

    // Delegated change: pakai $(document).on bila jQuery ada, fallback native.
    function onDocChange(selector, fn) {
        if (window.jQuery) {
            window.jQuery(document).on('change', selector, function (e) { fn(e, this); });
        } else {
            document.addEventListener('change', function (e) {
                if (e.target && e.target.matches && e.target.matches(selector)) fn(e, e.target);
            });
        }
    }

    function clearDateError(form) {
        form.querySelectorAll('.sewa-date-error').forEach(function (n) { n.remove(); });
    }

    // #13: cabang-kembali mengikuti cabang-ambil selama masih placeholder/kosong.
    onDocChange('select[name="cabang_ambil_id"]', function (e, el) {
        var form = sewaFormOf(el);
        if (!form) return;
        var kembali = form.querySelector('select[name="cabang_kembali_id"]');
        if (kembali && !kembali.value) kembali.value = el.value;

        // Filter supir berdasarkan cabang ambil yang dipilih
        var cabangId = el.value;
        var supirSelect = form.querySelector('select[name="supir_id"]');
        if (supirSelect) {
            Array.from(supirSelect.options).forEach(function(opt) {
                if (opt.value === "") return;
                opt.hidden = (opt.dataset.cabangId !== cabangId);
            });

            // Reset pilihan supir jika tidak sesuai cabang
            if (supirSelect.value !== "" && supirSelect.options[supirSelect.selectedIndex].dataset.cabangId !== cabangId) {
                supirSelect.value = "";
                var card = document.getElementById('supirProfileCard');
                if (card) card.style.display = 'none';
                updateSewaButton();
            }
        }
    });

    // #33: hapus catatan inline saat tanggal diubah / submit diulang.
    onDocChange('input[name="tanggal_mulai"], input[name="tanggal_selesai"]', function (e, el) {
        var form = sewaFormOf(el);
        if (form) clearDateError(form);
    });

    // #33: cegah submit bila rentang salah — capture agar jalan SEBELUM handler AJAX existing.
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!form || !form.querySelector) return;
        var mulai = form.querySelector('input[name="tanggal_mulai"]');
        var selesai = form.querySelector('input[name="tanggal_selesai"]');
        if (!mulai || !selesai) return;
        clearDateError(form);
        if (mulai.value && selesai.value && selesai.value <= mulai.value) {
            e.preventDefault();
            e.stopPropagation();
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