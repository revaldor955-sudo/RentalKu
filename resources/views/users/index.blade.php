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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background: #f5f7f6;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            color: #1f2937;
            margin: 0;
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
            padding: 12px 16px;
        }

        #users-table thead .dt-column-order {
            display: none !important;
        }

        .pager-bar{background:#fff;border:1px solid #edf0ee;border-radius:16px;box-shadow:0 8px 20px rgba(0,0,0,0.05);padding:12px 16px;font-size:14px}
        .pager-bar .text-secondary{font-size:14px;font-weight:500}.pager-select{width:auto;border-radius:10px;font-size:13px;height:34px;padding:6px 28px 6px 10px}
        .pager-jump{width:72px;border-radius:10px;text-align:center;font-size:13px;height:34px;padding:6px 8px}
        .pager-btn{border:1px solid #dee2e6;border-radius:10px;color:#1f2937;font-weight:600;background:#fff;font-size:13px;height:34px;display:inline-flex;align-items:center;padding:6px 12px}
        .pager-btn:hover{border-color:#198754;color:#198754;background:#f5f7f6}
        .pager-btn.disabled{opacity:0.4;pointer-events:none}
        .pager-next{background:#198754;border-color:#198754;color:#fff}
        .pager-next:hover{background:#146c43;border-color:#146c43;color:#fff}

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

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-footer .btn {
            padding: 6px 14px;
            min-width: 100px;
        }

        .page-content {
            padding: 24px;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
        }
    </style>

    @include('layouts.partials.modal-head-style')
</head>

<body>

@include('layouts.partials.sidebar')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainContent = document.getElementById('mainContent');
        const pageContent = mainContent?.querySelector('.page-content');

        if (mainContent && pageContent) {
            const navbar = document.querySelector('header.topbar');
            if (navbar) {
                mainContent.insertBefore(navbar, pageContent);
            }
        }
    });
</script>

<div class="page-content">

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Management Pengguna
            </h2>

            <p class="text-muted mb-0">
                Kelola akun Admin, Staff, dan Customer RentalKu.
            </p>
        </div>

        <div>
            <button
                type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#tambahUserModal">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Pengguna
            </button>
        </div>

    </div>

    @if (session('success'))
        <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
    @endif

    @if (session('error'))
        <span id="flashError" class="d-none">{{ session('error') }}</span>
    @endif

    @if ($errors->any())

        <div class="alert alert-danger mb-4">

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

    <div class="page-card">

        <div class="table-responsive">

            <table class="table align-middle mb-0" id="users-table">

                <thead>

                    <tr>

                        <th class="px-3 py-3">
                            No
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
                </tbody>

            </table>

            <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3" id="pager-users">
                <div class="text-secondary" id="pager-info-users">Menampilkan 0–0 dari 0 data</div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select id="pager-len-users" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                        <option value="10">10 / halaman</option>
                        <option value="20">20 / halaman</option>
                        <option value="50">50 / halaman</option>
                        <option value="100">100 / halaman</option>
                        <option value="custom">Custom</option>
                    </select>
                    <input type="number" id="pager-custom-users" class="form-control form-control-sm pager-jump" min="1" max="500" value="10" aria-label="Jumlah custom per halaman">
                    <span class="text-secondary" id="pager-page-users">Halaman 1 / 1</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm pager-btn" id="pager-first-users">First</button>
                    <button type="button" class="btn btn-sm pager-btn" id="pager-prev-users" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                    <button type="button" class="btn btn-sm pager-btn pager-next" id="pager-next-users" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                    <button type="button" class="btn btn-sm pager-btn" id="pager-last-users">Last</button>
                </div>
            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="editUserModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            @include('layouts.partials.modal-head', ['title' => 'Edit Pengguna', 'icon' => 'bi-pencil-square'])

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
                        <i class="bi bi-x-circle me-1"></i>Batal
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

            @include('layouts.partials.modal-head', ['title' => 'Detail Pengguna', 'icon' => 'bi-person-badge', 'titleId' => 'detailUserModalLabel'])

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

<div class="modal fade" id="fotoUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Foto Pengguna'])
            <div class="modal-body p-3 text-center">
                <img id="fotoUserPreview" src="" class="img-fluid rounded" alt="Foto pengguna">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahUserModal" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            @include('layouts.partials.modal-head', ['title' => 'Tambah Pengguna', 'icon' => 'bi-person-plus-fill'])

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
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>

                    <button type="button" class="btn btn-green"
                        onclick="submitUserForm(event, 'tambahUserForm')">
                        <i class="bi bi-save me-1"></i>
                        Simpan Pengguna
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
        var err = document.getElementById('flashError');
        if (err) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: err.textContent,
            });
        }
    })();
</script>

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

    function openFotoUser(url) {
        $('#fotoUserPreview').attr('src', url);
        bootstrap.Modal.getOrCreateInstance($('#fotoUserModal')[0]).show();
    }

    function userPhoto(photo) {
        if (photo) {
            const full = '{{ asset('__PHOTO__') }}'.replace('__PHOTO__', photo);
            return '<a href="#" onclick="openFotoUser(\'' + full + '\');return false;">' +
                '<img src="' + full + '" class="user-photo" alt="Foto pengguna"></a>';
        }

        return '<div class="photo-placeholder"><i class="bi bi-person-fill"></i></div>';
    }

    function userActions(data) {
        let html = '<div class="d-flex justify-content-center gap-2">';

        html += '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" title="Detail" ' +
            'onclick="openUserDetail(' + data.id + ')">' +
            '<i class="bi bi-eye"></i></button>';

        html += '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" title="Edit" ' +
            'onclick="openEditUser(' + data.id + ')">' +
            '<i class="bi bi-pencil-square"></i></button>';

        if (data.id != CURRENT_USER_ID) {

            html += '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" title="Hapus" ' +
                'onclick="deleteUser(' + data.id + ', \'' + data.name.replace(/'/g, "\\'") + '\')">' +
                '<i class="bi bi-trash"></i></button>';

        }

        html += '</div>';

        return html;
    }

    $(document).ready(function() {

        var tabelUsers = $('#users-table').DataTable({
            paging: false,
            info: false,
            dom: 'frt',
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('users.data') }}',
            },
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'px-3',
                    width: '70px',
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
                },
                {
                    data: 'address',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '140px',
                    render: function(data) {
                        return userActions(data);
                    },
                },
            ],
           order: [],
            language: {
                processing: 'Memproses...',
                search: 'Cari:',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(difilter dari _MAX_ total data)',
                loadingRecords: 'Memuat...',
                zeroRecords: 'Tidak ditemukan data yang cocok',
                emptyTable: 'Belum ada pengguna',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

        function renderPagerUsers() {
            var info = tabelUsers.page.info();
            var total=info.recordsDisplay;
            var start=total?info.start+1:0;
            $('#pager-info-users').text('Menampilkan '+start+'–'+info.end+' dari '+total+' data');
            var pages=info.pages;
            $('#pager-page-users').text('Halaman '+(pages?info.page+1:0)+' / '+pages);
            var page=pages?info.page+1:0;
            $('#pager-first-users, #pager-prev-users').toggleClass('disabled', page <= 1);
            $('#pager-next-users, #pager-last-users').toggleClass('disabled', page >= pages);
        }

        $('#pager-first-users').on('click', function() {
            tabelUsers.page('first').draw('page');
        });
        $('#pager-prev-users').on('click', function() {
            tabelUsers.page('previous').draw('page');
        });
        $('#pager-next-users').on('click', function() {
            tabelUsers.page('next').draw('page');
        });
        $('#pager-last-users').on('click', function() {
            tabelUsers.page('last').draw('page');
        });
        $('#pager-len-users').on('change', function() {
            if ($(this).val() === 'custom') { $('#pager-custom-users').focus(); return; }
            var n = Number($(this).val());
            $('#pager-custom-users').val(n);
            tabelUsers.page.len(n).draw();
        });
        $('#pager-custom-users').on('change', function() {
            var n = parseInt($(this).val(), 10) || 1;
            n = Math.min(Math.max(n, 1), 500);
            $(this).val(n);
            if (['10','20','50','100'].indexOf(String(n)) !== -1) { $('#pager-len-users').val(String(n)); }
            else { $('#pager-len-users').val('custom'); }
            tabelUsers.page.len(n).draw();
        });
        tabelUsers.on('draw.dt', renderPagerUsers);
        renderPagerUsers();

    });

    function openUserDetail(id) {

        var $modal = bootstrap.Modal.getOrCreateInstance($('#detailUserModal')[0]);

        var $loading = $('#userDetailLoading');
        var $error = $('#userDetailError');
        var $content = $('#userDetailContent');

        $loading.removeClass('d-none');
        $error.addClass('d-none');
        $content.addClass('d-none');

        $modal.show();

        $.ajax({
            url: '{{ route('users.detail', '__ID__') }}'.replace('__ID__', id),
            method: 'GET',
            headers: { 'Accept': 'application/json' },
            success: function(data) {
                $('#ud-photo').html(
                    data.photo_url ?
                    '<img src="' + data.photo_url + '" class="user-photo" style="width:90px;height:90px;" alt="Foto pengguna">' :
                    '<div class="photo-placeholder" style="width:90px;height:90px;"><i class="bi bi-person-fill"></i></div>'
                );
                $('#ud-name').text(data.name);
                $('#ud-email').text(data.email);
                $('#ud-role').html(roleBadge(data.roles_id, data.role_name));
                $('#ud-phone').text(data.phone);
                $('#ud-id').text(data.id);
                $('#ud-address').text(data.address);

                $loading.addClass('d-none');
                $content.removeClass('d-none');
            },
            error: function(xhr) {
                $loading.addClass('d-none');
                $('#userDetailErrorMessage').text('Gagal memuat detail pengguna: ' + xhr.status + ' ' + xhr.statusText);
                $error.removeClass('d-none');
            },
        });

    }

    function openEditUser(id) {

        var $modal = bootstrap.Modal.getOrCreateInstance($('#editUserModal')[0]);

        var $loading = $('#editUserLoading');
        var $error = $('#editUserError');
        var $fields = $('#editUserFields');
        var $submitBtn = $('#editUserSubmit');
        $('#editUserErrorForm').addClass('d-none');

        $loading.removeClass('d-none');
        $error.addClass('d-none');
        $fields.addClass('d-none');
        $submitBtn.prop('disabled', true);

        $modal.show();

        $.ajax({
            url: '{{ route('users.detail', '__ID__') }}'.replace('__ID__', id),
            method: 'GET',
            headers: { 'Accept': 'application/json' },
            success: function(data) {
                $('#edit-name').val(data.name);
                $('#edit-email').val(data.email);
                $('#edit-roles-id').val(data.roles_id);
                $('#edit-phone').val(data.phone === '-' ? '' : data.phone);
                $('#edit-address').val(data.address === '-' ? '' : data.address);
                $('#editUserForm').attr('action', '{{ route('users.update', '__ID__') }}'.replace('__ID__', id));

                $loading.addClass('d-none');
                $fields.removeClass('d-none');
                $submitBtn.prop('disabled', false);
            },
            error: function(xhr) {
                $loading.addClass('d-none');
                $('#editUserErrorMessage').text('Gagal memuat data pengguna: ' + xhr.status + ' ' + xhr.statusText);
                $error.removeClass('d-none');
                $submitBtn.prop('disabled', false);
            },
        });

    }

    function submitUserForm(event, formId) {
        event.preventDefault();

        var $form = $('#' + formId);
        var $btn = $form.find('button[onclick^="submitUserForm"]');
        var $errorBox = $form.find('.ajax-error');

        $btn.prop('disabled', true);
        $errorBox.addClass('d-none');

        var formData = new FormData($form[0]);
        if (formId === 'editUserForm') {
            formData.append('_method', 'PUT');
        }
        $.ajax({
            url: $form.attr('action'),
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
                var modalId = formId === 'editUserForm' ? 'editUserModal' : 'tambahUserModal';
                bootstrap.Modal.getInstance($('#' + modalId)[0]).hide();
                $form[0].reset();
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
                var result = xhr.responseJSON || {};
                var msgs = Object.values(result.errors || {}).flat();
                $errorBox.text(msgs.length ? msgs.join(', ') : (result.message || 'Terjadi kesalahan.'));
                $errorBox.removeClass('d-none');
            },
            complete: function() {
                $btn.prop('disabled', false);
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
