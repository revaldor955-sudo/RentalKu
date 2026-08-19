<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Rental - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css"
    >

    <style>
        body {
            background: #f6f8f7;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #eee;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            color: #1f2937;
            text-decoration: none;
        }

        .brand span {
            color: #198754;
        }

        .page-title {
            font-weight: 800;
            color: #1f2937;
        }

        .card-custom {
            background: white;
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,.05);
        }

        .table th {
            font-size: 13px;
            color: #6b7280;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            white-space: nowrap;
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

        .btn-action {
            border-radius: 9px;
            font-size: 12px;
            font-weight: 600;
        }

        .empty {
            padding: 50px;
            text-align: center;
            color: #6b7280;
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="container py-3">

        <div class="d-flex align-items-center justify-content-between">

            <a href="{{ route('admin.dashboard') }}" class="brand">
                Rental<span>Ku</span>.
            </a>

            <div class="d-flex align-items-center gap-3">

                <span>
                    <i class="bi bi-person-circle"></i>
                    {{ Auth::user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i>
                        Keluar
                    </button>
                </form>

            </div>

        </div>

    </div>
</nav>


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

        <a href="{{ route('admin.dashboard') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Dashboard

        </a>

    </div>


    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ALERT ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
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

                            <th class="px-4 py-3">
                                #
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
<div
    class="modal fade"
    id="detailRentalModal"
    tabindex="-1"
    aria-labelledby="detailRentalModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-success text-white">

                <h5 class="modal-title" id="detailRentalModalLabel">
                    <i class="bi bi-car-front me-2"></i>
                    Detail Rental
                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Tutup"
                ></button>

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


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
</script>

<script
    src="https://code.jquery.com/jquery-3.7.1.min.js">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js">
</script>

<script
    src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js">
</script>

<script>

    const CSRF_TOKEN = '{{ csrf_token() }}';

    function confirmAction(event, message) {
        event.preventDefault();

        const form = event.target.closest('form');

        Swal.fire({
            title: 'Konfirmasi',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
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
        const baseUrl = '{{ route('rentals.updateStatus', '__ID__') }}'.replace('__ID__', data.id);

        let html = '<div class="d-flex gap-2 justify-content-end">';

        html += '<button type="button" class="btn btn-outline-primary btn-sm btn-action" ' +
            'onclick="openRentalDetail(' + data.id + ')">' +
            '<i class="bi bi-eye me-1"></i>Detail</button>';

        if (data.status === 'Menunggu') {

            html += '<form action="' + baseUrl + '" method="POST">' +
                '<input type="hidden" name="_token" value="' + CSRF_TOKEN + '">' +
                '<input type="hidden" name="_method" value="PUT">' +
                '<input type="hidden" name="status" value="Disetujui">' +
                '<button type="submit" class="btn btn-success btn-sm btn-action" ' +
                'onclick="confirmAction(event, \'Setujui pengajuan rental ini?\')">' +
                '<i class="bi bi-check-lg"></i> Setujui</button></form>';

            html += '<form action="' + baseUrl + '" method="POST">' +
                '<input type="hidden" name="_token" value="' + CSRF_TOKEN + '">' +
                '<input type="hidden" name="_method" value="PUT">' +
                '<input type="hidden" name="status" value="Ditolak">' +
                '<button type="submit" class="btn btn-outline-danger btn-sm btn-action" ' +
                'onclick="confirmAction(event, \'Tolak pengajuan rental ini?\')">' +
                '<i class="bi bi-x-lg"></i> Tolak</button></form>';

        } else if (data.status === 'Disetujui') {

            html += '<form action="' + baseUrl + '" method="POST">' +
                '<input type="hidden" name="_token" value="' + CSRF_TOKEN + '">' +
                '<input type="hidden" name="_method" value="PUT">' +
                '<input type="hidden" name="status" value="Selesai">' +
                '<button type="submit" class="btn btn-primary btn-sm btn-action" ' +
                'onclick="confirmAction(event, \'Selesaikan rental ini?\')">' +
                '<i class="bi bi-check2-circle"></i> Selesaikan</button></form>';

        }

        html += '</div>';

        return html;
    }

    $(document).ready(function () {

        $('#rentals-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('rentals.data') }}',
                type: 'GET',
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'px-4',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: null,
                    orderable: true,
                    searchable: false,
                    render: function (data) {
                        return '<div class="fw-bold">' + data.user_name + '</div>' +
                            '<small class="text-muted">' + data.user_email + '</small>';
                    },
                },
                {
                    data: null,
                    orderable: true,
                    searchable: false,
                    render: function (data) {
                        return '<div class="fw-bold">' + data.mobil_name + '</div>' +
                            '<small class="text-muted">' + data.mobil_plate + '</small>';
                    },
                },
                {
                    data: null,
                    orderable: true,
                    searchable: false,
                    render: function (data) {
                        return data.tanggal_mulai + '<br>' +
                            '<small class="text-muted">s/d ' + data.tanggal_selesai + '</small>';
                    },
                },
                {
                    data: 'jumlah_hari',
                    orderable: true,
                    searchable: false,
                    render: function (data) {
                        return data + ' hari';
                    },
                },
                {
                    data: 'total_harga',
                    orderable: true,
                    searchable: false,
                    render: function (data) {
                        return '<strong>' + formatRupiah(data) + '</strong>';
                    },
                },
                {
                    data: 'status',
                    orderable: true,
                    searchable: false,
                    render: function (data) {
                        return statusBadge(data);
                    },
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-end pe-4',
                    render: function (data) {
                        return rentalActions(data);
                    },
                },
            ],
            order: [[3, 'desc']],
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
                paginate: {
                    first: 'Pertama',
                    previous: 'Sebelumnya',
                    next: 'Berikutnya',
                    last: 'Terakhir',
                },
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

    });

    function openRentalDetail(id) {

        const modalEl = document.getElementById('detailRentalModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

        const loading = document.getElementById('rentalDetailLoading');
        const error = document.getElementById('rentalDetailError');
        const content = document.getElementById('rentalDetailContent');

        loading.classList.remove('d-none');
        error.classList.add('d-none');
        content.classList.add('d-none');

        modal.show();

        fetch('{{ route('rentals.detail', '__ID__') }}'.replace('__ID__', id), {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server mengembalikan status ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('rd-pelanggan').textContent = data.pelanggan;
                document.getElementById('rd-email').textContent = data.email;
                document.getElementById('rd-mobil').textContent = data.mobil;
                document.getElementById('rd-plat').textContent = data.plat;
                document.getElementById('rd-tanggal').textContent =
                    data.tanggal_mulai + ' s/d ' + data.tanggal_selesai;
                document.getElementById('rd-jumlah-hari').textContent =
                    data.jumlah_hari + ' hari';
                document.getElementById('rd-cabang-ambil').textContent = data.cabang_ambil;
                document.getElementById('rd-cabang-kembali').textContent = data.cabang_kembali;
                document.getElementById('rd-harga-perhari').textContent =
                    formatRupiah(data.harga_perhari);
                document.getElementById('rd-subtotal').textContent =
                    formatRupiah(data.subtotal);
                document.getElementById('rd-deposit').textContent =
                    formatRupiah(data.deposit);
                document.getElementById('rd-total').textContent =
                    formatRupiah(data.total_harga);
                document.getElementById('rd-status').innerHTML = statusBadge(data.status);
                document.getElementById('rd-catatan').textContent = data.catatan;

                loading.classList.add('d-none');
                content.classList.remove('d-none');
            })
            .catch(err => {
                loading.classList.add('d-none');
                document.getElementById('rentalDetailErrorMessage').textContent =
                    'Gagal memuat detail rental: ' + err.message;
                error.classList.remove('d-none');
            });

    }

</script>

</body>
</html>
