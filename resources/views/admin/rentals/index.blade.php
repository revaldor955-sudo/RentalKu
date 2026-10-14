<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Rental - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background: #f6f8f7;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }

        .page-title {
            font-weight: 800;
            color: #1f2937;
        }

        .card-custom {
            background: white;
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
        }

        .table th {
            font-size: 13px;
            color: #6b7280;
            white-space: nowrap;
            text-transform: uppercase;
        }

        .table td {
            vertical-align: middle;
            white-space: nowrap;
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

        /* Sembunyikan ikon sort di semua kolom */
        #rentals-table thead .dt-column-order {
            display: none !important;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .status-disetujui {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #842029;
        }

        .status-selesai {
            background: #cff4fc;
            color: #055160;
        }

        /* Sidebar layout base styles are in admin-sidebar.blade.php */

        .pager-bar{background:#fff;border:1px solid #edf0ee;border-radius:16px;box-shadow:0 8px 20px rgba(0,0,0,0.05);padding:12px 16px;font-size:14px}
        .pager-bar .text-secondary{font-size:14px;font-weight:500}.pager-select{width:auto;border-radius:10px;font-size:13px;height:34px;padding:6px 28px 6px 10px}
        .pager-jump{width:72px;border-radius:10px;text-align:center;font-size:13px;height:34px;padding:6px 8px}
        .pager-btn{border:1px solid #dee2e6;border-radius:10px;color:#1f2937;font-weight:600;background:#fff;font-size:13px;height:34px;display:inline-flex;align-items:center;padding:6px 12px}
        .pager-btn:hover{border-color:#198754;color:#198754;background:#f5f7f6}
        .pager-btn.disabled{opacity:0.4;pointer-events:none}
        .pager-next{background:#198754;border-color:#198754;color:#fff}
        .pager-next:hover{background:#146c43;border-color:#146c43;color:#fff}

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

<div class="page-content">
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="page-title mb-1">
                Management Rental
            </h2>

            <p class="text-muted mb-0">
                Kelola pengajuan sewa mobil pelanggan.
            </p>
        </div>

    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>

        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>

        </div>
    @endif

    <div class="card-custom">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0" id="rentals-table">

                    <thead>

                        <tr>

                            <th class="px-3 py-3">
                                No
                            </th>

                            <th>
                                Pelanggan
                            </th>

                            <th>
                                Mobil
                            </th>

                            <th>
                                Tanggal Sewa
                            </th>

                            <th>
                                Hari
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end pe-4">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>
                        {{-- Diisi oleh DataTables (server-side) --}}
                    </tbody>

                </table>

                <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3" id="rentals-pager">
                    <div class="text-secondary small" id="rentals-info">
                        Menampilkan 0–0 dari 0 data
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <select id="rentals-len" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                            <option value="10">10 / halaman</option>
                            <option value="20">20 / halaman</option>
                            <option value="50">50 / halaman</option>
                        </select>
                        <input type="number" id="rentals-jump" class="form-control form-control-sm pager-jump" min="1" max="1" value="1" aria-label="Lompat ke halaman">
                        <span class="text-secondary" id="rentals-page">Halaman 1 / 1</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm pager-btn" id="rentals-first">First</button>
                        <button type="button" class="btn btn-sm pager-btn" id="rentals-prev" aria-label="Halaman sebelumnya">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm pager-btn pager-next" id="rentals-next" aria-label="Halaman berikutnya">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <button type="button" class="btn btn-sm pager-btn" id="rentals-last">Last</button>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="detailRentalModal" tabindex="-1" aria-labelledby="detailRentalModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            @include('layouts.partials.modal-head', ['title' => 'Detail Rental', 'icon' => 'bi-car-front', 'titleId' => 'detailRentalModalLabel'])

            <div class="modal-body p-4">

                <div id="rentalDetailLoading" class="text-center py-5">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="text-muted mt-3 mb-0">
                        Memuat detail rental...
                    </p>
                </div>

                <div id="rentalDetailError" class="alert alert-danger d-none" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span id="rentalDetailErrorMessage">
                        Gagal memuat detail rental.
                    </span>
                </div>

                <div id="rentalDetailContent" class="d-none">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <small class="text-muted fw-bold text-uppercase">Pelanggan</small>
                                <h6 class="fw-bold mb-1" id="rd-pelanggan">-</h6>
                                <small class="text-muted" id="rd-email">-</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <small class="text-muted fw-bold text-uppercase">Mobil</small>
                                <div class="d-flex align-items-center gap-3 mt-2">
                                    <img id="rd-mobil-img" src="" alt="Mobil" class="rounded-3" style="width: 80px; height: 60px; object-fit: cover; display: none;">
                                    <div>
                                        <h6 class="fw-bold mb-1" id="rd-mobil">-</h6>
                                        <small class="text-muted" id="rd-plat">-</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase">Periode Sewa</small>
                                <div class="fw-semibold" id="rd-tanggal">-</div>
                                <small class="text-muted" id="rd-jumlah-hari">-</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase">Cabang</small>
                                <div class="fw-semibold">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>
                                    <span id="rd-cabang-ambil">-</span>
                                </div>
                                <div class="fw-semibold">
                                    <i class="bi bi-box-arrow-right me-1"></i>
                                    <span id="rd-cabang-kembali">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase">Rincian Biaya</small>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Harga per hari</small>
                                    <small id="rd-harga-perhari">-</small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Subtotal</small>
                                    <small id="rd-subtotal">-</small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Deposit</small>
                                    <small id="rd-deposit">-</small>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span>
                                    <span id="rd-total">-</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase">Status</small>
                                <div id="rd-status">-</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="border rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase">Catatan</small>
                                <p class="mb-0" id="rd-catatan">-</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

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

    function updateRentalStatus(id, status) {
        const confirmTexts = {
            'Disetujui': 'Setujui pengajuan rental ini?',
            'Ditolak': 'Tolak pengajuan rental ini?',
            'Selesai': 'Selesaikan rental ini?',
        };
        const text = confirmTexts[status] || 'Ubah status rental ini?';

        Swal.fire({
            title: 'Konfirmasi',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('rentals.updateStatus', '__ID__') }}".replace('__ID__', id),
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                data: {
                    status: status
                },
                success: function(res) {
                    $('#rentals-table').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message || 'Terjadi kesalahan',
                    });
                },
                error: function(xhr) {
                    const res = xhr.responseJSON || {};
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message || 'Terjadi kesalahan',
                    });
                },
            });
        });
    }

        function formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function statusBadge(status) {
            const map = {
                'Menunggu': 'status-menunggu',
                'Disetujui': 'status-disetujui',
                'Ditolak': 'status-ditolak',
                'Selesai': 'status-selesai',
            };

            const cls = map[status] || 'bg-secondary text-white';

            return '<span class="status ' + cls + '">' + status + '</span>';
        }

        function rentalActions(data) {
            let html = '<div class="d-flex gap-2 justify-content-end">';

            html += '<button class="btn p-1 text-primary" style="border:none;background:none;" title="Detail" ' +
                'onclick="openRentalDetail(' + data.id + ')">' +
                '<i class="bi bi-eye"></i></button>';

            if (data.status === 'Menunggu') {
                html += '<button type="button" class="btn p-1 text-success" style="border:none;background:none;" title="Setujui" ' +
                    'onclick="updateRentalStatus(' + data.id + ', \'Disetujui\')">' +
                    '<i class="bi bi-check-circle"></i></button>';
                html += '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" title="Tolak" ' +
                    'onclick="updateRentalStatus(' + data.id + ', \'Ditolak\')">' +
                    '<i class="bi bi-x-circle"></i></button>';
            } else if (data.status === 'Disetujui') {
                html += '<button type="button" class="btn p-1 text-info" style="border:none;background:none;" title="Selesaikan" ' +
                    'onclick="updateRentalStatus(' + data.id + ', \'Selesai\')">' +
                    '<i class="bi bi-check-circle"></i></button>';
            }

            html += '</div>';
            return html;
        }

        $(document).ready(function() {

            $('#rentals-table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                info: false,
                dom: 'frt',
                ajax: {
                    url: "{{ route('rentals.data') }}",
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
                        searchable: false,
                        render: function(data) {
                            return '<div class="fw-bold">' + data.user_name + '</div>' +
                                '<small class="text-muted">' + data.user_email + '</small>';
                        },
                    },
                    {
                        data: null,
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return '<div class="fw-bold">' + data.mobil_name + '</div>' +
                                '<small class="text-muted">' + data.mobil_plate + '</small>';
                        },
                    },
                    {
                        data: null,
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return data.tanggal_mulai + '<br>' +
                                '<small class="text-muted">s/d ' + data.tanggal_selesai +
                                '</small>';
                        },
                    },
                    {
                        data: 'jumlah_hari',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return data + ' hari';
                        },
                    },
                    {
                        data: 'total_harga',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return '<strong>' + formatRupiah(data) + '</strong>';
                        },
                    },
                    {
                        data: 'status',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return statusBadge(data);
                        },
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-end pe-4',
                        width: '140px',
                        render: function(data) {
                            return rentalActions(data);
                        },
                    },
                ],
                order: [
                    [3, 'desc']
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
                    emptyTable: 'Belum ada rental',
                    aria: {
                        sortAscending: ': aktifkan untuk urut naik',
                        sortDescending: ': aktifkan untuk urut turun',
                    },
                },
            });

            var rentalsTable = $('#rentals-table').DataTable();

            function renderRentalsPager() {
                var info = rentalsTable.page.info();
                var total=info.recordsDisplay; var start=total?info.start+1:0;
                $('#rentals-info').text('Menampilkan '+start+'–'+info.end+' dari '+total+' data');
                var pages = info.pages || 1;
                var page = info.page + 1;
                $('#rentals-jump').attr('max', pages).val(page);
                $('#rentals-page').text('Halaman '+(pages?info.page+1:0)+' / '+pages);
                $('#rentals-first').toggleClass('disabled', page <= 1);
                $('#rentals-prev').toggleClass('disabled', page <= 1);
                $('#rentals-next').toggleClass('disabled', page >= pages);
                $('#rentals-last').toggleClass('disabled', page >= pages);
            }

            rentalsTable.on('draw.dt', renderRentalsPager);
            renderRentalsPager();

            $('#rentals-first').on('click', function() { rentalsTable.page('first').draw('page'); });
            $('#rentals-prev').on('click', function() { rentalsTable.page('previous').draw('page'); });
            $('#rentals-next').on('click', function() { rentalsTable.page('next').draw('page'); });
            $('#rentals-last').on('click', function() { rentalsTable.page('last').draw('page'); });
            $('#rentals-len').on('change', function() { rentalsTable.page.len(Number($(this).val())).draw(); });
            $('#rentals-jump').on('change', function() {
                var pages = rentalsTable.page.info().pages || 1;
                var n = parseInt($(this).val(), 10) || 1;
                n = Math.min(Math.max(n, 1), pages);
                rentalsTable.page(n - 1).draw('page');
            });

        });

        function openRentalDetail(id) {

            var $modal = bootstrap.Modal.getOrCreateInstance($('#detailRentalModal')[0]);

            var $loading = $('#rentalDetailLoading');
            var $error = $('#rentalDetailError');
            var $content = $('#rentalDetailContent');

            $loading.removeClass('d-none');
            $error.addClass('d-none');
            $content.addClass('d-none');

            $modal.show();

            $.ajax({
                url: "{{ route('rentals.detail', '__ID__') }}".replace('__ID__', id),
                method: 'GET',
                headers: { 'Accept': 'application/json' },
                success: function(data) {
                    $('#rd-pelanggan').text(data.pelanggan);
                    $('#rd-email').text(data.email);
                    $('#rd-mobil').text(data.mobil);
                    $('#rd-plat').text(data.plat);
                    if (data.mobil_image) {
                        $('#rd-mobil-img').attr('src', data.mobil_image).show();
                    } else {
                        $('#rd-mobil-img').hide();
                    }
                    $('#rd-tanggal').text(data.tanggal_mulai + ' s/d ' + data.tanggal_selesai);
                    $('#rd-jumlah-hari').text(data.jumlah_hari + ' hari');
                    $('#rd-cabang-ambil').text(data.cabang_ambil);
                    $('#rd-cabang-kembali').text(data.cabang_kembali);
                    $('#rd-harga-perhari').text(formatRupiah(data.harga_perhari));
                    $('#rd-subtotal').text(formatRupiah(data.subtotal));
                    $('#rd-deposit').text(formatRupiah(data.deposit));
                    $('#rd-total').text(formatRupiah(data.total_harga));
                    $('#rd-status').html(statusBadge(data.status));
                    $('#rd-catatan').text(data.catatan || '-');

                    $loading.addClass('d-none');
                    $content.removeClass('d-none');
                },
                error: function(xhr) {
                    $loading.addClass('d-none');
                    $('#rentalDetailErrorMessage').text('Gagal memuat detail rental: ' + xhr.status + ' ' + xhr.statusText);
                    $error.removeClass('d-none');
                }
            });

        }

</script>

</body>

</html>
