<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Mobil - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

    <style>
        body {
            background: #f5f7f6;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .profile {
            background: #f3f7f5;
            border-radius: 12px;
            padding: 8px 14px;
        }

        .profile-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #198754;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-header {
            margin-top: 30px;
            padding: 32px;
            border-radius: 22px;
            background: linear-gradient(135deg, #212529, #198754);
            color: white;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .10);
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 800;
        }

        .page-header p {
            color: #dcefe4;
            margin-bottom: 0;
        }

        .header-icon {
            font-size: 90px;
            opacity: .12;
        }

        .stat-card {
            background: white;
            border-radius: 18px;
            border: 1px solid #edf0ee;
            padding: 22px;
            height: 100%;
            transition: .25s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
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

        .stat-number {
            font-size: 27px;
            font-weight: 800;
        }

        .content-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            overflow: hidden;
        }

        .content-header {
            padding: 22px 25px;
            border-bottom: 1px solid #edf0ee;
        }

        .section-title {
            font-weight: 800;
            color: #1f2937;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px 13px;
            border-color: #dee2e6;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .12);
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #374151;
        }

        .btn-green {
            background: #198754;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 18px;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }

        .modal-footer .btn {
            padding: 6px 14px;
            min-width: 100px;
        }

        .facility-box {
            background: #f8faf9;
            border: 1px solid #edf0ee;
            border-radius: 12px;
            padding: 12px;
        }

        .facility-item {
            cursor: pointer;
        }

        .facility-item input {
            accent-color: #198754;
        }

        .table-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            overflow: hidden;
        }

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            border-bottom: 1px solid #e9ecef;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        /* Sembunyikan ikon sort di semua kolom */
        #mobils-table thead .dt-column-order {
            display: none !important;
        }

        .car-image {
            width: 58px;
            height: 45px;
            object-fit: cover;
            border-radius: 10px;
        }

        .car-placeholder {
            width: 58px;
            height: 45px;
            border-radius: 10px;
            background: #f1f3f2;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }

        .badge-status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-tersedia {
            background: #dff7e8;
            color: #198754;
        }

        .status-disewa {
            background: #fff3cd;
            color: #997404;
        }

        .status-maintenance {
            background: #f8d7da;
            color: #b02a37;
        }


        .alert {
            border-radius: 12px;
            border: none;
        }

        footer {
            margin-top: 70px;
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
@include('layouts.partials.admin-navbar')


<div class="container">

    {{-- HEADER --}}
    <div class="page-header">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <span class="badge bg-light text-success px-3 py-2 mb-3">
                    <i class="bi bi-car-front me-1"></i>
                    Management Mobil
                </span>

                <h1>
                    Kelola Data Mobil
                </h1>

                <p class="mt-2">
                    Kelola seluruh kendaraan RentalKu mulai dari data mobil,
                    harga, fasilitas, cabang hingga status kendaraan.
                </p>

            </div>

            <div class="col-lg-4 text-center d-none d-lg-block">

                <i class="bi bi-car-front-fill header-icon"></i>

            </div>

        </div>

    </div>


    {{-- ALERT --}}
    @if(session('success'))

        <div class="alert alert-success mt-4">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger mt-4">

            <strong>
                <i class="bi bi-exclamation-circle me-2"></i>
                Data belum dapat disimpan.
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- STATISTIK --}}
    <div class="row g-4 mt-2">

        {{-- TOTAL --}}
        <div class="col-md-6 col-xl-3">

            <div class="stat-card">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-muted">
                            Total Mobil
                        </div>

                        <div class="stat-number">
                            {{ $mobils->count() }}
                        </div>

                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-car-front"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- TERSEDIA --}}
        <div class="col-md-6 col-xl-3">

            <div class="stat-card">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-muted">
                            Tersedia
                        </div>

                        <div class="stat-number text-success">
                            {{ $mobils->where('status', 'Tersedia')->count() }}
                        </div>

                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- DISEWA --}}
        <div class="col-md-6 col-xl-3">

            <div class="stat-card">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-muted">
                            Sedang Disewa
                        </div>

                        <div class="stat-number text-warning">
                            {{ $mobils->where('status', 'Disewa')->count() }}
                        </div>

                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-key"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- MAINTENANCE --}}
        <div class="col-md-6 col-xl-3">

            <div class="stat-card">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <div class="text-muted">
                            Maintenance
                        </div>

                        <div class="stat-number text-danger">
                            {{ $mobils->where('status', 'Maintenance')->count() }}
                        </div>

                    </div>

                    <div class="stat-icon">
                        <i class="bi bi-tools"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- DATA MOBIL --}}
    <div class="mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="section-title mb-1">
                    Daftar Mobil
                </h3>

                <p class="text-muted mb-0">
                    Seluruh kendaraan yang terdaftar di RentalKu.
                </p>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Dashboard
                </a>

                <button type="button"
                        class="btn btn-green"
                        data-bs-toggle="modal"
                        data-bs-target="#tambahMobilModal">

                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Mobil

                </button>

            </div>

        </div>


        <div class="table-card">

            <div class="table-responsive">

                <table class="table align-middle mb-0" id="mobils-table">

                    <thead>

                        <tr>

                            <th class="px-3 py-3">
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
                        {{-- Diisi oleh DataTables (server-side) --}}
                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- MODAL TAMBAH MOBIL --}}
    <div class="modal fade"
         id="tambahMobilModal"
         tabindex="-1"
         aria-labelledby="tambahMobilModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="tambahMobilModalLabel">
                        <i class="bi bi-plus-circle text-success me-2"></i>
                        Tambah Mobil
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup"></button>

                </div>

                <div class="modal-body">

                    <form action="{{ route('mobils.store') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          id="formTambahMobil">

                        @csrf

                        <div class="row g-4">

                            {{-- BRAND --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Brand Mobil
                                </label>

                                <select name="brand_id" class="form-select" required>

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


                            {{-- TIPE --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Tipe Mobil
                                </label>

                                <select name="tipe_mobil_id" class="form-select" required>

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


                            {{-- CABANG --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Cabang
                                </label>

                                <select name="cabang_id" class="form-select" required>

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


                            {{-- NAMA --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Nama Mobil
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="Contoh: Toyota Avanza"
                                    value="{{ old('name') }}"
                                    required>

                            </div>


                            {{-- PLAT --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Plat Nomor
                                </label>

                                <input
                                    type="text"
                                    name="plate_number"
                                    class="form-control"
                                    placeholder="Contoh: KB 1234 AB"
                                    value="{{ old('plate_number') }}"
                                    required>

                            </div>


                            {{-- TAHUN --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Tahun
                                </label>

                                <input
                                    type="number"
                                    name="tahun"
                                    class="form-control"
                                    placeholder="Contoh: 2025"
                                    value="{{ old('tahun') }}"
                                    required>

                            </div>


                            {{-- TRANSMISI --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Transmisi
                                </label>

                                <select name="transmisi" class="form-select" required>

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


                            {{-- KAPASITAS --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Kapasitas Penumpang
                                </label>

                                <input
                                    type="number"
                                    name="kapasitas"
                                    min="1"
                                    placeholder="Kapasitas"
                                    value="{{ old('kapasitas') }}">

                            </div>


                            {{-- WARNA --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Warna
                                </label>

                                <input
                                    type="text"
                                    name="warna"
                                    class="form-control"
                                    placeholder="Contoh: Hitam"
                                    value="{{ old('warna') }}"
                                    required>

                            </div>


                            {{-- HARGA --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Harga Per Hari
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                    <input
                                        type="number"
                                        name="harga_perhari"
                                        class="form-control"
                                        placeholder="300000"
                                        value="{{ old('harga_perhari') }}"
                                        min="0"
                                        required>

                                </div>

                            </div>


                            {{-- DEPOSIT --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Deposit
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                    <input
                                        type="number"
                                        name="deposit"
                                        class="form-control"
                                        placeholder="500000"
                                        value="{{ old('deposit') }}"
                                        min="0"
                                        required>

                                </div>

                            </div>


                            {{-- FOTO --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Foto Mobil
                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.svg">

                                <small class="text-muted">
                                    JPG, PNG, JPEG, SVG • Maksimal 2MB
                                </small>

                            </div>


                            {{-- STATUS --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Status
                                </label>

                                <select name="status" class="form-select" required>

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


                            {{-- DESKRIPSI --}}
                            <div class="col-12">

                                <label class="form-label">
                                    Deskripsi
                                </label>

                                <textarea
                                    name="description"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Masukkan deskripsi mobil...">{{ old('description') }}</textarea>

                            </div>


                            {{-- FASILITAS --}}
                            <div class="col-12">

                                <label class="form-label">
                                    Fasilitas
                                </label>

                                <div class="facility-box">

                                    <div class="row g-2">

                                        @foreach($fasilitas as $fasilitasItem)

                                            <div class="col-md-4 col-lg-3">

                                                <label class="facility-item d-flex align-items-center gap-2">

                                                    <input
                                                        type="checkbox"
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

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        <i class="bi bi-x-circle me-1"></i>
                        Batal

                    </button>

                    <button type="submit"
                            form="formTambahMobil"
                            class="btn btn-green">

                        <i class="bi bi-save me-1"></i>
                        Simpan Mobil

                    </button>

                </div>

            </div>

        </div>

    </div>

    </div>


    {{-- MODAL EDIT MOBIL --}}
    <div class="modal fade"
         id="editMobilModal"
         tabindex="-1"
         aria-labelledby="editMobilModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="editMobilModalLabel">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Edit Mobil
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup"></button>

                </div>

                <div class="modal-body">

                    <form action=""
                          method="POST"
                          enctype="multipart/form-data"
                          id="formEditMobil">

                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            {{-- BRAND --}}
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


                            {{-- TIPE --}}
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


                            {{-- CABANG --}}
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


                            {{-- NAMA --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Nama Mobil
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="editName"
                                    class="form-control"
                                    placeholder="Contoh: Toyota Avanza"
                                    required>

                            </div>


                            {{-- PLAT --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Plat Nomor
                                </label>

                                <input
                                    type="text"
                                    name="plate_number"
                                    id="editPlateNumber"
                                    class="form-control"
                                    placeholder="Contoh: KB 1234 AB"
                                    required>

                            </div>


                            {{-- TAHUN --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Tahun
                                </label>

                                <input
                                    type="number"
                                    name="tahun"
                                    id="editTahun"
                                    class="form-control"
                                    placeholder="Contoh: 2025"
                                    required>

                            </div>


                            {{-- TRANSMISI --}}
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


                            {{-- KAPASITAS --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Kapasitas Penumpang
                                </label>

                                <input
                                    type="number"
                                    name="kapasitas"
                                    id="editKapasitas"
                                    class="form-control"
                                    min="1"
                                    placeholder="Kapasitas">

                            </div>


                            {{-- WARNA --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Warna
                                </label>

                                <input
                                    type="text"
                                    name="warna"
                                    id="editWarna"
                                    class="form-control"
                                    placeholder="Contoh: Hitam"
                                    required>

                            </div>


                            {{-- HARGA --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Harga Per Hari
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                    <input
                                        type="number"
                                        name="harga_perhari"
                                        id="editHargaPerhari"
                                        class="form-control"
                                        placeholder="300000"
                                        min="0"
                                        required>

                                </div>

                            </div>


                            {{-- DEPOSIT --}}
                            <div class="col-md-4">

                                <label class="form-label">
                                    Deposit
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        Rp
                                    </span>

                                    <input
                                        type="number"
                                        name="deposit"
                                        id="editDeposit"
                                        class="form-control"
                                        placeholder="500000"
                                        min="0"
                                        required>

                                </div>

                            </div>


                            {{-- FOTO --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Foto Mobil
                                </label>

                                <img
                                    id="editFotoPreview"
                                    src=""
                                    class="car-image mb-2"
                                    style="width:120px;height:90px;object-fit:cover;border-radius:10px;display:none;"
                                    alt="Preview foto mobil">

                                <input
                                    type="file"
                                    name="image"
                                    id="editImage"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.svg">

                                <small class="text-muted">
                                    JPG, PNG, JPEG, SVG • Maksimal 2MB • Kosongkan jika foto tidak diganti
                                </small>

                            </div>


                            {{-- STATUS --}}
                            <div class="col-md-6">

                                <label class="form-label">
                                    Status
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


                            {{-- DESKRIPSI --}}
                            <div class="col-12">

                                <label class="form-label">
                                    Deskripsi
                                </label>

                                <textarea
                                    name="description"
                                    id="editDescription"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Masukkan deskripsi mobil..."></textarea>

                            </div>


                            {{-- FASILITAS --}}
                            <div class="col-12">

                                <label class="form-label">
                                    Fasilitas
                                </label>

                                <div class="facility-box">

                                    <div class="row g-2">

                                        @foreach($fasilitas as $fasilitasItem)

                                            <div class="col-md-4 col-lg-3">

                                                <label class="facility-item d-flex align-items-center gap-2">

                                                    <input
                                                        type="checkbox"
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

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        <i class="bi bi-x-circle me-1"></i>
                        Batal

                    </button>

                    <button type="submit"
                            form="formEditMobil"
                            class="btn btn-green">

                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan

                    </button>

                </div>

            </div>

        </div>

    </div>


<footer class="bg-white border-top py-4">

    <div class="container text-center">

        <div class="fw-bold">
            Rental<span class="text-success">ku</span>.
        </div>

        <small class="text-muted">
            Management Mobil • RentalKu
        </small>

    </div>

</footer>


<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<script>
    const CSRF_TOKEN = '{{ csrf_token() }}';

    function statusBadge(status) {
        const map = {
            'Tersedia': 'status-tersedia',
            'Disewa': 'status-disewa',
            'Maintenance': 'status-maintenance',
        };

        const cls = map[status] || 'bg-secondary text-white';

        return '<span class="badge-status ' + cls + '">' + status + '</span>';
    }

    function mobilPhoto(image) {
        if (image) {
            return '<img src="' + '{{ asset('__PHOTO__') }}'.replace('__PHOTO__', image) +
                '" class="car-image" alt="Foto mobil">';
        }

        return '<div class="car-placeholder"><i class="bi bi-car-front fs-5"></i></div>';
    }

    function mobilActions(data) {
        let html = '<div class="d-flex gap-2">';

        html += '<button type="button" data-id="' + data.id +
            '" class="btn p-1 text-primary" style="border:none;background:none;" title="Edit" ' +
            'onclick="editMobil(this.dataset.id)">' +
            '<i class="bi bi-pencil-square"></i></button>';

        html += '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" title="Hapus" ' +
            'onclick="deleteMobil(' + data.id + ', \'' + data.name.replace(/'/g, "\\'") + '\')">' +
            '<i class="bi bi-trash"></i></button>';

        html += '</div>';

        return html;
    }

    $(document).ready(function() {

        $('#mobils-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('mobils.data') }}',
                type: 'GET',
            },
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'px-3',
                    width: '70px',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: null,
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<div class="d-flex align-items-center gap-3">' +
                            mobilPhoto(data.image) +
                            '<div><strong>' + data.name + '</strong>' +
                            '<div class="small text-muted">' + data.warna +
                            '</div></div></div>';
                    },
                },
                {
                    data: 'brand_name',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return data;
                    },
                },
                {
                    data: 'tipe_name',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return data;
                    },
                },
                {
                    data: 'cabang_name',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return data;
                    },
                },
                {
                    data: 'plate_number',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<span class="fw-semibold">' + data + '</span>';
                    },
                },
                {
                    data: 'tahun',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return data;
                    },
                },
                {
                    data: 'harga_perhari',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<span class="fw-semibold">Rp ' +
                            Number(data).toLocaleString('id-ID') + '</span>';
                    },
                },
                {
                    data: 'status',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return statusBadge(data);
                    },
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    width: '140px',
                    render: function(data) {
                        return mobilActions(data);
                    },
                },
            ],
            order: [
                [1, 'asc']
            ],
            language: {
                processing: 'Memproses...',
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(difilter dari _MAX_ total data)',
                infoPostFix: '',
                loadingRecords: 'Memuat...',
                zeroRecords: 'Tidak ditemukan data yang cocok',
                emptyTable: 'Belum ada mobil',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

    });

    function deleteMobil(id, name) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus mobil "' + name + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('mobils.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {
                    $('#mobils-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Mobil berhasil dihapus.',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                },
                error: function(xhr) {
                    const result = xhr.responseJSON || {};
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: result.message ||
                            'Terjadi kesalahan saat menghapus mobil.',
                    });
                }
            });
        });
    }

    function editMobil(id) {
        const data = $('#mobils-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data mobil tidak ditemukan.',
            });
            return;
        }

        // Isi action form dengan route update
        $('#formEditMobil').attr('action',
            "{{ route('mobils.update', '__ID__') }}".replace('__ID__', id));

        // Isi semua field
        $('#editBrandId').val(data.brand_id);
        $('#editTipeMobilId').val(data.tipe_mobil_id);
        $('#editCabangId').val(data.cabang_id);
        $('#editName').val(data.name);
        $('#editPlateNumber').val(data.plate_number);
        $('#editTahun').val(data.tahun);
        $('#editTransmisi').val(data.transmisi);
        $('#editKapasitas').val(data.kapasitas);
        $('#editWarna').val(data.warna);
        $('#editHargaPerhari').val(data.harga_perhari);
        $('#editDeposit').val(data.deposit);
        $('#editStatus').val(data.status);
        $('#editDescription').val(data.description);

        // Fasilitas
        $('#editMobilModal .edit-fasilitas-checkbox').prop('checked', false);

        if (data.fasilitas_ids && data.fasilitas_ids.length) {
            $('#editMobilModal .edit-fasilitas-checkbox').each(function() {
                if (data.fasilitas_ids.includes(parseInt($(this).val()))) {
                    $(this).prop('checked', true);
                }
            });
        }

        // Preview foto
        if (data.image) {
            $('#editFotoPreview')
                .attr('src', "{{ asset('__PHOTO__') }}".replace('__PHOTO__', data.image))
                .show();
        } else {
            $('#editFotoPreview').attr('src', '').hide();
        }

        // Kosongkan input file
        $('#editImage').val('');

        // Tampilkan modal
        bootstrap.Modal.getOrCreateInstance($('#editMobilModal')[0]).show();
    }

    $('#formEditMobil').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'PUT',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(result) {
                $('#editMobilModal').modal('hide');
                $('#mobils-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Mobil berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui mobil.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });
</script>

</body>
</html>