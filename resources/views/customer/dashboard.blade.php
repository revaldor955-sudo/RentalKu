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

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7f6;
            color: #1f2937;
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        .section {
            padding-top: 70px;
            padding-bottom: 30px;
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
            transform: translateY(-7px);
            box-shadow: 0 18px 40px rgba(0,0,0,.10);
        }

        .car-photo-wrapper {
            position: relative;
            overflow: hidden;
        }

        .car-img {
            width: 100%;
            height: 210px;
            object-fit: cover;
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

    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>


<nav class="navbar navbar-expand-lg sticky-top">

    <div class="container py-3">

        <a href="{{ url('/') }}" class="text-decoration-none brand">
            Rental<span>ku</span>.
        </a>

        <div class="d-flex align-items-center gap-3">

            <div class="user-box d-none d-md-flex"
                 data-bs-toggle="modal"
                 data-bs-target="#profileModal"
                 style="cursor: pointer;">

                <div class="user-icon">
                    <i class="bi bi-person"></i>
                </div>

                <span>
                    {{ Auth::user()->name }}
                </span>

            </div>

        </div>

    </div>

</nav>


<div class="container">


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

                    <p class="stat-number">
                        {{ $mobils->count() }}
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

                    <p class="stat-number">
                        0
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

                    <p class="stat-number">
                        Rp 0
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


<section id="mobil" class="section">
    <section class="section pt-4">

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

    @if($rentals->count())

        <div class="row g-4">

            @foreach($rentals as $rental)

                <div class="col-lg-6">

                    <div class="stat-card">

                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    {{ $rental->mobil->name ?? 'Mobil' }}
                                </h5>

                                <small class="text-muted">
                                    Rental #{{ $rental->id }}
                                </small>

                            </div>

                            @if($rental->status === 'Menunggu')

                                <span class="badge bg-warning text-dark">
                                    Menunggu

                                </span>

                            @elseif($rental->status === 'Disetujui')

                                <span class="badge bg-success">
                                    Disetujui

                                </span>

                            @elseif($rental->status === 'Berjalan')

                                <span class="badge bg-primary">
                                    Berjalan

                                </span>

                            @elseif($rental->status === 'Selesai')

                                <span class="badge bg-secondary">
                                    Selesai

                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Dibatalkan
                                </span>

                            @endif

                        </div>


                        <div class="row g-3 mb-3">

                            <div class="col-6">

                                <small class="text-muted d-block">
                                    Tanggal Mulai
                                </small>

                                <strong>
                                    {{ $rental->tanggal_mulai->format('d/m/Y') }}
                                </strong>

                            </div>

                            <div class="col-6">

                                <small class="text-muted d-block">
                                    Tanggal Selesai
                                </small>

                                <strong>
                                    {{ $rental->tanggal_selesai->format('d/m/Y') }}
                                </strong>

                            </div>

                            <div class="col-6">

                                <small class="text-muted d-block">
                                    Jumlah Hari
                                </small>

                                <strong>
                                    {{ $rental->jumlah_hari }} Hari
                                </strong>

                            </div>

                            <div class="col-6">

                                <small class="text-muted d-block">
                                    Total Harga
                                </small>

                                <strong class="text-success">
                                    Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                                </strong>

                            </div>

                        </div>


                   {{-- TOMBOL PEMBAYARAN --}}

@if($rental->status === 'Disetujui')

    @if(!$rental->pembayaran)

        <a
            href="{{ route('pembayaran.create', $rental->id) }}"
            class="btn btn-success w-100"
        >
            <i class="bi bi-credit-card me-1"></i>
            Bayar Sekarang
        </a>

    @elseif($rental->pembayaran->status === 'Menunggu')

        <div class="alert alert-info mb-0">
            <i class="bi bi-clock-history me-1"></i>
            Bukti pembayaran sudah dikirim dan sedang
            menunggu verifikasi admin.
        </div>

   @elseif($rental->pembayaran->status === 'Disetujui')

    <div class="alert alert-success mb-0">
        <i class="bi bi-check-circle-fill me-1"></i>
        Pembayaran sudah diverifikasi admin.
    </div>

    @elseif($rental->pembayaran->status === 'Ditolak')

        <a
            href="{{ route('pembayaran.create', $rental->id) }}"
            class="btn btn-danger w-100"
        >
            <i class="bi bi-arrow-repeat me-1"></i>
            Upload Ulang Pembayaran
        </a>

    @endif

@elseif($rental->status === 'Menunggu')

    <div class="alert alert-warning mb-0">
        <i class="bi bi-hourglass-split me-1"></i>
        Menunggu persetujuan admin sebelum melakukan pembayaran.
    </div>

@elseif($rental->status === 'Ditolak')

    <div class="alert alert-danger mb-0">
        <i class="bi bi-x-circle me-1"></i>
        Pengajuan rental ditolak.
    </div>

@elseif($rental->status === 'Selesai')

    <div class="alert alert-secondary mb-0">
        <i class="bi bi-check2-circle me-1"></i>
        Rental telah selesai.
    </div>

@endif

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-card">

            <div class="empty-icon">

                <i class="bi bi-calendar-x"></i>

            </div>

            <h5 class="fw-bold mt-4">
                Belum Ada Rental
            </h5>

            <p class="text-muted mb-0">
                Rental yang kamu lakukan akan muncul di sini.
            </p>

        </div>

    @endif

</section>

    <div class="mb-4">

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


    <div class="row g-4">

        @forelse($mobils as $index => $mobil)

            <div class="col-md-6 col-lg-4">

                <div class="car-card" data-mobil-id="{{ $mobil->id }}" role="button" title="Lihat detail {{ $mobil->name }}">

                    {{-- FOTO --}}

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

</div>


                    {{-- DETAIL MOBIL --}}

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
                    <i class="bi bi-images me-1"></i>
                    Foto kendaraan menggunakan Pexels API
                </div>

                <div class="footer-text mt-2">
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


{{-- MODAL DETAIL MOBIL (diisi via AJAX, tanpa reload halaman) --}}
<div
    class="modal fade"
    id="mobilDetailModal"
    tabindex="-1"
    aria-labelledby="mobilDetailModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">

        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">

            <div class="modal-header border-0 pb-0">

                <h5 class="modal-title fw-bold" id="mobilDetailModalLabel">
                    Detail Mobil
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Tutup"></button>

            </div>

            <div class="modal-body p-0" id="mobilDetailModalBody"></div>

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

    // Buka modal detail mobil via AJAX — tanpa reload halaman.
    const mobilDetailModalEl = document.getElementById('mobilDetailModal');

    const mobilDetailModalBody = document.getElementById('mobilDetailModalBody');

    async function openMobilDetail(mobilId) {

        mobilDetailModalBody.innerHTML = `

            <div class="text-center py-5">

                <div class="spinner-border text-success" role="status"></div>

            </div>`;

        try {

            const response = await fetch(`/mobils/${mobilId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Respon tidak valid.');
            }

            const html = await response.text();

            mobilDetailModalBody.innerHTML = html;

            bootstrap.Modal.getOrCreateInstance(mobilDetailModalEl).show();

        } catch (error) {

            mobilDetailModalBody.innerHTML = `

                <div class="alert alert-danger m-3 mb-0">

                    <i class="bi bi-exclamation-triangle me-1"></i>

                    Gagal memuat detail mobil. Silakan coba lagi.

                </div>`;

        }

    }

    // Klik kartu mobil (atau tombol "Sewa") di dashboard → buka modal
    document.querySelectorAll('[data-mobil-id]').forEach(function (card) {

        card.addEventListener('click', function () {

            openMobilDetail(card.dataset.mobilId);

        });

    });

    // Popup form sewa (SweetAlert) — template di-inject dari konten modal
    function openSewaPopup() {

        const template = document.getElementById('sewaFormTemplate');

        if (!template) return;

        const carTitle = document.querySelector('.mobil-modal .mm-title');

        Swal.fire({
            title: carTitle ? carTitle.textContent.trim() : 'Sewa Mobil',
            html: template.innerHTML,
            width: 600,
            showConfirmButton: false,
            didOpen: () => {

                const form = document.querySelector('#swal2-html-container form');

                if (!form) return;

                form.addEventListener('submit', async function (event) {

                    event.preventDefault();

                    const formData = new FormData(form);

                    Swal.showLoading();

                    try {

                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        Swal.hideLoading();

                        if (!response.ok) {

                            const firstError = data.errors
                                ? Object.values(data.errors).flat()[0]
                                : (data.message ?? 'Terjadi kesalahan.');

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
                            text: data.message ?? 'Pengajuan sewa mobil berhasil dibuat.',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            window.location.reload();
                        });

                    } catch (error) {

                        Swal.hideLoading();

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan. Silakan coba lagi.',
                        });

                    }

                });

            }
        });

    }

</script>


</body>
</html>