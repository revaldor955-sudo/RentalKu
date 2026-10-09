<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Customer - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>

        body {
            margin: 0;
            background: #f5f7f6;
            color: #1f2937;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
        }

        .navbar {
            background: rgba(255,255,255,.95);
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .user-box {
            background: #f5f8f6;
            border-radius: 50px;
            padding: 6px 12px 6px 7px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .user-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #198754;
            color: white;
            font-size: 16px;
        }

        .user-box.dropdown-toggle {
            transition: none;
        }

        .user-box.dropdown-toggle:hover {
            transform: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        .dropdown-menu {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.2s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            font-size: 14px;
            padding: 10px 16px;
            color: #1f2937;
            transition: all 0.15s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: #f5f7f6;
            color: #198754;
        }

        .dropdown-item.text-danger:hover,
        .dropdown-item.text-danger:focus {
            background: #fee;
            color: #dc3545;
        }

        .dropdown-divider {
            margin: 6px 0;
            opacity: 0.5;
        }

        .hero {
            position: relative;
            overflow: hidden;
            margin-top: 30px;
            border-radius: 28px;
            padding: 55px;
            min-height: 400px;
            background:
                linear-gradient(
                    110deg,
                    rgba(8,70,42,.98),
                    rgba(25,135,84,.88)
                );
            color: white;
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,.06);
            top: -120px;
            right: 35%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.2);
            color: white;
            border-radius: 50px;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: 44px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 18px;
        }

        .hero h1 span {
            color: #b8f2d1;
        }

        .hero p {
            color: #e1f4e9;
            font-size: 16px;
            line-height: 1.7;
            max-width: 540px;
            margin-bottom: 28px;
        }

        .hero-btn {
            background: white;
            color: #157347;
            border: none;
            border-radius: 12px;
            padding: 12px 21px;
            font-weight: 700;
            transition: .2s;
        }

        .hero-btn:hover {
            background: #f1fdf5;
            color: #11653e;
            transform: translateY(-2px);
        }

        .hero-secondary {
            color: white;
            border: 1px solid rgba(255,255,255,.4);
            border-radius: 12px;
            padding: 11px 20px;
            font-weight: 600;
        }

        .hero-secondary:hover {
            background: rgba(255,255,255,.1);
            color: white;
        }

        .hero-photo-wrapper {
            position: relative;
            z-index: 2;
        }

        .hero-img {
            width: 100%;
            height: 290px;
            object-fit: cover;
            border-radius: 22px;
            box-shadow: 0 20px 45px rgba(0,0,0,.25);
        }

        .floating-card {
            position: absolute;
            bottom: -15px;
            left: -20px;
            background: white;
            color: #1f2937;
            border-radius: 16px;
            padding: 12px 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,.18);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .floating-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .floating-card small {
            display: block;
            color: #6b7280;
        }

        .floating-card strong {
            font-size: 14px;
        }

        .stats {
            margin-top: -30px;
            position: relative;
            z-index: 5;
        }

        .stat-card {
            background: white;
            border-radius: 18px;
            padding: 20px;
            border: 1px solid #edf0ee;
            box-shadow: 0 8px 25px rgba(0,0,0,.05);
            height: 100%;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 15px;
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .stat-title {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 3px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 800;
            margin: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        .section {
            padding-top: 70px;
            padding-bottom: 30px;
            /* Judul tidak ketutup navbar sticky saat lompat anchor. */
            scroll-margin-top: 80px;
        }

        .section-label {
            color: #198754;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 7px;
        }

        .section-title {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -.5px;
            margin-bottom: 5px;
        }

        .section-desc {
            color: #6b7280;
            margin-bottom: 0;
        }

        .car-card {
            background: white;
            border: 1px solid #edf0ee;
            border-radius: 22px;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 7px 25px rgba(0,0,0,.045);
            transition: all .25s ease;
        }

        .car-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,.05);
        }

        .car-photo-wrapper {
            position: relative;
            overflow: hidden;
        }

        .car-img {
            width: 100%;
            height: 210px;
            object-fit: contain;
            background: #f1f5f9;
            display: block;
            transition: transform .4s ease;
        }

        .car-card:hover .car-img {
            transform: scale(1.04);
        }

        .car-status {
            position: absolute;
            top: 14px;
            left: 14px;
            background: #198754;
            color: white;
            padding: 6px 11px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }

        .car-populer {
            position: absolute;
            top: 14px;
            right: 14px;
            background: #ffc107;
            color: #1f2937;
            padding: 6px 11px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }

        .car-body {
            padding: 21px;
        }

        .car-title {
            font-size: 19px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .car-info {
            display: flex;
            gap: 13px;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .car-info span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .car-info i {
            color: #198754;
        }

        .price-label {
            font-size: 12px;
            color: #6b7280;
        }

        .price {
            color: #198754;
            font-weight: 800;
            font-size: 20px;
        }

        .price span {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        .btn-rental {
            background: #198754;
            color: white;
            border: none;
            border-radius: 11px;
            padding: 10px 15px;
            font-size: 13px;
            font-weight: 700;
        }

        .btn-rental:hover {
            background: #146c43;
            color: white;
        }

        .empty-card {
            background: white;
            border: 1px solid #edf0ee;
            border-radius: 22px;
            padding: 60px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: auto;
        }

        footer {
            background: #17211d;
            color: white;
            margin-top: 70px;
        }

        .footer-brand {
            font-size: 22px;
            font-weight: 800;
        }

        .footer-brand span {
            color: #42c77d;
        }

        .footer-text {
            color: #aeb8b2;
            font-size: 14px;
        }

        .footer-line {
            border-color: rgba(255,255,255,.1);
        }

        @media (max-width: 991px) {

            body {
                padding-bottom: 70px;
            }

            .hero {
                padding: 35px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .stats {
                margin-top: 20px;
            }

        }

        @media (max-width: 576px) {

            .hero {
                padding: 27px;
                border-radius: 22px;
            }

            .hero h1 {
                font-size: 30px;
            }

            .hero-img {
                height: 220px;
            }

            .floating-card {
                left: 10px;
                bottom: -12px;
            }

            .section-title {
                font-size: 25px;
            }

        }

        .car-card[data-mobil-id] {
            cursor: pointer;
        }

        /* Motion 60fps: entrance, skeleton, success check. */
        @keyframes rise-in {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: none; }
        }

        .anim-rise {
            animation: rise-in .5s cubic-bezier(.22,1,.36,1) backwards;
        }

        @keyframes skel-shimmer {
            0% { background-position: -400px 0; }
            100% { background-position: 400px 0; }
        }

        .skel-card {
            background: #fff;
            border: 1px solid #edf0ee;
            border-radius: 22px;
            overflow: hidden;
            height: 100%;
        }

        .skel-line {
            border-radius: 8px;
            background: linear-gradient(90deg, #eef1f0 25%, #f8faf9 50%, #eef1f0 75%);
            background-size: 800px 100%;
            animation: skel-shimmer 1.2s ease-in-out infinite;
        }

        .swal-check svg circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            animation: check-stroke .6s cubic-bezier(.65,0,.45,1) forwards;
        }

        .swal-check svg path {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: check-stroke .3s .5s cubic-bezier(.65,0,.45,1) forwards;
        }

        @keyframes check-stroke {
            to { stroke-dashoffset: 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            .anim-rise,
            .skel-line,
            .swal-check svg circle,
            .swal-check svg path {
                animation: none;
            }
        }

        .rental-card {
            margin-bottom: 1.5rem;
        }

        @media (min-width: 992px) {

            .rental-masonry {
                columns: 2;
                column-gap: 1.5rem;
            }

            .rental-card {
                break-inside: avoid;
            }

        }

    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @include('layouts.partials.modal-head-style')
</head>

<body>

<div style="height: 76px;"></div>
@include('layouts.partials.customer-nav')

<div class="container">

    @if (session('success'))
        <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
    @endif

    @if (session('error'))
        <span id="flashError" class="d-none">{{ session('error') }}</span>
    @endif

<section class="hero">

    <div class="row align-items-center">

        <div class="col-lg-6">

            <div class="hero-content">

                <div class="hero-badge">

                    <i class="bi bi-stars"></i>

                    Dashboard Customer

                </div>

                <h1>
                    Halo,
                    <span>{{ Auth::user()->name }}</span> 👋
                </h1>

                <p>

                    Siap untuk perjalanan berikutnya?

                    Temukan mobil yang nyaman, aman,
                    dan sesuai dengan kebutuhanmu
                    hanya di RentalKu.

                </p>

                <div class="d-flex flex-wrap gap-2">

                    <a
                        href="#mobil"
                        class="btn hero-btn"
                    >

                        <i class="bi bi-car-front-fill me-1"></i>

                        Cari Mobil

                    </a>

                    <a
                        href="#informasi"
                        class="btn hero-secondary"
                    >

                        Pelajari RentalKu

                    </a>

                </div>

            </div>

        </div>

        <div class="col-lg-6 mt-5 mt-lg-0">

            <div class="hero-photo-wrapper">

                <img
                    src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg"
                    class="hero-img"
                    alt="Mobil RentalKu"
                >

                <div class="floating-card">

                    <div class="floating-icon">

                        <i class="bi bi-shield-check"></i>

                    </div>

                    <div>

                        <small>Rental mudah & aman</small>

                        <strong>Siap menemani perjalananmu</strong>

        </div>

    </div>

</div>

        </div>

    </div>

</section>

<div class="row g-3 stats">

    <div class="col-md-4">

        <div class="stat-card">

            <div class="d-flex align-items-center gap-3">

                <div class="stat-icon">
                    <i class="bi bi-car-front-fill"></i>
                </div>

                <div>

                    <div class="stat-title">
                        Mobil Tersedia
                    </div>

                    <p class="stat-number" data-count="{{ $mobilTersediaCount ?? $mobils->count() }}">
                        {{ $mobilTersediaCount ?? $mobils->count() }}
                    </p>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card">

            <div class="d-flex align-items-center gap-3">

                <div class="stat-icon">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>

                <div>

                    <div class="stat-title">
                        Rental Saya
                    </div>

                    <p class="stat-number" data-count="{{ $rentalCount ?? $rentals->count() }}">
                        {{ $rentalCount ?? $rentals->count() }}
                    </p>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card">

            <div class="d-flex align-items-center gap-3">

                <div class="stat-icon">
                    <i class="bi bi-wallet2"></i>
                </div>

                <div>

                    <div class="stat-title">
                        Total Transaksi
                    </div>

                    <p class="stat-number" data-count="{{ $totalTransaksi ?? 0 }}" data-rp="1">
                        Rp {{ number_format($totalTransaksi ?? 0, 0, ',', '.') }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@if(($klaimUpdates ?? collect())->count())

    <div class="alert alert-info mt-4 mb-0" role="alert">

        <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-bell-fill"></i>
            <strong>Kabar Klaim Kompensasi</strong>
        </div>

        @foreach($klaimUpdates as $klaim)

            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center py-1">

                <span>
                    Klaim {{ $klaim->jenis === 'pengembalian_dana' ? 'Pengembalian Dana' : ($klaim->jenis === 'diskon' ? 'Diskon' : 'Gratis Sewa') }}
                    untuk {{ $klaim->mobil->name ?? 'mobil' }}
                    telah
                    <span class="badge {{ $klaim->status === 'ditolak' ? 'bg-danger' : 'bg-success' }}">
                        {{ $klaim->status === 'disetujui' ? 'Disetujui' : ($klaim->status === 'ditolak' ? 'Ditolak' : 'Selesai') }}
                    </span>
                </span>

                <a href="{{ route('customer.kompensasi.index') }}" class="btn btn-sm btn-info">
                    Lihat
                </a>

            </div>

        @endforeach

    </div>

@endif

<section class="section">
    <section id="rental-saya" class="section pt-4">

    <div class="mb-4">

        <div class="section-label">
            Aktivitas Rental
        </div>

        <h2 class="section-title">
            Rental Saya
        </h2>

        <p class="section-desc">
            Lihat status rental dan lakukan pembayaran kendaraanmu.
        </p>

    </div>


            @if($rentalsAktif->count())
                <div class="rental-masonry">
                    @foreach($rentalsAktif as $rental)
                        @include('customer.partials.rental-card', ['rental' => $rental])
                    @endforeach

                </div>

                @if($rentalsAktif->count() > $jumlahRental)
                    <div class="text-center mt-4 d-flex flex-wrap gap-2 justify-content-center">
                        <a href="{{ route('customer.dashboard', array_merge(request()->only(['q', 'cabang', 'transmisi']), ['jumlah_rental' => $jumlahRental + 4])) }}" class="btn btn-outline-success px-4 py-2">
                            Tampilkan Lebih Banyak
                            <small class="text-muted ms-1">({{ $rentalsAktif->count() - $rentalsTampil->count() }} lainnya)</small>
                            <i class="bi bi-chevron-down ms-1"></i>
                        </a>

                        @if($jumlahRental > 4)
                            <a href="{{ route('customer.dashboard', request()->only(['q', 'cabang', 'transmisi'])) }}" class="btn btn-outline-secondary px-4 py-2">
                                Tampilkan Lebih Sedikit
                                <i class="bi bi-chevron-up ms-1"></i>
                            </a>
                        @endif
                    </div>
                @endif

            @else
                <div class="text-center py-5">
                    <i class="bi bi-lightning-charge fs-1 text-muted"></i>
                    <p class="text-muted mt-2 mb-0">Tidak ada aktivitas rental saat ini.</p>
                </div>
            @endif



</section>

    <div class="mb-4" id="mobil" style="scroll-margin-top: 80px;">

        <div class="section-label">
            Pilihan Rental
        </div>

        <h2 class="section-title">
            Mobil Pilihan Untukmu
        </h2>

        <p class="section-desc">
            Temukan kendaraan yang cocok untuk menemani
            perjalananmu bersama RentalKu.
        </p>

    </div>

    <form method="GET" action="{{ route('customer.dashboard') }}" class="card p-3 mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small mb-1" for="filterQ">Cari Mobil</label>
                <input type="text" id="filterQ" name="q" class="form-control" placeholder="Nama mobil" value="{{ ($filters ?? [])['q'] ?? request('q', '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1" for="filterCabang">Cabang</label>
                <select id="filterCabang" name="cabang" class="form-select">
                    <option value="">Semua Cabang</option>
                    @foreach(($cabangs ?? []) as $cabang)
                        <option value="{{ $cabang->id }}" {{ (string)(($filters ?? [])['cabang'] ?? request('cabang', '')) === (string)$cabang->id ? 'selected' : '' }}>
                            {{ $cabang->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1" for="filterTransmisi">Transmisi</label>
                <select id="filterTransmisi" name="transmisi" class="form-select">
                    <option value="">Semua</option>
                    <option value="Manual" {{ (($filters ?? [])['transmisi'] ?? request('transmisi', '')) === 'Manual' ? 'selected' : '' }}>Manual</option>
                    <option value="Otomatis" {{ (($filters ?? [])['transmisi'] ?? request('transmisi', '')) === 'Otomatis' ? 'selected' : '' }}>Otomatis</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-success flex-grow-1">
                    <i class="bi bi-search me-1"></i>
                    Cari
                </button>
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <div class="row g-4" id="mobilGrid">

        @forelse($mobils as $index => $mobil)

            <div class="col-md-6 col-lg-4">

                    <div class="car-card anim-rise" data-mobil-id="{{ $mobil->id }}" role="button" title="Lihat detail {{ $mobil->name }}" style="animation-delay: {{ min($index * 70, 560) }}ms;">

                  <div class="car-photo-wrapper">

    @if($mobil->image)
        <img
            src="{{ asset($mobil->image) }}"
            class="car-img"
            alt="{{ $mobil->name }}"
        >
    @else
        <img
            src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg"
            class="car-img"
            alt="{{ $mobil->name }}"
        >
    @endif

    <div class="car-status">

        @if($mobil->status == 'Tersedia')
            <i class="bi bi-check-circle-fill me-1"></i>
            Tersedia
        @elseif($mobil->status == 'Disewa')
            <i class="bi bi-calendar-check-fill me-1"></i>
            Disewa
        @else
            <i class="bi bi-tools me-1"></i>
            Maintenance
        @endif

    </div>

    @if(in_array($mobil->id, ($populerIds ?? [])))
        <div class="car-populer"><i class="bi bi-fire me-1"></i>Populer</div>
    @endif

</div>

                    <div class="car-body">

    <h5 class="car-title">
        {{ $mobil->name }}
    </h5>

    <div class="car-info">

        <span>
            <i class="bi bi-car-front-fill"></i>
            {{ $mobil->transmisi }}
        </span>

        <span>
            <i class="bi bi-people-fill"></i>
            {{ $mobil->kapasitas }} orang
        </span>

    </div>

    <div class="d-flex flex-wrap gap-2 mb-2">
        <small class="text-muted">
            <i class="bi bi-wallet2 me-1"></i>
            Deposit: Rp {{ number_format($mobil->deposit ?? 0, 0, ',', '.') }}
        </small>
        <small class="text-muted">
            <i class="bi bi-geo-alt me-1"></i>
            {{ $mobil->cabang->name ?? '-' }}
        </small>
    </div>

    <div class="d-flex justify-content-between align-items-end">

        <div>

            <div class="price-label">
                Mulai dari
            </div>

            <div class="price">
                Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}
                <span>/hari</span>
            </div>

        </div>

        <button
            type="button"
            class="btn btn-rental"
        >
            Sewa
        </button>

    </div>

</div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="empty-card">

                    <div class="empty-icon">

                        <i class="bi bi-car-front"></i>

                    </div>

                    <h5 class="fw-bold mt-4">
                        Belum Ada Mobil
                    </h5>

                    <p class="text-muted mb-0">
                        Mobil yang tersedia akan muncul di halaman ini.
                    </p>

                </div>

            </div>

        @endforelse

    </div>

</section>

<section id="informasi" class="py-5">

    <div class="row g-4">

        <div class="col-md-4">

            <div class="stat-card h-100">

                <div class="stat-icon mb-3">

                    <i class="bi bi-shield-check"></i>

                </div>

                <h5 class="fw-bold">
                    Aman & Terpercaya
                </h5>

                <p class="text-muted small mb-0">
                    RentalKu menyediakan kendaraan
                    untuk membantu perjalananmu dengan nyaman.
                </p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="stat-card h-100">

                <div class="stat-icon mb-3">

                    <i class="bi bi-clock-history"></i>

                </div>

                <h5 class="fw-bold">
                    Proses Mudah
                </h5>

                <p class="text-muted small mb-0">
                    Pilih mobil sesuai kebutuhanmu
                    dan lakukan proses rental dengan mudah.
                </p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="stat-card h-100">

                <div class="stat-icon mb-3">

                    <i class="bi bi-headset"></i>

                </div>

                <h5 class="fw-bold">
                    Siap Membantu
                </h5>

                <p class="text-muted small mb-0">
                    Tim RentalKu siap membantu
                    kebutuhan rental kendaraanmu.
                </p>

            </div>

        </div>

    </div>

</section>

</div>

<footer>

    <div class="container py-5">

        <div class="row g-4">

            <div class="col-md-6">

                <div class="footer-brand">
                    Rental<span>ku</span>.
                </div>

                <p class="footer-text mt-2 mb-0">
                    Solusi rental mobil yang nyaman,
                    mudah, dan terpercaya untuk perjalananmu.
                </p>

            </div>

            <div class="col-md-6 text-md-end">

                <div class="footer-text">
                    &copy; {{ date('Y') }} RentalKu.
                    Semua hak dilindungi.
                </div>

            </div>

        </div>

        <hr class="footer-line my-4">

        <div class="footer-text text-center">
            Dashboard Customer RentalKu
        </div>

    </div>

</footer>

<div class="d-lg-none fixed-bottom bg-white border-top p-2">
    <div class="d-flex gap-2">
        <a href="#mobil" class="btn btn-success flex-grow-1">
            <i class="bi bi-car-front-fill me-1"></i>
            Cari Mobil
        </a>
        <a href="#rental-saya" class="btn btn-outline-success flex-grow-1">
            <i class="bi bi-calendar-check-fill me-1"></i>
            Rental Saya
        </a>
    </div>
</div>

{{-- MODAL DETAIL MOBIL (diisi via AJAX, tanpa reload halaman) --}}
<div
    class="modal fade"
    id="mobilDetailModal"
    tabindex="-1"
    aria-labelledby="mobilDetailModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">

        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">

            @include('layouts.partials.modal-head', ['title' => 'Detail Mobil', 'titleId' => 'mobilDetailModalLabel'])

            <div class="modal-body p-0" id="mobilDetailModalBody"></div>

        </div>

    </div>

</div>

{{-- MODAL LIHAT BUKTI FOTO (denda) --}}
<div
    class="modal fade"
    id="buktiModal"
    tabindex="-1"
    aria-labelledby="buktiModalTitle"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">

            @include('layouts.partials.modal-head', ['title' => 'Bukti Foto', 'icon' => 'bi-image', 'titleId' => 'buktiModalTitle'])

            <div class="modal-body text-center p-3">

                <img id="buktiModalImg" src="" alt="Bukti foto" class="img-fluid rounded">

            </div>

        </div>

    </div>

</div>

<script>
    function openBuktiModal(el) {
        document.getElementById('buktiModalImg').src = el.dataset.src;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('buktiModal')).show();
    }
</script>

{{-- MODAL PEMBAYARAN (diisi via data-attribute tombol, submit AJAX tanpa pindah halaman) --}}
<style>
    #pembayaranModal .pm-summary {
        background: #f5f8f6;
        border-radius: 14px;
        padding: 14px 16px;
    }
    #pembayaranModal .pm-total-box {
        background: #e9f7ef;
        border-radius: 14px;
        padding: 14px 16px;
    }
    #pembayaranModal .pm-total {
        color: #198754;
        font-weight: 800;
        font-size: 24px;
    }
    #pembayaranModal .pm-metode {
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 12px 14px;
    }
    #pembayaranModal .pm-preview {
        max-width: 100%;
        max-height: 220px;
        object-fit: cover;
        border-radius: 12px;
        margin-top: 12px;
        display: none;
    }
</style>

<div
    class="modal fade"
    id="pembayaranModal"
    tabindex="-1"
    aria-labelledby="pembayaranModalTitle"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">

            @include('layouts.partials.modal-head', ['title' => 'Bayar Sekarang', 'titleId' => 'pembayaranModalTitle', 'subtitle' => 'Selesaikan pembayaran rental kendaraanmu.'])

            <div class="modal-body p-4">

                <div class="pm-summary mb-3">

                    <div class="d-flex justify-content-between align-items-center mb-1">

                        <strong id="pmMobil">Mobil</strong>

                        <small class="text-muted" id="pmRental">#0</small>

                    </div>

                    <div class="pm-total-box d-flex justify-content-between align-items-center mt-2">

                        <small class="text-muted">Total dibayar</small>

                        <span class="pm-total" id="pmTotal">Rp 0</span>

                    </div>

                </div>

                <form
                    id="pembayaranForm"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label fw-semibold" for="pmMetode">
                            Metode Pembayaran
                        </label>

                        <select
                            name="metode_pembayaran_id"
                            id="pmMetode"
                            class="form-select"
                            required>

                            <option value="">
                                -- Pilih Metode Pembayaran --
                            </option>

                            @foreach($metodePembayarans as $metode)

                                <option value="{{ $metode->id }}" data-cabang="{{ $metode->cabang_id ?? '' }}">
                                    {{ $metode->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    @if($metodePembayarans->count())

                        <div class="mb-3" id="pmMetodeDetail">

                            <label class="form-label fw-semibold">
                                Rekening / Akun Pembayaran
                            </label>

                            @foreach($metodePembayarans as $metode)

                                <div
                                    class="pm-metode pm-metode-detail d-none"
                                    id="pm-metode-{{ $metode->id }}">

                                    <strong>
                                        <i class="bi bi-wallet2 text-success me-2"></i>
                                        {{ $metode->name }}
                                    </strong>

                                    <div>
                                        <small class="text-muted">
                                            Nomor akun:
                                            <strong>{{ $metode->nomor_akun }}</strong>
                                        </small>
                                    </div>

                                    @if($metode->atas_nama)

                                        <div>
                                            <small class="text-muted">
                                                Atas nama:
                                                <strong>{{ $metode->atas_nama }}</strong>
                                            </small>
                                        </div>

                                    @endif

                                </div>

                            @endforeach

                            <div class="pm-metode" id="pm-metode-placeholder">

                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Pilih metode pembayaran untuk melihat
                                    nomor rekening / akun.
                                </small>

                            </div>

                        </div>

                    @endif

                    <div class="mb-3">

                        <label class="form-label fw-semibold" for="pmTanggal">
                            Tanggal Pembayaran
                        </label>

                        <input
                            type="date"
                            name="tanggal_bayar"
                            id="pmTanggal"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-semibold" for="pmBukti">
                            Bukti Pembayaran
                        </label>

                        <input
                            type="file"
                            name="bukti"
                            id="pmBukti"
                            class="form-control"
                            accept=".jpg,.jpeg,.png"
                            required>

                        <div class="form-text">
                            Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                        </div>

                        <img
                            id="pmPreview"
                            class="pm-preview"
                            alt="Preview bukti pembayaran">

                    </div>

                    <div class="alert alert-warning mb-0">

                        <i class="bi bi-info-circle me-2"></i>

                        Pastikan bukti terlihat jelas dan sesuai dengan jumlah
                        pembayaran sebesar
                        <strong id="pmTotalNote">Rp 0</strong>.

                    </div>

                </form>

            </div>

            <div class="modal-footer border-0 pt-0 px-4 pb-4">

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">
                    Batal
                </button>

                <button
                    type="submit"
                    form="pembayaranForm"
                    id="pmSubmit"
                    class="btn btn-success">
                    <i class="bi bi-send me-1"></i>
                    Kirim Pembayaran
                </button>

            </div>

        </div>

    </div>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Modal profil bersama (admin/staff/customer) --}}
@include('layouts.partials.profile-modal')

<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    (function() {
        var ok = document.getElementById('flashSuccess');
        if (ok) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: ok.textContent,
                timer: 1800,
                showConfirmButton: false,
            });
        }
        var err = document.getElementById('flashError');
        if (err) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: err.textContent,
            });
        }
    })();
</script>

<script>

    // Buka modal detail mobil via AJAX — tanpa reload halaman.
    var $mobilDetailModalBody = $('#mobilDetailModalBody');

    function openMobilDetail(mobilId) {
        $mobilDetailModalBody.html('<div class="text-center py-5"><div class="spinner-border text-success" role="status"></div></div>');

        $.ajax({
            url: '/mobils/' + mobilId,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .done(function(html) {
            $mobilDetailModalBody.html(html);
            bootstrap.Modal.getOrCreateInstance($('#mobilDetailModal')[0]).show();
        })
        .fail(function() {
            $mobilDetailModalBody.html('<div class="alert alert-danger m-3 mb-0"><i class="bi bi-exclamation-triangle me-1"></i> Gagal memuat detail mobil. Silakan coba lagi.</div>');
        });
    }

    $(document).on('click', '[data-mobil-id]', function() {
        openMobilDetail($(this).data('mobil-id'));
    });

    // Popup form sewa (SweetAlert) — template di-inject dari konten modal.
    // Modal Bootstrap disembunyikan dulu: focus-trap-nya merebut fokus
    // sehingga input di dalam SweetAlert (mis. Catatan) tidak bisa diketik.
    function openSewaPopup() {
        var $template = $('#sewaFormTemplate');
        if (!$template.length) return;

        if ($('.mobil-modal .mm-badge-available').length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Mobil sedang tidak tersedia.',
            });
            return;
        }

        var $modal = $('#mobilDetailModal');
        if ($modal.length) {
            bootstrap.Modal.getOrCreateInstance($modal[0]).hide();
        }

        var $carTitle = $('.mobil-modal .mm-title');

        Swal.fire({
            title: $carTitle.length ? $carTitle.text().trim() : 'Sewa Mobil',
            html: $template.html(),
            width: 600,
            showConfirmButton: false,
            didOpen: function() {
                initSewaForm();
            }
        });
    }

    function updateSewaButtonSwal($swal) {
        var form = $swal.find('form#sewaForm')[0] || $swal.find('form')[0];
        if (!form) return;
        var tglMulai = form.querySelector('input[name="tanggal_mulai"]');
        var tglSelesai = form.querySelector('input[name="tanggal_selesai"]');
        var btn = form.querySelector('button[type="submit"]');
        if (!tglMulai || !tglSelesai || !btn) return;
        btn.disabled = !(tglMulai.value && tglSelesai.value);
    }

    function initSewaForm() {
        var $form = $('#swal2-html-container form#sewaForm');
        if (!$form.length) {
            $form = $('#swal2-html-container form').first();
        }
        if (!$form.length) return;

        var $swal = $('#swal2-html-container');

        // Re-bind supir dropdown onchange after Swal inject
        var supirSelect = $swal.find('#supirSelectModal')[0];
        if (supirSelect) {
            supirSelect.addEventListener('change', function() {
                const card = $swal.find('#supirProfileCardModal')[0];
                const opt = this.options[this.selectedIndex];
                
                if (this.value === "") {
                    $swal.find('#supirNameModal')[0].innerText = 'Silakan pilih supir';
                    $swal.find('#supirPhoneModal')[0].innerText = '-';
                    $swal.find('#supirTarifModal')[0].innerText = '0';
                    $swal.find('#supirImgModal')[0].src = 'https://ui-avatars.com/api/?name=Pilih+Supir';
                } else {
                    $swal.find('#supirNameModal')[0].innerText = opt.dataset.name;
                    $swal.find('#supirPhoneModal')[0].innerText = opt.dataset.phone;
                    $swal.find('#supirTarifModal')[0].innerText = opt.dataset.tarif.replace('Rp ', '').replace('/hari', '');
                    $swal.find('#supirImgModal')[0].src = opt.dataset.image;
                }
                card.style.display = 'block';
                updateSewaButtonSwal($swal);
            });
        }

        // Filter supir berdasarkan cabang ambil yang dipilih
        var cabangAmbil = $swal.find('select[name="cabang_ambil_id"]')[0];
        if (cabangAmbil && supirSelect) {
            cabangAmbil.addEventListener('change', function() {
                const cabangId = this.value;

                // Sembunyikan option supir dari cabang lain
                Array.from(supirSelect.options).forEach(function(opt) {
                    if (opt.value === "") return;
                    opt.hidden = (String(opt.dataset.cabangId) !== String(cabangId));
                });

                // Reset pilihan jika supir terpilih bukan dari cabang ini
                if (supirSelect.value !== "" && supirSelect.options[supirSelect.selectedIndex].dataset.cabangId !== cabangId) {
                    supirSelect.value = "";
                    supirSelect.dispatchEvent(new Event('change'));
                }
            });

            // Trigger awal supaya filter langsung jalan saat popup dibuka
            cabangAmbil.dispatchEvent(new Event('change'));
        }

        // Bind date inputs supaya tombol Ajukan Sewa enable/disable
        var dateInputs = $swal.find('input[name="tanggal_mulai"], input[name="tanggal_selesai"]');
        dateInputs.on('change', function() {
            updateSewaButtonSwal($swal);
        });
        updateSewaButtonSwal($swal);

        $form.off('submit').on('submit', function(event) {
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
                url: $form.attr('action').replace('/rental/', '/checkout/'),
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

                if (!data.success) {
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

                if (data.html) {
                    $('#swal2-html-container').html(data.html);
                    $('#cs-kode-promo').on('keypress', function(e) {
                        if (e.which === 13) {
                            e.preventDefault();
                            applyPromo();
                        }
                    });
                } else {
                    $submit.prop('disabled', false);
                    $submit.html(submitHtml);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Respon checkout tidak valid.',
                    });
                }
            })
            .fail(function(xhr) {
                Swal.hideLoading();
                $submit.prop('disabled', false);
                $submit.html(submitHtml);
                var data = xhr.responseJSON || {};
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
                    : (data.message || 'Terjadi kesalahan. Silakan coba lagi.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: firstError,
                });
            });
        });
    }

    // Modal pembayaran — dibuka dari tombol Bayar / Upload Ulang di kartu rental.
    function openPembayaranModal(btn) {
        var $btn = $(btn);

        var form = $('#pembayaranForm')[0];
        form.reset();
        $('#pembayaranForm').attr('action', $btn.data('action'));

        // Hanya tampilkan rekening milik cabang rental ini.
        // Kalau cabang belum punya rekening, tampilkan milik pusat.
        var cabang = String($btn.data('cabang') || '');
        var hasOwn = false;

        $('#pmMetode option[value!=""]').each(function() {
            var c = String($(this).data('cabang') || '');
            if (c !== '' && c === cabang) {
                hasOwn = true;
            }
        });

        $('#pmMetode option[value!=""]').each(function() {
            var c = String($(this).data('cabang') || '');
            $(this).toggle(hasOwn ? (c === cabang) : (c === ''));
        });

        $('#pembayaranModalTitle').text($btn.data('title') || 'Bayar Sekarang');
        $('#pmMobil').text($btn.data('mobil') || 'Mobil');
        $('#pmRental').text('#' + $btn.data('rental'));

        var total = 'Rp ' + Number($btn.data('total') || 0).toLocaleString('id-ID');
        $('#pmTotal').text(total);
        $('#pmTotalNote').text(total);

        var now = new Date();
        var today = now.getFullYear() + '-'
            + String(now.getMonth() + 1).padStart(2, '0') + '-'
            + String(now.getDate()).padStart(2, '0');
        $('#pmTanggal').val(today);

        $('#pmPreview').hide().attr('src', '');
        toggleMetodeDetail();

        bootstrap.Modal.getOrCreateInstance($('#pembayaranModal')[0]).show();
    }

    $(document).on('click', '.btn-bayar', function() {
        openPembayaranModal(this);
    });

    function toggleMetodeDetail() {
        var selectedId = $('#pmMetode').val();

        $('#pmMetodeDetail .pm-metode-detail').addClass('d-none');

        if (selectedId) {
            $('#pm-metode-' + selectedId).removeClass('d-none');
            $('#pm-metode-placeholder').addClass('d-none');
        } else {
            $('#pm-metode-placeholder').removeClass('d-none');
        }
    }

    $(document).on('change', '#pmMetode', toggleMetodeDetail);

    $(document).on('change', '#pmBukti', function(event) {
        var file = event.target.files[0];
        var $preview = $('#pmPreview');

        if (file) {
            $preview.attr('src', URL.createObjectURL(file));
            $preview.show();
        } else {
            $preview.hide();
        }
    });

    $(document).on('submit', '#pembayaranForm', function(event) {
        event.preventDefault();

        var $form = $(this);
        var buktiFile = $('#pmBukti')[0].files[0];
        if (buktiFile && buktiFile.size > 2 * 1024 * 1024) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Ukuran bukti maksimal 2 MB.',
            });
            return;
        }

        var $submit = $('#pmSubmit');
        var formData = new FormData($form[0]);
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
        .done(function(data) {
            Swal.hideLoading();
            $submit.prop('disabled', false);
            $submit.html(submitHtml);
            bootstrap.Modal.getOrCreateInstance($('#pembayaranModal')[0]).hide();

            Swal.fire({
                title: 'Berhasil!',
                html: '<div class="swal-check"><svg width="72" height="72" viewBox="0 0 52 52"><circle cx="26" cy="26" r="24" fill="none" stroke="#198754" stroke-width="2.5"/><path fill="none" stroke="#198754" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" d="M14 27l8 8 16-16"/></svg><p>' + escHtml(data.message || 'Bukti pembayaran berhasil dikirim.') + '</p></div>',
                confirmButtonText: 'OK',
            }).then(function() {
                window.location.reload();
            });
        })
        .fail(function(xhr) {
            Swal.hideLoading();
            $submit.prop('disabled', false);
            $submit.html(submitHtml);

            var r = xhr.responseJSON || {};
            var errs = r.errors || {};
            Object.keys(errs).forEach(function(key) {
                var $input = $form.find('[name="' + key + '"]');
                if ($input.length) {
                    $input.addClass('is-invalid');
                    $input.after('<div class="invalid-feedback d-block">' + errs[key][0] + '</div>');
                }
            });
            var firstError = r.errors
                ? Object.values(r.errors).flat()[0]
                : (r.message || 'Terjadi kesalahan. Silakan coba lagi.');

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: firstError,
            });
        });
    });

    // Live search katalog: ketik langsung muncul tanpa reload.
    var mobilSearchUrl = '{{ route('customer.mobils.search') }}';
    var mobilFallbackImg = 'https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg';
    var mobilSearchTimer = null;

    function escHtml(text) {
        return String(text === null || text === undefined ? '' : text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function formatRp(value) {
        return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
    }

    var populerIds = @json($populerIds ?? []);

    function renderMobilGrid(mobils) {
        var $grid = $('#mobilGrid');

        if (!mobils.length) {
            $grid.html(
                '<div class="col-12">' +
                    '<div class="empty-card">' +
                        '<div class="empty-icon"><i class="bi bi-car-front"></i></div>' +
                        '<h5 class="fw-bold mt-4">Mobil Tidak Ditemukan</h5>' +
                        '<p class="text-muted mb-0">Coba kata kunci atau filter lain.</p>' +
                    '</div>' +
                '</div>'
            );
            return;
        }

        var html = '';

        mobils.forEach(function(m, i) {
            var isPopuler = populerIds.indexOf(m.id) !== -1;
            var delay = Math.min(i * 70, 560);
            html +=
                '<div class="col-md-6 col-lg-4">' +
                    '<div class="car-card anim-rise" data-mobil-id="' + m.id + '" role="button" title="Lihat detail ' + escHtml(m.name) + '" style="animation-delay: ' + delay + 'ms;">' +
                        '<div class="car-photo-wrapper">' +
                            '<img src="' + (m.image_url || mobilFallbackImg) + '" class="car-img" alt="' + escHtml(m.name) + '">' +
                            '<div class="car-status"><i class="bi bi-check-circle-fill me-1"></i>Tersedia</div>' +
                            (isPopuler ? '<div class="car-populer"><i class="bi bi-fire me-1"></i>Populer</div>' : '') +
                        '</div>' +
                        '<div class="car-body">' +
                            '<h5 class="car-title">' + escHtml(m.name) + '</h5>' +
                            '<div class="car-info">' +
                                '<span><i class="bi bi-car-front-fill"></i>' + escHtml(m.transmisi) + '</span>' +
                                '<span><i class="bi bi-people-fill"></i>' + escHtml(m.kapasitas) + ' orang</span>' +
                            '</div>' +
                            '<div class="d-flex flex-wrap gap-2 mb-2">' +
                                '<small class="text-muted"><i class="bi bi-wallet2 me-1"></i>Deposit: ' + formatRp(m.deposit) + '</small>' +
                                '<small class="text-muted"><i class="bi bi-geo-alt me-1"></i>' + escHtml(m.cabang) + '</small>' +
                            '</div>' +
                            '<div class="d-flex justify-content-between align-items-end">' +
                                '<div>' +
                                    '<div class="price-label">Mulai dari</div>' +
                                    '<div class="price">' + formatRp(m.harga_perhari) + '<span>/hari</span></div>' +
                                '</div>' +
                                '<button type="button" class="btn btn-rental">Sewa</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';
        });

        $grid.html(html);
    }

    function mobilSkeleton() {
        var html = '';

        for (var i = 0; i < 3; i++) {
            html +=
                '<div class="col-md-6 col-lg-4">' +
                    '<div class="skel-card">' +
                        '<div class="skel-line" style="height: 210px; border-radius: 0;"></div>' +
                        '<div class="p-3">' +
                            '<div class="skel-line mb-2" style="height: 20px; width: 60%;"></div>' +
                            '<div class="skel-line mb-3" style="height: 14px; width: 80%;"></div>' +
                            '<div class="skel-line" style="height: 28px; width: 45%;"></div>' +
                        '</div>' +
                    '</div>' +
                '</div>';
        }

        return html;
    }

    function fetchMobils() {
        $('#mobilGrid').html(mobilSkeleton());

        $.ajax({
            url: mobilSearchUrl,
            method: 'GET',
            data: {
                q: $('#filterQ').val(),
                cabang: $('#filterCabang').val(),
                transmisi: $('#filterTransmisi').val(),
            },
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).done(function(data) {
            renderMobilGrid(data);
        });
    }

    $('#filterQ').on('input', function() {
        clearTimeout(mobilSearchTimer);
        mobilSearchTimer = setTimeout(fetchMobils, 350);
    });

    $('#filterCabang, #filterTransmisi').on('change', fetchMobils);

    // Count-up statistik (GoodUI + 60fps): angka berjalan saat halaman dibuka.
    (function() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        document.querySelectorAll('.stat-number[data-count]').forEach(function(el) {
            var target = parseFloat(el.dataset.count) || 0;
            var rp = el.dataset.rp === '1';
            var dur = 900;
            var t0 = null;

            function fmt(v) {
                var n = Math.round(v).toLocaleString('id-ID');
                return rp ? 'Rp ' + n : n;
            }

            function tick(t) {
                if (!t0) t0 = t;
                var p = Math.min((t - t0) / dur, 1);
                var eased = 1 - Math.pow(1 - p, 4);
                el.textContent = fmt(target * eased);
                if (p < 1) requestAnimationFrame(tick);
            }

            requestAnimationFrame(tick);
        });
    })();

</script>

</body>
</html>