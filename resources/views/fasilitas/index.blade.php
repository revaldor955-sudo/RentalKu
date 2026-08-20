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

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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

    .modal-footer .btn {
        padding: 6px 14px;
        min-width: 100px;
    }
</style>

</head>

<body>

@include('layouts.partials.admin-navbar')

<div class="container py-5">

{{-- HEADER --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="page-title mb-1">
            Management Fasilitas
        </h2>

        <p class="text-muted mb-0">
            Kelola fasilitas yang tersedia pada kendaraan RentalKu.
        </p>

    </div>

    <button
        type="button"
        class="btn btn-green"
        data-bs-toggle="modal"
        data-bs-target="#tambahFasilitasModal">

        <i class="bi bi-plus-lg me-1"></i>
        Tambah Fasilitas

    </button>

</div>


{{-- SUCCESS --}}

@if(session('success'))
    <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
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

    {{-- DAFTAR FASILITAS --}}

    <div class="col-lg-12">

        <div class="page-card">

            <div class="p-4 border-bottom">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Daftar Fasilitas
                        </h5>

                        <small class="text-muted">
                            Seluruh fasilitas yang terdaftar di RentalKu.
                        </small>

                    </div>

                </div>

            </div>

            <div class="table-responsive">

                <table class="table align-middle mb-0" id="fasilitas-table">

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
                        {{-- Diisi oleh DataTables (server-side) --}}
                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- MODAL TAMBAH --}}

<div
    class="modal fade"
    id="tambahFasilitasModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle text-success me-2"></i>
                    Tambah Fasilitas
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form
                action="{{ route('fasilitas.store') }}"
                method="POST"
                id="formTambahFasilitas">

                @csrf

                <div class="modal-body">

                    <label class="form-label fw-semibold">
                        Nama Fasilitas
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Contoh: AC"
                        required>

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
                        form="formTambahFasilitas"
                        class="btn btn-green">

                        <i class="bi bi-save me-1"></i>
                        Simpan Fasilitas

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- MODAL EDIT --}}

<div
    class="modal fade"
    id="editFasilitasModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square text-primary me-2"></i>
                    Edit Fasilitas
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form
                action=""
                method="POST"
                id="formEditFasilitas">

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <label class="form-label fw-semibold">
                        Nama Fasilitas
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="editNamaFasilitas"
                        class="form-control"
                        placeholder="Contoh: AC"
                        required>

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
                        form="formEditFasilitas"
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

<script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
</script>

<script>

    const CSRF_TOKEN = '{{ csrf_token() }}';

    const flashSuccess = document.getElementById('flashSuccess');

    if (flashSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: flashSuccess.textContent,
            timer: 1800,
            showConfirmButton: false,
        });
    }

    $(document).ready(function() {

        $('#fasilitas-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('fasilitas.data') }}',
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
                            '<div class="facility-icon"><i class="bi bi-tools"></i></div>' +
                            '<strong>' + data.name + '</strong>' +
                            '</div>';
                    },
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<div class="d-flex justify-content-center gap-2">' +
                            '<button type="button" class="btn btn-warning btn-sm btn-action" ' +
                            'title="Edit" onclick="editFasilitas(' + data + ')">' +
                            '<i class="bi bi-pencil"></i></button>' +
                            '<button type="button" class="btn btn-danger btn-sm btn-action" ' +
                            'title="Hapus" onclick="deleteFasilitas(' + data +
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
                infoPostFix: '',
                loadingRecords: 'Memuat...',
                zeroRecords: 'Tidak ditemukan data yang cocok',
                emptyTable: 'Belum ada fasilitas',
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

    function deleteFasilitas(id, name) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus fasilitas "' + name + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('fasilitas.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {
                    $('#fasilitas-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Fasilitas berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus fasilitas.',
                    });
                }
            });
        });
    }

    function editFasilitas(id) {
        const data = $('#fasilitas-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data fasilitas tidak ditemukan.',
            });
            return;
        }

        $('#editNamaFasilitas').val(data.name);

        $('#formEditFasilitas').attr('action',
            "{{ route('fasilitas.update', '__ID__') }}".replace('__ID__', id));

        new bootstrap.Modal(document.getElementById('editFasilitasModal')).show();
    }

    $(document).on('submit', '#formTambahFasilitas', function(e) {
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
                $('#tambahFasilitasModal').modal('hide');
                $('#formTambahFasilitas')[0].reset();
                $('#fasilitas-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Fasilitas berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan fasilitas.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditFasilitas', function(e) {
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
                $('#editFasilitasModal').modal('hide');
                $('#fasilitas-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Fasilitas berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui fasilitas.');

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
