<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Kerusakan Mobil - RentalKu</title>

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

        #kerusakanMobils-table thead .dt-column-order {
            display: none !important;
        }

        .jenis-badge {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .jenis-mesin { background: #e7f1ff; color: #0d6efd; }
        .jenis-ban { background: #fff3cd; color: #997404; }
        .jenis-body { background: #f8d7da; color: #b02a37; }
        .jenis-interior { background: #d1e7dd; color: #0f5132; }
        .jenis-rem { background: #e2d1f0; color: #6f42c1; }
        .jenis-kelistrikan { background: #ffeaa7; color: #b8860b; }
        .jenis-ac { background: #d6eaf8; color: #2e86c1; }
        .jenis-transmisi { background: #fadbd8; color: #c0392b; }
        .jenis-suspensi { background: #d5f5e3; color: #1e8e49; }
        .jenis-kaca { background: #fdebd0; color: #d4ac0d; }
        .jenis-lainnya { background: #e8daef; color: #8e44ad; }

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
                Management Kerusakan Mobil
            </h2>

            <p class="text-muted mb-0">
                Kelola jenis-jenis kerusakan mobil di RentalKu.
            </p>

        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#tambahKerusakanMobilModal">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah Kerusakan

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
                                Daftar Jenis Kerusakan
                            </h5>

                            <small class="text-muted">
                                Seluruh jenis kerusakan yang terdaftar di RentalKu.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0" id="kerusakanMobils-table">

                        <thead>

                            <tr>

                                <th class="px-3 py-3">
                                    No
                                </th>

                                <th>
                                    Jenis Kerusakan
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
                        </tbody>

                    </table>

                    <div class="p-3">
                        <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div class="text-secondary" id="km-pager-info">
                                Menampilkan 0–0 dari 0 data
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <select id="km-pager-len" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                                    <option value="10">10 / halaman</option>
                                    <option value="20">20 / halaman</option>
                                    <option value="50">50 / halaman</option>
                                    <option value="100">100 / halaman</option>
                                    <option value="custom">Custom</option>
                                </select>
                                <input type="number" id="km-pager-custom" class="form-control form-control-sm pager-jump" min="1" max="500" value="10" aria-label="Jumlah custom per halaman">
                                <span class="text-secondary" id="km-pager-pages">
                                    Halaman 1 / 1
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm pager-btn" id="km-pager-first">First</button>
                                <button type="button" class="btn btn-sm pager-btn" id="km-pager-prev" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                                <button type="button" class="btn btn-sm pager-btn pager-next" id="km-pager-next" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                                <button type="button" class="btn btn-sm pager-btn" id="km-pager-last">Last</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="tambahKerusakanMobilModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Tambah Kerusakan Mobil', 'icon' => 'bi-plus-circle'])

                <form
                    action="{{ route('kerusakan_mobils.store') }}"
                    method="POST"
                    id="formTambahKerusakanMobil">

                    @csrf

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Jenis Kerusakan
                        </label>

                        <select name="jenis_kerusakan" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Mesin">Mesin</option>
                            <option value="Ban">Ban</option>
                            <option value="Body">Body</option>
                            <option value="Interior">Interior</option>
                            <option value="Rem">Rem</option>
                            <option value="Kelistrikan">Kelistrikan</option>
                            <option value="AC">AC</option>
                            <option value="Transmisi">Transmisi</option>
                            <option value="Suspensi">Suspensi</option>
                            <option value="Kaca">Kaca</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Deskripsi tambahan mengenai jenis kerusakan..."></textarea>

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
                            Simpan Kerusakan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="editKerusakanMobilModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Edit Kerusakan Mobil', 'icon' => 'bi-pencil-square'])

                <form
                    action=""
                    method="POST"
                    id="formEditKerusakanMobil">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Jenis Kerusakan
                        </label>

                        <select name="jenis_kerusakan" id="editJenisKerusakan" class="form-select" required>
                            <option value="Mesin">Mesin</option>
                            <option value="Ban">Ban</option>
                            <option value="Body">Body</option>
                            <option value="Interior">Interior</option>
                            <option value="Rem">Rem</option>
                            <option value="Kelistrikan">Kelistrikan</option>
                            <option value="AC">AC</option>
                            <option value="Transmisi">Transmisi</option>
                            <option value="Suspensi">Suspensi</option>
                            <option value="Kaca">Kaca</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Deskripsi
                        </label>

                        <textarea
                            name="description"
                            id="editDeskripsiKerusakan"
                            class="form-control"
                            rows="3"
                            placeholder="Deskripsi tambahan mengenai jenis kerusakan..."></textarea>

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

    function jenisBadge(jenis) {
        const map = {
            'Mesin': 'jenis-mesin',
            'Ban': 'jenis-ban',
            'Body': 'jenis-body',
            'Interior': 'jenis-interior',
            'Rem': 'jenis-rem',
            'Kelistrikan': 'jenis-kelistrikan',
            'AC': 'jenis-ac',
            'Transmisi': 'jenis-transmisi',
            'Suspensi': 'jenis-suspensi',
            'Kaca': 'jenis-kaca',
            'Lainnya': 'jenis-lainnya',
        };

        const cls = map[jenis] || 'bg-secondary text-white';

        return '<span class="jenis-badge ' + cls + '">' + jenis + '</span>';
    }

    $(document).ready(function() {

        var kmTable = $('#kerusakanMobils-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            dom: 'frt',
            ajax: {
                url: '{{ route('kerusakan_mobils.data') }}',
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
                    data: 'jenis_kerusakan',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return jenisBadge(data);
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
                            'title="Edit" onclick="editKerusakanMobil(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                            'title="Hapus" onclick="deleteKerusakanMobil(' + data +
                            ', \'' + row.jenis_kerusakan.replace(/'/g, "\\'") + '\')">' +
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
                emptyTable: 'Belum ada jenis kerusakan',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

        function renderKmPager() {
            var info = kmTable.page.info();
            var total = info.recordsDisplay;
            var start = total ? info.start + 1 : 0;
            $('#km-pager-info').text('Menampilkan '+start+'–'+info.end + ' dari ' + total + ' data');
            var pages = Math.max(info.pages, 1);
            var page = info.page + 1;
            $('#km-pager-pages').text('Halaman ' + (pages ? info.page + 1 : 0) + ' / ' + pages);
            $('#km-pager-first, #km-pager-prev').toggleClass('disabled', page <= 1);
            $('#km-pager-next, #km-pager-last').toggleClass('disabled', page >= pages);
        }

        kmTable.on('draw.dt', renderKmPager);
        renderKmPager();

        $('#km-pager-first').on('click', function() {
            kmTable.page('first').draw('page');
        });
        $('#km-pager-prev').on('click', function() {
            kmTable.page('previous').draw('page');
        });
        $('#km-pager-next').on('click', function() {
            kmTable.page('next').draw('page');
        });
        $('#km-pager-last').on('click', function() {
            kmTable.page('last').draw('page');
        });
        $('#km-pager-len').on('change', function() {
            var v = $(this).val();
            if (v === 'custom') { $('#km-pager-custom').focus(); return; }
            var n = parseInt(v, 10) || 10;
            $('#km-pager-custom').val(n);
            kmTable.page.len(n).draw();
        });
        $('#km-pager-custom').on('change', function() {
            var n = parseInt($(this).val(), 10) || 1;
            n = Math.min(Math.max(n, 1), 500);
            $(this).val(n);
            if (['10', '20', '50', '100'].indexOf(String(n)) !== -1) { $('#km-pager-len').val(String(n)); }
            else { $('#km-pager-len').val('custom'); }
            kmTable.page.len(n).draw();
        });

    });

    function deleteKerusakanMobil(id, jenis) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus jenis kerusakan "' + jenis + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('kerusakan_mobils.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {

$('#kerusakanMobils-table').DataTable().ajax.reload(null, true);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Jenis kerusakan berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus jenis kerusakan.',
                    });
                }
            });
        });
    }

    function editKerusakanMobil(id) {
        const data = $('#kerusakanMobils-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data jenis kerusakan tidak ditemukan.',
            });
            return;
        }

        $('#editJenisKerusakan').val(data.jenis_kerusakan);
        $('#editDeskripsiKerusakan').val(data.description);

        $('#formEditKerusakanMobil').attr('action',
            "{{ route('kerusakan_mobils.update', '__ID__') }}".replace('__ID__', id));

        bootstrap.Modal.getOrCreateInstance($('#editKerusakanMobilModal')[0]).show();
    }

    $(document).on('submit', '#formTambahKerusakanMobil', function(e) {
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
                bootstrap.Modal.getInstance($('#tambahKerusakanMobilModal')[0]).hide();
                $('#formTambahKerusakanMobil')[0].reset();
                $('#kerusakanMobils-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Jenis kerusakan berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan jenis kerusakan.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditKerusakanMobil', function(e) {
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
                bootstrap.Modal.getInstance($('#editKerusakanMobilModal')[0]).hide();
                $('#kerusakanMobils-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Jenis kerusakan berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui jenis kerusakan.');

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
