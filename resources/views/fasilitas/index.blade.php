<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Management Fasilitas - RentalKu</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    body {
        background: #f5f7f6;
        font-family: Arial, Helvetica, sans-serif;
        color: #1f2937;
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

    .page-title {
        font-weight: 800;
    }

    .page-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #edf0ee;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
    }

    .form-control {
        border-radius: 10px;
        padding: 11px 13px;
    }

    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .12);
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

    .table thead th {
        background: #f8faf9;
        color: #6c757d;
        font-size: 12px;
        text-transform: uppercase;
        border-bottom: 1px solid #e9ecef;
    }

    .table tbody td {
        vertical-align: middle;
    }

    .facility-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #e9f7ef;
        color: #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>

</head>

<body>

<nav class="navbar">
    <div class="container py-3">

    <div class="d-flex justify-content-between align-items-center">

        <a
            href="{{ route('admin.dashboard') }}"
            class="text-decoration-none brand">
            Rental<span>ku</span>.
        </a>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.dashboard') }}"
                class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-speedometer2 me-1"></i>
                Dashboard
            </a>

            <form
                action="{{ route('logout') }}"
                method="POST">

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-danger btn-sm">

                    <i class="bi bi-box-arrow-right me-1"></i>
                    Keluar

                </button>

            </form>

        </div>

    </div>

</div>

</nav>

<div class="container py-5">

{{-- HEADER --}}

<div class="mb-4">

    <h2 class="page-title mb-1">
        Management Fasilitas
    </h2>

    <p class="text-muted mb-0">
        Kelola fasilitas yang tersedia pada kendaraan RentalKu.
    </p>

</div>


{{-- SUCCESS --}}

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        <i class="bi bi-check-circle-fill me-2"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif


{{-- ERROR --}}

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


<div class="row g-4">

    {{-- FORM TAMBAH --}}

    <div class="col-lg-4">

        <div class="page-card p-4">

            <h5 class="fw-bold mb-1">
                <i class="bi bi-plus-circle text-success me-2"></i>
                Tambah Fasilitas
            </h5>

            <p class="text-muted small mb-4">
                Tambahkan fasilitas baru untuk kendaraan.
            </p>

            <form
                action="{{ route('fasilitas.store') }}"
                method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Nama Fasilitas
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Contoh: AC"
                        required>

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <button
                    type="submit"
                    class="btn btn-green w-100">

                    <i class="bi bi-save me-1"></i>
                    Simpan Fasilitas

                </button>

            </form>

        </div>

    </div>


    {{-- DAFTAR FASILITAS --}}

    <div class="col-lg-8">

        <div class="page-card">

            <div class="p-4 border-bottom">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Daftar Fasilitas
                        </h5>

                        <small class="text-muted">
                            {{ $fasilitas->count() }} fasilitas tersedia
                        </small>

                    </div>

                    <span class="badge bg-success rounded-pill">
                        {{ $fasilitas->count() }}
                    </span>

                </div>

            </div>


            @if($fasilitas->count())

                <div class="table-responsive">

                    <table class="table mb-0">

                        <thead>

                            <tr>

                                <th class="px-4 py-3">
                                    No
                                </th>

                                <th>
                                    Fasilitas
                                </th>

                                <th class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($fasilitas as $item)

                                <tr>

                                    <td class="px-4">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>

                                        <div class="d-flex align-items-center gap-3">

                                            <div class="facility-icon">

                                                <i class="bi bi-check-circle"></i>

                                            </div>

                                            <strong>
                                                {{ $item->name }}
                                            </strong>

                                        </div>

                                    </td>

                                    <td class="text-center">

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- EDIT --}}

                                            <button
                                                type="button"
                                                class="btn btn-warning btn-sm btn-action"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $item->id }}">

                                                <i class="bi bi-pencil"></i>

                                            </button>


                                            {{-- DELETE --}}

                                            <form
                                                action="{{ route('fasilitas.destroy', $item->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm btn-action"
                                                    onclick="return confirm('Yakin ingin menghapus fasilitas {{ $item->name }}?')">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                                {{-- MODAL EDIT --}}

                                <div
                                    class="modal fade"
                                    id="editModal{{ $item->id }}"
                                    tabindex="-1">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5 class="modal-title fw-bold">
                                                    Edit Fasilitas
                                                </h5>

                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal">
                                                </button>

                                            </div>

                                            <form
                                                action="{{ route('fasilitas.update', $item->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">

                                                    <label class="form-label fw-semibold">
                                                        Nama Fasilitas
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="name"
                                                        value="{{ $item->name }}"
                                                        class="form-control"
                                                        required>

                                                </div>

                                                <div class="modal-footer">

                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">

                                                        Batal

                                                    </button>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-success">

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

                <div class="text-center py-5">

                    <i class="bi bi-tools fs-1 text-muted"></i>

                    <h5 class="fw-bold mt-3">
                        Belum ada fasilitas
                    </h5>

                    <p class="text-muted mb-0">
                        Silakan tambahkan fasilitas pertama.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>
