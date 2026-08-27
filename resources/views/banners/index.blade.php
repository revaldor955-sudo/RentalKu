<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Banner - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f5f7f6;
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        .page-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .04);
            overflow: hidden;
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

        .banner-image {
            width: 150px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        .image-placeholder {
            width: 150px;
            height: 80px;
            border-radius: 12px;
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .status-active {
            background: #dff7e8;
            color: #198754;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-inactive {
            background: #f8d7da;
            color: #b02a37;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
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
            padding: 10px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .12);
        }

        .form-label {
            font-weight: 600;
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

            <h2 class="fw-bold mb-1">
                Management Banner
            </h2>

            <p class="text-muted mb-0">
                Kelola banner yang ditampilkan pada halaman utama RentalKu.
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
                data-bs-target="#tambahBannerModal">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah Banner

            </button>

        </div>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- VALIDATION --}}
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


    {{-- TABLE --}}
    <div class="page-card">

        @if($banners->count())

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th class="px-4 py-3">No</th>

                            <th class="px-4 py-3">Banner</th>

                            <th class="px-4 py-3">Judul</th>

                            <th class="px-4 py-3">Urutan</th>

                            <th class="px-4 py-3">Status</th>

                            <th class="px-4 py-3 text-center">Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($banners as $banner)

                            <tr>

                                {{-- NO --}}
                                <td class="px-4">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- GAMBAR --}}
                                <td>

                                    @if($banner->gambar)

                                        <img
                                            src="{{ asset($banner->gambar) }}"
                                            class="banner-image"
                                            alt="{{ $banner->judul }}"
                                        >

                                    @else

                                        <div class="image-placeholder">
                                            <i class="bi bi-image"></i>
                                        </div>

                                    @endif

                                </td>


                                {{-- JUDUL --}}
                                <td>

                                    <strong>
                                        {{ $banner->judul }}
                                    </strong>

                                    @if($banner->description)

                                        <div class="small text-muted">

                                            {{ Str::limit($banner->description, 60) }}

                                        </div>

                                    @endif

                                </td>


                                {{-- URUTAN --}}
                                <td>
                                    {{ $banner->urutan ?? 0 }}
                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($banner->status === 'aktif')

                                        <span class="status-active">
                                            Aktif
                                        </span>

                                    @else

                                        <span class="status-inactive">
                                            Tidak Aktif
                                        </span>

                                    @endif

                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- EDIT --}}
                                        <button
                                            type="button"
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editBanner{{ $banner->id }}"
                                            title="Edit">

                                            <i class="bi bi-pencil-square"></i>

                                        </button>


                                        {{-- HAPUS --}}
                                        <form
                                            action="{{ route('banners.destroy', $banner->id) }}"
                                            method="POST"
                                            onsubmit="return confirmSubmit(event, 'Yakin ingin menghapus banner ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                            {{-- MODAL EDIT --}}
                            <div
                                class="modal fade"
                                id="editBanner{{ $banner->id }}"
                                tabindex="-1">

                                <div class="modal-dialog modal-lg modal-dialog-centered">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title">

                                                <i class="bi bi-pencil-square me-2"></i>

                                                Edit Banner

                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                            </button>

                                        </div>


                                        <form
                                            action="{{ route('banners.update', $banner->id) }}"
                                            method="POST"
                                            enctype="multipart/form-data">

                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">

                                                <div class="row g-3">

                                                    {{-- JUDUL --}}
                                                    <div class="col-md-8">

                                                        <label class="form-label">
                                                            Judul Banner
                                                        </label>

                                                        <input
                                                            type="text"
                                                            name="judul"
                                                            class="form-control"
                                                            value="{{ $banner->judul }}"
                                                            required>

                                                    </div>


                                                    {{-- URUTAN --}}
                                                    <div class="col-md-4">

                                                        <label class="form-label">
                                                            Urutan
                                                        </label>

                                                        <input
                                                            type="number"
                                                            name="urutan"
                                                            class="form-control"
                                                            min="0"
                                                            value="{{ $banner->urutan ?? 0 }}">

                                                    </div>


                                                    {{-- GAMBAR --}}
                                                    <div class="col-12">

                                                        <label class="form-label">
                                                            Gambar Banner
                                                        </label>

                                                        <input
                                                            type="file"
                                                            name="gambar"
                                                            class="form-control"
                                                            accept=".jpg,.jpeg,.png,.svg">

                                                        <div class="form-text">
                                                            Kosongkan jika gambar tidak ingin diubah.
                                                        </div>

                                                    </div>


                                                    {{-- DESKRIPSI --}}
                                                    <div class="col-12">

                                                        <label class="form-label">
                                                            Deskripsi
                                                        </label>

                                                        <textarea
                                                            name="description"
                                                            class="form-control"
                                                            rows="3">{{ $banner->description }}</textarea>

                                                    </div>


                                                    {{-- LINK CTA --}}
                                                    <div class="col-md-6">

                                                        <label class="form-label">
                                                            Link CTA <span class="text-secondary">(opsional)</span>
                                                        </label>

                                                        <input
                                                            type="text"
                                                            name="link"
                                                            value="{{ old('link', $banner->link) }}"
                                                            class="form-control"
                                                            placeholder="https://wa.me/6281234567890">

                                                    </div>


                                                    {{-- STATUS --}}
                                                    <div class="col-md-6">

                                                        <label class="form-label">
                                                            Status
                                                        </label>

                                                        <select
                                                            name="status"
                                                            class="form-select"
                                                            required>

                                                            <option value="aktif"
                                                                {{ $banner->status === 'aktif' ? 'selected' : '' }}>
                                                                Aktif
                                                            </option>

                                                            <option value="nonaktif"
                                                                {{ $banner->status === 'nonaktif' ? 'selected' : '' }}>
                                                                Tidak Aktif
                                                            </option>

                                                        </select>

                                                    </div>

                                                </div>

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
                                                    class="btn btn-green">

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

                <i class="bi bi-images fs-1 text-muted"></i>

                <h5 class="fw-bold mt-3">
                    Belum ada banner
                </h5>

                <p class="text-muted">
                    Silakan tambahkan banner baru.
                </p>

                <button
                    type="button"
                    class="btn btn-green"
                    data-bs-toggle="modal"
                    data-bs-target="#tambahBannerModal">

                    <i class="bi bi-plus-circle me-1"></i>

                    Tambah Banner

                </button>

            </div>

        @endif

    </div>

</div>


{{-- MODAL TAMBAH --}}
<div
    class="modal fade"
    id="tambahBannerModal"
    tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="bi bi-plus-circle me-2"></i>

                    Tambah Banner

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>


            <form
                action="{{ route('banners.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        {{-- JUDUL --}}
                        <div class="col-md-8">

                            <label class="form-label">
                                Judul Banner
                            </label>

                            <input
                                type="text"
                                name="judul"
                                class="form-control"
                                placeholder="Contoh: Promo RentalKu"
                                value="{{ old('judul') }}"
                                required>

                        </div>


                        {{-- URUTAN --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Urutan
                            </label>

                            <input
                                type="number"
                                name="urutan"
                                class="form-control"
                                min="0"
                                value="{{ old('urutan', 0) }}">

                        </div>


                        {{-- GAMBAR --}}
                        <div class="col-12">

                            <label class="form-label">
                                Gambar Banner
                            </label>

                            <input
                                type="file"
                                name="gambar"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.svg">

                            <div class="form-text">
                                JPG, JPEG, PNG, atau SVG. Maksimal 2 MB.
                            </div>

                        </div>


                        {{-- DESKRIPSI --}}
                        <div class="col-12">

                            <label class="form-label">
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Deskripsi banner...">{{ old('description') }}</textarea>

                        </div>


                        {{-- LINK CTA --}}
                        <div class="col-12">

                            <label class="form-label">
                                Link CTA <span class="text-secondary">(opsional — tombol "Selengkapnya" pada banner)</span>
                            </label>

                            <input
                                type="text"
                                name="link"
                                value="{{ old('link') }}"
                                class="form-control"
                                placeholder="https://wa.me/6281234567890">

                        </div>


                        {{-- STATUS --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select"
                                required>

                                <option value="">
                                    -- Pilih Status --
                                </option>

                                <option value="aktif"
                                    {{ old('status') === 'aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="nonaktif"
                                    {{ old('status') === 'nonaktif' ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>

                    </div>

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
                        class="btn btn-green">

                        <i class="bi bi-plus-circle me-1"></i>

                        Tambah Banner

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