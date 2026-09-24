<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Cabang - RentalKu</title>

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
            white-space: nowrap;
            border-bottom: 1px solid #e9ecef;
            padding: 12px 16px;
        }

        .table tbody td {
            vertical-align: middle;
        }

        #cabangs-table thead .dt-column-order {
            display: none !important;
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
                Management Cabang
            </h2>

            <p class="text-muted mb-0">
                Kelola cabang RentalKu.
            </p>

        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#tambahCabangModal">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah Cabang

            </button>

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

                <div class="p-4 border-bottom">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Daftar Cabang
                            </h5>

                            <small class="text-muted">
                                Seluruh cabang yang terdaftar di RentalKu.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0" id="cabangs-table">

                        <thead>

                            <tr>

                                <th class="px-3 py-3">
                                    No
                                </th>

                                <th>
                                    Nama
                                </th>

                                <th>
                                    Alamat
                                </th>

                                <th>
                                    Telepon
                                </th>

                                <th class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="tambahCabangModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Tambah Cabang', 'icon' => 'bi-plus-circle'])

                <form
                    action="{{ route('cabangs.store') }}"
                    method="POST"
                    id="formTambahCabang">

                    @csrf

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Nama Cabang
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Contoh: Cabang Jakarta"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Alamat
                        </label>

                        <textarea
                            name="address"
                            class="form-control"
                            rows="3"
                            placeholder="Alamat lengkap cabang"
                            required></textarea>

                        <label class="form-label fw-semibold mt-3">
                            Telepon
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            placeholder="Contoh: 021-1234567">

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
                            Simpan Cabang

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="editCabangModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Edit Cabang', 'icon' => 'bi-pencil-square'])

                <form
                    action=""
                    method="POST"
                    id="formEditCabang">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Nama Cabang
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="editNamaCabang"
                            class="form-control"
                            placeholder="Contoh: Cabang Jakarta"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Alamat
                        </label>

                        <textarea
                            name="address"
                            id="editAlamatCabang"
                            class="form-control"
                            rows="3"
                            placeholder="Alamat lengkap cabang"
                            required></textarea>

                        <label class="form-label fw-semibold mt-3">
                            Telepon
                        </label>

                        <input
                            type="text"
                            name="phone"
                            id="editPhoneCabang"
                            class="form-control"
                            placeholder="Contoh: 021-1234567">

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

    $(document).ready(function() {

        $('#cabangs-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('cabangs.data') }}',
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
                        return '<strong>' + data + '</strong>';
                    },
                },
                {
                    data: 'address',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'phone',
                    orderable: false,
                    searchable: true,
                    render: function(data) {
                        return data
                            ? data
                            : '<span class="text-muted">-</span>';
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
                            'title="Edit" onclick="editCabang(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                            'title="Hapus" onclick="deleteCabang(' + data +
                            ', \'' + row.name.replace(/'/g, "\\'") + '\')">' +
                            '<i class="bi bi-trash"></i></button>' +
                            '</div>';
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
                loadingRecords: 'Memuat...',
                zeroRecords: 'Tidak ditemukan data yang cocok',
                emptyTable: 'Belum ada cabang',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

    });

    function deleteCabang(id, name) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus cabang "' + name + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('cabangs.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {
                    $('#cabangs-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Cabang berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus cabang.',
                    });
                }
            });
        });
    }

    function editCabang(id) {
        const data = $('#cabangs-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data cabang tidak ditemukan.',
            });
            return;
        }

        $('#editNamaCabang').val(data.name);
        $('#editAlamatCabang').val(data.address);
        $('#editPhoneCabang').val(data.phone);

        $('#formEditCabang').attr('action',
            "{{ route('cabangs.update', '__ID__') }}".replace('__ID__', id));

        bootstrap.Modal.getOrCreateInstance($('#editCabangModal')[0]).show();
    }

    $(document).on('submit', '#formTambahCabang', function(e) {
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
                bootstrap.Modal.getInstance($('#tambahCabangModal')[0]).hide();
                $('#formTambahCabang')[0].reset();
                $('#cabangs-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Cabang berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan cabang.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditCabang', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: 'PUT',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(result) {
                bootstrap.Modal.getInstance($('#editCabangModal')[0]).hide();
                $('#cabangs-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Cabang berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui cabang.');

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