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

    <style>
        body {
            background: #f5f7f6;
            font-family: Arial, sans-serif;
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

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
<nav class="navbar">
    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center w-100">

            <a href="{{ route('admin.dashboard') }}"
               class="text-decoration-none brand">
                Rental<span>ku</span>.
            </a>

            <div class="d-flex align-items-center gap-3">

                <div class="profile d-flex align-items-center gap-2">

                    <div class="profile-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>

                    <div class="d-none d-md-block">

                        <div class="fw-bold small">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="text-muted" style="font-size:12px;">
                            Administrator
                        </div>

                    </div>

                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i>
                        Keluar
                    </button>
                </form>

            </div>

        </div>

    </div>
</nav>


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


    {{-- FORM TAMBAH MOBIL --}}
    <div class="content-card mt-5">

        <div class="content-header">

            <h4 class="section-title mb-1">
                <i class="bi bi-plus-circle text-success me-2"></i>
                Tambah Mobil
            </h4>

            <p class="text-muted mb-0">
                Tambahkan kendaraan baru ke sistem RentalKu.
            </p>

        </div>


        <div class="p-4">

            <form action="{{ route('mobils.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

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
    value="{{ old('kapasitas') }}"
>


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


                    {{-- BUTTON --}}
                    <div class="col-12 text-end">

                        <button type="submit" class="btn btn-green">

                            <i class="bi bi-save me-1"></i>
                            Simpan Mobil

                        </button>

                    </div>

                </div>

            </form>

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

        </div>


        <div class="table-card">

            @if($mobils->count())

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th class="px-4 py-3">
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

                            @foreach($mobils as $mobil)

                                <tr>

                                    <td class="px-4">
                                        {{ $loop->iteration }}
                                    </td>


                                    {{-- MOBIL --}}
                                    <td>

                                        <div class="d-flex align-items-center gap-3">

                                            @if($mobil->image)

                                                <img
                                                    src="{{ asset($mobil->image) }}"
                                                    class="car-image"
                                                    alt="{{ $mobil->name }}">

                                            @else

                                                <div class="car-placeholder">

                                                    <i class="bi bi-car-front fs-5"></i>

                                                </div>

                                            @endif


                                            <div>

                                                <div class="fw-bold">
                                                    {{ $mobil->name }}
                                                </div>

                                                <small class="text-muted">
                                                    {{ $mobil->warna }}
                                                </small>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- BRAND --}}
                                    <td>

                                        {{ $mobil->brand?->name ?? '-' }}

                                    </td>


                                    {{-- TIPE --}}
                                    <td>

                                        {{ $mobil->tipeMobil?->name ?? '-' }}

                                    </td>


                                    {{-- CABANG --}}
                                    <td>

                                        {{ $mobil->cabang?->name ?? '-' }}

                                    </td>


                                    {{-- PLAT --}}
                                    <td>

                                        <span class="fw-semibold">
                                            {{ $mobil->plate_number }}
                                        </span>

                                    </td>


                                    {{-- TAHUN --}}
                                    <td>
                                        {{ $mobil->tahun }}
                                    </td>


                                    {{-- HARGA --}}
                                    <td>

                                        <span class="fw-semibold">

                                            Rp
                                            {{ number_format($mobil->harga_perhari, 0, ',', '.') }}

                                        </span>

                                    </td>


                                    {{-- STATUS --}}
                                    <td>

                                        @if($mobil->status === 'Tersedia')

                                            <span class="badge-status status-tersedia">
                                                Tersedia
                                            </span>

                                        @elseif($mobil->status === 'Disewa')

                                            <span class="badge-status status-disewa">
                                                Disewa
                                            </span>

                                        @else

                                            <span class="badge-status status-maintenance">
                                                Maintenance
                                            </span>

                                        @endif

                                    </td>


                                    {{-- AKSI --}}
                                    <td>

                                        <div class="d-flex gap-2">

                                            {{-- EDIT --}}
                                            <a
                                                href="{{ route('mobils.edit', $mobil->id) }}"
                                                class="btn btn-outline-primary btn-action"
                                                title="Edit">

                                                <i class="bi bi-pencil"></i>

                                            </a>


                                            {{-- HAPUS --}}
                                            <form
                                                action="{{ route('mobils.destroy', $mobil->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus mobil ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-action"
                                                    title="Hapus">

                                                    <i class="bi bi-trash"></i>

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

                <div class="text-center p-5">

                    <i class="bi bi-car-front fs-1 text-muted"></i>

                    <h5 class="fw-bold mt-3">
                        Belum ada data mobil
                    </h5>

                    <p class="text-muted">
                        Silakan tambahkan mobil melalui form di atas.
                    </p>

                </div>

            @endif

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


</body>
</html>