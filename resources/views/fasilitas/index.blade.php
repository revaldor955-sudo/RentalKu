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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
            border-bottom: 1px solid #e9ecef;
            padding: 12px 16px;
        }

        .table tbody td {
            vertical-align: middle;
        }

        #fasilitas-table thead .dt-column-order {
            display: none !important;
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

        .modal-footer .btn {
            padding: 6px 14px;
            min-width: 100px;
        }

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        /* Sidebar layout base styles ada di admin-sidebar.blade.php */

        .page-content {
            padding: 24px;
        }

        .pager-bar{background:#fff;border:1px solid #edf0ee;border-radius:16px;box-shadow:0 8px 20px rgba(0,0,0,0.05);padding:12px 16px;font-size:14px}
        .pager-bar .text-secondary{font-size:14px;font-weight:500}.pager-select{width:auto;border-radius:10px;font-size:13px;height:34px;padding:6px 28px 6px 10px}
        .pager-jump{width:72px;border-radius:10px;text-align:center;font-size:13px;height:34px;padding:6px 8px}
        .pager-btn{border:1px solid #dee2e6;border-radius:10px;color:#1f2937;font-weight:600;background:#fff;font-size:13px;height:34px;display:inline-flex;align-items:center;padding:6px 12px}
        .pager-btn:hover{border-color:#198754;color:#198754;background:#f5f7f6}
        .pager-btn.disabled{opacity:0.4;pointer-events:none}
        .pager-next{background:#198754;border-color:#198754;color:#fff}
        .pager-next:hover{background:#146c43;border-color:#146c43;color:#fff}

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
            Management Fasilitas
        </h2>

        <p class="text-muted mb-0">
            Kelola fasilitas yang tersedia pada kendaraan RentalKu.
        </p>

    </div>

<div class="d-flex gap-2">

            <button
        type="button"
        class="btn btn-green"
        data-bs-toggle="modal"
        data-bs-target="#tambahFasilitasModal">

        <i class="bi bi-plus-circle me-1"></i>
        Tambah Fasilitas

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

                            <th class="px-3 py-3">
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
                    </tbody>

                </table>

                <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="text-secondary small" id="fasilitas-info">Menampilkan 0–0 dari 0 data</div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <select id="fasilitas-perPage" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                            <option value="10">10 / halaman</option>
                            <option value="20">20 / halaman</option>
                            <option value="50">50 / halaman</option>
                        </select>
                        <input type="number" id="fasilitas-jump" class="form-control form-control-sm pager-jump" min="1" max="1" value="1" aria-label="Lompat ke halaman">
                        <span class="text-secondary" id="fasilitas-pageLabel">Halaman 1 / 1</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm pager-btn" id="fasilitas-first">First Page</button>
                        <button type="button" class="btn btn-sm pager-btn" id="fasilitas-prev" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                        <button type="button" class="btn btn-sm pager-btn pager-next" id="fasilitas-next" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                        <button type="button" class="btn btn-sm pager-btn" id="fasilitas-last">Last Page</button>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="tambahFasilitasModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Tambah Fasilitas', 'icon' => 'bi-plus-circle'])

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
                        class="btn btn-green">

                        <i class="bi bi-save me-1"></i>
                        Simpan Fasilitas

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="editFasilitasModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            @include('layouts.partials.modal-head', ['title' => 'Edit Fasilitas', 'icon' => 'bi-pencil-square'])

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

        var fasilitasTable = $('#fasilitas-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            dom: 'frt',
            ajax: '{{ route('fasilitas.data') }}',
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
                    searchable: false,
                    render: function(data, type, row) {
                        return '<div class="d-flex align-items-center gap-3">' +
                            '<div class="facility-icon"><i class="bi bi-tools"></i></div>' +
                            '<strong>' + row.name + '</strong>' +
                            '</div>';
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
                            'title="Edit" onclick="editFasilitas(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                            'title="Hapus" onclick="deleteFasilitas(' + data +
                            ', \'' + row.name.replace(/'/g, "\\'") + '\')">' +
                            '<i class="bi bi-trash"></i></button>' +
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
                emptyTable: 'Belum ada fasilitas',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

        function renderFasilitasPager() {
            var info = fasilitasTable.page.info();
            var pages = info.pages;
            var total = info.recordsDisplay;
            var start = total ? info.start + 1 : 0;
            $('#fasilitas-info').text('Menampilkan '+start+'–'+info.end + ' dari ' + total + ' data');
            $('#fasilitas-jump').attr('max', pages ? pages : 1).val(pages ? info.page + 1 : 0);
            $('#fasilitas-pageLabel').text('Halaman ' + (pages ? info.page + 1 : 0) + ' / ' + pages);
            $('#fasilitas-first').toggleClass('disabled', info.page <= 0);
            $('#fasilitas-prev').toggleClass('disabled', info.page <= 0);
            $('#fasilitas-next').toggleClass('disabled', info.page >= pages - 1);
            $('#fasilitas-last').toggleClass('disabled', info.page >= pages - 1);
        }

        $('#fasilitas-table').on('draw.dt', renderFasilitasPager);
        $('#fasilitas-first').on('click', function() { fasilitasTable.page('first').draw('page'); });
        $('#fasilitas-prev').on('click', function() { fasilitasTable.page('previous').draw('page'); });
        $('#fasilitas-next').on('click', function() { fasilitasTable.page('next').draw('page'); });
        $('#fasilitas-last').on('click', function() { fasilitasTable.page('last').draw('page'); });
        $('#fasilitas-perPage').on('change', function() { fasilitasTable.page.len(Number($(this).val())).draw(); });
        $('#fasilitas-jump').on('change', function() {
            var info = fasilitasTable.page.info();
            var pages = info.pages > 0 ? info.pages : 1;
            var n = parseInt($(this).val(), 10) || 1;
            if (n < 1) { n = 1; }
            if (n > pages) { n = pages; }
            fasilitasTable.page(n - 1).draw('page');
        });
        renderFasilitasPager();

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

        bootstrap.Modal.getOrCreateInstance($('#editFasilitasModal')[0]).show();
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
                bootstrap.Modal.getInstance($('#tambahFasilitasModal')[0]).hide();
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
                bootstrap.Modal.getInstance($('#editFasilitasModal')[0]).hide();
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