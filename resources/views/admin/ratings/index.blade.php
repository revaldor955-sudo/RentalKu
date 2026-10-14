<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan Pelanggan - RentalKu</title>
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
            margin: 0;
        }
        .page-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            overflow: hidden;
        }
        .page-title {
            font-size: 30px;
            font-weight: 800;
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
            white-space: nowrap;
        }
        #ratings-table thead .dt-column-order {
            display: none !important;
        }
        .star-color {
            color: #d97706;
        }
        .btn-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 18px;
            line-height: 1;
            padding: 0;
        }
        .btn-outline-danger {
            color: #dc2626;
            border-color: #dc2626;
        }
        .btn-outline-danger:hover {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }
        .page-content {
            padding: 24px;
        }
        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
        }
        .pager-bar{background:#fff;border:1px solid #edf0ee;border-radius:16px;box-shadow:0 8px 20px rgba(0,0,0,0.05);padding:12px 16px;font-size:14px}
        .pager-bar .text-secondary{font-size:14px;font-weight:500}.pager-select{width:auto;border-radius:10px;font-size:13px;height:34px;padding:6px 28px 6px 10px}
        .pager-jump{width:72px;border-radius:10px;text-align:center;font-size:13px;height:34px;padding:6px 8px}
        .pager-btn{border:1px solid #dee2e6;border-radius:10px;color:#1f2937;font-weight:600;background:#fff;font-size:13px;height:34px;display:inline-flex;align-items:center;padding:6px 12px}
        .pager-btn:hover{border-color:#198754;color:#198754;background:#f5f7f6}
        .pager-btn.disabled{opacity:0.4;pointer-events:none}
        .pager-next{background:#198754;border-color:#198754;color:#fff}
        .pager-next:hover{background:#146c43;border-color:#146c43;color:#fff}
    </style>
</head>
<body>

@include('layouts.partials.sidebar')

<div class="page-content">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title mb-1">Ulasan Pelanggan</h1>
                <p class="text-muted mb-0">Kelola ulasan dan rating dari pelanggan RentalKu.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="page-card">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="ratings-table">
                    <thead>
                        <tr>
                            <th class="px-3 py-3">No</th>
                            <th>Pelanggan</th>
                            <th>Mobil</th>
                            <th>Bintang</th>
                            <th>Komentar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3" id="ratings-pager">
                    <div class="text-secondary small" id="ratings-info">Menampilkan 0–0 dari 0 data</div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <select class="form-select form-select-sm pager-select" id="ratings-perpage" aria-label="Jumlah per halaman">
                            <option value="10">10 / halaman</option>
                            <option value="20">20 / halaman</option>
                            <option value="50">50 / halaman</option>
                        </select>
                        <input type="number" class="form-control form-control-sm pager-jump" id="ratings-jump" min="1" value="1" aria-label="Lompat ke halaman">
                        <span class="text-secondary" id="ratings-page-label">Halaman 1 / 1</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm pager-btn" id="ratings-first">First</button>
                        <button type="button" class="btn btn-sm pager-btn" id="ratings-prev" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                        <button type="button" class="btn btn-sm pager-btn pager-next" id="ratings-next" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                        <button type="button" class="btn btn-sm pager-btn" id="ratings-last">Last</button>
                    </div>
                </div>
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

    function showSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: message,
            timer: 1800,
            showConfirmButton: false,
        });
    }

    function deleteRating(id, name) {
        Swal.fire({
            title: 'Hapus Ulasan?',
            text: name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url('admin/ratings') }}/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                    },
                    success: function() {
                        showSuccess('Ulasan berhasil dihapus.');
                      $('#ratings-table').DataTable().ajax.reload(null, true);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menghapus ulasan.',
                        });
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        var ratingsTable = $('#ratings-table').DataTable({
            paging: false,
            info: false,
            dom: 'frt',
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.ratings.data') }}',
                type: 'GET',
            },
            columns: [
                {
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
                    data: 'customer_name',
                    render: function(data, type, row) {
                        return '<div class="fw-600">' + data + '</div>' +
                            '<div class="text-muted small">' + (row.customer_email || '') + '</div>';
                    },
                },
                {
                    data: 'mobil_name',
                    render: function(data, type, row) {
                        return '<div class="fw-500">' + data + '</div>' +
                            '<div class="text-muted small">Booking #' + row.booking_id + '</div>';
                    },
                },
                {
                    data: 'rating',
                    className: 'text-center',
                    render: function(data) {
                        var stars = '';
                        for (var i = 1; i <= 5; i++) {
                            stars += '<i class="bi bi-star-' + (i <= data ? 'fill' : 'half') + ' star-color fs-5"></i>';
                        }
                        return '<div class="d-flex align-items-center justify-content-center gap-1">' + stars +
                            '<span class="ms-1 fw-500">' + data + '/5</span></div>';
                    },
                },
                {
                    data: 'komentar',
                    orderable: false,
                    render: function(data) {
                        return data || '<span class="text-muted">Tidak ada komentar.</span>';
                    },
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '100px',
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-outline-danger btn-icon p-0" title="Hapus" onclick="deleteRating(' + data + ', \'' + (row.customer_name || '').replace(/'/g, "\\'") + '\')"><i class="bi bi-trash"></i></button>';
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
                emptyTable: 'Belum ada ulasan',
            },
        });
        function renderRatingsPager() {
            var info = ratingsTable.page.info();
            var total=info.recordsDisplay;
            var start=total?info.start+1:0;
            var pages=info.pages;
            $('#ratings-info').text('Menampilkan '+start+'–'+info.end+' dari '+total+' data');
            var max = Math.max(pages, 1);
            $('#ratings-jump').attr('max', max);
            $('#ratings-jump').val(pages ? (info.page + 1) : 1);
            $('#ratings-page-label').text('Halaman '+(pages?info.page+1:0)+' / '+pages);
            var first = (info.page === 0 || info.pages <= 1);
            var last = (info.pages <= 1 || info.page === info.pages - 1);
            $('#ratings-first').toggleClass('disabled', first);
            $('#ratings-prev').toggleClass('disabled', first);
            $('#ratings-next').toggleClass('disabled', last);
            $('#ratings-last').toggleClass('disabled', last);
        }
        ratingsTable.on('draw.dt', renderRatingsPager);
        renderRatingsPager();
        $('#ratings-first').on('click', function() { ratingsTable.page('first').draw('page'); });
        $('#ratings-prev').on('click', function() { ratingsTable.page('previous').draw('page'); });
        $('#ratings-next').on('click', function() { ratingsTable.page('next').draw('page'); });
        $('#ratings-last').on('click', function() { ratingsTable.page('last').draw('page'); });
        $('#ratings-perpage').on('change', function() { ratingsTable.page.len($(this).val()).draw(); });
        $('#ratings-jump').on('change', function() { var info = ratingsTable.page.info(); var max = Math.max(info.pages, 1); var n = parseInt($(this).val(), 10) || 1; if (n < 1) n = 1; if (n > max) n = max; ratingsTable.page(n - 1).draw('page'); });
    });
</script>

</body>
</html>