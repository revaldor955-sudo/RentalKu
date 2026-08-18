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

    <style>
        body {
            background: #f5f7f6;
            font-family: Arial, Helvetica, sans-serif;
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

        .car-image {
            width: 75px;
            height: 55px;
            object-fit: cover;
            border-radius: 10px;
        }

        .car-placeholder {
            width: 75px;
            height: 55px;
            border-radius: 10px;
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

        .modal-header {
            background: #198754;
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center w-100">

            <a
                href="{{ route('staff.dashboard') }}"
                class="text-decoration-none brand"
            >
                Rental<span>ku</span>.
            </a>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('staff.dashboard') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    <i class="bi bi-speedometer2 me-1"></i>
                    Dashboard
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="btn btn-outline-danger btn-sm"
                    >
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Keluar
                    </button>
                </form>

            </div>

        </div>

    </div>
</nav>


<div class="container py-5">

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

        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Terdapat kesalahan:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
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

                            <th class="px-4 py-3">#</th>

                            <th>Mobil</th>

                            <th>Brand</th>

                            <th>Plat Nomor</th>

                            <th>Tahun</th>

                            <th>Transmisi</th>

                            <th>Harga / Hari</th>

                            <th>Status</th>

                            <th class="text-center">Aksi</th>

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

                                    @if($mobil->status === 'Tersedia' || $mobil->status === 'tersedia')

                                        <span class="status status-tersedia">
                                            Tersedia
                                        </span>

                                    @elseif($mobil->status === 'Disewa' || $mobil->status === 'disewa')

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

                                        <a
                                            href="{{ route('staff.mobils.edit', $mobil->id) }}"
                                            class="btn btn-warning btn-sm"
                                            title="Edit"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form
                                            action="{{ route('staff.mobils.destroy', $mobil->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus mobil ini?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
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


{{-- MODAL TAMBAH MOBIL --}}

<div
    class="modal fade"
    id="tambahMobilModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-car-front me-2"></i>
                    Tambah Mobil
                </h5>

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

                    <div class="row g-3">

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


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
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


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Harga / Hari
                            </label>

                            <input
                                type="number"
                                name="harga_perhari"
                                class="form-control"
                                placeholder="350000"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Deposit
                            </label>

                            <input
                                type="number"
                                name="deposit"
                                class="form-control"
                                placeholder="500000"
                                required
                            >

                        </div>


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


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>