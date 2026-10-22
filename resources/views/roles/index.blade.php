<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Role - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f5f7f6;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            color: #1f2937;
            margin: 0;
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

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px 13px;
        }

        .form-control:focus,
        .form-select:focus {
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
            white-space: nowrap;
            border-bottom: 1px solid #e9ecef;
            padding: 12px 16px;
        }

        .table tbody td {
            vertical-align: middle;
        }

        /* Sembunyikan ikon sort di semua kolom */
        #roles-table thead .dt-column-order {
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

        .modal-footer .btn {
            padding: 6px 14px;
            min-width: 100px;
        }

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
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
            <h2 class="page-title mb-1">
                Management Role
            </h2>

            <p class="text-muted mb-0">
                Kelola role pengguna di RentalKu.
            </p>

        </div>

    </div>

    @if(session('success'))
        <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
    @endif

    @if($errors->any())

        <div class="alert alert-danger mb-4">

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

        <div class="col-lg-12">

            <div class="page-card">

                <div class="table-responsive">

                    <table class="table align-middle mb-0" id="roles-table">

                        <thead>

                            <tr>

                                <th class="px-3 py-3">
                                    No
                                </th>

                                <th>
                                    Nama
                                </th>

                                <th>
                                    Deskripsi
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

                    <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3" id="pager-roles">
                        <div class="text-secondary" id="pager-info-roles">Menampilkan 0–0 dari 0 data</div>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <select id="pager-len-roles" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                                <option value="10">10 / halaman</option>
                                <option value="20">20 / halaman</option>
                                <option value="50">50 / halaman</option>
                                <option value="100">100 / halaman</option>
                                <option value="custom">Custom</option>
                            </select>
                            <input type="number" id="pager-custom-roles" class="form-control form-control-sm pager-jump" min="1" max="500" value="10" aria-label="Jumlah custom per halaman">
                            <span class="text-secondary" id="pager-page-roles">Halaman 1 / 1</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm pager-btn" id="pager-first-roles">First</button>
                            <button type="button" class="btn btn-sm pager-btn" id="pager-prev-roles" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                            <button type="button" class="btn btn-sm pager-btn pager-next" id="pager-next-roles" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                            <button type="button" class="btn btn-sm pager-btn" id="pager-last-roles">Last</button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="tambahRoleModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Tambah Role', 'icon' => 'bi-plus-circle'])

                <form
                    action="{{ route('roles.store') }}"
                    method="POST"
                    id="formTambahRole">

                    @csrf

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Nama Role
                        </label>

                        <select name="name" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                            <option value="Customer">Customer</option>
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Deskripsi role..."></textarea>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            <i class="bi bi-x-circle me-1"></i>
                            Batal

                        </button>

                        <button
                            type="submit"
                            class="btn btn-green">

                            <i class="bi bi-save me-1"></i>
                            Simpan Role

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="editRoleModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Edit Role', 'icon' => 'bi-pencil-square'])

                <form
                    action=""
                    method="POST"
                    id="formEditRole">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Nama Role
                        </label>

                        <select name="name" id="editNamaRole" class="form-select" required>
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                            <option value="Customer">Customer</option>
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            id="editDeskripsiRole"
                            class="form-control"
                            rows="3"
                            placeholder="Deskripsi role..."></textarea>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            <i class="bi bi-x-circle me-1"></i>
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

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    var CSRF_TOKEN = '{{ csrf_token() }}';

    var $flashSuccess = $('#flashSuccess');

    if ($flashSuccess.length) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: $flashSuccess.text(),
            timer: 1800,
            showConfirmButton: false,
        });
    }

    function roleBadge(name) {
        const map = {
            'Admin': 'role-admin',
            'Staff': 'role-staff',
            'Customer': 'role-customer',
        };

        const cls = map[name] || 'bg-secondary text-white';

        return '<span class="role-badge ' + cls + '">' + name + '</span>';
    }

    $(document).ready(function() {

        var tabelRoles = $('#roles-table').DataTable({
            paging: false,
            info: false,
            dom: 'frt',
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('roles.data') }}',
                type: 'GET',
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
                    data: 'name',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return roleBadge(data);
                    },
                },
                {
                    data: 'description',
                    orderable: false,
                    searchable: true,
                    render: function(data) {
                        return data
                            ? data
                            : '<span class="text-muted">Tidak ada deskripsi.</span>';
                    },
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '140px',
                    render: function(data, type, row) {
                        return '<div class="d-flex justify-content-center gap-2">' +
                            '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" ' +
                            'title="Edit" onclick="editRole(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            (row.users_count > 0
                                ? '<button type="button" class="btn p-1 text-secondary" style="border:none;background:none;" disabled title="Role masih dipakai user"><i class="bi bi-lock"></i></button>'
                                : '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                                'title="Hapus" onclick="deleteRole(' + data +
                                ', \'' + row.name.replace(/'/g, "\\'") + '\')">' +
                                '<i class="bi bi-trash"></i></button>') +
                            '</div>';
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
                emptyTable: 'Belum ada role',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

        function renderPagerRoles() {
            var info = tabelRoles.page.info();
            var total=info.recordsDisplay;
            var start=total?info.start+1:0;
            $('#pager-info-roles').text('Menampilkan '+start+'–'+info.end+' dari '+total+' data');
            var pages=info.pages;
            $('#pager-page-roles').text('Halaman '+(pages?info.page+1:0)+' / '+pages);
            var page=pages?info.page+1:0;
            $('#pager-first-roles, #pager-prev-roles').toggleClass('disabled', page <= 1);
            $('#pager-next-roles, #pager-last-roles').toggleClass('disabled', page >= pages);
        }

        $('#pager-first-roles').on('click', function() {
            tabelRoles.page('first').draw('page');
        });
        $('#pager-prev-roles').on('click', function() {
            tabelRoles.page('previous').draw('page');
        });
        $('#pager-next-roles').on('click', function() {
            tabelRoles.page('next').draw('page');
        });
        $('#pager-last-roles').on('click', function() {
            tabelRoles.page('last').draw('page');
        });
        $('#pager-len-roles').on('change', function() {
            if ($(this).val() === 'custom') { $('#pager-custom-roles').focus(); return; }
            var n = Number($(this).val());
            $('#pager-custom-roles').val(n);
            tabelRoles.page.len(n).draw();
        });
        $('#pager-custom-roles').on('change', function() {
            var n = parseInt($(this).val(), 10) || 1;
            n = Math.min(Math.max(n, 1), 500);
            $(this).val(n);
            if (['10','20','50','100'].indexOf(String(n)) !== -1) { $('#pager-len-roles').val(String(n)); }
            else { $('#pager-len-roles').val('custom'); }
            tabelRoles.page.len(n).draw();
        });
        tabelRoles.on('draw.dt', renderPagerRoles);
        renderPagerRoles();

    });

    function deleteRole(id, name) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus role "' + name + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('roles.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {
                    $('#roles-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Role berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus role.',
                    });
                }
            });
        });
    }

    function editRole(id) {
        const data = $('#roles-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data role tidak ditemukan.',
            });
            return;
        }

        $('#editNamaRole').val(data.name);
        $('#editDeskripsiRole').val(data.description);

        $('#formEditRole').attr('action',
            "{{ route('roles.update', '__ID__') }}".replace('__ID__', id));

        bootstrap.Modal.getOrCreateInstance($('#editRoleModal')[0]).show();
    }

    $(document).on('submit', '#formTambahRole', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(result) {
                bootstrap.Modal.getInstance($('#tambahRoleModal')[0]).hide();
                $('#formTambahRole')[0].reset();
                $('#roles-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Role berhasil dibuat.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat membuat role.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditRole', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(result) {
                bootstrap.Modal.getInstance($('#editRoleModal')[0]).hide();
                $('#roles-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Role berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui role.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

</script>

</body>

</html>
