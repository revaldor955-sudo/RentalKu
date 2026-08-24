<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Pengguna - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

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
    @include('layouts.partials.admin-navbar')


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

            <div class="d-flex gap-2">

                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Dashboard
                </a>

                <button type="button" class="btn btn-green" data-bs-toggle="modal" data-bs-target="#tambahUserModal">
                    <i class="bi bi-person-plus-fill me-1"></i>
                    Tambah Pengguna
                </button>

            </div>

        </div>


        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                <i class="bi bi-check-circle me-2"></i>

                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>
        @endif


        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">

                <i class="bi bi-exclamation-circle me-2"></i>

                {{ session('error') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>
        @endif


        {{-- VALIDATION ERROR --}}
        @if ($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Terdapat kesalahan:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- TABLE --}}
        <div class="page-card">

            <div class="table-responsive">

                <table class="table align-middle mb-0" id="users-table">

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
                        {{-- Diisi oleh DataTables (server-side) --}}
                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- MODAL EDIT (reusabel, diisi via AJAX) --}}
    <div class="modal fade" id="editUserModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Pengguna
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <form id="editUserForm" action="" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div id="editUserLoading" class="text-center py-4">
                            <div class="spinner-border text-success" role="status"></div>
                            <p class="text-muted mt-2 mb-0">
                                Memuat data pengguna...
                            </p>
                        </div>

                        <div id="editUserError" class="alert alert-danger d-none" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <span id="editUserErrorMessage">Gagal memuat data pengguna.</span>
                        </div>

                        <div id="editUserErrorForm" class="alert alert-danger d-none ajax-error"></div>
                        <div id="editUserFields" class="d-none">

                            <div class="row g-3">

                                <div class="col-md-6">

                                    <label class="form-label">
                                        Nama
                                    </label>

                                    <input type="text" name="name" id="edit-name" class="form-control" required>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Email
                                    </label>

                                    <input type="email" name="email" id="edit-email" class="form-control" required>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Role
                                    </label>

                                    <select name="roles_id" id="edit-roles-id" class="form-select" required>

                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Password Baru
                                    </label>

                                    <input type="password" name="password" class="form-control"
                                        placeholder="Kosongkan jika tidak diubah">

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Nomor Telepon
                                    </label>

                                    <input type="text" name="phone" id="edit-phone" class="form-control">

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label">
                                        Foto
                                    </label>

                                    <input type="file" name="photo" class="form-control"
                                        accept=".jpg,.jpeg,.png">

                                </div>


                                <div class="col-12">

                                    <label class="form-label">
                                        Alamat
                                    </label>

                                    <textarea name="address" id="edit-address" class="form-control" rows="3"></textarea>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="button" id="editUserSubmit" class="btn btn-green"
                            onclick="submitUserForm(event, 'editUserForm')">
                            <i class="bi bi-save me-1"></i>
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <div class="modal fade" id="detailUserModal" tabindex="-1" aria-labelledby="detailUserModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title" id="detailUserModalLabel">
                        <i class="bi bi-person-badge me-2"></i>
                        Detail Pengguna
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>

                </div>

                <div class="modal-body p-4">

                    <div id="userDetailLoading" class="text-center py-5">
                        <div class="spinner-border text-success" role="status"></div>
                        <p class="text-muted mt-3 mb-0">
                            Memuat detail pengguna...
                        </p>
                    </div>

                    <div id="userDetailError" class="alert alert-danger d-none" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <span id="userDetailErrorMessage">
                            Gagal memuat detail pengguna.
                        </span>
                    </div>

                    <div id="userDetailContent" class="d-none text-center">

                        <div id="ud-photo"></div>

                        <h5 class="fw-bold mt-3 mb-1" id="ud-name">-</h5>

                        <div class="text-muted mb-1" id="ud-email">-</div>

                        <div class="mb-3" id="ud-role">-</div>

                        <div class="row g-2 text-start">

                            <div class="col-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <small class="text-muted fw-bold text-uppercase">Telepon</small>
                                    <div class="fw-semibold" id="ud-phone">-</div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <small class="text-muted fw-bold text-uppercase">ID Pengguna</small>
                                    <div class="fw-semibold" id="ud-id">-</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="border rounded-3 p-3">
                                    <small class="text-muted fw-bold text-uppercase">Alamat</small>
                                    <div class="fw-semibold" id="ud-address">-</div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="tambahUserModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="bi bi-person-plus-fill me-2"></i>
                        Tambah Pengguna
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <form id="tambahUserForm" action="{{ route('users.store') }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body">
                        <div id="tambahUserError" class="alert alert-danger d-none ajax-error"></div>
                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label">
                                    Nama
                                </label>

                                <input type="text" name="name" class="form-control"
                                    placeholder="Masukkan nama" required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Email
                                </label>

                                <input type="email" name="email" class="form-control"
                                    placeholder="contoh@email.com" required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Role
                                </label>

                                <select name="roles_id" class="form-select" required>

                                    <option value="">
                                        -- Pilih Role --
                                    </option>

                                    @foreach ($roles as $role)
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

                                <input type="password" name="password" class="form-control"
                                    placeholder="Minimal 6 karakter" required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Nomor Telepon
                                </label>

                                <input type="text" name="phone" class="form-control"
                                    placeholder="08xxxxxxxxxx">

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Foto
                                </label>

                                <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png">

                                <div class="form-text">
                                    JPG, JPEG, atau PNG. Maksimal 2 MB.
                                </div>

                            </div>


                            <div class="col-12">

                                <label class="form-label">
                                    Alamat
                                </label>

                                <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat"></textarea>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="button" class="btn btn-green"
                            onclick="submitUserForm(event, 'tambahUserForm')">
                            <i class="bi bi-person-plus me-1"></i>
                            Tambah Pengguna
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const CURRENT_USER_ID = {{ auth()->id() }};

        function roleBadge(rolesId, roleName) {
            const map = {
                1: 'role-admin',
                2: 'role-staff',
                3: 'role-customer',
            };

            const cls = map[rolesId] || 'bg-secondary text-white';

            return '<span class="role-badge ' + cls + '">' + roleName + '</span>';
        }

        function userPhoto(photo) {
            if (photo) {
                return '<img src="' + '{{ asset('__PHOTO__') }}'.replace('__PHOTO__', photo) +
                    '" class="user-photo" alt="Foto pengguna">';
            }

            return '<div class="photo-placeholder"><i class="bi bi-person-fill"></i></div>';
        }

        function userActions(data) {
            let html = '<div class="d-flex justify-content-center gap-2">';

            html += '<button type="button" class="btn btn-outline-primary btn-sm" title="Detail" ' +
                'onclick="openUserDetail(' + data.id + ')">' +
                '<i class="bi bi-eye"></i></button>';

            html += '<button type="button" class="btn btn-warning btn-sm" title="Edit" ' +
                'onclick="openEditUser(' + data.id + ')">' +
                '<i class="bi bi-pencil-square"></i></button>';

            if (data.id != CURRENT_USER_ID) {

                html += '<button type="button" class="btn btn-danger btn-sm" title="Hapus" ' +
                    'onclick="deleteUser(' + data.id + ', \'' + data.name.replace(/'/g, "\\'") + '\')">' +
                    '<i class="bi bi-trash"></i></button>';

            }

            html += '</div>';

            return html;
        }

        $(document).ready(function() {

            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('users.data') }}',
                    type: 'GET',
                },
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'px-4',
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
                                userPhoto(data.photo) +
                                '<div><strong>' + data.name + '</strong>' +
                                '<div class="small text-muted">ID #' + data.id +
                                '</div></div></div>';
                        },
                    },
                    {
                        data: 'email',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return data;
                        },
                    },
                    {
                        data: null,
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return roleBadge(data.roles_id, data.role_name);
                        },
                    },
                    {
                        data: 'phone',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return data;
                        },
                    },
                    {
                        data: 'address',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return data;
                        },
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data) {
                            return userActions(data);
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
                    emptyTable: 'Belum ada pengguna',
                    paginate: {
                        previous: 'Sebelumnya',
                        next: 'Berikutnya'
                    },
                    aria: {
                        sortAscending: ': aktifkan untuk urut naik',
                        sortDescending: ': aktifkan untuk urut turun',
                    },
                },
            });

        });

        function openUserDetail(id) {

            const modalEl = document.getElementById('detailUserModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

            const loading = document.getElementById('userDetailLoading');
            const error = document.getElementById('userDetailError');
            const content = document.getElementById('userDetailContent');

            loading.classList.remove('d-none');
            error.classList.add('d-none');
            content.classList.add('d-none');

            modal.show();

            $.ajax({
                        url: '{{ route('users.detail', '__ID__') }}'.replace('__ID__', id),
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        },
                        success: function(data) {
                            document.getElementById('ud-photo').innerHTML =
                                data.photo_url ?
                                '<img src="' + data.photo_url +
                                '" class="user-photo" style="width:90px;height:90px;" alt="Foto pengguna">' :
                                '<div class="photo-placeholder" style="width:90px;height:90px;"><i class="bi bi-person-fill"></i></div>';
                                document.getElementById('ud-name').textContent = data.name;
                                document.getElementById('ud-email').textContent = data.email;
                                document.getElementById('ud-role').innerHTML = roleBadge(data.roles_id, data.role_name);
                                document.getElementById('ud-phone').textContent = data.phone;
                                document.getElementById('ud-id').textContent = data.id;
                                document.getElementById('ud-address').textContent = data.address;

                                loading.classList.add('d-none');
                                content.classList.remove('d-none');
                            },
                            error: function(xhr) {
                                loading.classList.add('d-none');
                                document.getElementById('userDetailErrorMessage').textContent =
                                    'Gagal memuat detail pengguna: ' + (xhr.status + ' ' + xhr.statusText);
                                error.classList.remove('d-none');
                            },
                        });

                    }

                        function openEditUser(id) {

                            const modalEl = document.getElementById('editUserModal');
                            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

                            const loading = document.getElementById('editUserLoading');
                            const error = document.getElementById('editUserError');
                            const fields = document.getElementById('editUserFields');
                            const submitBtn = document.getElementById('editUserSubmit');
                            document.getElementById('editUserErrorForm').classList.add('d-none');

                            loading.classList.remove('d-none');
                            error.classList.add('d-none');
                            fields.classList.add('d-none');
                            submitBtn.disabled = true;

                            modal.show();

                            $.ajax({
                                url: '{{ route('users.detail', '__ID__') }}'.replace('__ID__', id),
                                method: 'GET',
                                headers: {
                                    'Accept': 'application/json',
                                },
                                success: function(data) {
                                    document.getElementById('edit-name').value = data.name;
                                    document.getElementById('edit-email').value = data.email;
                                    document.getElementById('edit-roles-id').value = data.roles_id;
                                    document.getElementById('edit-phone').value = data.phone === '-' ? '' : data.phone;
                                    document.getElementById('edit-address').value = data.address === '-' ? '' : data
                                        .address;

                                    document.getElementById('editUserForm').action =
                                        '{{ route('users.update', '__ID__') }}'.replace('__ID__', id);

                                    loading.classList.add('d-none');
                                    fields.classList.remove('d-none');
                                    submitBtn.disabled = false;
                                },
                                error: function(xhr) {
                                    loading.classList.add('d-none');
                                    document.getElementById('editUserErrorMessage').textContent =
                                        'Gagal memuat data pengguna: ' + xhr.status + ' ' + xhr.statusText;
                                    error.classList.remove('d-none');
                                    submitBtn.disabled = false;
                                },
                            });

                        }

                        function submitUserForm(event, formId) {
                            event.preventDefault();

                            const form = document.getElementById(formId);
                            const btn = form.querySelector('button[onclick^="submitUserForm"]');
                            const errorBox = form.querySelector('.ajax-error');

                            btn.disabled = true;
                            errorBox.classList.add('d-none');

                            const formData = new FormData(form);
                            if (formId === 'editUserForm') {
                                formData.append('_method', 'PUT');
                            }
                            $.ajax({
                                url: form.action,
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': CSRF_TOKEN,
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(result) {
                                    const modalId = formId === 'editUserForm' ? 'editUserModal' :
                                        'tambahUserModal';
                                    bootstrap.Modal.getInstance(document.getElementById(modalId)).hide();
                                    form.reset();
                                    $('#users-table').DataTable().ajax.reload();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: result.message,
                                        timer: 1500,
                                        showConfirmButton: false,
                                    });
                                },
                                error: function(xhr) {
                                    const result = xhr.responseJSON || {};
                                    const msgs = Object.values(result.errors || {}).flat();
                                    errorBox.textContent = msgs.length ? msgs.join(', ') : (result.message ||
                                        'Terjadi kesalahan.');
                                    errorBox.classList.remove('d-none');
                                },
                                complete: function() {
                                    btn.disabled = false;
                                }
                            });
                        }

                        function deleteUser(id, name) {
                            Swal.fire({
                                title: 'Konfirmasi',
                                text: 'Apakah Anda yakin ingin menghapus pengguna "' + name + '"?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, hapus',
                                cancelButtonText: 'Batal',
                            }).then(function(result) {
                                if (!result.isConfirmed) return;

                                $.ajax({
                                    url: '{{ route('users.destroy', '__ID__') }}'.replace('__ID__', id),
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': CSRF_TOKEN,
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest',
                                    },
                                    success: function(result) {
                                        $('#users-table').DataTable().ajax.reload();

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: result.message,
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
                                                'Terjadi kesalahan saat menghapus pengguna.',
                                        });
                                    }
                                });
                            });
                        }
    </script>

</body>

</html>
