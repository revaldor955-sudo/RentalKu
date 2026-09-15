<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


<style>

/* =========================================================
   ROOT
========================================================= */

:root {

    --rk-bg: #050907;
    --rk-bg-2: #08100c;

    --rk-card: rgba(13, 22, 17, .82);
    --rk-card-2: rgba(17, 29, 22, .92);

    --rk-green: #36ff91;
    --rk-green-2: #16d86e;
    --rk-green-dark: #0b9d4d;

    --rk-text: #f3fff8;
    --rk-text-soft: #b9c9c0;
    --rk-muted: #77877e;

    --rk-border: rgba(89, 255, 151, .15);

}


/* =========================================================
   BODY
========================================================= */

html {
    scroll-behavior: smooth;
}

body {

    margin: 0;

    background:
        radial-gradient(
            circle at 10% 0%,
            rgba(31, 255, 130, .10),
            transparent 28%
        ),

        radial-gradient(
            circle at 90% 10%,
            rgba(0, 255, 149, .08),
            transparent 25%
        ),

        linear-gradient(
            135deg,
            #050907 0%,
            #08110c 45%,
            #030604 100%
        );

    color: var(--rk-text);

    font-family:
        'Plus Jakarta Sans',
        sans-serif;

    min-height: 100vh;

    overflow-x: hidden;

}


/* =========================================================
   BACKGROUND GRID
========================================================= */

body::before {

    content: "";

    position: fixed;

    inset: 0;

    pointer-events: none;

    z-index: -2;

    opacity: .20;

    background-image:

        linear-gradient(
            rgba(78,255,150,.05) 1px,
            transparent 1px
        ),

        linear-gradient(
            90deg,
            rgba(78,255,150,.05) 1px,
            transparent 1px
        );

    background-size: 55px 55px;

}


/* =========================================================
   GLOW ORBS
========================================================= */

body::after {

    content: "";

    position: fixed;

    width: 420px;

    height: 420px;

    right: -180px;

    top: 100px;

    border-radius: 50%;

    background: rgba(39,255,130,.08);

    filter: blur(90px);

    pointer-events: none;

    z-index: -1;

}


/* =========================================================
   NAVBAR
========================================================= */

.navbar {

    background:
        rgba(4, 10, 7, .82) !important;

    border-bottom:
        1px solid
        rgba(76,255,148,.12) !important;

    backdrop-filter:
        blur(20px);

}


/* =========================================================
   MAIN CONTAINER
========================================================= */

.container {

    max-width: 1450px;

}


/* =========================================================
   HERO
========================================================= */

.rk-hero {

    position: relative;

    overflow: hidden;

    margin-top: 35px;

    padding: 50px;

    min-height: 310px;

    border-radius: 32px;

    background:

        radial-gradient(
            circle at 85% 35%,
            rgba(46,255,137,.22),
            transparent 27%
        ),

        linear-gradient(
            135deg,
            #101b15,
            #07100b 55%,
            #0c2a19
        );

    border:
        1px solid
        rgba(78,255,150,.18);

    box-shadow:

        0 30px 80px
        rgba(0,0,0,.45),

        inset 0 1px 0
        rgba(255,255,255,.05);

    animation:
        rkFadeUp .8s ease both;

}


.rk-hero::before {

    content: "";

    position: absolute;

    width: 500px;

    height: 500px;

    right: -180px;

    top: -230px;

    border-radius: 50%;

    border:
        1px solid
        rgba(54,255,145,.18);

    box-shadow:

        0 0 100px
        rgba(54,255,145,.10);

}


.rk-hero::after {

    content: "";

    position: absolute;

    width: 220px;

    height: 220px;

    right: 80px;

    bottom: -130px;

    border-radius: 50%;

    background:
        rgba(54,255,145,.08);

    filter:
        blur(30px);

}


.rk-hero-content {

    position: relative;

    z-index: 2;

}


.rk-admin-badge {

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 9px 15px;

    border-radius: 999px;

    background:
        rgba(54,255,145,.10);

    border:
        1px solid
        rgba(54,255,145,.25);

    color:
        var(--rk-green);

    font-size: 12px;

    font-weight: 800;

    letter-spacing: 1.5px;

    text-transform: uppercase;

    box-shadow:
        0 0 25px
        rgba(54,255,145,.10);

}


.rk-admin-badge i {

    font-size: 16px;

    filter:
        drop-shadow(
            0 0 7px
            var(--rk-green)
        );

}


.rk-hero h1 {

    margin-top: 20px;

    margin-bottom: 0;

    color: #ffffff;

    font-size: clamp(32px, 4vw, 58px);

    font-weight: 800;

    letter-spacing: -2px;

}


.rk-hero h1 span {

    color:
        var(--rk-green);

    text-shadow:
        0 0 25px
        rgba(54,255,145,.45);

}


.rk-hero p {

    max-width: 720px;

    margin-top: 18px;

    color:
        #9caf9f;

    font-size: 15px;

    line-height: 1.8;

}


.rk-hero-icon {

    position: relative;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    width: 180px;

    height: 180px;

    border-radius: 50%;

    background:
        rgba(54,255,145,.06);

    border:
        1px solid
        rgba(54,255,145,.16);

    box-shadow:

        0 0 40px
        rgba(54,255,145,.10),

        inset 0 0 40px
        rgba(54,255,145,.05);

}


.rk-hero-icon i {

    color:
        var(--rk-green);

    font-size: 85px;

    filter:

        drop-shadow(
            0 0 8px
            var(--rk-green)
        )

        drop-shadow(
            0 0 28px
            rgba(54,255,145,.7)
        );

    animation:
        rkPulse 2.5s ease-in-out infinite;

}


/* =========================================================
   SECTION
========================================================= */

.rk-section {

    margin-top: 55px;

}


.rk-section-title {

    color: #ffffff;

    font-size: 25px;

    font-weight: 800;

    letter-spacing: -.6px;

}


.rk-section-subtitle {

    color:
        var(--rk-muted);

    font-size: 13px;

}


/* =========================================================
   STAT CARDS
========================================================= */

.rk-stat {

    position: relative;

    overflow: hidden;

    height: 100%;

    padding: 25px;

    border-radius: 22px;

    background:
        linear-gradient(
            145deg,
            rgba(20,32,25,.95),
            rgba(8,14,11,.95)
        );

    border:
        1px solid
        var(--rk-border);

    box-shadow:
        0 15px 40px
        rgba(0,0,0,.28);

    transition:
        transform .35s ease,
        border-color .35s ease,
        box-shadow .35s ease;

    animation:
        rkFadeUp .7s ease both;

}


.rk-stat::before {

    content: "";

    position: absolute;

    width: 130px;

    height: 130px;

    right: -55px;

    top: -55px;

    border-radius: 50%;

    background:
        rgba(54,255,145,.09);

    filter:
        blur(10px);

}


.rk-stat:hover {

    transform:
        translateY(-8px);

    border-color:
        rgba(54,255,145,.38);

    box-shadow:

        0 20px 50px
        rgba(0,0,0,.4),

        0 0 35px
        rgba(54,255,145,.08);

}


.rk-stat-icon {

    width: 58px;

    height: 58px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 17px;

    background:
        rgba(54,255,145,.10);

    border:
        1px solid
        rgba(54,255,145,.18);

    color:
        var(--rk-green);

    font-size: 25px;

    box-shadow:
        0 0 22px
        rgba(54,255,145,.10);

}


.rk-stat-icon i {

    filter:
        drop-shadow(
            0 0 6px
            rgba(54,255,145,.8)
        );

}


.rk-stat-label {

    margin-top: 18px;

    color:
        #819188;

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 1px;

}


.rk-stat-number {

    margin-top: 4px;

    color:
        #ffffff;

    font-size: 31px;

    font-weight: 800;

}


.rk-stat-number.green {

    color:
        var(--rk-green);

    text-shadow:
        0 0 18px
        rgba(54,255,145,.28);

}


/* =========================================================
   MANAGEMENT CARDS
========================================================= */

.rk-menu-card {

    position: relative;

    display: block;

    height: 100%;

    padding: 25px;

    overflow: hidden;

    text-decoration: none;

    border-radius: 22px;

    background:
        linear-gradient(
            145deg,
            rgba(16,27,21,.94),
            rgba(7,13,10,.96)
        );

    border:
        1px solid
        rgba(255,255,255,.07);

    box-shadow:
        0 12px 35px
        rgba(0,0,0,.28);

    transition:
        transform .35s ease,
        border-color .35s ease,
        box-shadow .35s ease;

}


.rk-menu-card::after {

    content: "↗";

    position: absolute;

    top: 20px;

    right: 22px;

    color:
        #506158;

    font-size: 20px;

    transition:
        .3s ease;

}


.rk-menu-card:hover {

    transform:
        translateY(-9px);

    border-color:
        rgba(54,255,145,.38);

    box-shadow:

        0 22px 55px
        rgba(0,0,0,.42),

        0 0 35px
        rgba(54,255,145,.08);

}


.rk-menu-card:hover::after {

    color:
        var(--rk-green);

    transform:
        translate(3px,-3px);

    text-shadow:
        0 0 10px
        var(--rk-green);

}


.rk-menu-icon {

    width: 62px;

    height: 62px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin-bottom: 20px;

    border-radius: 18px;

    color:
        var(--rk-green);

    background:
        linear-gradient(
            145deg,
            rgba(54,255,145,.16),
            rgba(54,255,145,.04)
        );

    border:
        1px solid
        rgba(54,255,145,.22);

    font-size: 27px;

    box-shadow:

        0 0 22px
        rgba(54,255,145,.10);

    transition:
        .35s ease;

}


.rk-menu-card:hover .rk-menu-icon {

    transform:
        scale(1.08)
        rotate(-3deg);

    box-shadow:

        0 0 20px
        rgba(54,255,145,.22),

        inset 0 0 20px
        rgba(54,255,145,.08);

}


.rk-menu-icon i {

    filter:
        drop-shadow(
            0 0 7px
            rgba(54,255,145,.8)
        );

}


.rk-menu-card h5 {

    color:
        #ffffff;

    font-size: 16px;

    font-weight: 800;

}


.rk-menu-card p {

    color:
        #75857c;

    font-size: 12px;

    line-height: 1.7;

}


/* =========================================================
   TABLE WRAPPER
========================================================= */

.rk-table-card {

    overflow: hidden;

    border-radius: 25px;

    background:
        #0b120e !important;

    border:
        1px solid
        rgba(54,255,145,.13) !important;

    box-shadow:

        0 20px 60px
        rgba(0,0,0,.35);

}


/* =========================================================
   TABLE - FIX TULISAN TIDAK KELIHATAN
========================================================= */

.rk-table {

    width: 100%;

    margin: 0 !important;

    color:
        #dce9e2 !important;

    background:
        #0b120e !important;

}


/* Semua cell dipaksa gelap + tulisan terang */

.rk-table > :not(caption) > * > * {

    background:
        #0b120e !important;

    color:
        #dce9e2 !important;

    border-bottom:
        1px solid
        rgba(255,255,255,.06) !important;

}


/* HEADER */

.rk-table thead th {

    padding:
        20px 18px !important;

    background:
        #101b15 !important;

    color:
        #788b81 !important;

    border-bottom:
        1px solid
        rgba(54,255,145,.12) !important;

    font-size: 11px !important;

    font-weight: 800 !important;

    letter-spacing: 1.2px;

    text-transform: uppercase;

    white-space: nowrap;

}


/* BODY */

.rk-table tbody td {

    padding:
        20px 18px !important;

    color:
        #c8d7cf !important;

    background:
        #0b120e !important;

    font-size: 13px;

    vertical-align: middle;

}


/* STRONG / NAMA MOBIL */

.rk-table tbody td strong {

    color:
        #ffffff !important;

    font-weight: 700;

}


/* Hover */

.rk-table tbody tr {

    transition:
        background .25s ease;

}


.rk-table tbody tr:hover td {

    background:
        #101b15 !important;

    color:
        #ffffff !important;

}


/* Harga */

.rk-price {

    color:
        #dfffee !important;

    font-weight: 700;

}


/* Image */

.rk-car-image {

    width: 58px;

    height: 45px;

    object-fit: cover;

    border-radius: 11px;

    border:
        1px solid
        rgba(54,255,145,.16);

    box-shadow:
        0 0 18px
        rgba(0,0,0,.4);

}


.rk-car-placeholder {

    width: 58px;

    height: 45px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 11px;

    background:
        #142019;

    border:
        1px solid
        rgba(54,255,145,.12);

    color:
        #53655b;

}


/* =========================================================
   STATUS
========================================================= */

.rk-status {

    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 8px 13px;

    border-radius: 999px;

    font-size: 11px;

    font-weight: 800;

}


.rk-status::before {

    content: "";

    width: 7px;

    height: 7px;

    border-radius: 50%;

}


.rk-status-available {

    color:
        #35ff91;

    background:
        rgba(54,255,145,.09);

    border:
        1px solid
        rgba(54,255,145,.18);

}


.rk-status-available::before {

    background:
        #36ff91;

    box-shadow:
        0 0 10px
        #36ff91;

}


.rk-status-rented {

    color:
        #ffd76a;

    background:
        rgba(255,200,70,.08);

    border:
        1px solid
        rgba(255,200,70,.18);

}


.rk-status-rented::before {

    background:
        #ffd76a;

}


.rk-status-maintenance {

    color:
        #ff7885;

    background:
        rgba(255,80,100,.08);

    border:
        1px solid
        rgba(255,80,100,.18);

}


.rk-status-maintenance::before {

    background:
        #ff6677;

}


/* =========================================================
   BUTTON
========================================================= */

.rk-btn {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 12px 18px;

    border: 0;

    border-radius: 13px;

    color:
        #041008 !important;

    background:
        linear-gradient(
            135deg,
            #64ffa9,
            #1ee778
        );

    font-size: 12px;

    font-weight: 800;

    text-decoration: none;

    box-shadow:
        0 0 25px
        rgba(54,255,145,.14);

    transition:
        .3s ease;

}


.rk-btn:hover {

    color:
        #041008 !important;

    transform:
        translateY(-3px);

    box-shadow:

        0 10px 30px
        rgba(54,255,145,.22),

        0 0 25px
        rgba(54,255,145,.16);

}


/* =========================================================
   EMPTY
========================================================= */

.rk-empty {

    padding: 70px 20px;

    text-align: center;

}


.rk-empty i {

    color:
        #43564b;

    font-size: 50px;

}


.rk-empty h5 {

    margin-top: 18px;

    color:
        #ffffff;

    font-weight: 800;

}


.rk-empty p {

    color:
        #68786f;

    font-size: 13px;

}


/* =========================================================
   USERS TABLE
========================================================= */

.rk-user-name {

    color:
        #ffffff !important;

    font-weight: 700;

}


.rk-user-email {

    color:
        #a9bbb1 !important;

}


.rk-role {

    display: inline-block;

    padding: 7px 12px;

    border-radius: 999px;

    font-size: 10px;

    font-weight: 800;

    letter-spacing: .5px;

}


.rk-role-admin {

    color:
        #ffffff;

    background:
        rgba(255,255,255,.09);

    border:
        1px solid
        rgba(255,255,255,.13);

}


.rk-role-staff {

    color:
        #6eb8ff;

    background:
        rgba(55,150,255,.10);

    border:
        1px solid
        rgba(55,150,255,.15);

}


.rk-role-customer {

    color:
        #36ff91;

    background:
        rgba(54,255,145,.09);

    border:
        1px solid
        rgba(54,255,145,.16);

}


/* =========================================================
   ANIMATION
========================================================= */

@keyframes rkFadeUp {

    from {

        opacity: 0;

        transform:
            translateY(25px);

    }

    to {

        opacity: 1;

        transform:
            translateY(0);

    }

}


@keyframes rkPulse {

    0%,
    100% {

        transform:
            scale(1);

    }

    50% {

        transform:
            scale(1.08);

    }

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 991px) {

    .rk-hero {

        padding: 35px;

    }

}


@media (max-width: 576px) {

    .rk-hero {

        padding: 27px;

        border-radius: 23px;

    }


    .rk-hero h1 {

        font-size: 32px;

        letter-spacing: -1px;

    }


    .rk-stat {

        padding: 20px;

    }


    .rk-menu-card {

        padding: 21px;

    }


    .rk-section {

        margin-top: 40px;

    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    *,
    *::before,
    *::after {

        animation-duration: .01ms !important;

        animation-iteration-count: 1 !important;

        transition-duration: .01ms !important;

    }

}

</style>

</head>


<body>


{{-- =====================================================
     NAVBAR
===================================================== --}}

@include('layouts.partials.admin-navbar')



<main class="container pb-5">


{{-- =====================================================
     HERO
===================================================== --}}

<section class="rk-hero">

    <div class="row align-items-center">

        <div class="col-lg-8 rk-hero-content">

            <div class="rk-admin-badge">

                <i class="bi bi-shield-fill-check"></i>

                Administrator

            </div>


            <h1>

                Selamat datang,

                <span>
                    {{ Auth::user()->name }}
                </span>

                👋

            </h1>


            <p>

                Kelola seluruh sistem RentalKu melalui
                dashboard administrator. Pantau kendaraan,
                pengguna, rental, pembayaran, pengembalian,
                hingga laporan dalam satu tempat.

            </p>

        </div>


        <div class="col-lg-4 text-center d-none d-lg-block">

            <div class="rk-hero-icon">

                <i class="bi bi-speedometer2"></i>

            </div>

        </div>

    </div>

</section>



{{-- =====================================================
     STATISTIK UTAMA
===================================================== --}}

<section class="rk-section">

    <div class="row g-4">


        {{-- TOTAL USERS --}}

        <div class="col-md-6 col-xl-3">

            <div class="rk-stat">

                <div class="rk-stat-icon">

                    <i class="bi bi-people-fill"></i>

                </div>

                <div class="rk-stat-label">

                    Total Pengguna

                </div>

                <div class="rk-stat-number">

                    {{ $totalUsers }}

                </div>

            </div>

        </div>


        {{-- TOTAL MOBIL --}}

        <div class="col-md-6 col-xl-3">

            <div class="rk-stat">

                <div class="rk-stat-icon">

                    <i class="bi bi-car-front-fill"></i>

                </div>

                <div class="rk-stat-label">

                    Total Mobil

                </div>

                <div class="rk-stat-number">

                    {{ $totalMobils }}

                </div>

            </div>

        </div>


        {{-- MOBIL TERSEDIA --}}

        <div class="col-md-6 col-xl-3">

            <div class="rk-stat">

                <div class="rk-stat-icon">

                    <i class="bi bi-check-circle-fill"></i>

                </div>

                <div class="rk-stat-label">

                    Mobil Tersedia

                </div>

                <div class="rk-stat-number green">

                    {{ $mobilTersedia }}

                </div>

            </div>

        </div>


        {{-- CABANG --}}

        <div class="col-md-6 col-xl-3">

            <div class="rk-stat">

                <div class="rk-stat-icon">

                    <i class="bi bi-buildings-fill"></i>

                </div>

                <div class="rk-stat-label">

                    Total Cabang

                </div>

                <div class="rk-stat-number">

                    {{ $totalCabang }}

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =====================================================
     STATUS KENDARAAN
===================================================== --}}

<section class="rk-section">

    <div class="row g-4">


        {{-- TERSEDIA --}}

        <div class="col-md-4">

            <div class="rk-stat">

                <div class="d-flex align-items-center gap-3">

                    <div class="rk-stat-icon">

                        <i class="bi bi-check2-circle"></i>

                    </div>

                    <div>

                        <div class="rk-stat-label mt-0">

                            Tersedia

                        </div>

                        <div class="rk-stat-number green">

                            {{ $mobilTersedia }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- DISEWA --}}

        <div class="col-md-4">

            <div class="rk-stat">

                <div class="d-flex align-items-center gap-3">

                    <div class="rk-stat-icon">

                        <i class="bi bi-key-fill"></i>

                    </div>

                    <div>

                        <div class="rk-stat-label mt-0">

                            Sedang Disewa

                        </div>

                        <div class="rk-stat-number">

                            {{ $mobilDisewa }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- MAINTENANCE --}}

        <div class="col-md-4">

            <div class="rk-stat">

                <div class="d-flex align-items-center gap-3">

                    <div class="rk-stat-icon">

                        <i class="bi bi-tools"></i>

                    </div>

                    <div>

                        <div class="rk-stat-label mt-0">

                            Maintenance

                        </div>

                        <div class="rk-stat-number">

                            {{ $mobilMaintenance }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =====================================================
     MANAGEMENT
===================================================== --}}

<section class="rk-section">

    <div class="mb-4">

        <h3 class="rk-section-title mb-1">

            Management Sistem

        </h3>

        <p class="rk-section-subtitle mb-0">

            Pusat kontrol seluruh fitur administrasi RentalKu.

        </p>

    </div>


    <div class="row g-4">


        {{-- MOBIL --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('mobils.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-car-front-fill"></i>

                </div>

                <h5>

                    Management Mobil

                </h5>

                <p class="mb-0">

                    Kelola seluruh data kendaraan RentalKu.

                </p>

            </a>

        </div>


        {{-- BRAND --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('brands.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-tags-fill"></i>

                </div>

                <h5>

                    Kategori & Merek

                </h5>

                <p class="mb-0">

                    Kelola tipe dan merek mobil.

                </p>

            </a>

        </div>


        {{-- FASILITAS --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('fasilitas.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-stars"></i>

                </div>

                <h5>

                    Management Fasilitas

                </h5>

                <p class="mb-0">

                    Kelola fasilitas kendaraan.

                </p>

            </a>

        </div>


        {{-- USERS --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('users.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-people-fill"></i>

                </div>

                <h5>

                    Management Pengguna

                </h5>

                <p class="mb-0">

                    Kelola akun pengguna RentalKu.

                </p>

            </a>

        </div>


        {{-- PROMO --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('kupons.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-ticket-perforated-fill"></i>

                </div>

                <h5>

                    Management Promo

                </h5>

                <p class="mb-0">

                    Kelola promo dan kupon.

                </p>

            </a>

        </div>


        {{-- BANNER --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('banners.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-images"></i>

                </div>

                <h5>

                    Management Banner

                </h5>

                <p class="mb-0">

                    Kelola banner halaman utama.

                </p>

            </a>

        </div>


        {{-- RENTAL --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('rentals.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-car-front-fill"></i>

                </div>

                <h5>

                    Management Rental

                </h5>

                <p class="mb-0">

                    Kelola pengajuan sewa mobil pelanggan.

                </p>

            </a>

        </div>


        {{-- PEMBAYARAN --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('pembayarans.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-credit-card-fill"></i>

                </div>

                <h5>

                    Management Pembayaran

                </h5>

                <p class="mb-0">

                    Kelola pembayaran rental pelanggan.

                </p>

            </a>

        </div>


        {{-- PENGEMBALIAN --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('pengembalian.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-arrow-return-left"></i>

                </div>

                <h5>

                    Pengembalian Mobil

                </h5>

                <p class="mb-0">

                    Kelola proses pengembalian kendaraan.

                </p>

            </a>

        </div>


        {{-- PEMERIKSAAN --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('pemeriksaan-kendaraan.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-clipboard2-check-fill"></i>

                </div>

                <h5>

                    Pemeriksaan Kendaraan

                </h5>

                <p class="mb-0">

                    Pemeriksaan kondisi kendaraan.

                </p>

            </a>

        </div>


        {{-- LAPORAN --}}

        <div class="col-md-6 col-lg-3">

            <a
                href="{{ route('laporan.index') }}"
                class="rk-menu-card"
            >

                <div class="rk-menu-icon">

                    <i class="bi bi-file-earmark-bar-graph-fill"></i>

                </div>

                <h5>

                    Laporan

                </h5>

                <p class="mb-0">

                    Laporan aktivitas RentalKu.

                </p>

            </a>

        </div>

    </div>

</section>



{{-- =====================================================
     MOBIL TERBARU
===================================================== --}}

<section class="rk-section">

    <div class="d-flex justify-content-between align-items-end mb-4">

        <div>

            <div class="rk-admin-badge mb-3">

                <i class="bi bi-car-front-fill"></i>

                Vehicle Monitor

            </div>

            <h3 class="rk-section-title mb-1">

                Mobil Terbaru

            </h3>

            <p class="rk-section-subtitle mb-0">

                Kendaraan terbaru yang ditambahkan ke sistem RentalKu.

            </p>

        </div>


        <a
            href="{{ route('mobils.index') }}"
            class="rk-btn"
        >

            Lihat Semua

            <i class="bi bi-arrow-up-right"></i>

        </a>

    </div>



    <div class="rk-table-card">

        @if($mobils->count())

            <div class="table-responsive">

                <table class="table rk-table align-middle">

                    <thead>

                        <tr>

                            <th class="px-4">

                                Mobil

                            </th>

                            <th>

                                Brand

                            </th>

                            <th>

                                Cabang

                            </th>

                            <th>

                                Tahun

                            </th>

                            <th>

                                Harga / Hari

                            </th>

                            <th>

                                Status

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($mobils as $mobil)

                            <tr>

                                <td class="px-4">

                                    <div
                                        class="d-flex align-items-center gap-3"
                                    >

                                        @if($mobil->image)

                                            <img
                                                src="{{ asset($mobil->image) }}"
                                                class="rk-car-image"
                                                alt="{{ $mobil->name }}"
                                            >

                                        @else

                                            <div class="rk-car-placeholder">

                                                <i class="bi bi-car-front-fill"></i>

                                            </div>

                                        @endif


                                        <strong>

                                            {{ $mobil->name }}

                                        </strong>

                                    </div>

                                </td>


                                <td>

                                    {{ $mobil->brand->name ?? '-' }}

                                </td>


                                <td>

                                    {{ $mobil->cabang->name ?? '-' }}

                                </td>


                                <td>

                                    {{ $mobil->tahun }}

                                </td>


                                <td class="rk-price">

                                    Rp
                                    {{ number_format($mobil->harga_perhari, 0, ',', '.') }}

                                </td>


                                <td>

                                    @if($mobil->status === 'Tersedia')

                                        <span class="rk-status rk-status-available">

                                            Tersedia

                                        </span>

                                    @elseif($mobil->status === 'Disewa')

                                        <span class="rk-status rk-status-rented">

                                            Disewa

                                        </span>

                                    @else

                                        <span class="rk-status rk-status-maintenance">

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

            <div class="rk-empty">

                <i class="bi bi-car-front"></i>

                <h5>

                    Belum ada data mobil

                </h5>

                <p>

                    Data mobil akan muncul setelah ditambahkan.

                </p>

            </div>

        @endif

    </div>

</section>



{{-- =====================================================
     PENGGUNA TERBARU
===================================================== --}}

<section class="rk-section">

    <div class="mb-4">

        <div class="rk-admin-badge mb-3">

            <i class="bi bi-people-fill"></i>

            User Monitor

        </div>

        <h3 class="rk-section-title mb-1">

            Pengguna Terbaru

        </h3>

        <p class="rk-section-subtitle mb-0">

            Pengguna terbaru yang terdaftar di RentalKu.

        </p>

    </div>



    <div class="rk-table-card">

        <div class="table-responsive">

            <table class="table rk-table rk-users-table align-middle">

                <thead>

                    <tr>

                        <th class="px-4">

                            Pengguna

                        </th>

                        <th>

                            Email

                        </th>

                        <th>

                            Role

                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($users as $user)

                        <tr>

                            <td class="px-4">

                                <div class="d-flex align-items-center gap-3">

                                    <div class="rk-stat-icon">

                                        <i class="bi bi-person-fill"></i>

                                    </div>

                                    <span class="rk-user-name">

                                        {{ $user->name }}

                                    </span>

                                </div>

                            </td>


                            <td class="rk-user-email">

                                {{ $user->email }}

                            </td>


                            <td>

                                @if($user->roles_id == 1)

                                    <span class="rk-role rk-role-admin">

                                        ADMIN

                                    </span>

                                @elseif($user->roles_id == 2)

                                    <span class="rk-role rk-role-staff">

                                        STAFF

                                    </span>

                                @else

                                    <span class="rk-role rk-role-customer">

                                        CUSTOMER

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="3"
                                class="text-center py-5"
                            >

                                <div class="rk-empty py-4">

                                    <i class="bi bi-person-x"></i>

                                    <h5>

                                        Belum ada pengguna

                                    </h5>

                                    <p>

                                        Pengguna yang baru terdaftar
                                        akan muncul di sini.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</section>


</main>



{{-- =====================================================
     FOOTER
===================================================== --}}

@include(
    'layouts.partials.admin-footer',
    ['pageTitle' => 'Administrator Dashboard']
)



<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>