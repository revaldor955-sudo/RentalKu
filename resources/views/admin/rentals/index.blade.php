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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background: #f6f8f7;
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        .page-content {
            padding: 24px;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
        }
    </style>
</head>

<body>

{{-- Sidebar Layout --}}
@include('layouts.partials.admin-sidebar')

<script>
    // Inject navbar into sidebar layout
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

{{-- Page Content --}}
<div class="page-content">

<div class="container py-4">

    {{-- HEADER --}}
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


    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>

        </div>
    @endif


    {{-- ALERT ERROR --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>

        </div>
    @endif


    {{-- TABLE --}}
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

            </div>

        </div>

    </div>

</div>


{{-- MODAL DETAIL RENTAL --}}
<div class="modal fade" id="detailRentalModal" tabindex="-1" aria-labelledby="detailRentalModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-success text-white">

                <h5 class="modal-title" id="detailRentalModalLabel">
                    <i class="bi bi-car-front me-2"></i>
                    Detail Rental
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Tutup"></button>

            </div>

            <div class="modal-body p-4">

                {{-- LOADING --}}
                <div id="rentalDetailLoading" class="text-center py-5">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="text-muted mt-3 mb-0">
                        Memuat detail rental...
                    </p>
                </div>

                {{-- ERROR --}}
                <div id="rentalDetailError" class="alert alert-danger d-none" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span id="rentalDetailErrorMessage">
                        Gagal memuat detail rental.
                    </span>
                </div>

                {{-- KONTEN --}}
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
                                <h6 class="fw-bold mb-1" id="rd-mobil">-</h6>
                                <small class="text-muted" id="rd-plat">-</small>
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
        const text = status === 'Disetujui' ? 'Setujui pengajuan rental ini?' :
            (status === 'Ditolak' ? 'Tolak pengajuan rental ini?' : 'Selesaikan rental ini?');

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
                    infoPostFix: '',
                    loadingRecords: 'Memuat...',
                    zeroRecords: 'Tidak ditemukan data yang cocok',
                    emptyTable: 'Belum ada rental',
                    aria: {
                        sortAscending: ': aktifkan untuk urut naik',
                        sortDescending: ': aktifkan untuk urut turun',
                    },
                },
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