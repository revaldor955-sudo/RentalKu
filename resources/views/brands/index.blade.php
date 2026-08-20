<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Brand - RentalKu</title>

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
            color: #1f2937;
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 27px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .page-card {
            background: white;
            border: 1px solid #edf0ee;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,.05);
        }

        .page-title {
            font-size: 30px;
            font-weight: 800;
        }

        .btn-green {
            background: #198754;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            padding: 10px 17px;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }

        .table thead th {
            background: #f8faf9;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            border-bottom: 1px solid #e9ecef;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .brand-logo {
            width: 55px;
            height: 55px;
            object-fit: contain;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: white;
            padding: 5px;
        }

        .no-logo {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .brand-name {
            font-weight: 700;
        }

        .description {
            max-width: 300px;
            color: #6b7280;
            font-size: 14px;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-header {
            background: #198754;
            color: white;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px 13px;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25,135,84,.12);
        }

        .empty {
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
            margin: auto;
            font-size: 30px;
        }

    </style>

</head>

<body>

{{-- NAVBAR --}}

@include('layouts.partials.admin-navbar')


<div class="container py-5">

    {{-- HEADER --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="page-title mb-1">
                Kategori Merek
            </h1>

            <p class="text-muted mb-0">
                Kelola merek kendaraan yang tersedia di RentalKu.
            </p>

        </div>

        <button
            type="button"
            class="btn btn-green"
            data-bs-toggle="modal"
            data-bs-target="#tambahBrandModal"
        >
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Merek
        </button>

    </div>


    {{-- SUCCESS --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- ERROR --}}

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- VALIDATION ERROR --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Terdapat kesalahan:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- TABLE --}}

    <div class="page-card">

        @if($brands->count())

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th class="px-4 py-3">
                                #
                            </th>

                            <th>
                                Logo
                            </th>

                            <th>
                                Merek
                            </th>

                            <th>
                                Deskripsi
                            </th>

                            <th>
                                Jumlah Mobil
                            </th>

                            <th>
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($brands as $brand)

                            <tr>

                                <td class="px-4">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- LOGO --}}

                                <td>

                                    @if($brand->logo)

                                        <img
                                            src="{{ asset($brand->logo) }}"
                                            class="brand-logo"
                                            alt="{{ $brand->name }}"
                                        >

                                    @else

                                        <div class="no-logo">

                                            <i class="bi bi-car-front-fill"></i>

                                        </div>

                                    @endif

                                </td>


                                {{-- NAME --}}

                                <td>

                                    <div class="brand-name">
                                        {{ $brand->name }}
                                    </div>

                                </td>


                                {{-- DESCRIPTION --}}

                                <td>

                                    <div class="description">

                                        {{ $brand->description ?: 'Tidak ada deskripsi.' }}

                                    </div>

                                </td>


                                {{-- JUMLAH MOBIL --}}

                                <td>

                                    <span class="badge bg-success-subtle text-success px-3 py-2">

                                        {{ $brand->mobils->count() }}

                                        Mobil

                                    </span>

                                </td>


                                {{-- ACTION --}}

                                <td>

                                    <div class="d-flex gap-2">

                                        {{-- EDIT --}}

                                        <button
                                            type="button"
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editBrand{{ $brand->id }}"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>


                                        {{-- DELETE --}}

                                        @if($brand->mobils->count() == 0)

                                            <form
                                                action="{{ route('brands.destroy', $brand->id) }}"
                                                method="POST"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="confirmAction(event, 'Yakin ingin menghapus merek {{ $brand->name }}?')"
                                                >

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        @else

                                            <button
                                                type="button"
                                                class="btn btn-secondary btn-sm"
                                                disabled
                                                title="Brand masih digunakan mobil"
                                            >

                                                <i class="bi bi-lock"></i>

                                            </button>

                                        @endif

                                    </div>

                                </td>

                            </tr>


                            {{-- MODAL EDIT --}}

                            <div
                                class="modal fade"
                                id="editBrand{{ $brand->id }}"
                                tabindex="-1"
                            >

                                <div class="modal-dialog modal-dialog-centered">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title fw-bold">
                                                Edit Merek
                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"
                                            ></button>

                                        </div>


                                        <form
                                            action="{{ route('brands.update', $brand->id) }}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                        >

                                            @csrf

                                            @method('PUT')


                                            <div class="modal-body p-4">

                                                <div class="mb-3">

                                                    <label class="form-label fw-bold">
                                                        Nama Merek
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="name"
                                                        class="form-control"
                                                        value="{{ $brand->name }}"
                                                        required
                                                    >

                                                </div>


                                                <div class="mb-3">

                                                    <label class="form-label fw-bold">
                                                        Logo
                                                    </label>

                                                    <input
                                                        type="file"
                                                        name="logo"
                                                        class="form-control"
                                                        accept=".jpg,.jpeg,.png,.svg"
                                                    >

                                                    <small class="text-muted">
                                                        Kosongkan jika tidak ingin mengganti logo.
                                                    </small>

                                                </div>


                                                <div class="mb-3">

                                                    <label class="form-label fw-bold">
                                                        Deskripsi
                                                    </label>

                                                    <textarea
                                                        name="description"
                                                        class="form-control"
                                                        rows="4"
                                                    >{{ $brand->description }}</textarea>

                                                </div>

                                            </div>


                                            <div class="modal-footer">

                                                <button
                                                    type="button"
                                                    class="btn btn-outline-secondary"
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

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty">

                <div class="empty-icon">

                    <i class="bi bi-tags"></i>

                </div>

                <h5 class="fw-bold mt-4">
                    Belum Ada Merek
                </h5>

                <p class="text-muted mb-4">
                    Tambahkan merek kendaraan pertama untuk RentalKu.
                </p>

                <button
                    type="button"
                    class="btn btn-green"
                    data-bs-toggle="modal"
                    data-bs-target="#tambahBrandModal"
                >
                    <i class="bi bi-plus-lg me-1"></i>
                    Tambah Merek
                </button>

            </div>

        @endif

    </div>

</div>


{{-- MODAL TAMBAH --}}

<div
    class="modal fade"
    id="tambahBrandModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Tambah Merek
                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                action="{{ route('brands.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <div class="modal-body p-4">

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Nama Merek
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Contoh: Toyota"
                            value="{{ old('name') }}"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Logo
                        </label>

                        <input
                            type="file"
                            name="logo"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.svg"
                        >

                        <small class="text-muted">
                            JPG, JPEG, PNG, atau SVG. Maksimal 2 MB.
                        </small>

                    </div>


                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                            placeholder="Deskripsi singkat mengenai merek..."
                        >{{ old('description') }}</textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-green"
                    >
                        <i class="bi bi-plus-lg me-1"></i>
                        Tambah Merek
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

    function confirmAction(event, message) {
        event.preventDefault();

        const form = event.target.closest('form');

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
    }

</script>

</body>

</html>