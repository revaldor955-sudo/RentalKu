<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fleet Management - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f4f6f5;
            color: #17201c;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .topbar {
            height: 76px;
            background: rgba(255,255,255,.94);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid #e8ece9;
            display: flex;
            align-items: center;
        }

        .brand {
            text-decoration: none;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #17201c;
        }

        .brand span {
            color: #198754;
        }

        .topbar-link {
            text-decoration: none;
            color: #66716c;
            font-size: 13px;
            font-weight: 700;
            padding: 9px 14px;
            border-radius: 10px;
            transition: .2s;
        }

        .topbar-link:hover {
            background: #eef6f1;
            color: #198754;
        }

        .logout-btn {
            border: 1px solid #e6e9e7;
            background: white;
            color: #65706b;
            border-radius: 10px;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 700;
        }

        .logout-btn:hover {
            background: #fff5f5;
            border-color: #f1c7cb;
            color: #b02a37;
        }

        .page-wrapper {
            max-width: 1450px;
            margin: auto;
            padding: 38px 24px 60px;
        }

        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #929b96;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .breadcrumb-custom a {
            color: #6d7772;
            text-decoration: none;
        }

        .breadcrumb-custom a:hover {
            color: #198754;
        }

        .hero-title {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 30px;
        }

        .hero-title h1 {
            margin: 0;
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .hero-title p {
            margin: 7px 0 0;
            color: #7b8580;
            font-size: 14px;
        }

        .hero-actions {
            display: flex;
            gap: 10px;
        }

        .btn-dashboard {
            height: 46px;
            padding: 0 17px;
            border: 1px solid #dfe5e1;
            background: white;
            color: #58635e;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-dashboard:hover {
            color: #198754;
            border-color: #b9d9c7;
            background: #f6fbf8;
        }

        .btn-add {
            height: 46px;
            padding: 0 18px;
            border: none;
            background: #198754;
            color: white;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 18px rgba(25,135,84,.18);
        }

        .btn-add:hover {
            background: #146c43;
            color: white;
            transform: translateY(-1px);
        }

        .overview-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .overview-card {
            position: relative;
            overflow: hidden;
            background: white;
            border: 1px solid #e8edea;
            border-radius: 18px;
            padding: 20px;
            min-height: 125px;
            box-shadow: 0 7px 25px rgba(21,39,30,.035);
        }

        .overview-card::after {
            content: "";
            position: absolute;
            width: 90px;
            height: 90px;
            right: -35px;
            bottom: -35px;
            border-radius: 50%;
            background: #eef8f2;
        }

        .overview-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: #eaf7ef;
            color: #198754;
            font-size: 19px;
            margin-bottom: 13px;
        }

        .overview-label {
            color: #858e89;
            font-size: 12px;
            font-weight: 600;
        }

        .overview-number {
            font-size: 25px;
            font-weight: 800;
            margin-top: 2px;
        }

        .custom-alert {
            border: none;
            border-radius: 14px;
            padding: 15px 18px;
            font-size: 13px;
            box-shadow: 0 5px 18px rgba(0,0,0,.03);
        }

        .fleet-card {
            background: white;
            border: 1px solid #e7ece9;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(21,39,30,.045);
        }

        .fleet-header {
            padding: 22px 24px;
            border-bottom: 1px solid #edf0ee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .fleet-heading {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .fleet-heading-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: #eef8f2;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        .fleet-heading h5 {
            font-size: 15px;
            font-weight: 800;
            margin: 0;
        }

        .fleet-heading p {
            margin: 3px 0 0;
            font-size: 11px;
            color: #969f9a;
        }

        .fleet-count {
            background: #f3f5f4;
            border-radius: 20px;
            padding: 6px 11px;
            font-size: 11px;
            font-weight: 700;
            color: #727c77;
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background: #fafbfa;
            border-bottom: 1px solid #edf0ee;
            border-top: none;
            padding: 14px 17px;
            color: #929a96;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .6px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 17px;
            border-color: #f0f2f1;
            vertical-align: middle;
            font-size: 12px;
            color: #525d57;
        }

        .table tbody tr {
            transition: .18s;
        }

        .table tbody tr:hover {
            background: #fbfdfc;
        }

        .car-info {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 220px;
        }

        .car-photo {
            width: 74px;
            height: 55px;
            border-radius: 11px;
            object-fit: cover;
            background: #edf5f0;
            border: 1px solid #e3ebe6;
        }

        .car-placeholder {
            width: 74px;
            height: 55px;
            border-radius: 11px;
            background: linear-gradient(145deg,#edf8f1,#dff1e7);
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .car-name {
            font-size: 13px;
            font-weight: 800;
            color: #252e29;
            margin-bottom: 3px;
        }

        .car-subtitle {
            color: #9aa29e;
            font-size: 10px;
        }

        .brand-text {
            font-weight: 700;
            color: #46514b;
        }

        .plate {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 7px;
            background: #f4f5f5;
            border: 1px solid #e7e9e8;
            font-size: 11px;
            font-weight: 800;
            color: #424a46;
            letter-spacing: .4px;
        }

        .year {
            font-weight: 700;
        }

        .transmission {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 9px;
            border-radius: 7px;
            background: #f6f7f7;
            color: #69736e;
            font-size: 10px;
            font-weight: 700;
        }

        .price {
            font-size: 12px;
            font-weight: 800;
            color: #198754;
            white-space: nowrap;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 30px;
            padding: 7px 10px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-available {
            background: #eaf7ef;
            color: #198754;
        }

        .status-available .status-dot {
            background: #198754;
        }

        .status-rented {
            background: #fff6dc;
            color: #997404;
        }

        .status-rented .status-dot {
            background: #d9a400;
        }

        .status-maintenance {
            background: #fff0f1;
            color: #b02a37;
        }

        .status-maintenance .status-dot {
            background: #b02a37;
        }

        .action-wrap {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            border: 1px solid #e7ebe8;
            border-radius: 9px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: .18s;
            font-size: 13px;
        }

        .action-edit {
            color: #198754;
        }

        .action-edit:hover {
            background: #eaf7ef;
            border-color: #c5e4d1;
            color: #146c43;
        }

        .action-delete {
            color: #b02a37;
        }

        .action-delete:hover {
            background: #fff0f1;
            border-color: #f0c8cc;
        }

        .empty-state {
            padding: 75px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #edf7f1;
            color: #198754;
            font-size: 31px;
        }

        .empty-state h5 {
            margin-top: 18px;
            font-weight: 800;
            font-size: 16px;
        }

        .empty-state p {
            color: #929b96;
            font-size: 12px;
        }

        .modal-content {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0,0,0,.15);
        }

        .modal-header {
            background: #18211d;
            color: white;
            border: none;
            padding: 22px 25px;
        }

        .modal-title {
            font-size: 16px;
            font-weight: 800;
        }

        .modal-title i {
            color: #58c98c;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: .7;
        }

        .modal-body {
            padding: 25px;
            background: #fff;
        }

        .form-label {
            color: #46514b;
            font-size: 11px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .form-control,
        .form-select {
            min-height: 44px;
            border: 1px solid #e1e6e3;
            border-radius: 11px;
            font-size: 12px;
            padding: 10px 13px;
            color: #303934;
            box-shadow: none !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #8ac9a7;
        }

        .form-control::placeholder {
            color: #b0b7b3;
        }

        textarea.form-control {
            min-height: 95px;
            resize: vertical;
        }

        .modal-footer {
            background: #fafbfa;
            border-top: 1px solid #edf0ee;
            padding: 16px 25px;
        }

        .btn-cancel {
            border: 1px solid #dfe4e1;
            background: white;
            color: #69736e;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 12px;
            font-weight: 700;
        }

        .btn-save {
            border: none;
            background: #198754;
            color: white;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 12px;
            font-weight: 700;
        }

        .btn-save:hover {
            background: #146c43;
            color: white;
        }

        .section-label {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 4px 0 2px;
            color: #198754;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .section-label::after {
            content: "";
            height: 1px;
            background: #edf0ee;
            flex: 1;
        }

        @media(max-width: 1000px) {

            .overview-grid {
                grid-template-columns: 1fr;
            }

            .hero-title {
                align-items: flex-start;
                flex-direction: column;
            }

            .fleet-header {
                align-items: flex-start;
                flex-direction: column;
            }

        }

        @media(max-width: 700px) {

            .page-wrapper {
                padding: 25px 14px 40px;
            }

            .hero-title h1 {
                font-size: 27px;
            }

            .hero-actions {
                width: 100%;
            }

            .hero-actions > * {
                flex: 1;
                justify-content: center;
            }

            .topbar {
                height: auto;
                padding: 15px 0;
            }

            .topbar .container {
                flex-direction: column;
                gap: 13px;
            }

            .car-info {
                min-width: 190px;
            }

        }

    </style>
</head>

<body>

{{-- =========================
     TOPBAR
========================= --}}

<nav class="topbar">

    <div class="container-fluid px-4">

        <div class="d-flex justify-content-between align-items-center w-100">

            <a
                href="{{ route('staff.dashboard') }}"
                class="brand"
            >
                Rental<span>ku</span>.
            </a>

            <div class="d-flex align-items-center gap-2">

                <a
                    href="{{ route('staff.dashboard') }}"
                    class="topbar-link"
                >
                    <i class="bi bi-grid-1x2-fill me-1"></i>
                    Dashboard
                </a>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="m-0"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout-btn"
                    >
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Keluar
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>


{{-- =========================
     PAGE
========================= --}}

<div class="page-wrapper">

    <div class="breadcrumb-custom">

        <a href="{{ route('staff.dashboard') }}">
            Dashboard
        </a>

        <i class="bi bi-chevron-right"></i>

        <span>Management Mobil</span>

    </div>


    <div class="hero-title">

        <div>

            <h1>
                Fleet Management
            </h1>

            <p>
                Kelola seluruh kendaraan yang terdaftar di RentalKu.
            </p>

        </div>


        <div class="hero-actions">

            <a
                href="{{ route('staff.dashboard') }}"
                class="btn-dashboard"
            >
                <i class="bi bi-arrow-left"></i>
                Dashboard
            </a>

            <button
                type="button"
                class="btn-add"
                data-bs-toggle="modal"
                data-bs-target="#tambahMobilModal"
            >
                <i class="bi bi-plus-lg"></i>
                Tambah Mobil
            </button>

        </div>

    </div>


    {{-- =========================
         OVERVIEW
    ========================= --}}

    @php
        $totalMobil = $mobils->count();
        $tersedia = $mobils->filter(function($mobil) {
            return strtolower($mobil->status) === 'tersedia';
        })->count();

        $disewa = $mobils->filter(function($mobil) {
            return strtolower($mobil->status) === 'disewa';
        })->count();
    @endphp


    <div class="overview-grid">

        <div class="overview-card">

            <div class="overview-icon">
                <i class="bi bi-car-front-fill"></i>
            </div>

            <div class="overview-label">
                Total Kendaraan
            </div>

            <div class="overview-number">
                {{ $totalMobil }}
            </div>

        </div>


        <div class="overview-card">

            <div class="overview-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="overview-label">
                Mobil Tersedia
            </div>

            <div class="overview-number">
                {{ $tersedia }}
            </div>

        </div>


        <div class="overview-card">

            <div class="overview-icon">
                <i class="bi bi-key-fill"></i>
            </div>

            <div class="overview-label">
                Sedang Disewa
            </div>

            <div class="overview-number">
                {{ $disewa }}
            </div>

        </div>

    </div>


    {{-- =========================
         ALERT SUCCESS
    ========================= --}}

    @if(session('success'))

        <div class="alert alert-success custom-alert alert-dismissible fade show mb-4">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- =========================
         ALERT ERROR
    ========================= --}}

    @if($errors->any())

        <div class="alert alert-danger custom-alert mb-4">

            <div class="fw-bold mb-2">
                <i class="bi bi-exclamation-circle me-2"></i>
                Terdapat kesalahan
            </div>

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================
         FLEET TABLE
    ========================= --}}

    <div class="fleet-card">

        <div class="fleet-header">

            <div class="fleet-heading">

                <div class="fleet-heading-icon">
                    <i class="bi bi-car-front-fill"></i>
                </div>

                <div>

                    <h5>
                        Daftar Kendaraan
                    </h5>

                    <p>
                        Inventory kendaraan RentalKu
                    </p>

                </div>

            </div>

            <div class="fleet-count">
                {{ $totalMobil }} kendaraan
            </div>

        </div>


        @if($mobils->count())

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th class="ps-4">
                                #
                            </th>

                            <th>
                                Kendaraan
                            </th>

                            <th>
                                Brand
                            </th>

                            <th>
                                Plat
                            </th>

                            <th>
                                Tahun
                            </th>

                            <th>
                                Transmisi
                            </th>

                            <th>
                                Harga / Hari
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-center pe-4">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($mobils as $mobil)

                            <tr>

                                <td class="ps-4">

                                    <span class="text-muted fw-bold">
                                        {{ $loop->iteration }}
                                    </span>

                                </td>


                                {{-- MOBIL --}}

                                <td>

                                    <div class="car-info">

                                        @if($mobil->image)

                                            <img
                                                src="{{ asset($mobil->image) }}"
                                                class="car-photo"
                                                alt="{{ $mobil->name }}"
                                            >

                                        @else

                                            <div class="car-placeholder">

                                                <i class="bi bi-car-front-fill"></i>

                                            </div>

                                        @endif


                                        <div>

                                            <div class="car-name">
                                                {{ $mobil->name }}
                                            </div>

                                            <div class="car-subtitle">
                                                {{ $mobil->warna ?? 'Warna tidak tersedia' }}
                                                ·
                                                {{ $mobil->kapasitas ?? '-' }} seat
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- BRAND --}}

                                <td>

                                    <span class="brand-text">
                                        {{ $mobil->brand->name ?? '-' }}
                                    </span>

                                </td>


                                {{-- PLAT --}}

                                <td>

                                    <span class="plate">
                                        {{ $mobil->plate_number ?? '-' }}
                                    </span>

                                </td>


                                {{-- TAHUN --}}

                                <td>

                                    <span class="year">
                                        {{ $mobil->tahun ?? '-' }}
                                    </span>

                                </td>


                                {{-- TRANSMISI --}}

                                <td>

                                    <span class="transmission">

                                        <i class="bi bi-gear-fill"></i>

                                        {{ ucfirst($mobil->transmisi ?? '-') }}

                                    </span>

                                </td>


                                {{-- HARGA --}}

                                <td>

                                    <span class="price">
                                        Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}
                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    @if(
                                        $mobil->status === 'Tersedia' ||
                                        strtolower($mobil->status) === 'tersedia'
                                    )

                                        <span class="status-pill status-available">

                                            <span class="status-dot"></span>

                                            Tersedia

                                        </span>

                                    @elseif(
                                        $mobil->status === 'Disewa' ||
                                        strtolower($mobil->status) === 'disewa'
                                    )

                                        <span class="status-pill status-rented">

                                            <span class="status-dot"></span>

                                            Disewa

                                        </span>

                                    @else

                                        <span class="status-pill status-maintenance">

                                            <span class="status-dot"></span>

                                            Maintenance

                                        </span>

                                    @endif

                                </td>


                                {{-- ACTION --}}

                                <td class="pe-4">

                                    <div class="action-wrap">

                                        <a
                                            href="{{ route('staff.mobils.edit', $mobil->id) }}"
                                            class="action-btn action-edit"
                                            title="Edit mobil"
                                        >

                                            <i class="bi bi-pencil"></i>

                                        </a>


                                        <form
                                            action="{{ route('staff.mobils.destroy', $mobil->id) }}"
                                            method="POST"
                                            class="m-0"
                                            onsubmit="return confirmSubmit(event, 'Yakin ingin menghapus mobil ini?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-btn action-delete"
                                                title="Hapus mobil"
                                            >

                                                <i class="bi bi-trash3"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">

                <div class="empty-icon">

                    <i class="bi bi-car-front-fill"></i>

                </div>

                <h5>
                    Belum Ada Kendaraan
                </h5>

                <p>
                    Tambahkan kendaraan pertama untuk mulai mengelola fleet RentalKu.
                </p>

                <button
                    type="button"
                    class="btn-add mt-2"
                    data-bs-toggle="modal"
                    data-bs-target="#tambahMobilModal"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Mobil
                </button>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH MOBIL
========================================================= --}}

<div
    class="modal fade"
    id="tambahMobilModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">


            <div class="modal-header">

                <div>

                    <div class="modal-title">

                        <i class="bi bi-car-front-fill me-2"></i>

                        Tambah Mobil

                    </div>

                    <small class="text-white-50">
                        Tambahkan kendaraan baru ke fleet RentalKu.
                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                action="{{ route('staff.mobils.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="modal-body">


                    {{-- IDENTITAS --}}

                    <div class="section-label">
                        Identitas Kendaraan
                    </div>

                    <div class="row g-3 mt-1">


                        <div class="col-md-6">

                            <label class="form-label">
                                Nama Mobil
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Contoh: Toyota Avanza"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Plat Nomor
                            </label>

                            <input
                                type="text"
                                name="plate_number"
                                class="form-control"
                                placeholder="KB 1234 XX"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Brand
                            </label>

                            <select
                                name="brand_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Brand --
                                </option>

                                @foreach($brands ?? [] as $brand)

                                    <option value="{{ $brand->id }}">
                                        {{ $brand->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Tipe Mobil
                            </label>

                            <select
                                name="tipe_mobil_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Tipe --
                                </option>

                                @foreach($tipeMobils ?? [] as $tipe)

                                    <option value="{{ $tipe->id }}">
                                        {{ $tipe->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Cabang
                            </label>

                            <select
                                name="cabang_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Cabang --
                                </option>

                                @foreach($cabangs ?? [] as $cabang)

                                    <option value="{{ $cabang->id }}">
                                        {{ $cabang->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Tahun
                            </label>

                            <input
                                type="number"
                                name="tahun"
                                class="form-control"
                                placeholder="2024"
                                required
                            >

                        </div>

                    </div>


                    {{-- SPESIFIKASI --}}

                    <div class="section-label mt-4">
                        Spesifikasi
                    </div>

                    <div class="row g-3 mt-1">


                        <div class="col-md-6">

                            <label class="form-label">
                                Transmisi
                            </label>

                            <select
                                name="transmisi"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Transmisi --
                                </option>

                                <option value="manual">
                                    Manual
                                </option>

                                <option value="matic">
                                    Matic
                                </option>

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Kapasitas
                            </label>

                            <input
                                type="number"
                                name="kapasitas"
                                class="form-control"
                                placeholder="7"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Warna
                            </label>

                            <input
                                type="text"
                                name="warna"
                                class="form-control"
                                placeholder="Hitam"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select"
                                required
                            >

                                <option value="Tersedia">
                                    Tersedia
                                </option>

                                <option value="Disewa">
                                    Disewa
                                </option>

                                <option value="Maintenance">
                                    Maintenance
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- HARGA --}}

                    <div class="section-label mt-4">
                        Harga & Deposit
                    </div>

                    <div class="row g-3 mt-1">


                        <div class="col-md-6">

                            <label class="form-label">
                                Harga / Hari
                            </label>

                            <input
                                type="number"
                                name="harga_perhari"
                                class="form-control"
                                placeholder="350000"
                                min="0"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Deposit
                            </label>

                            <input
                                type="number"
                                name="deposit"
                                class="form-control"
                                placeholder="500000"
                                min="0"
                                required
                            >

                        </div>

                    </div>


                    {{-- MEDIA --}}

                    <div class="section-label mt-4">
                        Media Kendaraan
                    </div>

                    <div class="row g-3 mt-1">


                        <div class="col-12">

                            <label class="form-label">
                                Foto Mobil
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png"
                            >

                            <div class="mt-2 text-muted" style="font-size:10px;">
                                Format yang didukung: JPG, JPEG, PNG.
                            </div>

                        </div>


                        <div class="col-12">

                            <label class="form-label">
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Tuliskan deskripsi singkat kendaraan..."
                            ></textarea>

                        </div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn-cancel"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn-save"
                    >
                        <i class="bi bi-check2-circle me-1"></i>
                        Simpan Mobil
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
</script>


<script>

    function confirmSubmit(event, message) {

        event.preventDefault();

        const form = event.target;

        Swal.fire({

            title: 'Hapus kendaraan?',
            text: message,
            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',

            reverseButtons: true,

            buttonsStyling: false,

            customClass: {
                confirmButton: 'btn btn-danger px-4 ms-2',
                cancelButton: 'btn btn-light px-4'
            }

        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

        return false;
    }

</script>


@if(session('success'))

<script>

    document.addEventListener('DOMContentLoaded', function () {

        Swal.fire({

            icon: 'success',

            title: 'Berhasil',

            text: @json(session('success')),

            timer: 2200,

            showConfirmButton: false

        });

    });

</script>

@endif

</body>
</html>