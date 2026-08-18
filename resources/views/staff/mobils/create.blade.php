<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tambah Mobil - RentalKu</title>

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

        .page-header {
            margin-top: 30px;
            background: linear-gradient(135deg, #198754, #0f5132);
            border-radius: 22px;
            padding: 32px;
            color: white;
        }

        .page-header h1 {
            font-weight: 800;
        }

        .page-header p {
            color: #dff4e8;
            margin-bottom: 0;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            margin-top: 25px;
            margin-bottom: 50px;
        }

        .form-title {
            font-weight: 800;
            color: #212529;
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #198754;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #343a40;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px 13px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .12);
        }

        .required {
            color: #dc3545;
        }

        .facility-box {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 12px 15px;
            transition: .2s;
            cursor: pointer;
            height: 100%;
        }

        .facility-box:hover {
            border-color: #198754;
            background: #f5fbf7;
        }

        .facility-box .form-check-input {
            margin-top: 4px;
        }

        .facility-box .form-check-label {
            cursor: pointer;
            font-weight: 500;
        }

        .image-preview {
            width: 100%;
            height: 220px;
            border: 2px dashed #ced4da;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f8f9fa;
            color: #8a938e;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-green {
            background: #198754;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            padding: 11px 20px;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }

        .btn-cancel {
            border-radius: 10px;
            padding: 11px 20px;
            font-weight: 600;
        }

        footer {
            margin-top: 50px;
        }

    </style>

</head>


<body>


{{-- NAVBAR --}}

<nav class="navbar">

    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center">

            <a
                href="{{ route('staff.dashboard') }}"
                class="text-decoration-none brand"
            >

                Rental<span>ku</span>.

            </a>


            <div class="d-flex align-items-center gap-3">

                <span class="d-none d-md-block">

                    <i class="bi bi-person-circle me-1"></i>

                    {{ Auth::user()->name }}

                </span>


                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-outline-danger btn-sm"
                    >

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

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <span class="badge bg-light text-success mb-2 px-3 py-2">

                    <i class="bi bi-plus-circle"></i>

                    Staff Rental

                </span>


                <h1 class="mb-2">

                    Tambah Mobil

                </h1>


                <p>

                    Tambahkan kendaraan baru ke dalam data RentalKu.

                </p>

            </div>


            <div class="d-none d-md-block">

                <i
                    class="bi bi-car-front-fill"
                    style="font-size: 90px; opacity: .15;"
                ></i>

            </div>

        </div>

    </div>



    {{-- ERROR --}}

    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show mt-4">

            <div class="fw-bold mb-2">

                <i class="bi bi-exclamation-triangle me-2"></i>

                Terdapat kesalahan:

            </div>


            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif



    {{-- FORM --}}

    <div class="form-card">

        <form
            action="{{ route('staff.mobils.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="p-4 p-md-5">


                {{-- INFORMASI DASAR --}}

                <div class="section-title">

                    <i class="bi bi-car-front me-2"></i>

                    Informasi Mobil

                </div>


                <div class="row g-4">


                    {{-- BRAND --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Brand

                            <span class="required">*</span>

                        </label>


                        <select
                            name="brand_id"
                            class="form-select @error('brand_id') is-invalid @enderror"
                        >

                            <option value="">
                                -- Pilih Brand --
                            </option>


                            @foreach($brands as $brand)

    <option
        value="{{ $brand->id }}"
        {{ old('brand_id') == $brand->id ? 'selected' : '' }}
    >

        {{ $brand->name }}

    </option>

@endforeach

                        </select>


                        @error('brand_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- TIPE MOBIL --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Tipe Mobil

                            <span class="required">*</span>

                        </label>


                        <select
                            name="tipe_mobil_id"
                            class="form-select @error('tipe_mobil_id') is-invalid @enderror"
                        >

                            <option value="">
                                -- Pilih Tipe Mobil --
                            </option>

@foreach($tipeMobils as $tipe)

    <option
        value="{{ $tipe->id }}"
        {{ old('tipe_mobil_id') == $tipe->id ? 'selected' : '' }}
    >
        {{ $tipe->name }}
    </option>

@endforeach
                        </select>


                        @error('tipe_mobil_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- NAMA MOBIL --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Nama Mobil

                            <span class="required">*</span>

                        </label>


                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Contoh: Toyota Avanza"
                        >


                        @error('name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- PLAT --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Plat Nomor

                            <span class="required">*</span>

                        </label>


                        <input
                            type="text"
                            name="plate_number"
                            value="{{ old('plate_number') }}"
                            class="form-control @error('plate_number') is-invalid @enderror"
                            placeholder="Contoh: KB 1234 AB"
                        >


                        @error('plate_number')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- TAHUN --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            Tahun

                            <span class="required">*</span>

                        </label>


                        <input
                            type="number"
                            name="tahun"
                            value="{{ old('tahun') }}"
                            class="form-control @error('tahun') is-invalid @enderror"
                            min="1990"
                            max="{{ date('Y') }}"
                            placeholder="2024"
                        >


                        @error('tahun')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- TRANSMISI --}}

                    <div class="col-md-4">

                        <label class="form-label">

                            Transmisi

                            <span class="required">*</span>

                        </label>


                        <select
                            name="transmisi"
                            class="form-select @error('transmisi') is-invalid @enderror"
                        >

                            <option value="">
                                -- Pilih --
                            </option>

                            <option
                                value="Manual"
                                {{ old('transmisi') == 'Manual' ? 'selected' : '' }}
                            >
                                Manual
                            </option>

                            <option
                                value="Matic"
                                {{ old('transmisi') == 'Matic' ? 'selected' : '' }}
                            >
                                Matic
                            </option>

                        </select>


                        @error('transmisi')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                {{-- KAPASITAS --}}

<div class="col-md-4">

    <label class="form-label">
        Kapasitas
        <span class="required">*</span>
    </label>

    <div class="input-group">

        <input
            type="number"
            name="kapasitas"
            value="{{ old('kapasitas', 4) }}"
            class="form-control @error('kapasitas') is-invalid @enderror"
            min="1"
            required
            placeholder="4"
        >

        <span class="input-group-text">
            orang
        </span>

    </div>

    @error('kapasitas')
        <div class="text-danger small mt-1">
            {{ $message }}
        </div>
    @enderror

</div>



                    {{-- WARNA --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Warna

                            <span class="required">*</span>

                        </label>


                        <input
                            type="text"
                            name="warna"
                            value="{{ old('warna') }}"
                            class="form-control @error('warna') is-invalid @enderror"
                            placeholder="Contoh: Hitam"
                        >


                        @error('warna')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                 <div class="col-md-6">

    <label class="form-label">
        Cabang
        <span class="required">*</span>
    </label>

    <select
        name="cabang_id"
        id="cabang_id"
        class="form-select @error('cabang_id') is-invalid @enderror"
        required
    >
        <option value="">-- Pilih Cabang --</option>

        @foreach($cabangs as $cabang)

            <option
                value="{{ $cabang->id }}"
                {{ old('cabang_id') == $cabang->id ? 'selected' : '' }}
            >
                {{ $cabang->name }}
            </option>

        @endforeach

    </select>

    @error('cabang_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>



                {{-- HARGA --}}

                <div class="section-title mt-5">

                    <i class="bi bi-cash-stack me-2"></i>

                    Harga dan Status

                </div>


                <div class="row g-4">


                    {{-- HARGA PER HARI --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Harga per Hari

                            <span class="required">*</span>

                        </label>


                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="number"
                                name="harga_perhari"
                                value="{{ old('harga_perhari') }}"
                                class="form-control @error('harga_perhari') is-invalid @enderror"
                                min="0"
                                placeholder="350000"
                            >

                        </div>


                        @error('harga_perhari')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- DEPOSIT --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Deposit

                            <span class="required">*</span>

                        </label>


                        <div class="input-group">

                            <span class="input-group-text">
                                Rp
                            </span>

                            <input
                                type="number"
                                name="deposit"
                                value="{{ old('deposit') }}"
                                class="form-control @error('deposit') is-invalid @enderror"
                                min="0"
                                placeholder="500000"
                            >

                        </div>


                        @error('deposit')

                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    {{-- STATUS --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Status

                            <span class="required">*</span>

                        </label>


                        <select
                            name="status"
                            class="form-select @error('status') is-invalid @enderror"
                        >

                            <option value="">
                                -- Pilih Status --
                            </option>

                            <option
                                value="Tersedia"
                                {{ old('status', 'Tersedia') == 'Tersedia' ? 'selected' : '' }}
                            >
                                Tersedia
                            </option>

                            <option
                                value="Disewa"
                                {{ old('status') == 'Disewa' ? 'selected' : '' }}
                            >
                                Disewa
                            </option>

                            <option
                                value="Maintenance"
                                {{ old('status') == 'Maintenance' ? 'selected' : '' }}
                            >
                                Maintenance
                            </option>

                        </select>


                        @error('status')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                </div>



                {{-- FOTO --}}

                <div class="section-title mt-5">

                    <i class="bi bi-image me-2"></i>

                    Foto Mobil

                </div>


                <div class="row g-4">


                    <div class="col-md-6">

                        <label class="form-label">

                            Foto Mobil

                        </label>


                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="form-control @error('image') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png,.svg"
                        >


                        <small class="text-muted">

                            Format: JPG, JPEG, PNG, SVG. Maksimal 2MB.

                        </small>


                        @error('image')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <div class="image-preview" id="imagePreview">

                            <div class="text-center">

                                <i
                                    class="bi bi-image"
                                    style="font-size: 40px;"
                                ></i>

                                <div class="mt-2">

                                    Preview Foto

                                </div>

                            </div>

                        </div>

                    </div>


                </div>



                {{-- FASILITAS --}}

                <div class="section-title mt-5">

                    <i class="bi bi-check2-square me-2"></i>

                    Fasilitas Mobil

                </div>


                <div class="row g-3">

                    @forelse($fasilitas as $item)

                        <div class="col-md-4 col-sm-6">

                            <label class="facility-box d-flex gap-3">

                                <input
                                    type="checkbox"
                                    name="fasilitas[]"
                                    value="{{ $item->id }}"
                                    class="form-check-input"
                                    {{ in_array($item->id, old('fasilitas', [])) ? 'checked' : '' }}
                                >

                                <span class="form-check-label">

                                    {{ $item->nama_fasilitas }}

                                </span>

                            </label>

                        </div>

                    @empty

                        <div class="col-12">

                            <div class="alert alert-light border">

                                Belum ada data fasilitas.

                            </div>

                        </div>

                    @endforelse

                </div>



                {{-- DESKRIPSI --}}

                <div class="section-title mt-5">

                    <i class="bi bi-card-text me-2"></i>

                    Deskripsi

                </div>


                <div>

                    <label class="form-label">

                        Deskripsi Mobil

                    </label>


                    <textarea
                        name="description"
                        rows="5"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Masukkan deskripsi mobil..."
                    >{{ old('description') }}</textarea>


                    @error('description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>



                {{-- BUTTON --}}

                <div class="d-flex justify-content-end gap-2 mt-5">

                    <a
                        href="{{ route('staff.mobils.index') }}"
                        class="btn btn-outline-secondary btn-cancel"
                    >

                        <i class="bi bi-arrow-left me-1"></i>

                        Kembali

                    </a>


                    <button
                        type="submit"
                        class="btn btn-green"
                    >

                        <i class="bi bi-check-lg me-1"></i>

                        Simpan Mobil

                    </button>

                </div>


            </div>

        </form>

    </div>

</div>



<footer class="bg-white border-top py-4">

    <div class="container text-center">

        <div class="fw-bold">

            Rental<span class="text-success">ku</span>.

        </div>

        <small class="text-muted">

            Staff Dashboard • Tambah Data Mobil

        </small>

    </div>

</footer>



<script>

    document.getElementById('image').addEventListener('change', function(event) {

        const file = event.target.files[0];

        const preview = document.getElementById('imagePreview');

        if (!file) {

            preview.innerHTML = `
                <div class="text-center">
                    <i class="bi bi-image" style="font-size: 40px;"></i>
                    <div class="mt-2">Preview Foto</div>
                </div>
            `;

            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {

            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview Foto">
            `;

        };

        reader.readAsDataURL(file);

    });

</script>



<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>