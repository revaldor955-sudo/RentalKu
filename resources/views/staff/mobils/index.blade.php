<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Mobil - RentalKu</title>

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
            background: #f5f7f6;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }

        .page-content {
            padding: 24px;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
        }

        .page-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .04);
        }

        .btn-green {
            background: #198754;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 18px;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }

        .car-image,
        .car-placeholder {
            width: 75px;
            height: 55px;
            border-radius: 10px;
        }

        .car-image {
            object-fit: cover;
        }

        .car-placeholder {
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 12px 16px;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .status {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
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

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        /* =====================================================
           INPUT RUPIAH
        ===================================================== */

        .rupiah-input {
            text-align: left;
        }
    </style>

    @include('layouts.partials.modal-head-style')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >
</head>

<body>

@include('layouts.partials.staff-sidebar')

<div class="page-content">

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Management Mobil
            </h2>

            <p class="text-muted mb-0">
                Kelola data kendaraan RentalKu.
            </p>

        </div>

        <button
            type="button"
            class="btn btn-green"
            data-bs-toggle="modal"
            data-bs-target="#tambahMobilModal"
        >
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Mobil
        </button>

    </div>


    @if(session('success'))

        <span id="flashSuccess" class="d-none">
            {{ session('success') }}
        </span>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Terdapat kesalahan:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="page-card">

        @if($mobils->count())

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th class="px-4 py-3">
                                #
                            </th>

                            <th>
                                Mobil
                            </th>

                            <th>
                                Brand
                            </th>

                            <th>
                                Plat Nomor
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

                            <th class="text-center">
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


                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        @if($mobil->image)

                                            <img
                                                src="{{ asset($mobil->image) }}"
                                                class="car-image"
                                                alt="{{ $mobil->name }}"
                                            >

                                        @else

                                            <div class="car-placeholder">

                                                <i class="bi bi-car-front"></i>

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
                                    {{ $mobil->plate_number ?? '-' }}
                                </td>


                                <td>
                                    {{ $mobil->tahun ?? '-' }}
                                </td>


                                <td>
                                    {{ ucfirst($mobil->transmisi ?? '-') }}
                                </td>


                                <td>
                                    Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}
                                </td>


                                <td>

                                    @if($mobil->status === 'Tersedia')

                                        <span class="status status-tersedia">
                                            Tersedia
                                        </span>

                                    @elseif($mobil->status === 'Disewa')

                                        <span class="status status-disewa">
                                            Disewa
                                        </span>

                                    @else

                                        <span class="status status-maintenance">
                                            Maintenance
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        <button
                                            type="button"
                                            class="btn p-1 text-primary"
                                            style="border:none;background:none;"
                                            title="Edit"
                                            data-id="{{ $mobil->id }}"
                                            onclick="editMobilStaff(this.dataset.id)"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                        </button>


                                        <form
                                            action="{{ route('staff.mobils.destroy', $mobil->id) }}"
                                            method="POST"
                                            onsubmit="return confirmSubmit(event, 'Yakin ingin menghapus mobil ini?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn p-1 text-danger"
                                                style="border:none;background:none;"
                                                title="Hapus"
                                            >

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

            <div class="text-center py-5">

                <i class="bi bi-car-front fs-1 text-muted"></i>

                <h5 class="fw-bold mt-3">
                    Belum ada data mobil
                </h5>

                <p class="text-muted mb-0">
                    Silakan tambahkan mobil baru.
                </p>

            </div>

        @endif

    </div>

</div>

</div>


{{-- =========================================================
     MODAL TAMBAH MOBIL
========================================================= --}}

<div
    class="modal fade"
    id="tambahMobilModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            @include(
                'layouts.partials.modal-head',
                [
                    'title' => 'Tambah Mobil',
                    'icon' => 'bi-car-front'
                ]
            )


            <form
                action="{{ route('staff.mobils.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="formTambahMobil"
            >

                @csrf


                <div class="modal-body">

                    <div class="row g-3">


                        {{-- NAMA MOBIL --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        {{-- PLAT NOMOR --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        {{-- BRAND --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        {{-- TIPE MOBIL --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        {{-- CABANG --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        {{-- TAHUN --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        {{-- TRANSMISI --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        {{-- KAPASITAS --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Kapasitas
                            </label>

                            <input
                                type="number"
                                name="kapasitas"
                                class="form-control"
                                placeholder="7"
                                min="1"
                                required
                            >

                        </div>


                        {{-- WARNA --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        {{-- =================================================
                             HARGA PER HARI
                             TAMPIL: 350.000
                             DIKIRIM: 350000
                        ================================================== --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Harga / Hari
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    type="text"
                                    id="harga_perhari_display"
                                    class="form-control rupiah-input"
                                    placeholder="350.000"
                                    autocomplete="off"
                                    inputmode="numeric"
                                    required
                                >

                            </div>

                            {{-- Nilai asli yang dikirim ke Laravel --}}

                            <input
                                type="hidden"
                                name="harga_perhari"
                                id="harga_perhari"
                            >

                            <small class="text-muted">
                                Contoh: 350.000
                            </small>

                        </div>


                        {{-- =================================================
                             DEPOSIT
                             TAMPIL: 500.000
                             DIKIRIM: 500000
                        ================================================== --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Deposit
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    type="text"
                                    id="deposit_display"
                                    class="form-control rupiah-input"
                                    placeholder="500.000"
                                    autocomplete="off"
                                    inputmode="numeric"
                                    required
                                >

                            </div>

                            {{-- Nilai asli yang dikirim ke Laravel --}}

                            <input
                                type="hidden"
                                name="deposit"
                                id="deposit"
                            >

                            <small class="text-muted">
                                Contoh: 500.000
                            </small>

                        </div>


                        {{-- STATUS --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        {{-- FOTO --}}

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Foto Mobil
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png"
                            >

                        </div>


                        {{-- FASILITAS --}}

                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Fasilitas
                            </label>

                            <div class="row g-2">

                                @foreach($fasilitas ?? [] as $item)

                                    <div class="col-md-4">

                                        <div class="form-check">

                                            <input
                                                type="checkbox"
                                                name="fasilitas[]"
                                                value="{{ $item->id }}"
                                                class="form-check-input"
                                                id="tambahFasilitas{{ $item->id }}"
                                            >

                                            <label
                                                class="form-check-label"
                                                for="tambahFasilitas{{ $item->id }}"
                                            >
                                                {{ $item->name }}
                                            </label>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Deskripsi mobil..."
                            ></textarea>

                        </div>


                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>


                    <button
                        type="submit"
                        class="btn btn-green"
                    >

                        <i class="bi bi-save me-1"></i>

                        Simpan Mobil

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- MODAL EDIT MOBIL --}}

<div
    class="modal fade"
    id="editMobilModal"
    tabindex="-1"
    aria-labelledby="editMobilModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            @include(
                'layouts.partials.modal-head',
                [
                    'title' => 'Edit Mobil',
                    'icon' => 'bi-pencil-square',
                    'titleId' => 'editMobilModalLabel'
                ]
            )


            <form
                action=""
                method="POST"
                enctype="multipart/form-data"
                id="formEditMobil"
            >

                @csrf

                @method('PUT')


                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Nama Mobil
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="editName"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Plat Nomor
                            </label>

                            <input
                                type="text"
                                name="plate_number"
                                id="editPlateNumber"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Brand
                            </label>

                            <select
                                name="brand_id"
                                id="editBrandId"
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

                            <label class="form-label fw-semibold">
                                Tipe Mobil
                            </label>

                            <select
                                name="tipe_mobil_id"
                                id="editTipeMobilId"
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

                            <label class="form-label fw-semibold">
                                Cabang
                            </label>

                            <select
                                name="cabang_id"
                                id="editCabangId"
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

                            <label class="form-label fw-semibold">
                                Tahun
                            </label>

                            <input
                                type="number"
                                name="tahun"
                                id="editTahun"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Transmisi
                            </label>

                            <select
                                name="transmisi"
                                id="editTransmisi"
                                class="form-select"
                                required
                            >

                                <option value="Manual">
                                    Manual
                                </option>

                                <option value="Matic">
                                    Matic
                                </option>

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Kapasitas
                            </label>

                            <input
                                type="number"
                                name="kapasitas"
                                id="editKapasitas"
                                class="form-control"
                                min="1"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Warna
                            </label>

                            <input
                                type="text"
                                name="warna"
                                id="editWarna"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Harga / Hari
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    type="text"
                                    id="editHargaDisplay"
                                    class="form-control rupiah-input"
                                    autocomplete="off"
                                    inputmode="numeric"
                                    required
                                >

                            </div>

                            <input
                                type="hidden"
                                name="harga_perhari"
                                id="editHarga"
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Deposit
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    Rp
                                </span>

                                <input
                                    type="text"
                                    id="editDepositDisplay"
                                    class="form-control rupiah-input"
                                    autocomplete="off"
                                    inputmode="numeric"
                                    required
                                >

                            </div>

                            <input
                                type="hidden"
                                name="deposit"
                                id="editDeposit"
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Status
                            </label>

                            <select
                                name="status"
                                id="editStatus"
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


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Foto Mobil
                            </label>

                            <img
                                id="editFotoPreview"
                                src=""
                                class="mb-2"
                                style="width:120px;height:90px;object-fit:cover;border-radius:10px;display:none;"
                                alt="Preview foto mobil"
                            >

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.svg"
                            >

                            <small class="text-muted">
                                Kosongkan jika foto tidak diganti.
                            </small>

                        </div>


                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Fasilitas
                            </label>

                            <div class="row g-2">

                                @foreach($fasilitas ?? [] as $item)

                                    <div class="col-md-4">

                                        <div class="form-check">

                                            <input
                                                type="checkbox"
                                                name="fasilitas[]"
                                                value="{{ $item->id }}"
                                                class="form-check-input edit-fasilitas-checkbox"
                                                id="editFasilitas{{ $item->id }}"
                                            >

                                            <label
                                                class="form-check-label"
                                                for="editFasilitas{{ $item->id }}"
                                            >
                                                {{ $item->name }}
                                            </label>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>


                        <div class="col-12">

                            <label class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                id="editDescription"
                                class="form-control"
                                rows="3"
                            ></textarea>

                        </div>


                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>


                    <button
                        type="submit"
                        class="btn btn-green"
                    >

                        <i class="bi bi-save me-1"></i>

                        Simpan Perubahan

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

@php
$mobilsData = [];
foreach ($mobils as $m) {
    $mobilsData[$m->id] = [
        'id' => $m->id,
        'brand_id' => $m->brand_id,
        'tipe_mobil_id' => $m->tipe_mobil_id,
        'cabang_id' => $m->cabang_id,
        'name' => $m->name,
        'plate_number' => $m->plate_number,
        'tahun' => $m->tahun,
        'transmisi' => $m->transmisi,
        'kapasitas' => $m->kapasitas,
        'warna' => $m->warna,
        'harga_perhari' => $m->harga_perhari,
        'deposit' => $m->deposit,
        'status' => $m->status,
        'description' => $m->description,
        'image' => $m->image ? asset($m->image) : null,
        'fasilitas_ids' => $m->fasilitas->pluck('id')->values()->all(),
    ];
}
@endphp

const MOBILS_DATA = @json($mobilsData);

function formatRupiah(angka) {

    if (angka === null || angka === undefined) {
        return '';
    }

    angka = String(angka).replace(/\D/g, '');

    if (angka === '') {
        return '';
    }

    return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}


$(document).on('input', '#harga_perhari_display', function () {

    var angka = $(this).val().replace(/\D/g, '');

    $('#harga_perhari').val(angka);

    $(this).val(formatRupiah(angka));

});


$(document).on('input', '#deposit_display', function () {

    var angka = $(this).val().replace(/\D/g, '');

    $('#deposit').val(angka);

    $(this).val(formatRupiah(angka));

});


$(document).on('input', '#editHargaDisplay', function () {

    var angka = $(this).val().replace(/\D/g, '');

    $('#editHarga').val(angka);

    $(this).val(formatRupiah(angka));

});


$(document).on('input', '#editDepositDisplay', function () {

    var angka = $(this).val().replace(/\D/g, '');

    $('#editDeposit').val(angka);

    $(this).val(formatRupiah(angka));

});


$(document).on('submit', '#formTambahMobil', function () {

    $('#harga_perhari').val($('#harga_perhari_display').val().replace(/\D/g, ''));

    $('#deposit').val($('#deposit_display').val().replace(/\D/g, ''));

});


$(document).on('submit', '#formEditMobil', function () {

    $('#editHarga').val($('#editHargaDisplay').val().replace(/\D/g, ''));

    $('#editDeposit').val($('#editDepositDisplay').val().replace(/\D/g, ''));

});


function editMobilStaff(id) {

    var data = MOBILS_DATA[id];

    if (!data) {

        Swal.fire({

            icon: 'error',

            title: 'Gagal',

            text: 'Data mobil tidak ditemukan.',

        });

        return;
    }

    $('#editBrandId').val(data.brand_id);
    $('#editTipeMobilId').val(data.tipe_mobil_id);
    $('#editCabangId').val(data.cabang_id);
    $('#editName').val(data.name);
    $('#editPlateNumber').val(data.plate_number);
    $('#editTahun').val(data.tahun);
    $('#editTransmisi').val(data.transmisi);
    $('#editKapasitas').val(data.kapasitas);
    $('#editWarna').val(data.warna);
    $('#editHarga').val(data.harga_perhari);
    $('#editDeposit').val(data.deposit);
    $('#editStatus').val(data.status);
    $('#editDescription').val(data.description);

    $('#editHargaDisplay').val(formatRupiah(data.harga_perhari));
    $('#editDepositDisplay').val(formatRupiah(data.deposit));

    if (data.image) {
        $('#editFotoPreview').attr('src', data.image).show();
    } else {
        $('#editFotoPreview').hide();
    }

    $('.edit-fasilitas-checkbox').prop('checked', false);

    if (data.fasilitas_ids && data.fasilitas_ids.length) {
        $.each(data.fasilitas_ids, function (i, fid) {
            $('.edit-fasilitas-checkbox[value="' + fid + '"]').prop('checked', true);
        });
    }

    $('#formEditMobil').attr(
        'action',
        "{{ route('staff.mobils.update', '__ID__') }}".replace('__ID__', id)
    );

    bootstrap.Modal.getOrCreateInstance($('#editMobilModal')[0]).show();
}


/* ============================================================
   SWEET ALERT SUCCESS
============================================================ */

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

})();


/* ============================================================
   KONFIRMASI HAPUS
============================================================ */

function confirmSubmit(event, message) {

    event.preventDefault();

    const form = event.target;

    Swal.fire({

        title: 'Konfirmasi',

        text: message,

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Ya',

        cancelButtonText: 'Batal',

    }).then((result) => {

        if (result.isConfirmed) {

            form.submit();

        }

    });

    return false;

}

</script>


</body>

</html>