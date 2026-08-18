<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Pengguna - RentalKu</title>

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

        .user-photo {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }

        .photo-placeholder {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
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

        .role-badge {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .role-admin {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .role-staff {
            background: #fff3cd;
            color: #997404;
        }

        .role-customer {
            background: #dff7e8;
            color: #198754;
        }

        .section-title {
            font-weight: 800;
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
    </style>
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center">

            <a
                href="{{ route('admin.dashboard') }}"
                class="text-decoration-none brand"
            >
                Rental<span>ku</span>.
            </a>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('admin.dashboard') }}"
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

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Management Pengguna
            </h2>

            <p class="text-muted mb-0">
                Kelola akun Admin, Staff, dan Customer RentalKu.
            </p>
        </div>

        <button
            type="button"
            class="btn btn-green"
            data-bs-toggle="modal"
            data-bs-target="#tambahUserModal"
        >
            <i class="bi bi-person-plus-fill me-1"></i>
            Tambah Pengguna
        </button>

    </div>


    {{-- ALERT SUCCESS --}}
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


    {{-- ALERT ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle me-2"></i>

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

        @if($users->count())

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th class="px-4 py-3">
                                #
                            </th>

                            <th>
                                Pengguna
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                Role
                            </th>

                            <th>
                                Telepon
                            </th>

                            <th>
                                Alamat
                            </th>

                            <th class="text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($users as $user)

                            <tr>

                                {{-- NO --}}
                                <td class="px-4">
                                    {{ $loop->iteration }}
                                </td>


                                {{-- PENGGUNA --}}
                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        @if($user->photo)

                                            <img
                                                src="{{ asset($user->photo) }}"
                                                class="user-photo"
                                                alt="Foto {{ $user->name }}"
                                            >

                                        @else

                                            <div class="photo-placeholder">
                                                <i class="bi bi-person-fill"></i>
                                            </div>

                                        @endif

                                        <div>

                                            <strong>
                                                {{ $user->name }}
                                            </strong>

                                            <div class="small text-muted">
                                                ID #{{ $user->id }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- EMAIL --}}
                                <td>
                                    {{ $user->email }}
                                </td>


                                {{-- ROLE --}}
                                <td>

                                    @if($user->roles_id == 1)

                                        <span class="role-badge role-admin">
                                            Admin
                                        </span>

                                    @elseif($user->roles_id == 2)

                                        <span class="role-badge role-staff">
                                            Staff
                                        </span>

                                    @elseif($user->roles_id == 3)

                                        <span class="role-badge role-customer">
                                            Customer
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Belum Ada Role
                                        </span>

                                    @endif

                                </td>


                                {{-- TELEPON --}}
                                <td>
                                    {{ $user->phone ?? '-' }}
                                </td>


                                {{-- ALAMAT --}}
                                <td>
                                    {{ $user->address ?? '-' }}
                                </td>


                                {{-- AKSI --}}
                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- EDIT --}}
                                        <button
                                            type="button"
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUser{{ $user->id }}"
                                            title="Edit"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>


                                        {{-- HAPUS --}}
                                        @if($user->id != auth()->id())

                                            <form
                                                action="{{ route('users.destroy', $user->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')"
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

                                        @endif

                                    </div>

                                </td>

                            </tr>


                            {{-- MODAL EDIT --}}
                            <div
                                class="modal fade"
                                id="editUser{{ $user->id }}"
                                tabindex="-1"
                            >

                                <div class="modal-dialog modal-lg modal-dialog-centered">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                <i class="bi bi-pencil-square me-2"></i>
                                                Edit Pengguna
                                            </h5>

                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"
                                            ></button>

                                        </div>

                                        <form
                                            action="{{ route('users.update', $user->id) }}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">

                                                <div class="row g-3">

                                                    <div class="col-md-6">

                                                        <label class="form-label">
                                                            Nama
                                                        </label>

                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            value="{{ $user->name }}"
                                                            required
                                                        >

                                                    </div>


                                                    <div class="col-md-6">

                                                        <label class="form-label">
                                                            Email
                                                        </label>

                                                        <input
                                                            type="email"
                                                            name="email"
                                                            class="form-control"
                                                            value="{{ $user->email }}"
                                                            required
                                                        >

                                                    </div>


                                                    <div class="col-md-6">

                                                        <label class="form-label">
                                                            Role
                                                        </label>

                                                        <select
                                                            name="roles_id"
                                                            class="form-select"
                                                            required
                                                        >

                                                            <option value="1"
                                                                {{ $user->roles_id == 1 ? 'selected' : '' }}>
                                                                Admin
                                                            </option>

                                                            <option value="2"
                                                                {{ $user->roles_id == 2 ? 'selected' : '' }}>
                                                                Staff
                                                            </option>

                                                            <option value="3"
                                                                {{ $user->roles_id == 3 ? 'selected' : '' }}>
                                                                Customer
                                                            </option>

                                                        </select>

                                                    </div>


                                                    <div class="col-md-6">

                                                        <label class="form-label">
                                                            Password Baru
                                                        </label>

                                                        <input
                                                            type="password"
                                                            name="password"
                                                            class="form-control"
                                                            placeholder="Kosongkan jika tidak diubah"
                                                        >

                                                    </div>


                                                    <div class="col-md-6">

                                                        <label class="form-label">
                                                            Nomor Telepon
                                                        </label>

                                                        <input
                                                            type="text"
                                                            name="phone"
                                                            class="form-control"
                                                            value="{{ $user->phone }}"
                                                        >

                                                    </div>


                                                    <div class="col-md-6">

                                                        <label class="form-label">
                                                            Foto
                                                        </label>

                                                        <input
                                                            type="file"
                                                            name="photo"
                                                            class="form-control"
                                                            accept=".jpg,.jpeg,.png"
                                                        >

                                                    </div>


                                                    <div class="col-12">

                                                        <label class="form-label">
                                                            Alamat
                                                        </label>

                                                        <textarea
                                                            name="address"
                                                            class="form-control"
                                                            rows="3"
                                                        >{{ $user->address }}</textarea>

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

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-5">

                <i class="bi bi-people fs-1 text-muted"></i>

                <h5 class="fw-bold mt-3">
                    Belum ada pengguna
                </h5>

                <p class="text-muted mb-0">
                    Silakan tambahkan pengguna baru.
                </p>

            </div>

        @endif

    </div>

</div>


{{-- MODAL TAMBAH --}}
<div
    class="modal fade"
    id="tambahUserModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Tambah Pengguna
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                action="{{ route('users.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Nama
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Masukkan nama"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="contoh@email.com"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Role
                            </label>

                            <select
                                name="roles_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Role --
                                </option>

                                @foreach($roles as $role)
    <option value="{{ $role->id }}">
        {{ $role->name }}
    </option>
@endforeach

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Minimal 6 karakter"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Nomor Telepon
                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                placeholder="08xxxxxxxxxx"
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Foto
                            </label>

                            <input
                                type="file"
                                name="photo"
                                class="form-control"
                                accept=".jpg,.jpeg,.png"
                            >

                            <div class="form-text">
                                JPG, JPEG, atau PNG. Maksimal 2 MB.
                            </div>

                        </div>


                        <div class="col-12">

                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea
                                name="address"
                                class="form-control"
                                rows="3"
                                placeholder="Masukkan alamat"
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
                        <i class="bi bi-person-plus me-1"></i>
                        Tambah Pengguna
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
