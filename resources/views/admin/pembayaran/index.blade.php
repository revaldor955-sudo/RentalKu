<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Pembayaran - RentalKu</title>

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

        /* Sembunyikan ikon sort di semua kolom */
        #pembayaran-table thead .dt-column-order {
            display: none !important;
        }

        .badge-status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #997404;
        }

        .status-disetujui {
            background: #dff7e8;
            color: #198754;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #b02a37;
        }

        .proof-image {
            width: 96px;
            height: 68px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
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

    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center mb-1">
            <h2 class="fw-bold mb-0">
                Management Pembayaran
            </h2>

        </div>

        <p class="text-muted mb-0">
            Kelola dan verifikasi pembayaran pelanggan RentalKu.
        </p>

    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>
    @endif

    @if ($errors->any())

        <div class="alert alert-danger mb-4">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <div class="page-card">

        <div class="table-responsive">

            <table class="table align-middle mb-0" id="pembayaran-table">

                <thead>

                    <tr>

                        <th class="px-3 py-3">
                            No
                        </th>

                        <th>
                            Pelanggan
                        </th>

                        <th>
                            Bukti
                        </th>

                        <th>
                            Mobil
                        </th>

                        <th>
                            Metode
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Jumlah
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

            <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3" id="pembayaran-pager">
                <div class="text-secondary small" id="pembayaran-info">
                    Menampilkan 0–0 dari 0 data
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select id="pembayaran-len" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                        <option value="10">10 / halaman</option>
                        <option value="20">20 / halaman</option>
                        <option value="50">50 / halaman</option>
                        <option value="100">100 / halaman</option>
                        <option value="custom">Custom</option>
                    </select>
                    <input type="number" id="pembayaran-custom" class="form-control form-control-sm pager-jump" min="1" max="500" value="10" aria-label="Jumlah custom per halaman">
                    <span class="text-secondary" id="pembayaran-page">Halaman 1 / 1</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm pager-btn" id="pembayaran-first">First</button>
                    <button type="button" class="btn btn-sm pager-btn" id="pembayaran-prev" aria-label="Halaman sebelumnya">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-sm pager-btn pager-next" id="pembayaran-next" aria-label="Halaman berikutnya">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                    <button type="button" class="btn btn-sm pager-btn" id="pembayaran-last">Last</button>
                </div>
            </div>

        </div>

    </div>

    </div>

<div class="modal fade" id="fotoPembayaranModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Bukti Pembayaran'])
            <div class="modal-body p-3 text-center">
                <img id="fotoPembayaranPreview" src="" class="img-fluid rounded" alt="Bukti pembayaran">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailPembayaranModal" tabindex="-1" aria-labelledby="detailPembayaranModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            @include('layouts.partials.modal-head', ['title' => 'Detail Pembayaran', 'icon' => 'bi-credit-card', 'titleId' => 'detailPembayaranModalLabel'])

            <div class="modal-body p-4">

                <div id="pembayaranDetailLoading" class="text-center py-5">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="text-muted mt-3 mb-0">
                        Memuat detail pembayaran...
                    </p>
                </div>

                <div id="pembayaranDetailError" class="alert alert-danger d-none" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span id="pembayaranDetailErrorMessage">
                        Gagal memuat detail pembayaran.
                    </span>
                </div>

                <div id="pembayaranDetailContent" class="d-none">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <small class="text-muted fw-bold text-uppercase">Pelanggan</small>
                                <h6 class="fw-bold mb-1" id="pd-pelanggan">-</h6>
                                <small class="text-muted" id="pd-email">-</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 h-100">
                                <small class="text-muted fw-bold text-uppercase">Mobil</small>
                                <h6 class="fw-bold mb-1" id="pd-mobil">-</h6>
                                <small class="text-muted" id="pd-plat">-</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase">Metode & Tanggal</small>
                                <div class="fw-semibold" id="pd-metode">-</div>
                                <small class="text-muted" id="pd-tanggal">-</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase">Jumlah</small>
                                <h5 class="fw-bold text-success mb-0" id="pd-jumlah">-</h5>
                            </div>
                        </div>
<!-- DETAIL RENTAL -->
<div class="col-12">
    <div class="border rounded-3 p-3">
        <h6 class="fw-bold mb-3">
            <i class="bi bi-car-front me-2"></i>Detail Rental
        </h6>

        <div class="row g-3">
            <div class="col-md-6">
                <small class="text-muted">ID Rental</small>
                <div class="fw-semibold" id="pd-rental-id">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Status Rental</small>
                <div class="fw-semibold" id="pd-rental-status">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Tanggal Mulai</small>
                <div id="pd-rental-mulai">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Tanggal Selesai</small>
                <div id="pd-rental-selesai">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Lama Sewa</small>
                <div id="pd-rental-hari">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Harga per Hari</small>
                <div id="pd-rental-harga">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Cabang Pengambilan</small>
                <div id="pd-rental-cabang-ambil">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Cabang Pengembalian</small>
                <div id="pd-rental-cabang-kembali">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Subtotal</small>
                <div id="pd-rental-subtotal">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Deposit</small>
                <div id="pd-rental-deposit">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Diskon</small>
                <div id="pd-rental-diskon">-</div>
            </div>

            <div class="col-md-6">
                <small class="text-muted">Total Rental</small>
                <h5 class="fw-bold text-success mb-0" id="pd-rental-total">-</h5>
            </div>
        </div>
    </div>
</div>
<!-- AKHIR DETAIL RENTAL -->
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase">Status</small>
                                <div id="pd-status">-</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase">Bukti Pembayaran</small>
                                <div id="pd-bukti">
                                    <span class="text-muted">Tidak ada</span>
                                </div>
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

    function updatePembayaranStatus(id, status) {
        const text = status === 'Disetujui' ? 'Setujui pembayaran ini?' : 'Tolak pembayaran ini?';

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
                url: "{{ route('pembayarans.updateStatus', '__ID__') }}".replace('__ID__', id),
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                data: {
                    status: status
                },
                success: function(res) {
                    $('#pembayaran-table').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
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

    function openFotoPembayaran(url) {
        $('#fotoPembayaranPreview').attr('src', url);
        bootstrap.Modal.getOrCreateInstance($('#fotoPembayaranModal')[0]).show();
    }

    function statusBadge(status) {
        const map = {
            'Menunggu': 'status-menunggu',
            'Disetujui': 'status-disetujui',
            'Ditolak': 'status-ditolak',
        };

        const cls = map[status] || 'bg-secondary text-white';

        return '<span class="badge-status ' + cls + '">' + status + '</span>';
    }

    function pembayaranActions(data) {
        let html = '<div class="d-flex gap-2 justify-content-end">';

        html += '<button class="btn p-1 text-primary" style="border:none;background:none;" ' +
            'onclick="openPembayaranDetail(' + data.id + ')" title="Detail">' +
            '<i class="bi bi-eye"></i></button>';

        if (data.status === 'Menunggu') {
            html += '<button class="btn p-1 text-success" style="border:none;background:none;" ' +
                'onclick="updatePembayaranStatus(' + data.id + ', \'Disetujui\')" title="Setujui">' +
                '<i class="bi bi-check-circle"></i></button>';
            html += '<button class="btn p-1 text-danger" style="border:none;background:none;" ' +
                'onclick="updatePembayaranStatus(' + data.id + ', \'Ditolak\')" title="Tolak">' +
                '<i class="bi bi-x-circle"></i></button>';
        }

        html += '</div>';

        return html;
    }

    $(document).ready(function() {

        $('#pembayaran-table').DataTable({
                            processing: true,
                            serverSide: true,
                            paging: false,
                            info: false,
                            dom: 'frt',
                            ajax: {
                                url: "{{ route('pembayarans.data') }}",
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
                                    data: 'user_name',
                                    orderable: true,
                                    searchable: false,
                                    render: function(data) {
                                        return '<strong>' + data + '</strong>';
                                    },
                                },
                                {
                                    data: 'bukti',
                                    orderable: false,
                                    searchable: false,
                                    render: function(data) {
                                        if (!data) {
                                            return '<span class="text-muted">Tidak ada</span>';
                                        }

                                        const url = "{{ asset('storage/__BUKTI__') }}".replace(
                                            '__BUKTI__', data);

                                        return '<a href="#" onclick="openFotoPembayaran(\'' + url + '\');return false;">' +
                                            '<img src="' + url +
                                            '" class="proof-image" alt="Bukti pembayaran"></a>';
                                    },
                                },
                                {
                                    data: 'mobil_name',
                                    orderable: true,
                                    searchable: false,
                                },
                                {
                                    data: 'metode_name',
                                    orderable: true,
                                    searchable: false,
                                },
                                {
                                    data: 'tanggal_bayar',
                                    orderable: true,
                                    searchable: false,
                                },
                                {
                                    data: 'jumlah',
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
                                        return pembayaranActions(data);
                                    },
                                },
                            ],
                           order: [],
                            ordering: false,    
                            language: {
                                processing: 'Memproses...',
                                search: 'Cari:',
                                lengthMenu: 'Tampilkan _MENU_ data',
                                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                                infoEmpty: 'Tidak ada data',
                                infoFiltered: '(difilter dari _MAX_ total data)',
                                loadingRecords: 'Memuat...',
                                zeroRecords: 'Tidak ditemukan data yang cocok',
                                emptyTable: 'Belum ada pembayaran',
                                aria: {
                                    sortAscending: ': aktifkan untuk urut naik',
                                    sortDescending: ': aktifkan untuk urut turun',
                                },
                            },
                        });

        var pembayaranTable = $('#pembayaran-table').DataTable();

        function renderPembayaranPager() {
            var info = pembayaranTable.page.info();
            var total=info.recordsDisplay; var start=total?info.start+1:0;
            $('#pembayaran-info').text('Menampilkan '+start+'–'+info.end+' dari '+total+' data');
            var pages = info.pages || 1;
            var page = info.page + 1;
            $('#pembayaran-page').text('Halaman '+(pages?info.page+1:0)+' / '+pages);
            $('#pembayaran-first').toggleClass('disabled', page <= 1);
            $('#pembayaran-prev').toggleClass('disabled', page <= 1);
            $('#pembayaran-next').toggleClass('disabled', page >= pages);
            $('#pembayaran-last').toggleClass('disabled', page >= pages);
        }

        pembayaranTable.on('draw.dt', renderPembayaranPager);
        renderPembayaranPager();

        $('#pembayaran-first').on('click', function() { pembayaranTable.page('first').draw('page'); });
        $('#pembayaran-prev').on('click', function() { pembayaranTable.page('previous').draw('page'); });
        $('#pembayaran-next').on('click', function() { pembayaranTable.page('next').draw('page'); });
        $('#pembayaran-last').on('click', function() { pembayaranTable.page('last').draw('page'); });
        $('#pembayaran-len').on('change', function() { if ($(this).val() === 'custom') { $('#pembayaran-custom').focus(); return; } var n = Number($(this).val()); $('#pembayaran-custom').val(n); pembayaranTable.page.len(n).draw(); });
        $('#pembayaran-custom').on('change', function() { var n = parseInt($(this).val(), 10) || 1; n = Math.min(Math.max(n, 1), 500); $(this).val(n); if (['10','20','50','100'].indexOf(String(n)) !== -1) { $('#pembayaran-len').val(String(n)); } else { $('#pembayaran-len').val('custom'); } pembayaranTable.page.len(n).draw(); });

    });

    function openPembayaranDetail(id) {

        var $modal = bootstrap.Modal.getOrCreateInstance($('#detailPembayaranModal')[0]);

        var $loading = $('#pembayaranDetailLoading');
        var $error = $('#pembayaranDetailError');
        var $content = $('#pembayaranDetailContent');

        $loading.removeClass('d-none');
        $error.addClass('d-none');
        $content.addClass('d-none');

        $modal.show();

        $.ajax({
            url: "{{ route('pembayarans.detail', '__ID__') }}".replace('__ID__', id),
            method: 'GET',
            success: function(data) {
                $('#pd-pelanggan').text(data.pelanggan);
                $('#pd-email').text(data.email);
                $('#pd-mobil').text(data.mobil);
                $('#pd-plat').text(data.plat);
                $('#pd-metode').text(data.metode);
                $('#pd-tanggal').text(data.tanggal_bayar);
                $('#pd-jumlah').text(formatRupiah(data.jumlah));
                $('#pd-status').html(statusBadge(data.status));
                
const rental = data.rental || {};

$('#pd-rental-id').text(rental.id ?? '-');
$('#pd-rental-status').text(rental.status ?? '-');
$('#pd-rental-mulai').text(rental.tanggal_mulai ?? '-');
$('#pd-rental-selesai').text(rental.tanggal_selesai ?? '-');
$('#pd-rental-hari').text((rental.jumlah_hari ?? 0) + ' hari');
$('#pd-rental-harga').text(formatRupiah(rental.harga_perhari ?? 0));
$('#pd-rental-cabang-ambil').text(rental.cabang_ambil ?? '-');
$('#pd-rental-cabang-kembali').text(rental.cabang_kembali ?? '-');
$('#pd-rental-subtotal').text(formatRupiah(rental.subtotal ?? 0));
$('#pd-rental-deposit').text(formatRupiah(rental.deposit ?? 0));
$('#pd-rental-diskon').text(formatRupiah(rental.diskon ?? 0));
$('#pd-rental-total').text(formatRupiah(rental.total_harga ?? 0));


                var $buktiContainer = $('#pd-bukti');
                $buktiContainer.empty();

                if (data.bukti_url) {
                    $buktiContainer.append('<img src="' + data.bukti_url + '" class="proof-image" alt="Bukti pembayaran">');
                } else {
                    $buktiContainer.html('<span class="text-muted">Tidak ada</span>');
                }

                $loading.addClass('d-none');
                $content.removeClass('d-none');
            },
            error: function(xhr) {
                $loading.addClass('d-none');
                $error.removeClass('d-none');
                $('#pembayaranDetailErrorMessage').text('Gagal memuat detail pembayaran: ' + xhr.status + ' ' + xhr.statusText);
            }
        });

    }
</script>

</body>

</html>
