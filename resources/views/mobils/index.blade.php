<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Mobil - RentalKu</title>

    {{-- BOOTSTRAP --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- BOOTSTRAP ICON --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- DATATABLE --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --primary: #198754;
            --primary-dark: #146c43;
            --primary-soft: #eaf8f0;
            --dark: #17221b;
            --muted: #748078;
            --border: #e8eee9;
            --background: #f5f8f6;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at 10% 0%, rgba(25, 135, 84, .06), transparent 25%),
                var(--background);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
        }

        /* =========================
           NAVBAR
        ========================== */

        .navbar {
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
        }

        .brand {
            font-size: 24px;
            font-weight: 800;
            color: #17221b;
            letter-spacing: -.8px;
        }

        .brand span {
            color: var(--primary);
        }

        /* =========================
           MAIN
        ========================== */

        .main-container {
            max-width: 1440px;
            margin: auto;
            padding: 30px 20px 70px;
        }

        /* =========================
           HERO
        ========================== */

        .hero {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 42px;
            min-height: 245px;
            background:
                linear-gradient(120deg, #17221b 0%, #198754 100%);
            color: white;
            box-shadow: 0 20px 50px rgba(25, 135, 84, .16);
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 330px;
            height: 330px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .07);
            right: 70px;
            top: -160px;
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
            right: -50px;
            bottom: -120px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 30px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .16);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .hero h1 {
            margin: 18px 0 8px;
            font-size: 36px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .hero p {
            max-width: 650px;
            margin: 0;
            color: rgba(255, 255, 255, .78);
            line-height: 1.7;
        }

        .hero-car {
            position: absolute;
            z-index: 1;
            right: 55px;
            bottom: -10px;
            font-size: 155px;
            color: white;
            opacity: .10;
            transform: rotate(-4deg);
        }

        /* =========================
           ALERT
        ========================== */

        .custom-alert {
            margin-top: 22px;
            padding: 15px 18px;
            border-radius: 16px;
            border: 1px solid transparent;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .custom-alert.success {
            background: #eaf8f0;
            color: #146c43;
            border-color: #cdebd9;
        }

        .custom-alert.error {
            background: #fff0f1;
            color: #b02a37;
            border-color: #f3c8cd;
        }

        /* =========================
           STATISTICS
        ========================== */

        .stats {
            margin-top: 24px;
        }

        .stat-card {
            position: relative;
            height: 100%;
            padding: 22px;
            border-radius: 21px;
            background: white;
            border: 1px solid var(--border);
            transition: all .25s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 35px rgba(20, 40, 28, .08);
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: var(--primary-soft);
            right: -35px;
            bottom: -35px;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: var(--primary-soft);
            color: var(--primary);
            font-size: 23px;
            position: relative;
            z-index: 2;
        }

        .stat-label {
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
        }

        .stat-number {
            margin-top: 3px;
            font-size: 29px;
            font-weight: 800;
            letter-spacing: -.8px;
        }

        .stat-description {
            margin-top: 7px;
            color: #98a19b;
            font-size: 11px;
        }

        /* =========================
           SECTION HEADER
        ========================== */

        .section-header {
            margin-top: 42px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .section-title {
            margin: 0;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .section-subtitle {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        /* =========================
           BUTTON
        ========================== */

        .btn-primary-custom {
            border: none;
            background: var(--primary);
            color: white;
            padding: 11px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 7px 18px rgba(25, 135, 84, .18);
            transition: .2s;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
        }

        .btn-dashboard {
            border: 1px solid var(--border);
            background: white;
            color: #49534d;
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-dashboard:hover {
            background: #f8faf9;
        }

        /* =========================
           FILTER BAR
        ========================== */

        .filter-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 17px;
            margin-bottom: 15px;
        }

        .filter-search {
            position: relative;
        }

        .filter-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa49e;
        }

        .filter-search input {
            padding-left: 42px;
            height: 45px;
        }

        .filter-card select {
            height: 45px;
        }

        .form-control,
        .form-select {
            border-color: var(--border);
            border-radius: 11px;
            font-size: 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .10);
        }

        /* =========================
           TABLE
        ========================== */

        .table-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(20, 40, 28, .03);
        }

        .table-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-card-header strong {
            font-size: 14px;
        }

        .table-card-header span {
            font-size: 12px;
            color: var(--muted);
        }

        .table {
            margin: 0 !important;
        }

        .table thead th {
            background: #f8faf9;
            color: #7b857e;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .7px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
            padding: 15px 12px;
        }

        .table tbody td {
            padding: 14px 12px;
            border-bottom: 1px solid #f0f3f1;
            vertical-align: middle;
            font-size: 12px;
        }

        .table tbody tr {
            transition: .2s;
        }

        .table tbody tr:hover {
            background: #fbfdfc;
        }

        #mobils-table thead .dt-column-order {
            display: none !important;
        }

        /* =========================
           CAR
        ========================== */

        .car-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 190px;
        }

        .car-image {
            width: 68px;
            height: 50px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: #f5f7f6;
        }

        .car-placeholder {
            width: 68px;
            height: 50px;
            border-radius: 12px;
            background: #f1f5f2;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9aa39d;
            border: 1px solid var(--border);
        }

        .car-name {
            font-weight: 800;
            color: #1d2921;
            font-size: 13px;
        }

        .car-color {
            margin-top: 3px;
            color: #909a94;
            font-size: 11px;
        }

        .plate {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 7px;
            background: #1c1c1c;
            color: white;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .price {
            color: var(--primary);
            font-weight: 800;
            white-space: nowrap;
        }

        .brand-text {
            font-weight: 700;
            color: #465148;
        }

        .type-text,
        .branch-text {
            color: #68736c;
        }

        /* =========================
           STATUS
        ========================== */

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .badge-status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-tersedia {
            background: #e5f7ed;
            color: #198754;
        }

        .status-disewa {
            background: #fff4d8;
            color: #a67800;
        }

        .status-maintenance {
            background: #ffe7ea;
            color: #c23645;
        }

        /* =========================
           ACTION
        ========================== */

        .action-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: white;
            transition: .2s;
        }

        .action-btn.edit {
            color: #0d6efd;
        }

        .action-btn.delete {
            color: #dc3545;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .action-btn.edit:hover {
            background: #edf5ff;
            border-color: #cfe2ff;
        }

        .action-btn.delete:hover {
            background: #fff0f1;
            border-color: #f3c8cd;
        }

        /* =========================
           DATATABLE
        ========================== */

        .dt-container {
            padding: 0 20px 18px;
        }

        .dt-search input,
        .dt-length select {
            border: 1px solid var(--border) !important;
            border-radius: 9px !important;
            padding: 7px 10px !important;
            font-size: 12px !important;
        }

        .dt-info {
            font-size: 11px;
            color: var(--muted);
        }

        .dt-paging .dt-paging-button {
            border-radius: 8px !important;
            border: none !important;
            font-size: 11px !important;
        }

        .dt-paging .dt-paging-button.current {
            background: var(--primary) !important;
            color: white !important;
        }

        /* =========================
           MODAL
        ========================== */

        .modal-content {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, .18);
        }

        .modal-header {
            padding: 21px 25px;
            border-bottom: 1px solid var(--border);
            background: #fbfcfb;
        }

        .modal-title {
            font-weight: 800;
            font-size: 18px;
        }

        .modal-body {
            padding: 25px;
            background: white;
        }

        .modal-footer {
            padding: 17px 25px;
            background: #fbfcfb;
            border-top: 1px solid var(--border);
        }

        .form-label {
            margin-bottom: 7px;
            font-size: 12px;
            font-weight: 800;
            color: #465148;
        }

        .form-control,
        .form-select {
            min-height: 44px;
        }

        .input-group-text {
            border-color: var(--border);
            background: #f7faf8;
            color: var(--primary);
            font-weight: 800;
        }

        textarea.form-control {
            min-height: 105px;
        }

        /* =========================
           FORM SECTION
        ========================== */

        .form-section {
            padding: 17px;
            background: #fafcfb;
            border: 1px solid var(--border);
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .form-section-title {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 16px;
            color: #26332b;
            font-size: 13px;
            font-weight: 800;
        }

        .form-section-title i {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: var(--primary-soft);
            color: var(--primary);
        }

        /* =========================
           FACILITIES
        ========================== */

        .facility-box {
            padding: 13px;
            border-radius: 13px;
            background: white;
            border: 1px solid var(--border);
        }

        .facility-item {
            height: 40px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 10px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: white;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            transition: .2s;
        }

        .facility-item:hover {
            border-color: #a9d8bd;
            background: var(--primary-soft);
        }

        .facility-item input {
            accent-color: var(--primary);
        }

        /* =========================
           PHOTO PREVIEW
        ========================== */

        .photo-preview-box {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px;
            border: 1px dashed #cbd8d0;
            border-radius: 13px;
            background: #fafcfb;
        }

        .photo-preview-box img {
            width: 125px;
            height: 88px;
            object-fit: cover;
            border-radius: 11px;
        }

        /* =========================
           FOOTER
        ========================== */

        footer {
            margin-top: 30px;
            padding: 28px 20px;
            border-top: 1px solid var(--border);
            background: white;
        }

        .footer-brand {
            font-size: 17px;
            font-weight: 800;
        }

        .footer-brand span {
            color: var(--primary);
        }

        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 768px) {

            .main-container {
                padding: 20px 12px 50px;
            }

            .hero {
                padding: 28px 23px;
            }

            .hero h1 {
                font-size: 27px;
            }

            .hero-car {
                display: none;
            }

            .section-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .section-actions {
                width: 100%;
            }

            .section-actions .btn {
                width: 100%;
            }

            .table-card {
                border-radius: 16px;
            }

            .modal-body {
                padding: 17px;
            }

            .modal-footer {
                padding: 14px 17px;
            }
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    @include('layouts.partials.admin-navbar')


    <main class="main-container">

        {{-- ================================
             HERO
        ================================= --}}
        <section class="hero">

            <div class="hero-content">

                <div class="hero-label">
                    <i class="bi bi-car-front-fill"></i>
                    MANAGEMENT MOBIL
                </div>

                <h1>
                    Kelola Armada RentalKu
                </h1>

                <p>
                    Atur seluruh kendaraan rental dengan mudah.
                    Pantau ketersediaan, harga, cabang, spesifikasi,
                    fasilitas, dan status mobil dalam satu tempat.
                </p>

            </div>

            <i class="bi bi-car-front-fill hero-car"></i>

        </section>


        {{-- ================================
             ALERT SUCCESS
        ================================= --}}
        @if(session('success'))

            <div class="custom-alert success">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <span>{{ session('success') }}</span>
            </div>

        @endif


        {{-- ================================
             ALERT ERROR
        ================================= --}}
        @if($errors->any())

            <div class="custom-alert error">

                <i class="bi bi-exclamation-circle-fill fs-5"></i>

                <div>
                    <strong>Data belum dapat disimpan.</strong>

                    <ul class="mb-0 mt-1 ps-3">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        @endif


        {{-- ================================
             STATISTIK
        ================================= --}}
        <div class="row g-3 stats">

            {{-- TOTAL --}}
            <div class="col-6 col-xl-3">

                <div class="stat-card">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="stat-label">
                                Total Mobil
                            </div>

                            <div class="stat-number">
                                {{ $mobils->count() }}
                            </div>

                            <div class="stat-description">
                                Seluruh armada terdaftar
                            </div>

                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-car-front-fill"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- TERSEDIA --}}
            <div class="col-6 col-xl-3">

                <div class="stat-card">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="stat-label">
                                Tersedia
                            </div>

                            <div class="stat-number text-success">
                                {{ $mobils->where('status', 'Tersedia')->count() }}
                            </div>

                            <div class="stat-description">
                                Siap disewakan
                            </div>

                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- DISEWA --}}
            <div class="col-6 col-xl-3">

                <div class="stat-card">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="stat-label">
                                Sedang Disewa
                            </div>

                            <div class="stat-number text-warning">
                                {{ $mobils->where('status', 'Disewa')->count() }}
                            </div>

                            <div class="stat-description">
                                Sedang digunakan customer
                            </div>

                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-key-fill"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- MAINTENANCE --}}
            <div class="col-6 col-xl-3">

                <div class="stat-card">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="stat-label">
                                Maintenance
                            </div>

                            <div class="stat-number text-danger">
                                {{ $mobils->where('status', 'Maintenance')->count() }}
                            </div>

                            <div class="stat-description">
                                Membutuhkan perawatan
                            </div>

                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-tools"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================
             SECTION HEADER
        ================================= --}}
        <div class="section-header">

            <div>

                <h2 class="section-title">
                    Daftar Armada
                </h2>

                <p class="section-subtitle">
                    Kelola semua kendaraan yang terdaftar di RentalKu.
                </p>

            </div>

            <div class="d-flex gap-2 section-actions">

                <a href="{{ route('admin.dashboard') }}"
                   class="btn btn-dashboard">

                    <i class="bi bi-arrow-left me-1"></i>
                    Dashboard

                </a>

                <button type="button"
                        class="btn btn-primary-custom"
                        data-bs-toggle="modal"
                        data-bs-target="#tambahMobilModal">

                    <i class="bi bi-plus-lg me-1"></i>
                    Tambah Mobil

                </button>

            </div>

        </div>


        {{-- ================================
             TABLE
        ================================= --}}
        <div class="table-card">

            <div class="table-card-header">

                <div>

                    <strong>
                        <i class="bi bi-list-ul text-success me-2"></i>
                        Data Kendaraan
                    </strong>

                    <div>
                        <span>
                            Daftar seluruh mobil RentalKu
                        </span>
                    </div>

                </div>

                <span>
                    <i class="bi bi-database me-1"></i>
                    Data realtime
                </span>

            </div>


            <div class="table-responsive">

                <table class="table align-middle"
                       id="mobils-table">

                    <thead>

                        <tr>

                            <th class="px-3">
                                No
                            </th>

                            <th>
                                Mobil
                            </th>

                            <th>
                                Brand
                            </th>

                            <th>
                                Tipe
                            </th>

                            <th>
                                Cabang
                            </th>

                            <th>
                                Plat
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

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>
                        {{-- DataTables --}}
                    </tbody>

                </table>

            </div>

        </div>

    </main>


    {{-- ======================================================
         MODAL TAMBAH MOBIL
    ======================================================= --}}
    <div class="modal fade"
         id="tambahMobilModal"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <div>

                        <div class="modal-title">
                            <i class="bi bi-plus-circle-fill text-success me-2"></i>
                            Tambah Mobil
                        </div>

                        <small class="text-muted">
                            Tambahkan kendaraan baru ke armada RentalKu
                        </small>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <form action="{{ route('mobils.store') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          id="formTambahMobil">

                        @csrf


                        {{-- INFORMASI UTAMA --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-car-front-fill"></i>

                                Informasi Kendaraan

                            </div>

                            <div class="row g-3">

                                <div class="col-md-4">

                                    <label class="form-label">
                                        Brand Mobil
                                    </label>

                                    <select name="brand_id"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Pilih Brand
                                        </option>

                                        @foreach($brands as $brand)

                                            <option value="{{ $brand->id }}"
                                                {{ old('brand_id') == $brand->id ? 'selected' : '' }}>

                                                {{ $brand->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Tipe Mobil
                                    </label>

                                    <select name="tipe_mobil_id"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Pilih Tipe Mobil
                                        </option>

                                        @foreach($tipeMobils as $tipeMobil)

                                            <option value="{{ $tipeMobil->id }}"
                                                {{ old('tipe_mobil_id') == $tipeMobil->id ? 'selected' : '' }}>

                                                {{ $tipeMobil->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Cabang
                                    </label>

                                    <select name="cabang_id"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Pilih Cabang
                                        </option>

                                        @foreach($cabangs as $cabang)

                                            <option value="{{ $cabang->id }}"
                                                {{ old('cabang_id') == $cabang->id ? 'selected' : '' }}>

                                                {{ $cabang->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Nama Mobil
                                    </label>

                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           placeholder="Contoh: Toyota Avanza"
                                           value="{{ old('name') }}"
                                           required>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Plat Nomor
                                    </label>

                                    <input type="text"
                                           name="plate_number"
                                           class="form-control"
                                           placeholder="Contoh: KB 1234 AB"
                                           value="{{ old('plate_number') }}"
                                           required>

                                </div>

                            </div>

                        </div>


                        {{-- SPESIFIKASI --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-gear-fill"></i>

                                Spesifikasi Mobil

                            </div>

                            <div class="row g-3">

                                <div class="col-md-4">

                                    <label class="form-label">
                                        Tahun
                                    </label>

                                    <input type="number"
                                           name="tahun"
                                           class="form-control"
                                           placeholder="2025"
                                           value="{{ old('tahun') }}"
                                           required>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Transmisi
                                    </label>

                                    <select name="transmisi"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Pilih Transmisi
                                        </option>

                                        <option value="Manual"
                                            {{ old('transmisi') == 'Manual' ? 'selected' : '' }}>
                                            Manual
                                        </option>

                                        <option value="Matic"
                                            {{ old('transmisi') == 'Matic' ? 'selected' : '' }}>
                                            Matic
                                        </option>

                                    </select>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Kapasitas Penumpang
                                    </label>

                                    <input type="number"
                                           name="kapasitas"
                                           min="1"
                                           class="form-control"
                                           placeholder="7"
                                           value="{{ old('kapasitas') }}">

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Warna
                                    </label>

                                    <input type="text"
                                           name="warna"
                                           class="form-control"
                                           placeholder="Contoh: Hitam"
                                           value="{{ old('warna') }}"
                                           required>

                                </div>

                            </div>

                        </div>


                        {{-- HARGA --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-cash-stack"></i>

                                Harga & Pembayaran

                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Harga Per Hari
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            Rp
                                        </span>

                                        <input type="number"
                                               name="harga_perhari"
                                               class="form-control"
                                               placeholder="300000"
                                               value="{{ old('harga_perhari') }}"
                                               min="0"
                                               required>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Deposit
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            Rp
                                        </span>

                                        <input type="number"
                                               name="deposit"
                                               class="form-control"
                                               placeholder="500000"
                                               value="{{ old('deposit') }}"
                                               min="0"
                                               required>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- FOTO & STATUS --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-image-fill"></i>

                                Foto & Status

                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Foto Mobil
                                    </label>

                                    <input type="file"
                                           name="image"
                                           class="form-control"
                                           accept=".jpg,.jpeg,.png,.svg">

                                    <small class="text-muted">
                                        JPG, PNG, JPEG, SVG • Maksimal 2MB
                                    </small>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Status Mobil
                                    </label>

                                    <select name="status"
                                            class="form-select"
                                            required>

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

                        </div>


                        {{-- DESKRIPSI --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-card-text"></i>

                                Deskripsi

                            </div>

                            <textarea name="description"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Masukkan deskripsi mobil...">{{ old('description') }}</textarea>

                        </div>


                        {{-- FASILITAS --}}
                        <div class="form-section mb-0">

                            <div class="form-section-title">

                                <i class="bi bi-stars"></i>

                                Fasilitas Mobil

                            </div>

                            <div class="facility-box">

                                <div class="row g-2">

                                    @foreach($fasilitas as $fasilitasItem)

                                        <div class="col-6 col-md-4 col-lg-3">

                                            <label class="facility-item">

                                                <input type="checkbox"
                                                       name="fasilitas[]"
                                                       value="{{ $fasilitasItem->id }}">

                                                <span>
                                                    {{ $fasilitasItem->name }}
                                                </span>

                                            </label>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </form>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light border"
                            data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            form="formTambahMobil"
                            class="btn btn-primary-custom">

                        <i class="bi bi-check-lg me-1"></i>
                        Simpan Mobil

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- ======================================================
         MODAL EDIT MOBIL
    ======================================================= --}}
    <div class="modal fade"
         id="editMobilModal"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <div>

                        <div class="modal-title">

                            <i class="bi bi-pencil-square text-primary me-2"></i>

                            Edit Mobil

                        </div>

                        <small class="text-muted">
                            Perbarui informasi kendaraan
                        </small>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <form action=""
                          method="POST"
                          enctype="multipart/form-data"
                          id="formEditMobil">

                        @csrf

                        @method('PUT')


                        {{-- INFORMASI --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-car-front-fill"></i>

                                Informasi Kendaraan

                            </div>

                            <div class="row g-3">

                                <div class="col-md-4">

                                    <label class="form-label">
                                        Brand Mobil
                                    </label>

                                    <select name="brand_id"
                                            id="editBrandId"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Pilih Brand
                                        </option>

                                        @foreach($brands as $brand)

                                            <option value="{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Tipe Mobil
                                    </label>

                                    <select name="tipe_mobil_id"
                                            id="editTipeMobilId"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Pilih Tipe Mobil
                                        </option>

                                        @foreach($tipeMobils as $tipeMobil)

                                            <option value="{{ $tipeMobil->id }}">
                                                {{ $tipeMobil->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Cabang
                                    </label>

                                    <select name="cabang_id"
                                            id="editCabangId"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Pilih Cabang
                                        </option>

                                        @foreach($cabangs as $cabang)

                                            <option value="{{ $cabang->id }}">
                                                {{ $cabang->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Nama Mobil
                                    </label>

                                    <input type="text"
                                           name="name"
                                           id="editName"
                                           class="form-control"
                                           required>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Plat Nomor
                                    </label>

                                    <input type="text"
                                           name="plate_number"
                                           id="editPlateNumber"
                                           class="form-control"
                                           required>

                                </div>

                            </div>

                        </div>


                        {{-- SPESIFIKASI --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-gear-fill"></i>

                                Spesifikasi

                            </div>

                            <div class="row g-3">

                                <div class="col-md-4">

                                    <label class="form-label">
                                        Tahun
                                    </label>

                                    <input type="number"
                                           name="tahun"
                                           id="editTahun"
                                           class="form-control"
                                           required>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Transmisi
                                    </label>

                                    <select name="transmisi"
                                            id="editTransmisi"
                                            class="form-select"
                                            required>

                                        <option value="">
                                            Pilih Transmisi
                                        </option>

                                        <option value="Manual">
                                            Manual
                                        </option>

                                        <option value="Matic">
                                            Matic
                                        </option>

                                    </select>

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Kapasitas Penumpang
                                    </label>

                                    <input type="number"
                                           name="kapasitas"
                                           id="editKapasitas"
                                           class="form-control"
                                           min="1">

                                </div>


                                <div class="col-md-4">

                                    <label class="form-label">
                                        Warna
                                    </label>

                                    <input type="text"
                                           name="warna"
                                           id="editWarna"
                                           class="form-control"
                                           required>

                                </div>

                            </div>

                        </div>


                        {{-- HARGA --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-cash-stack"></i>

                                Harga & Deposit

                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Harga Per Hari
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            Rp
                                        </span>

                                        <input type="number"
                                               name="harga_perhari"
                                               id="editHargaPerhari"
                                               class="form-control"
                                               min="0"
                                               required>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Deposit
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            Rp
                                        </span>

                                        <input type="number"
                                               name="deposit"
                                               id="editDeposit"
                                               class="form-control"
                                               min="0"
                                               required>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- FOTO STATUS --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-image-fill"></i>

                                Foto & Status

                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Foto Saat Ini
                                    </label>

                                    <div class="photo-preview-box">

                                        <img id="editFotoPreview"
                                             src=""
                                             style="display:none;"
                                             alt="Preview foto">

                                        <span class="small text-muted">
                                            Foto baru akan menggantikan foto lama.
                                        </span>

                                    </div>

                                    <input type="file"
                                           name="image"
                                           id="editImage"
                                           class="form-control mt-2"
                                           accept=".jpg,.jpeg,.png,.svg">

                                    <small class="text-muted">
                                        Kosongkan jika tidak ingin mengganti foto.
                                    </small>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Status Mobil
                                    </label>

                                    <select name="status"
                                            id="editStatus"
                                            class="form-select"
                                            required>

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

                        </div>


                        {{-- DESKRIPSI --}}
                        <div class="form-section">

                            <div class="form-section-title">

                                <i class="bi bi-card-text"></i>

                                Deskripsi

                            </div>

                            <textarea name="description"
                                      id="editDescription"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Masukkan deskripsi mobil..."></textarea>

                        </div>


                        {{-- FASILITAS --}}
                        <div class="form-section mb-0">

                            <div class="form-section-title">

                                <i class="bi bi-stars"></i>

                                Fasilitas Mobil

                            </div>

                            <div class="facility-box">

                                <div class="row g-2">

                                    @foreach($fasilitas as $fasilitasItem)

                                        <div class="col-6 col-md-4 col-lg-3">

                                            <label class="facility-item">

                                                <input type="checkbox"
                                                       name="fasilitas[]"
                                                       value="{{ $fasilitasItem->id }}"
                                                       class="edit-fasilitas-checkbox">

                                                <span>
                                                    {{ $fasilitasItem->name }}
                                                </span>

                                            </label>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    </form>

                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light border"
                            data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            form="formEditMobil"
                            class="btn btn-primary-custom">

                        <i class="bi bi-check-lg me-1"></i>
                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- FOOTER --}}
    <footer>

        <div class="text-center">

            <div class="footer-brand">
                Rental<span>Ku</span>
            </div>

            <div class="small text-muted mt-1">
                Management Mobil • RentalKu
            </div>

        </div>

    </footer>


    {{-- =========================
         JS
    ========================== --}}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>

        const CSRF_TOKEN = '{{ csrf_token() }}';


        /* =====================================================
           STATUS BADGE
        ====================================================== */

        function statusBadge(status) {

            const map = {
                'Tersedia': 'status-tersedia',
                'Disewa': 'status-disewa',
                'Maintenance': 'status-maintenance'
            };

            const cls = map[status] || 'bg-secondary text-white';

            return `
                <span class="badge-status ${cls}">
                    ${status}
                </span>
            `;
        }


        /* =====================================================
           FOTO MOBIL
        ====================================================== */

        function mobilPhoto(image) {

            if (image) {

                return `
                    <img
                        src="{{ asset('__PHOTO__') }}"
                        class="car-image"
                        alt="Foto mobil"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                    <div class="car-placeholder" style="display:none;">
                        <i class="bi bi-car-front fs-5"></i>
                    </div>
                `.replace('__PHOTO__', image);

            }

            return `
                <div class="car-placeholder">
                    <i class="bi bi-car-front fs-5"></i>
                </div>
            `;
        }


        /* =====================================================
           AKSI
        ====================================================== */

        function mobilActions(data) {

            return `
                <div class="action-group">

                    <button
                        type="button"
                        class="action-btn edit"
                        title="Edit Mobil"
                        onclick="editMobil(${data.id})">

                        <i class="bi bi-pencil-square"></i>

                    </button>

                    <button
                        type="button"
                        class="action-btn delete"
                        title="Hapus Mobil"
                        onclick="deleteMobil(${data.id}, ${JSON.stringify(data.name)})">

                        <i class="bi bi-trash3"></i>

                    </button>

                </div>
            `;
        }


        /* =====================================================
           DATATABLE
        ====================================================== */

        $(document).ready(function() {

            $('#mobils-table').DataTable({

                processing: true,

                serverSide: true,

                ajax: {
                    url: '{{ route('mobils.data') }}',
                    type: 'GET'
                },

                columns: [

                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'px-3',
                        width: '55px',

                        render: function(data, type, row, meta) {

                            return `
                                <span class="text-muted fw-semibold">
                                    ${meta.row + meta.settings._iDisplayStart + 1}
                                </span>
                            `;

                        }
                    },


                    {
                        data: null,
                        orderable: true,
                        searchable: true,

                        render: function(data) {

                            return `
                                <div class="car-wrapper">

                                    ${mobilPhoto(data.image)}

                                    <div>

                                        <div class="car-name">
                                            ${data.name ?? '-'}
                                        </div>

                                        <div class="car-color">
                                            <i class="bi bi-palette me-1"></i>
                                            ${data.warna ?? '-'}
                                        </div>

                                    </div>

                                </div>
                            `;

                        }
                    },


                    {
                        data: 'brand_name',
                        render: function(data) {

                            return `
                                <span class="brand-text">
                                    ${data ?? '-'}
                                </span>
                            `;

                        }
                    },


                    {
                        data: 'tipe_name',

                        render: function(data) {

                            return `
                                <span class="type-text">
                                    ${data ?? '-'}
                                </span>
                            `;

                        }
                    },


                    {
                        data: 'cabang_name',

                        render: function(data) {

                            return `
                                <span class="branch-text">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    ${data ?? '-'}
                                </span>
                            `;

                        }
                    },


                    {
                        data: 'plate_number',

                        render: function(data) {

                            return `
                                <span class="plate">
                                    ${data ?? '-'}
                                </span>
                            `;

                        }
                    },


                    {
                        data: 'tahun',

                        render: function(data) {

                            return `
                                <span class="fw-semibold">
                                    ${data ?? '-'}
                                </span>
                            `;

                        }
                    },


                    {
                        data: 'harga_perhari',

                        render: function(data) {

                            const harga = Number(data || 0)
                                .toLocaleString('id-ID');

                            return `
                                <span class="price">
                                    Rp ${harga}
                                </span>
                            `;

                        }
                    },


                    {
                        data: 'status',

                        render: function(data) {

                            return statusBadge(data);

                        }
                    },


                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        width: '100px',

                        render: function(data) {

                            return mobilActions(data);

                        }
                    }

                ],


                order: [
                    [1, 'asc']
                ],


                pageLength: 10,


                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],


                language: {

                    processing: 'Memproses...',

                    search: 'Cari:',

                    lengthMenu: 'Tampilkan _MENU_',

                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ mobil',

                    infoEmpty: 'Tidak ada data',

                    infoFiltered: '(difilter dari _MAX_ total data)',

                    loadingRecords: 'Memuat...',

                    zeroRecords: 'Mobil tidak ditemukan',

                    emptyTable: 'Belum ada mobil',

                    paginate: {
                        first: '«',
                        last: '»',
                        next: '›',
                        previous: '‹'
                    }

                }

            });

        });


        /* =====================================================
           DELETE
        ====================================================== */

        function deleteMobil(id, name) {

            Swal.fire({

                title: 'Hapus Mobil?',

                html: `
                    Data mobil
                    <strong>${name}</strong>
                    akan dihapus secara permanen.
                `,

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Ya, Hapus',

                cancelButtonText: 'Batal',

                reverseButtons: true,

                buttonsStyling: true,

            }).then(function(result) {

                if (!result.isConfirmed) {
                    return;
                }


                $.ajax({

                    url: "{{ route('mobils.destroy', '__ID__') }}"
                        .replace('__ID__', id),

                    method: 'DELETE',

                    headers: {

                        'X-CSRF-TOKEN': CSRF_TOKEN,

                        'Accept': 'application/json',

                        'X-Requested-With': 'XMLHttpRequest'

                    },


                    beforeSend: function() {

                        Swal.fire({

                            title: 'Menghapus...',

                            text: 'Mohon tunggu.',

                            allowOutsideClick: false,

                            didOpen: function() {

                                Swal.showLoading();

                            }

                        });

                    },


                    success: function(result) {

                        $('#mobils-table')
                            .DataTable()
                            .ajax
                            .reload(null, false);


                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text: result?.message ||
                                'Mobil berhasil dihapus.',

                            timer: 1600,

                            showConfirmButton: false

                        });

                    },


                    error: function(xhr) {

                        const result =
                            xhr.responseJSON || {};

                        Swal.fire({

                            icon: 'error',

                            title: 'Gagal',

                            text:
                                result.message ||
                                'Terjadi kesalahan saat menghapus mobil.'

                        });

                    }

                });

            });

        }


        /* =====================================================
           EDIT MOBIL
        ====================================================== */

        function editMobil(id) {

            const table =
                $('#mobils-table').DataTable();


            const data =
                table.rows().data().toArray()
                .find(r => r.id == id);


            if (!data) {

                Swal.fire({

                    icon: 'error',

                    title: 'Data Tidak Ditemukan',

                    text: 'Data mobil tidak ditemukan pada halaman ini.'

                });

                return;

            }


            /* ACTION FORM */

            $('#formEditMobil').attr(

                'action',

                "{{ route('mobils.update', '__ID__') }}"
                    .replace('__ID__', id)

            );


            /* FIELD */

            $('#editBrandId').val(data.brand_id);

            $('#editTipeMobilId')
                .val(data.tipe_mobil_id);

            $('#editCabangId')
                .val(data.cabang_id);

            $('#editName')
                .val(data.name);

            $('#editPlateNumber')
                .val(data.plate_number);

            $('#editTahun')
                .val(data.tahun);

            $('#editTransmisi')
                .val(data.transmisi);

            $('#editKapasitas')
                .val(data.kapasitas);

            $('#editWarna')
                .val(data.warna);

            $('#editHargaPerhari')
                .val(data.harga_perhari);

            $('#editDeposit')
                .val(data.deposit);

            $('#editStatus')
                .val(data.status);

            $('#editDescription')
                .val(data.description);


            /* FASILITAS */

            $('#editMobilModal .edit-fasilitas-checkbox')
                .prop('checked', false);


            if (
                data.fasilitas_ids &&
                data.fasilitas_ids.length
            ) {

                $('#editMobilModal .edit-fasilitas-checkbox')
                    .each(function() {

                        const value =
                            parseInt($(this).val());

                        if (
                            data.fasilitas_ids
                                .map(Number)
                                .includes(value)
                        ) {

                            $(this).prop(
                                'checked',
                                true
                            );

                        }

                    });

            }


            /* FOTO */

            if (data.image) {

                $('#editFotoPreview')

                    .attr(

                        'src',

                        "{{ asset('__PHOTO__') }}"
                            .replace(
                                '__PHOTO__',
                                data.image
                            )

                    )

                    .show();

            } else {

                $('#editFotoPreview')
                    .attr('src', '')
                    .hide();

            }


            $('#editImage').val('');


            /* SHOW MODAL */

            const modal =
                bootstrap.Modal
                    .getOrCreateInstance(
                        document.getElementById(
                            'editMobilModal'
                        )
                    );


            modal.show();

        }


        /* =====================================================
           UPDATE MOBIL
        ====================================================== */

        $('#formEditMobil').on(
            'submit',
            function(e) {

                e.preventDefault();


                const form = this;

                const formData =
                    new FormData(form);


                $.ajax({

                    url: $(form).attr('action'),

                    method: 'POST',

                    data: formData,

                    processData: false,

                    contentType: false,

                    headers: {

                        'X-CSRF-TOKEN':
                            CSRF_TOKEN,

                        'Accept':
                            'application/json',

                        'X-Requested-With':
                            'XMLHttpRequest'

                    },


                    beforeSend: function() {

                        Swal.fire({

                            title: 'Menyimpan...',

                            text: 'Mohon tunggu.',

                            allowOutsideClick: false,

                            didOpen: function() {

                                Swal.showLoading();

                            }

                        });

                    },


                    success: function(result) {

                        const modal =
                            bootstrap.Modal
                                .getInstance(
                                    document.getElementById(
                                        'editMobilModal'
                                    )
                                );


                        if (modal) {
                            modal.hide();
                        }


                        $('#mobils-table')
                            .DataTable()
                            .ajax
                            .reload(null, false);


                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text:
                                result.message ||
                                'Mobil berhasil diperbarui.',

                            timer: 1600,

                            showConfirmButton: false

                        });

                    },


                    error: function(xhr) {

                        const r =
                            xhr.responseJSON || {};


                        let msg =
                            'Terjadi kesalahan saat memperbarui mobil.';


                        if (r.errors) {

                            const firstError =
                                Object.values(r.errors)[0];

                            if (
                                Array.isArray(firstError) &&
                                firstError.length
                            ) {

                                msg =
                                    firstError[0];

                            }

                        } else if (r.message) {

                            msg = r.message;

                        }


                        Swal.fire({

                            icon: 'error',

                            title: 'Gagal',

                            text: msg

                        });

                    }

                });

            }
        );


        /* =====================================================
           PREVIEW FOTO EDIT
        ====================================================== */

        $('#editImage').on(
            'change',
            function() {

                const file =
                    this.files[0];


                if (!file) {
                    return;
                }


                const reader =
                    new FileReader();


                reader.onload =
                    function(e) {

                        $('#editFotoPreview')

                            .attr(
                                'src',
                                e.target.result
                            )

                            .show();

                    };


                reader.readAsDataURL(file);

            }
        );


        /* =====================================================
           PREVIEW FOTO TAMBAH
        ====================================================== */

        $('#tambahMobilModal input[name="image"]')
            .on('change', function() {

                const file =
                    this.files[0];

                if (!file) {
                    return;
                }

                const reader =
                    new FileReader();

                reader.onload =
                    function(e) {

                        /*
                         * Preview sederhana menggunakan
                         * SweetAlert.
                         */

                        Swal.fire({

                            title: 'Preview Foto',

                            imageUrl: e.target.result,

                            imageAlt: 'Preview mobil',

                            confirmButtonText: 'Bagus'

                        });

                    };

                reader.readAsDataURL(file);

            });


        /* =====================================================
           AUTO CLOSE ALERT
        ====================================================== */

        setTimeout(function() {

            $('.custom-alert')
                .fadeOut(400);

        }, 5000);

    </script>

</body>

</html>