<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Foto Mobil - RentalKu</title>

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

        #fotoMobils-table thead .dt-column-order {
            display: none !important;
        }

        .foto-preview {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e9ecef;
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

        .pager-bar {
            background: #fff;
            border: 1px solid #edf0ee;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            padding: 12px 16px;
            font-size: 14px;
        }
        .pager-bar .text-secondary { font-size: 14px; font-weight: 500; }
        .pager-select {
            width: auto;
            border-radius: 10px;
            font-size: 13px;
            height: 34px;
            padding: 6px 28px 6px 10px;
        }
        .pager-jump {
            width: 72px;
            border-radius: 10px;
            text-align: center;
            font-size: 13px;
            height: 34px;
            padding: 6px 8px;
        }
        .pager-btn {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            color: #1f2937;
            font-weight: 600;
            background: #fff;
            font-size: 13px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
        }
        .pager-btn:hover {
            border-color: #198754;
            color: #198754;
            background: #f5f7f6;
        }
        .pager-btn.disabled {
            opacity: 0.4;
            pointer-events: none;
        }
        .pager-next {
            background: #198754;
            border-color: #198754;
            color: #fff;
        }
        .pager-next:hover {
            background: #146c43;
            border-color: #146c43;
            color: #fff;
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
                Management Foto Mobil
            </h2>

            <p class="text-muted mb-0">
                Kelola foto-foto tambahan mobil di RentalKu.
            </p>

        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#tambahFotoMobilModal">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah Foto

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
                                Daftar Foto Mobil
                            </h5>

                            <small class="text-muted">
                                Seluruh foto mobil yang terdaftar di RentalKu.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0" id="fotoMobils-table">

                        <thead>

                            <tr>

                                <th class="px-3 py-3">
                                    No
                                </th>

                                <th>
                                    Mobil
                                </th>

                                <th>
                                    Foto
                                </th>

                                <th class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                    <div class="p-3">
                        <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div class="text-secondary" id="fm-pager-info">
                                Menampilkan 0–0 dari 0 data
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <select id="fm-pager-len" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                                    <option value="10">10 / halaman</option>
                                    <option value="20">20 / halaman</option>
                                    <option value="50">50 / halaman</option>
                                </select>
                                <input type="number" id="fm-pager-jump" class="form-control form-control-sm pager-jump" min="1" value="1" aria-label="Lompat ke halaman">
                                <span class="text-secondary" id="fm-pager-pages">
                                    Halaman 1 / 1
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm pager-btn" id="fm-pager-first">First</button>
                                <button type="button" class="btn btn-sm pager-btn" id="fm-pager-prev" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                                <button type="button" class="btn btn-sm pager-btn pager-next" id="fm-pager-next" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                                <button type="button" class="btn btn-sm pager-btn" id="fm-pager-last">Last</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="fotoMobilModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                @include('layouts.partials.modal-head', ['title' => 'Foto Mobil'])
                <div class="modal-body p-3 text-center">
                    <img id="fotoMobilPreview" src="" class="img-fluid rounded" alt="Foto mobil">
                </div>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        id="tambahFotoMobilModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Tambah Foto Mobil', 'icon' => 'bi-plus-circle'])

                <form
                    action="{{ route('foto_mobils.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="formTambahFotoMobil">

                    @csrf

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Mobil
                        </label>

                        <select name="mobil_id" class="form-select" required>
                            <option value="">-- Pilih Mobil --</option>
                            @foreach($mobils as $mobil)
                                <option value="{{ $mobil->id }}">
                                    {{ $mobil->name }} ({{ $mobil->plate_number }})
                                </option>
                            @endforeach
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Foto Mobil
                        </label>

                        <input
                            type="file"
                            name="url"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.svg"
                            required>

                        <small class="text-muted">JPG, PNG, JPEG, SVG, Maksimal 2MB</small>

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
                            Simpan Foto

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="editFotoMobilModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Edit Foto Mobil', 'icon' => 'bi-pencil-square'])

                <form
                    action=""
                    method="POST"
                    enctype="multipart/form-data"
                    id="formEditFotoMobil">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Mobil
                        </label>

                        <select name="mobil_id" id="editMobilIdFoto" class="form-select" required>
                            <option value="">-- Pilih Mobil --</option>
                            @foreach($mobils as $mobil)
                                <option value="{{ $mobil->id }}">
                                    {{ $mobil->name }} ({{ $mobil->plate_number }})
                                </option>
                            @endforeach
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Foto Mobil
                        </label>

                        <img
                            id="editFotoPreview"
                            src=""
                            class="foto-preview mb-2"
                            style="display:none;"
                            alt="Preview foto mobil">

                        <input
                            type="file"
                            name="url"
                            id="editUrlFoto"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.svg">

                        <small class="text-muted">JPG, PNG, JPEG, SVG, Maksimal 2MB, Kosongkan jika foto tidak diganti</small>

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

    function openFotoMobil(url) {
        $('#fotoMobilPreview').attr('src', url);
        bootstrap.Modal.getOrCreateInstance($('#fotoMobilModal')[0]).show();
    }

    function fotoPreview(url) {
        if (url) {
            const full = '{{ asset('__PHOTO__') }}'.replace('__PHOTO__', url);
            return '<a href="#" onclick="openFotoMobil(\'' + full + '\');return false;">' +
                '<img src="' + full + '" class="foto-preview" alt="Foto mobil"></a>';
        }
        return '<span class="text-muted">-</span>';
    }

    $(document).ready(function() {

        var fmTable = $('#fotoMobils-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            dom: 'frt',
            ajax: {
                url: '{{ route('foto_mobils.data') }}',
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
                    data: null,
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return '<strong>' + data.mobil_name + '</strong>' +
                            '<div class="small text-muted">' + data.mobil_plate + '</div>';
                    },
                },
                {
                    data: 'url',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return fotoPreview(data);
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
                            'title="Edit" onclick="editFotoMobil(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                            'title="Hapus" onclick="deleteFotoMobil(' + data +
                            ', \'' + row.mobil_name.replace(/'/g, "\\'") + '\')">' +
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
                emptyTable: 'Belum ada foto mobil',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

        function renderFmPager() {
            var info = fmTable.page.info();
            var total = info.recordsDisplay;
            var start = total ? info.start + 1 : 0;
            $('#fm-pager-info').text('Menampilkan '+start+'–'+info.end + ' dari ' + total + ' data');
            var pages = Math.max(info.pages, 1);
            var page = info.page + 1;
            $('#fm-pager-pages').text('Halaman ' + (pages ? info.page + 1 : 0) + ' / ' + pages);
            var $jump = $('#fm-pager-jump');
            $jump.attr('max', pages);
            if (document.activeElement !== $jump[0]) {
                $jump.val(page);
            }
            $('#fm-pager-first, #fm-pager-prev').toggleClass('disabled', page <= 1);
            $('#fm-pager-next, #fm-pager-last').toggleClass('disabled', page >= pages);
        }

        fmTable.on('draw.dt', renderFmPager);
        renderFmPager();

        $('#fm-pager-first').on('click', function() {
            fmTable.page('first').draw('page');
        });
        $('#fm-pager-prev').on('click', function() {
            fmTable.page('previous').draw('page');
        });
        $('#fm-pager-next').on('click', function() {
            fmTable.page('next').draw('page');
        });
        $('#fm-pager-last').on('click', function() {
            fmTable.page('last').draw('page');
        });
        $('#fm-pager-len').on('change', function() {
            fmTable.page.len(Number($(this).val())).draw();
        });
        $('#fm-pager-jump').on('change', function() {
            var pages = Math.max(fmTable.page.info().pages, 1);
            var p = parseInt($(this).val(), 10) || 1;
            p = Math.min(Math.max(p, 1), pages);
            fmTable.page(p - 1).draw('page');
        });

    });

    function deleteFotoMobil(id, mobilName) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus foto mobil "' + mobilName + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('foto_mobils.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {

$('#fotoMobils-table').DataTable().ajax.reload(null, true);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Foto mobil berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus foto mobil.',
                    });
                }
            });
        });
    }

    function editFotoMobil(id) {
        const data = $('#fotoMobils-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data foto mobil tidak ditemukan.',
            });
            return;
        }

        $('#editMobilIdFoto').val(data.mobil_id);
        $('#editUrlFoto').val('');

        if (data.url) {
            $('#editFotoPreview').attr('src', '{{ asset('__PHOTO__') }}'.replace('__PHOTO__', data.url)).show();
        } else {
            $('#editFotoPreview').hide();
        }

        $('#formEditFotoMobil').attr('action',
            "{{ route('foto_mobils.update', '__ID__') }}".replace('__ID__', id));

        bootstrap.Modal.getOrCreateInstance($('#editFotoMobilModal')[0]).show();
    }

    $(document).on('submit', '#formTambahFotoMobil', function(e) {
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
                bootstrap.Modal.getInstance($('#tambahFotoMobilModal')[0]).hide();
                $('#formTambahFotoMobil')[0].reset();
                $('#fotoMobils-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Foto mobil berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan foto mobil.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditFotoMobil', function(e) {
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
                bootstrap.Modal.getInstance($('#editFotoMobilModal')[0]).hide();
                $('#fotoMobils-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Foto mobil berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui foto mobil.');

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
