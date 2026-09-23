<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Staff Dashboard — RentalKu</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <style>

        :root {

            --green: #168b5b;
            --green-dark: #0d5e3d;
            --green-soft: #eaf7f1;

            --black: #101513;
            --black-2: #18201d;

            --cream: #f7f8f6;

            --text: #18201d;
            --muted: #8a938e;

            --line: #e8ece9;

            --gold: #c6a15b;

        }


        body {

            background: var(--cream);

            color: var(--text);

            font-family:
                'Plus Jakarta Sans',
                sans-serif;

        }


        a {
            text-decoration: none;
        }


        .navbar-main {

            height: 78px;

            background:
                rgba(255,255,255,.88);

            backdrop-filter:
                blur(20px);

            border-bottom:
                1px solid var(--line);

            display: flex;

            align-items: center;

            position: sticky;

            top: 0;

            z-index: 1000;

        }


        .navbar-inner {

            width: 100%;

            max-width: 1450px;

            margin: auto;

            padding: 0 35px;

            display: flex;

            align-items: center;

            justify-content: space-between;

        }


        .logo {

            display: flex;

            align-items: center;

            gap: 11px;

            color: var(--black);

        }


        .logo-mark {

            width: 42px;

            height: 42px;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    #1eaa70,
                    #08633f
                );

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            box-shadow:
                0 8px 20px
                rgba(22,139,91,.20);

        }


        .logo-mark i {
            font-size: 20px;
        }


        .logo-text {

            font-size: 20px;

            font-weight: 800;

            letter-spacing: -.7px;

        }


        .logo-text span {
            color: var(--green);
        }


        .nav-center {

            display: flex;

            align-items: center;

            gap: 7px;

        }


        .nav-link {

            color: #737c77;

            font-size: 11px;

            font-weight: 700;

            padding:
                9px 13px;

            border-radius: 9px;

            transition: .2s;

        }


        .nav-link:hover {

            color: var(--green);

            background:
                var(--green-soft);

        }


        .nav-link.active {

            color: var(--green);

            background:
                var(--green-soft);

        }


        .profile {

            display: flex;

            align-items: center;

            gap: 9px;

            padding:
                5px 8px 5px 5px;

            border:
                1px solid var(--line);

            background: white;

            border-radius: 13px;

            cursor: pointer;

        }


        .profile-avatar {

            width: 34px;

            height: 34px;

            border-radius: 10px;

            background:
                var(--green-soft);

            color: var(--green);

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: 800;

        }


        .profile-name {

            font-size: 10px;

            font-weight: 800;

        }


        .profile-role {

            color: var(--muted);

            font-size: 8px;

            margin-top: 1px;

        }



        /* =====================================================
           PAGE
        ===================================================== */

        .page {

            max-width: 1450px;

            margin: auto;

            padding:
                35px;

        }


        .hero {

            position: relative;

            overflow: hidden;

            min-height: 310px;

            border-radius: 30px;

            background:

                radial-gradient(
                    circle at 82% 15%,
                    rgba(45,205,139,.22),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 70% 100%,
                    rgba(198,161,91,.13),
                    transparent 25%
                ),

                linear-gradient(
                    120deg,
                    #0d1512,
                    #13251d 60%,
                    #0d1713
                );

            color: white;

            padding:
                45px 48px;

            box-shadow:
                0 25px 60px
                rgba(10,30,20,.13);

        }


        .hero-content {

            position: relative;

            z-index: 3;

            max-width: 620px;

        }


        .hero-label {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            color: #8ce4ba;

            font-size: 9px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: 1.5px;

        }


        .hero-label span {

            width: 6px;

            height: 6px;

            border-radius: 50%;

            background: #41d894;

            box-shadow:
                0 0 0 5px
                rgba(65,216,148,.10);

        }


        .hero h1 {

            margin:
                17px 0 12px;

            font-size: 38px;

            line-height: 1.15;

            letter-spacing: -1.7px;

            font-weight: 800;

        }


        .hero h1 span {

            color: #58d99b;

        }


        .hero-description {

            color: #aab9b2;

            font-size: 11px;

            line-height: 1.8;

            max-width: 530px;

            margin: 0;

        }


        .hero-actions {

            margin-top: 25px;

            display: flex;

            gap: 10px;

            flex-wrap: wrap;

        }


        .hero-btn {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding:
                11px 16px;

            border-radius: 11px;

            font-size: 10px;

            font-weight: 800;

            transition: .2s;

        }


        .hero-btn-primary {

            background: white;

            color: var(--green-dark);

        }


        .hero-btn-primary:hover {

            transform: translateY(-2px);

            color: var(--green-dark);

        }


        .hero-btn-secondary {

            color: white;

            border:
                1px solid
                rgba(255,255,255,.14);

            background:
                rgba(255,255,255,.05);

        }


        .hero-btn-secondary:hover {

            background:
                rgba(255,255,255,.1);

            color: white;

        }


        .hero-car {

            position: absolute;

            right: 25px;

            bottom: -28px;

            width: 430px;

            height: 260px;

            border-radius: 50%;

            background:
                radial-gradient(
                    ellipse,
                    rgba(52,190,130,.18),
                    transparent 65%
                );

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .hero-car i {

            font-size: 190px;

            color:
                rgba(255,255,255,.055);

            transform:
                rotate(-4deg);

        }


        .hero-orbit {

            position: absolute;

            right: 105px;

            top: 38px;

            width: 180px;

            height: 180px;

            border:
                1px solid
                rgba(255,255,255,.07);

            border-radius: 50%;

        }



        /* =====================================================
           STAT FLOATING
        ===================================================== */

        .stats {

            margin-top: -48px;

            position: relative;

            z-index: 10;

        }


        .stat-card {

            background: white;

            border:
                1px solid var(--line);

            border-radius: 18px;

            padding:
                19px;

            min-height: 130px;

            box-shadow:
                0 15px 35px
                rgba(20,35,28,.07);

            transition: .25s;

        }


        .stat-card:hover {

            transform:
                translateY(-5px);

            box-shadow:
                0 20px 40px
                rgba(20,35,28,.11);

        }


        .stat-top {

            display: flex;

            align-items: center;

            justify-content: space-between;

        }


        .stat-icon {

            width: 40px;

            height: 40px;

            border-radius: 11px;

            background:
                var(--green-soft);

            color: var(--green);

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .stat-label {

            color: var(--muted);

            font-size: 9px;

            font-weight: 700;

        }


        .stat-number {

            margin-top: 5px;

            font-size: 25px;

            font-weight: 800;

            letter-spacing: -1px;

        }


        .stat-bottom {

            margin-top: 12px;

            font-size: 8px;

            color: #9aa29e;

        }


        .stat-bottom i {

            color: var(--green);

        }



        /* =====================================================
           SECTION HEADER
        ===================================================== */

        .section {

            margin-top: 48px;

        }


        .section-head {

            display: flex;

            align-items: end;

            justify-content: space-between;

            margin-bottom: 18px;

        }


        .eyebrow {

            color: var(--green);

            font-size: 8px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: 1.5px;

            margin-bottom: 6px;

        }


        .section-title {

            margin: 0;

            font-size: 21px;

            font-weight: 800;

            letter-spacing: -.7px;

        }


        .section-description {

            color: var(--muted);

            font-size: 9px;

            margin-top: 5px;

        }


        .view-all {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            color: var(--green);

            font-size: 9px;

            font-weight: 800;

        }



        /* =====================================================
           MANAGEMENT BENTO
        ===================================================== */

        .management {

            display: grid;

            grid-template-columns:
                1.5fr
                1fr
                1fr
                1fr;

            grid-template-rows:
                145px
                145px;

            gap: 13px;

        }


        .manage-card {

            position: relative;

            overflow: hidden;

            background: white;

            border:
                1px solid var(--line);

            border-radius: 20px;

            padding: 22px;

            color: var(--text);

            transition: .25s;

        }


        .manage-card:hover {

            transform:
                translateY(-4px);

            border-color:
                rgba(22,139,91,.25);

            box-shadow:
                0 18px 35px
                rgba(20,35,28,.07);

            color: var(--text);

        }


        .manage-card.large {

            grid-row:
                span 2;

            background:

                radial-gradient(
                    circle at 90% 10%,
                    rgba(29,174,113,.18),
                    transparent 35%
                ),

                linear-gradient(
                    135deg,
                    #ffffff,
                    #edf8f2
                );

        }


        .manage-number {

            position: absolute;

            right: 20px;

            top: 17px;

            color: #d8dfdb;

            font-size: 10px;

            font-weight: 800;

        }


        .manage-icon {

            width: 46px;

            height: 46px;

            border-radius: 14px;

            background:
                var(--green-soft);

            color: var(--green);

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 19px;

            margin-bottom: 17px;

        }


        .manage-card.large
        .manage-icon {

            width: 57px;

            height: 57px;

            font-size: 23px;

        }


        .manage-title {

            font-size: 12px;

            font-weight: 800;

        }


        .manage-card.large
        .manage-title {

            font-size: 18px;

        }


        .manage-description {

            color: var(--muted);

            font-size: 9px;

            line-height: 1.6;

            margin-top: 5px;

            max-width: 250px;

        }


        .manage-arrow {

            position: absolute;

            right: 19px;

            bottom: 17px;

            width: 30px;

            height: 30px;

            border-radius: 50%;

            background: white;

            border:
                1px solid var(--line);

            display: flex;

            align-items: center;

            justify-content: center;

            color: var(--green);

            font-size: 11px;

            transition: .2s;

        }


        .manage-card:hover
        .manage-arrow {

            transform:
                translate(2px,-2px);

            background:
                var(--green);

            color: white;

            border-color:
                var(--green);

        }



        /* =====================================================
           FLEET AREA
        ===================================================== */

        .fleet-card {

            background: white;

            border:
                1px solid var(--line);

            border-radius: 23px;

            overflow: hidden;

        }


        .fleet-header {

            padding:
                22px 24px;

            border-bottom:
                1px solid var(--line);

            display: flex;

            justify-content: space-between;

            align-items: center;

        }


        .fleet-title {

            font-size: 13px;

            font-weight: 800;

        }


        .fleet-subtitle {

            color: var(--muted);

            font-size: 8px;

            margin-top: 4px;

        }


        .fleet-table {

            width: 100%;

            border-collapse:
                collapse;

        }


        .fleet-table th {

            padding:
                12px 22px;

            background:
                #fafcfb;

            color: #a0a8a4;

            font-size: 8px;

            text-transform:
                uppercase;

            letter-spacing: .7px;

            text-align: left;

        }


        .fleet-table td {

            padding:
                15px 22px;

            border-top:
                1px solid #f0f2f1;

            font-size: 9px;

        }


        .fleet-name {

            display: flex;

            align-items: center;

            gap: 10px;

        }


        .fleet-car-icon {

            width: 36px;

            height: 36px;

            border-radius: 10px;

            background:
                #f1f7f4;

            color: var(--green);

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .fleet-car-name {

            font-weight: 800;

            font-size: 10px;

        }


        .fleet-car-info {

            color: var(--muted);

            font-size: 8px;

            margin-top: 2px;

        }


        .fleet-price {

            font-weight: 800;

        }


        .status {

            display: inline-flex;

            align-items: center;

            gap: 5px;

            border-radius: 30px;

            padding:
                6px 9px;

            font-size: 8px;

            font-weight: 800;

        }


        .status::before {

            content: '';

            width: 5px;

            height: 5px;

            border-radius: 50%;

            background:
                currentColor;

        }


        .status-available {

            background: #eaf8f1;

            color: #168b5b;

        }


        .status-rented {

            background: #fff6df;

            color: #a57a17;

        }


        .status-maintenance {

            background: #fff0f1;

            color: #b74351;

        }



        /* =====================================================
           SIDE INFO
        ===================================================== */

        .info-card {

            height: 100%;

            background:
                linear-gradient(
                    145deg,
                    #101714,
                    #18251f
                );

            color: white;

            border-radius: 23px;

            padding: 25px;

            position: relative;

            overflow: hidden;

        }


        .info-card::before {

            content: '';

            position: absolute;

            width: 180px;

            height: 180px;

            right: -70px;

            top: -70px;

            border-radius: 50%;

            border:
                1px solid
                rgba(255,255,255,.08);

        }


        .info-label {

            color: #83dcae;

            font-size: 8px;

            font-weight: 800;

            text-transform:
                uppercase;

            letter-spacing: 1.4px;

        }


        .info-title {

            font-size: 19px;

            font-weight: 800;

            line-height: 1.35;

            margin-top: 12px;

        }


        .info-list {

            margin-top: 23px;

        }


        .info-row {

            display: flex;

            align-items: center;

            gap: 10px;

            padding:
                11px 0;

            border-bottom:
                1px solid
                rgba(255,255,255,.07);

        }


        .info-row:last-child {

            border-bottom: none;

        }


        .info-row-icon {

            width: 30px;

            height: 30px;

            border-radius: 9px;

            background:
                rgba(255,255,255,.07);

            color: #7ee0ad;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .info-row-label {

            color: #89958f;

            font-size: 8px;

        }


        .info-row-value {

            color: white;

            font-size: 10px;

            font-weight: 800;

            margin-top: 2px;

        }



        /* =====================================================
           FOOTER
        ===================================================== */

        .bottom-space {

            height: 25px;

        }



        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media(max-width:1100px) {

            .nav-center {
                display: none;
            }

            .management {

                grid-template-columns:
                    1fr 1fr;

                grid-template-rows:
                    auto;

            }

            .manage-card.large {

                grid-row:
                    span 1;

            }

            .hero-car {

                opacity: .5;

                right: -100px;

            }

        }


        @media(max-width:768px) {

            .navbar-inner {

                padding:
                    0 17px;

            }

            .page {

                padding:
                    20px 15px;

            }

            .hero {

                padding:
                    30px 25px;

                min-height: 340px;

            }

            .hero h1 {

                font-size: 28px;

            }

            .hero-car {

                width: 280px;

                right: -100px;

                bottom: -10px;

            }

            .hero-car i {

                font-size: 130px;

            }

            .stats {

                margin-top: 15px;

            }

            .management {

                grid-template-columns:
                    1fr 1fr;

                gap: 10px;

            }

            .manage-card {

                min-height: 140px;

            }

            .fleet-table {

                min-width: 650px;

            }

        }


        @media(max-width:480px) {

            .profile-name,
            .profile-role {

                display: none;

            }

            .management {

                grid-template-columns:
                    1fr;

            }

            .hero {

                min-height: 390px;

            }

            .hero-actions {

                flex-direction: column;

                align-items: flex-start;

            }

        }

    </style>

</head>


<body>


{{-- ==========================================================
           NAVBAR
        
========================================================== --}}

<nav class="navbar-main">

    <div class="navbar-inner">


        <a
            href="{{ route('staff.dashboard') }}"
            class="logo"
        >

            <div class="logo-mark">

                <i class="bi bi-car-front-fill"></i>

            </div>

            <div class="logo-text">
                Rental<span>ku</span>
            </div>

        </a>


        <div class="nav-center">

            <a
                href="{{ route('staff.dashboard') }}"
                class="nav-link active"
            >
                Dashboard
            </a>

            <a
                href="{{ route('staff.mobils.index') }}"
                class="nav-link"
            >
                Kendaraan
            </a>

            <a
                href="{{ route('rentals.index') }}"
                class="nav-link"
            >
                Rental
            </a>

            <a
                href="{{ route('pembayarans.index') }}"
                class="nav-link"
            >
                Pembayaran
            </a>

            <a
                href="{{ route('laporan.index') }}"
                class="nav-link"
            >
                Laporan
            </a>

        </div>


        <div
            class="profile"
            data-bs-toggle="modal"
            data-bs-target="#profileModal"
        >

            <div class="profile-avatar">

                {{ strtoupper(
                    substr(Auth::user()->name, 0, 1)
                ) }}

            </div>

            <div>

                <div class="profile-name">
                    {{ Auth::user()->name }}
                </div>

                <div class="profile-role">
                    Staff RentalKu
                </div>

            </div>

            <i
                class="bi bi-chevron-down text-muted"
                style="font-size:9px;"
            ></i>

        </div>


    </div>

</nav>



{{-- ==========================================================
     PAGE
========================================================== --}}

<main class="page">


    {{-- ======================================================
         HERO
    ======================================================= --}}

    <section class="hero">


        <div class="hero-content">


            <div class="hero-label">

                <span></span>

                Staff Control Center

            </div>


            <h1>

                Selamat datang,
                <span>
                    {{ Auth::user()->name }}
                </span>

            </h1>


            <p class="hero-description">

                Semua kebutuhan operasional RentalKu
                berada dalam satu dashboard. Pantau armada,
                kelola rental pelanggan, pembayaran,
                hingga pemeriksaan kendaraan.

            </p>


            <div class="hero-actions">

                <a
                    href="{{ route('rentals.index') }}"
                    class="hero-btn hero-btn-primary"
                >

                    <i class="bi bi-calendar2-check"></i>

                    Kelola Rental

                </a>


                <a
                    href="{{ route('staff.mobils.index') }}"
                    class="hero-btn hero-btn-secondary"
                >

                    <i class="bi bi-car-front"></i>

                    Lihat Armada

                </a>

            </div>


        </div>


        <div class="hero-orbit"></div>


        <div class="hero-car">

            <i class="bi bi-car-front-fill"></i>

        </div>


    </section>



    {{-- ======================================================
         STATISTICS
    ======================================================= --}}

    <section class="stats">

        <div class="row g-3">


            {{-- TOTAL MOBIL --}}

            <div class="col-6 col-xl-3">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Total Armada
                            </div>

                            <div class="stat-number">
                                {{ $totalMobils }}
                            </div>

                        </div>


                        <div class="stat-icon">

                            <i class="bi bi-car-front-fill"></i>

                        </div>

                    </div>


                    <div class="stat-bottom">

                        <i class="bi bi-check-circle me-1"></i>

                        Kendaraan terdaftar

                    </div>

                </div>

            </div>



            {{-- AVAILABLE --}}

            <div class="col-6 col-xl-3">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Tersedia
                            </div>

                            <div class="stat-number text-success">
                                {{ $mobilTersedia }}
                            </div>

                        </div>


                        <div class="stat-icon">

                            <i class="bi bi-check2-circle"></i>

                        </div>

                    </div>


                    <div class="stat-bottom">

                        <i class="bi bi-circle-fill me-1"></i>

                        Siap disewakan

                    </div>

                </div>

            </div>



            {{-- RENTED --}}

            <div class="col-6 col-xl-3">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Sedang Disewa
                            </div>

                            <div class="stat-number">
                                {{ $mobilDisewa }}
                            </div>

                        </div>


                        <div class="stat-icon">

                            <i class="bi bi-key-fill"></i>

                        </div>

                    </div>


                    <div class="stat-bottom">

                        <i class="bi bi-activity me-1"></i>

                        Digunakan pelanggan

                    </div>

                </div>

            </div>



            {{-- RENTAL --}}

            <div class="col-6 col-xl-3">

                <div class="stat-card">

                    <div class="stat-top">

                        <div>

                            <div class="stat-label">
                                Total Rental
                            </div>

                            <div class="stat-number">
                                {{ $totalRental }}
                            </div>

                        </div>


                        <div class="stat-icon">

                            <i class="bi bi-calendar-check-fill"></i>

                        </div>

                    </div>


                    <div class="stat-bottom">

                        <i class="bi bi-arrow-up-right me-1"></i>

                        Pengajuan pelanggan

                    </div>

                </div>

            </div>


        </div>

    </section>



    {{-- ======================================================
         MANAGEMENT
    ======================================================= --}}

    <section class="section">


        <div class="section-head">

            <div>

                <div class="eyebrow">
                    Workspace
                </div>

                <h2 class="section-title">
                    Semua yang kamu butuhkan.
                </h2>

                <div class="section-description">
                    Akses cepat ke seluruh modul RentalKu.
                </div>

            </div>

        </div>



        <div class="management">


            {{-- MOBIL --}}

            <a
                href="{{ route('staff.mobils.index') }}"
                class="manage-card large"
            >

                <span class="manage-number">
                    01
                </span>


                <div class="manage-icon">

                    <i class="bi bi-car-front-fill"></i>

                </div>


                <div class="manage-title">
                    Management Mobil
                </div>


                <div class="manage-description">

                    Kelola seluruh armada RentalKu,
                    mulai dari data kendaraan, harga,
                    stok, hingga status kendaraan.

                </div>


                <div class="manage-arrow">

                    <i class="bi bi-arrow-up-right"></i>

                </div>

            </a>



            {{-- BRAND --}}

            <a
                href="{{ route('brands.index') }}"
                class="manage-card"
            >

                <span class="manage-number">
                    02
                </span>

                <div class="manage-icon">
                    <i class="bi bi-tags-fill"></i>
                </div>

                <div class="manage-title">
                    Kategori & Merek
                </div>

                <div class="manage-description">
                    Kelola brand dan kategori mobil.
                </div>

                <div class="manage-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </a>



            {{-- FASILITAS --}}

            <a
                href="{{ route('fasilitas.index') }}"
                class="manage-card"
            >

                <span class="manage-number">
                    03
                </span>

                <div class="manage-icon">
                    <i class="bi bi-stars"></i>
                </div>

                <div class="manage-title">
                    Fasilitas
                </div>

                <div class="manage-description">
                    Kelola fasilitas kendaraan.
                </div>

                <div class="manage-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </a>



            {{-- USER --}}

            <a
                href="{{ route('users.index') }}"
                class="manage-card"
            >

                <span class="manage-number">
                    04
                </span>

                <div class="manage-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div class="manage-title">
                    Pengguna
                </div>

                <div class="manage-description">
                    Kelola akun RentalKu.
                </div>

                <div class="manage-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </a>



            {{-- RENTAL --}}

            <a
                href="{{ route('rentals.index') }}"
                class="manage-card"
            >

                <span class="manage-number">
                    05
                </span>

                <div class="manage-icon">
                    <i class="bi bi-calendar2-check-fill"></i>
                </div>

                <div class="manage-title">
                    Rental
                </div>

                <div class="manage-description">
                    Kelola pengajuan rental.
                </div>

                <div class="manage-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </a>



            {{-- PEMBAYARAN --}}

            <a
                href="{{ route('pembayarans.index') }}"
                class="manage-card"
            >

                <span class="manage-number">
                    06
                </span>

                <div class="manage-icon">
                    <i class="bi bi-credit-card-fill"></i>
                </div>

                <div class="manage-title">
                    Pembayaran
                </div>

                <div class="manage-description">
                    Kelola transaksi pelanggan.
                </div>

                <div class="manage-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </a>



            {{-- PEMERIKSAAN --}}

            <a
                href="{{ route('pemeriksaan-kendaraan.index') }}"
                class="manage-card"
            >

                <span class="manage-number">
                    07
                </span>

                <div class="manage-icon">
                    <i class="bi bi-clipboard2-check-fill"></i>
                </div>

                <div class="manage-title">
                    Pemeriksaan
                </div>

                <div class="manage-description">
                    Cek kondisi kendaraan.
                </div>

                <div class="manage-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </a>



            {{-- PROMO --}}

            <a
                href="{{ route('kupons.index') }}"
                class="manage-card"
            >

                <span class="manage-number">
                    08
                </span>

                <div class="manage-icon">
                    <i class="bi bi-ticket-perforated-fill"></i>
                </div>

                <div class="manage-title">
                    Promo
                </div>

                <div class="manage-description">
                    Kelola promo dan kupon.
                </div>

                <div class="manage-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </a>



            {{-- BANNER --}}

            <a
                href="{{ route('banners.index') }}"
                class="manage-card"
            >

                <span class="manage-number">
                    09
                </span>

                <div class="manage-icon">
                    <i class="bi bi-images"></i>
                </div>

                <div class="manage-title">
                    Banner
                </div>

                <div class="manage-description">
                    Kelola banner website.
                </div>

                <div class="manage-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </a>



            {{-- LAPORAN --}}

            <a
                href="{{ route('laporan.index') }}"
                class="manage-card"
            >

                <span class="manage-number">
                    10
                </span>

                <div class="manage-icon">
                    <i class="bi bi-bar-chart-fill"></i>
                </div>

                <div class="manage-title">
                    Laporan
                </div>

                <div class="manage-description">
                    Lihat laporan RentalKu.
                </div>

                <div class="manage-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>

            </a>


        </div>

    </section>



    {{-- ======================================================
         FLEET
    ======================================================= --}}

    <section class="section">


        <div class="section-head">

            <div>

                <div class="eyebrow">
                    Fleet Overview
                </div>

                <h2 class="section-title">
                    Armada terbaru
                </h2>

                <div class="section-description">
                    Kondisi kendaraan yang baru ditambahkan.
                </div>

            </div>


            <a
                href="{{ route('staff.mobils.index') }}"
                class="view-all"
            >

                Lihat semua

                <i class="bi bi-arrow-up-right"></i>

            </a>

        </div>



        <div class="row g-4">


            {{-- TABLE --}}

            <div class="col-xl-8">


                <div class="fleet-card">


                    <div class="fleet-header">

                        <div>

                            <div class="fleet-title">
                                Daftar Kendaraan
                            </div>

                            <div class="fleet-subtitle">
                                Informasi armada RentalKu
                            </div>

                        </div>


                        <i
                            class="bi bi-three-dots"
                            style="
                                color:#a4ada8;
                            "
                        ></i>

                    </div>



                    @if($mobils->count())


                        <div class="table-responsive">


                            <table class="fleet-table">


                                <thead>

                                    <tr>

                                        <th>
                                            Kendaraan
                                        </th>

                                        <th>
                                            Tahun
                                        </th>

                                        <th>
                                            Harga
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>


                                    @foreach($mobils as $mobil)


                                        <tr>


                                            <td>

                                                <div class="fleet-name">


                                                    <div class="fleet-car-icon">

                                                        <i class="bi bi-car-front-fill"></i>

                                                    </div>


                                                    <div>

                                                        <div class="fleet-car-name">

                                                            {{ $mobil->name }}

                                                        </div>


                                                        <div class="fleet-car-info">

                                                            Armada RentalKu

                                                        </div>

                                                    </div>


                                                </div>

                                            </td>


                                            <td>

                                                {{ $mobil->tahun }}

                                            </td>


                                            <td>

                                                <span class="fleet-price">

                                                    Rp
                                                    {{ number_format(
                                                        $mobil->harga_perhari,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}

                                                </span>

                                            </td>


                                            <td>


                                                @if($mobil->status === 'Tersedia')


                                                    <span
                                                        class="status status-available"
                                                    >
                                                        Tersedia
                                                    </span>


                                                @elseif($mobil->status === 'Disewa')


                                                    <span
                                                        class="status status-rented"
                                                    >
                                                        Disewa
                                                    </span>


                                                @else


                                                    <span
                                                        class="status status-maintenance"
                                                    >
                                                        Maintenance
                                                    </span>


                                                @endif


                                            </td>


                                        </tr>


                                    @endforeach


                                </tbody>


                            </table>


                        </div>


                    @else


                        <div class="text-center py-5">

                            <i
                                class="bi bi-car-front"
                                style="
                                    font-size:42px;
                                    color:#c7cfcb;
                                "
                            ></i>


                            <div
                                class="fw-bold mt-3"
                                style="font-size:12px;"
                            >
                                Belum ada kendaraan
                            </div>


                            <div
                                class="text-muted mt-1"
                                style="font-size:9px;"
                            >
                                Data kendaraan belum tersedia.
                            </div>

                        </div>


                    @endif


                </div>


            </div>



            {{-- SUMMARY --}}

            <div class="col-xl-4">


                <div class="info-card">


                    <div class="info-label">
                        Operational Summary
                    </div>


                    <div class="info-title">

                        Kondisi armada
                        RentalKu saat ini.

                    </div>


                    <div class="info-list">


                        <div class="info-row">

                            <div class="info-row-icon">

                                <i class="bi bi-car-front-fill"></i>

                            </div>


                            <div>

                                <div class="info-row-label">
                                    Total kendaraan
                                </div>

                                <div class="info-row-value">
                                    {{ $totalMobils }} Unit
                                </div>

                            </div>

                        </div>



                        <div class="info-row">

                            <div class="info-row-icon">

                                <i class="bi bi-check-lg"></i>

                            </div>


                            <div>

                                <div class="info-row-label">
                                    Kendaraan tersedia
                                </div>

                                <div class="info-row-value">
                                    {{ $mobilTersedia }} Unit
                                </div>

                            </div>

                        </div>



                        <div class="info-row">

                            <div class="info-row-icon">

                                <i class="bi bi-key-fill"></i>

                            </div>


                            <div>

                                <div class="info-row-label">
                                    Sedang disewa
                                </div>

                                <div class="info-row-value">
                                    {{ $mobilDisewa }} Unit
                                </div>

                            </div>

                        </div>



                        <div class="info-row">

                            <div class="info-row-icon">

                                <i class="bi bi-calendar-check"></i>

                            </div>


                            <div>

                                <div class="info-row-label">
                                    Total rental
                                </div>

                                <div class="info-row-value">
                                    {{ $totalRental }} Pengajuan
                                </div>

                            </div>

                        </div>


                    </div>


                </div>

            </div>


        </div>

    </section>


    <div class="bottom-space"></div>


</main>



{{-- ==========================================================
     PROFILE MODAL
========================================================== --}}

@include('layouts.partials.profile-modal')



{{-- ==========================================================
     FOOTER
========================================================== --}}

@include(
    'layouts.partials.admin-footer',
    ['pageTitle' => 'Staff Dashboard']
)



{{-- Bootstrap --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>