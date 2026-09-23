
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manajemen Supir - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --green: #16a34a;
            --green-dark: #15803d;
            --green-soft: #ecfdf3;
            --dark: #102018;
            --muted: #718078;
            --border: #e7eee9;
            --background: #f6f8f7;
        }

        body {
            background: var(--background);
            color: var(--dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .main-container {
            padding: 35px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .eyebrow {
            color: var(--green);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .page-title {
            font-size: 30px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .page-description {
            color: var(--muted);
            font-size: 14px;
            margin: 0;
        }

        .btn-primary-custom {
            background: var(--green);
            border: none;
            border-radius: 13px;
            color: white;
            font-size: 13px;
            font-weight: 700;
            padding: 13px 20px;
        }

        .btn-primary-custom:hover {
            background: var(--green-dark);
            color: white;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 22px;
            height: 100%;
        }

        .stat-label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: 800;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: var(--green-soft);
            color: var(--green);
            font-size: 21px;
        }

        .table-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
        }

        .table-card-header {
            padding: 22px 25px;
            border-bottom: 1px solid var(--border);
        }

        .table-card-title {
            font-size: 16px;
            font-weight: 800;
        }

        .table-card-subtitle {
            color: var(--muted);
            font-size: 12px;
            margin-top: 5px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8faf9;
            border-bottom: 1px solid var(--border);
            color: #6b7b70;
            font-size: 11px;
            font-weight: 800;
            padding: 17px 20px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .table tbody td {
            border-bottom: 1px solid #f0f3f1;
            font-size: 13px;
            padding: 17px 20px;
            vertical-align: middle;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .driver-photo {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 14px;
            background: #edf3ee;
        }

        .driver-photo-placeholder {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: var(--green-soft);
            color: var(--green);
            font-size: 21px;
        }

        .driver-name {
            font-weight: 800;
            color: var(--dark);
        }

        .driver-phone {
            color: var(--muted);
            font-size: 11px;
            margin-top: 4px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            padding: 7px 11px;
        }

        .status-available {
            background: #dcfce7;
            color: #15803d;
        }

        .status-unavailable {
            background: #fee2e2;
            color: #b91c1c;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-edit {
            background: #eff6ff;
            color: #2563eb;
        }

        .action-delete {
            background: #fef2f2;
            color: #dc2626;
        }

        .modal-content {
            border: none;
            border-radius: 22px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: 1px solid var(--border);
            padding: 22px 25px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 800;
        }

        .modal-body {
            padding: 25px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border: 1px solid #dce6df;
            border-radius: 11px;
            font-size: 13px;
            padding: 12px 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(22, 163, 74, .1);
        }

        .btn-save {
            background: var(--green);
            border: none;
            border-radius: 11px;
            color: white;
            font-size: 13px;
            font-weight: 700;
            padding: 12px 22px;
        }

        .btn-save:hover {
            background: var(--green-dark);
            color: white;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 20px 14px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-title {
                font-size: 24px;
            }

            .btn-primary-custom {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    @include('layouts.partials.admin-navbar')

    <main class="main-container">

        <div class="page-header">
            <div>
                <div class="eyebrow">
                    <i class="bi bi-person-badge-fill me-1"></i>
                    Manajemen Supir
                </div>

                <h1 class="page-title">Kelola Data Supir</h1>

                <p class="page-description">
                    Tambahkan dan kelola supir yang tersedia untuk layanan RentalKu.
                </p>
            </div>

            <button type="button"
                class="btn btn-primary-custom"
                data-bs-toggle="modal"
                data-bs-target="#tambahSupirModal">

                <i class="bi bi-plus-lg me-2"></i>
                Tambah Supir
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0"
                role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger rounded-4 border-0">
                <strong>Terjadi kesalahan:</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Supir</div>

                            <div class="stat-number">
                                {{ $supirs->count() }}
                            </div>
                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Supir Tersedia</div>

                            <div class="stat-number text-success">
                                {{ $supirs->where('status', 'tersedia')->count() }}
                            </div>
                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Tidak Tersedia</div>

                            <div class="stat-number text-danger">
                                {{ $supirs->where('status', 'tidak tersedia')->count() }}
                            </div>
                        </div>

                        <div class="stat-icon">
                            <i class="bi bi-person-x-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="table-card">

            <div class="table-card-header">
                <div class="table-card-title">
                    <i class="bi bi-list-ul text-success me-2"></i>
                    Daftar Supir
                </div>

                <div class="table-card-subtitle">
                    Seluruh data supir RentalKu
                </div>
            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Supir</th>
                            <th>Tarif Per Hari</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($supirs as $supir)

                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">

                                        @if($supir->image)
                                            <img src="{{ asset($supir->image) }}"
                                                alt="{{ $supir->name }}"
                                                class="driver-photo">
                                        @else
                                            <div class="driver-photo-placeholder">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <div class="driver-name">
                                                {{ $supir->name }}
                                            </div>

                                            <div class="driver-phone">
                                                <i class="bi bi-telephone me-1"></i>
                                                {{ $supir->phone }}
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <strong>
                                        Rp {{ number_format($supir->tarif_perhari, 0, ',', '.') }}
                                    </strong>

                                    <div class="text-muted small">
                                        / hari
                                    </div>
                                </td>

                                <td>
                                    @if($supir->status === 'tersedia')

                                        <span class="status-badge status-available">
                                            <i class="bi bi-circle-fill"></i>
                                            Tersedia
                                        </span>

                                    @else

                                        <span class="status-badge status-unavailable">
                                            <i class="bi bi-circle-fill"></i>
                                            Tidak Tersedia
                                        </span>

                                    @endif
                                </td>

                                <td class="text-center">

                                    <button type="button"
                                        class="action-btn action-edit me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editSupirModal{{ $supir->id }}"
                                        title="Edit">

                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form action="{{ route('supirs.destroy', $supir->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus supir ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="action-btn action-delete"
                                            title="Hapus">

                                            <i class="bi bi-trash3"></i>
                                        </button>

                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-5">

                                    <i class="bi bi-person-x fs-1 text-muted"></i>

                                    <p class="text-muted mt-3 mb-0">
                                        Belum ada data supir.
                                    </p>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </main>

    <div class="modal fade"
        id="tambahSupirModal"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <div>
                        <div class="modal-title">
                            <i class="bi bi-person-plus-fill text-success me-2"></i>
                            Tambah Supir
                        </div>

                        <small class="text-muted">
                            Masukkan data supir baru
                        </small>
                    </div>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <form action="{{ route('supirs.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">
                                Nama Supir
                            </label>

                            <input type="text"
                                name="name"
                                class="form-control"
                                placeholder="Masukkan nama supir"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Nomor Telepon
                            </label>

                            <input type="text"
                                name="phone"
                                class="form-control"
                                placeholder="Contoh: 081234567890"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Tarif Per Hari
                            </label>

                            <input type="number"
                                name="tarif_perhari"
                                class="form-control"
                                placeholder="Contoh: 150000"
                                min="0"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Status
                            </label>

                            <select name="status"
                                class="form-select"
                                required>

                                <option value="tersedia">
                                    Tersedia
                                </option>

                                <option value="tidak tersedia">
                                    Tidak Tersedia
                                </option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Foto Supir
                            </label>

                            <input type="file"
                                name="image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.svg">

                            <small class="text-muted">
                                Maksimal 2 MB.
                            </small>
                        </div>

                    </div>

                    <div class="modal-footer border-0 px-4 pb-4">

                        <button type="button"
                            class="btn btn-light rounded-3"
                            data-bs-dismiss="modal">

                            Batal
                        </button>

                        <button type="submit"
                            class="btn btn-save">

                            <i class="bi bi-check-lg me-2"></i>
                            Simpan Supir
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    @foreach($supirs as $supir)

        <div class="modal fade"
            id="editSupirModal{{ $supir->id }}"
            tabindex="-1"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">

                        <div>
                            <div class="modal-title">
                                <i class="bi bi-pencil-square text-success me-2"></i>
                                Edit Supir
                            </div>

                            <small class="text-muted">
                                Perbarui informasi supir
                            </small>
                        </div>

                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>

                    </div>

                    <form action="{{ route('supirs.update', $supir->id) }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">
                                    Nama Supir
                                </label>

                                <input type="text"
                                    name="name"
                                    class="form-control"
                                    value="{{ $supir->name }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Nomor Telepon
                                </label>

                                <input type="text"
                                    name="phone"
                                    class="form-control"
                                    value="{{ $supir->phone }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Tarif Per Hari
                                </label>

                                <input type="number"
                                    name="tarif_perhari"
                                    class="form-control"
                                    value="{{ $supir->tarif_perhari }}"
                                    min="0"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Status
                                </label>

                                <select name="status"
                                    class="form-select"
                                    required>

                                    <option value="tersedia"
                                        {{ $supir->status === 'tersedia' ? 'selected' : '' }}>
                                        Tersedia
                                    </option>

                                    <option value="tidak tersedia"
                                        {{ $supir->status === 'tidak tersedia' ? 'selected' : '' }}>
                                        Tidak Tersedia
                                    </option>

                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Ganti Foto
                                </label>

                                <input type="file"
                                    name="image"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.svg">

                                <small class="text-muted">
                                    Kosongkan jika tidak ingin mengganti foto.
                                </small>
                            </div>

                        </div>

                        <div class="modal-footer border-0 px-4 pb-4">

                            <button type="button"
                                class="btn btn-light rounded-3"
                                data-bs-dismiss="modal">

                                Batal
                            </button>

                            <button type="submit"
                                class="btn btn-save">

                                <i class="bi bi-check-lg me-2"></i>
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>