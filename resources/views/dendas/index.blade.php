<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Denda - RentalKu</title>

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

        #dendas-table thead .dt-column-order {
            display: none !important;
        }

        .badge-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .jenis-badge {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .jenis-keterlambatan { background: #fff3cd; color: #997404; }
        .jenis-kerusakan { background: #f8d7da; color: #b02a37; }
        .jenis-kehilangan { background: #e7f1ff; color: #0d6efd; }

        .status-belum-bayar { background: #fff3cd; color: #997404; }
        .status-menunggu { background: #e7f1ff; color: #0d6efd; }
        .status-lunas { background: #d1e7dd; color: #0f5132; }

        .foto-thumb {
            width: 64px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
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

        /* Sidebar layout base styles are in admin-sidebar.blade.php */

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

    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center mb-1">
            <h2 class="fw-bold mb-0">
                Management Denda
            </h2>

            <div class="d-flex gap-2">
                <button
                    type="button"
                    class="btn btn-green"
                    data-bs-toggle="modal"
                    data-bs-target="#tambahDendaModal">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Denda
                </button>
            </div>
        </div>

        <p class="text-muted mb-0">
            Kelola denda keterlambatan, kerusakan, dan kehilangan kendaraan.
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

            <table class="table align-middle mb-0" id="dendas-table">

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
                            Jenis
                        </th>

                        <th>
                            Nominal
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Foto
                        </th>

                        <th class="text-end pe-4">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>
                </tbody>

            </table>

            <div class="p-3">
                <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="text-secondary" id="denda-pager-info">
                        Menampilkan 0–0 dari 0 data
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <select id="denda-pager-len" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                            <option value="10">10 / halaman</option>
                            <option value="20">20 / halaman</option>
                            <option value="50">50 / halaman</option>
                            <option value="100">100 / halaman</option>
                            <option value="custom">Custom</option>
                        </select>
                        <input type="number" id="pager-custom-denda" class="form-control form-control-sm pager-jump" min="1" max="500" value="10" aria-label="Jumlah custom per halaman">
                        <span class="text-secondary" id="denda-pager-pages">
                            Halaman 1 / 1
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm pager-btn" id="denda-pager-first">First</button>
                        <button type="button" class="btn btn-sm pager-btn" id="denda-pager-prev" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                        <button type="button" class="btn btn-sm pager-btn pager-next" id="denda-pager-next" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                        <button type="button" class="btn btn-sm pager-btn" id="denda-pager-last">Last</button>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="tambahDendaModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            @include('layouts.partials.modal-head', ['title' => 'Tambah Denda', 'icon' => 'bi-plus-circle'])

            <form
                action="{{ route('dendas.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="formTambahDenda">

                @csrf

                <div class="modal-body">

                    <label class="form-label fw-semibold">
                        Rental
                    </label>

                    <select name="rental_id" class="form-select" required>
                        <option value="">-- Pilih Rental (Status Selesai) --</option>
                        @foreach($rentals as $rental)
                            <option value="{{ $rental->id }}">
                                {{ $rental->user->name ?? '-' }} — {{ $rental->mobil->name ?? '-' }} ({{ $rental->mobil->plate_number ?? '-' }})
                            </option>
                        @endforeach
                    </select>

                    <label class="form-label fw-semibold mt-3">
                        Jenis Denda
                    </label>

                    <select name="jenis" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="keterlambatan">Keterlambatan</option>
                        <option value="kerusakan">Kerusakan</option>
                        <option value="kehilangan">Kehilangan</option>
                    </select>

                    <label class="form-label fw-semibold mt-3">
                        Nominal Denda
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input
                            type="text"
                            name="nominal_display"
                            id="nominalDisplay"
                            class="form-control rupiah-input"
                            placeholder="50.000"
                            inputmode="numeric"
                            autocomplete="off"
                            data-target="nominal"
                            required>
                        <input
                            type="hidden"
                            name="nominal"
                            id="nominal">
                    </div>

                    <label class="form-label fw-semibold mt-3">
                        Foto Bukti
                    </label>

                    <input
                        type="file"
                        name="foto_bukti"
                        class="form-control"
                        accept=".jpg,.jpeg,.png">

                    <small class="text-muted">JPG, PNG, JPEG, Maksimal 2MB</small>

                    <label class="form-label fw-semibold mt-3">
                        Syarat & Ketentuan
                    </label>

                    <textarea
                        name="syarat_dan_ketentuan"
                        class="form-control"
                        rows="3"
                        placeholder="Syarat dan ketentuan denda..."></textarea>

                    <label class="form-label fw-semibold mt-3">
                        Status
                    </label>

                    <select name="status" class="form-select" required>
                        <option value="belum bayar">Belum Bayar</option>
                    </select>

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
                        Simpan Denda

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<div
    class="modal fade"
    id="editDendaModal"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            @include('layouts.partials.modal-head', ['title' => 'Edit Denda', 'icon' => 'bi-pencil-square'])

            <form
                action=""
                method="POST"
                enctype="multipart/form-data"
                id="formEditDenda">

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <label class="form-label fw-semibold">
                        Rental
                    </label>

                    <select name="rental_id" id="editRentalIdDenda" class="form-select" required>
                        <option value="">-- Pilih Rental (Status Selesai) --</option>
                        @foreach($rentals as $rental)
                            <option value="{{ $rental->id }}">
                                {{ $rental->user->name ?? '-' }} — {{ $rental->mobil->name ?? '-' }} ({{ $rental->mobil->plate_number ?? '-' }})
                            </option>
                        @endforeach
                    </select>

                    <label class="form-label fw-semibold mt-3">
                        Jenis Denda
                    </label>

                    <select name="jenis" id="editJenisDenda" class="form-select" required>
                        <option value="keterlambatan">Keterlambatan</option>
                        <option value="kerusakan">Kerusakan</option>
                        <option value="kehilangan">Kehilangan</option>
                    </select>

                    <label class="form-label fw-semibold mt-3">
                        Nominal Denda
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input
                            type="text"
                            name="nominal_display"
                            id="editNominalDendaDisplay"
                            class="form-control rupiah-input"
                            placeholder="50.000"
                            inputmode="numeric"
                            autocomplete="off"
                            data-target="editNominalDenda"
                            required>
                        <input
                            type="hidden"
                            name="nominal"
                            id="editNominalDenda">
                    </div>

                    <label class="form-label fw-semibold mt-3">
                        Foto Bukti
                    </label>

                    <img
                        id="editFotoBuktiPreview"
                        src=""
                        class="mb-2"
                        style="max-width: 200px; display:none; border-radius: 8px;"
                        alt="Preview foto bukti">

                    <input
                        type="file"
                        name="foto_bukti"
                        id="editFotoBuktiDenda"
                        class="form-control"
                        accept=".jpg,.jpeg,.png">

                    <small class="text-muted">JPG, PNG, JPEG, Maksimal 2MB, Kosongkan jika foto tidak diganti</small>

                    <label class="form-label fw-semibold mt-3">
                        Syarat & Ketentuan
                    </label>

                    <textarea
                        name="syarat_dan_ketentuan"
                        id="editSyaratDenda"
                        class="form-control"
                        rows="3"
                        placeholder="Syarat dan ketentuan denda..."></textarea>

                    <label class="form-label fw-semibold mt-3">
                        Status
                    </label>

                    <select name="status" id="editStatusDenda" class="form-select" required>
                        <option value="belum bayar">Belum Bayar</option>
                        <option value="menunggu verifikasi">Menunggu Verifikasi</option>
                        <option value="lunas">Lunas</option>
                    </select>

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

<div class="modal fade" id="fotoDendaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Bukti Foto Denda'])
            <div class="modal-body p-3 text-center">
                <img id="fotoDendaPreview" src="" class="img-fluid rounded" alt="Bukti denda">
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
    const CSRF_TOKEN = '{{ csrf_token() }}';

    function formatRupiahInput(value) {
        let angka = String(value || '').replace(/\D/g, '');
        if (!angka) return '';
        return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function formatRupiah(value) {
        return 'Rp ' + Number(value).toLocaleString('id-ID');
    }

    function getRawRupiah(value) {
        return String(value || '').replace(/\D/g, '');
    }

    $(document).on('input', '.rupiah-input', function() {
        const input = this;
        const rawValue = getRawRupiah(input.value);
        input.value = formatRupiahInput(rawValue);
        $('#' + $(input).data('target')).val(rawValue);
    });

    function openFotoDenda(url) {
        $('#fotoDendaPreview').attr('src', url);
        bootstrap.Modal.getOrCreateInstance($('#fotoDendaModal')[0]).show();
    }

    function statusBadge(status) {
        const map = {
            'belum bayar': 'status-belum-bayar',
            'menunggu verifikasi': 'status-menunggu',
            'lunas': 'status-lunas',
        };

        const cls = map[status] || 'status-belum-bayar';

        return '<span class="badge-status ' + cls + '">' + status + '</span>';
    }

    function jenisBadge(jenis) {
        const map = {
            'keterlambatan': 'jenis-keterlambatan',
            'kerusakan': 'jenis-kerusakan',
            'kehilangan': 'jenis-kehilangan',
        };

        const text = {
            'keterlambatan': 'Keterlambatan',
            'kerusakan': 'Kerusakan',
            'kehilangan': 'Kehilangan',
        };

        const cls = map[jenis] || 'jenis-keterlambatan';

        return '<span class="jenis-badge ' + cls + '">' + (text[jenis] || jenis) + '</span>';
    }

                    $(document).ready(function() {

                        var dendaTable = $('#dendas-table').DataTable({
                            processing: true,
                            serverSide: true,
                            paging: false,
                            info: false,
                            dom: 'frt',
                            ajax: {
                                url: '{{ route('dendas.data') }}',
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
                                    orderable: false,
                                    searchable: true,
                                    render: function(data) {
                                        return '<strong>' + data.pelanggan + '</strong>';
                                    },
                                },
                                {
                                    data: null,
                                    orderable: false,
                                    searchable: true,
                                    render: function(data) {
                                        return '<div class="fw-bold">' + data.mobil_name + '</div>' +
                                            '<small class="text-muted">' + data.mobil_plate + '</small>';
                                    },
                                },
                                {
                                    data: 'jenis',
                                    orderable: true,
                                    searchable: true,
                                    render: function(data) {
                                        return jenisBadge(data);
                                    },
                                },
                                {
                                    data: 'nominal',
                                    orderable: true,
                                    searchable: false,
                                    render: function(data) {
                                        return '<strong>' + formatRupiah(data) + '</strong>';
                                    },
                                },
                                {
                                    data: 'status',
                                    orderable: true,
                                    searchable: true,
                                    render: function(data) {
                                        return statusBadge(data);
                                    },
                                },
                                {
                                    data: 'created_at',
                                    orderable: true,
                                    searchable: false,
                                },
                                {
                                    data: 'foto_bukti',
                                    orderable: false,
                                    searchable: false,
                                    render: function(data) {
                                        if (!data) {
                                            return '<span class="text-muted">-</span>';
                                        }

                                        const url = "{{ asset('__FOTO__') }}".replace('__FOTO__', data);

                                        return '<a href="#" onclick="openFotoDenda(\'' + url + '\');return false;">' +
                                            '<img src="' + url + '" class="foto-thumb" alt="Bukti denda"></a>';
                                    },
                                },
                                {
                                    data: 'id',
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-center',
                                    width: '140px',
                                    render: function(data, type, row) {
                                        let html = '<div class="d-flex justify-content-center gap-2">';

                                        if (row.status === 'menunggu verifikasi') {
                                            if (row.bukti_bayar_url) {
                                                html += '<button type="button" class="btn p-1 text-info" style="border:none;background:none;" ' +
                                                    'title="Lihat Bukti" onclick="openFotoDenda(\'' + row.bukti_bayar_url + '\')">' +
                                                    '<i class="bi bi-eye"></i></button>';
                                            }

                                            html += '<button type="button" class="btn p-1 text-success" style="border:none;background:none;" ' +
                                                'title="Verifikasi Lunas" onclick="verifikasiDenda(' + data + ', \'lunas\')">' +
                                                '<i class="bi bi-check-circle"></i></button>';

                                            html += '<button type="button" class="btn p-1 text-warning" style="border:none;background:none;" ' +
                                                'title="Tolak Bukti" onclick="verifikasiDenda(' + data + ', \'belum bayar\')">' +
                                                '<i class="bi bi-x-circle"></i></button>';
                                        }

                                        html += '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" ' +
                                            'title="Edit" onclick="editDenda(' + data + ')">' +
                                            '<i class="bi bi-pencil-square"></i></button>' +
                                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                                            'title="Hapus" onclick="deleteDenda(' + data +
                                            ', \'' + row.pelanggan.replace(/'/g, "\\'") + '\')">' +
                                            '<i class="bi bi-trash"></i></button>';

                                        return html + '</div>';
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
                                emptyTable: 'Belum ada denda',
                                aria: {
                                    sortAscending: ': aktifkan untuk urut naik',
                                    sortDescending: ': aktifkan untuk urut turun',
                                },
                            },
                        });

                        function renderDendaPager() {
                            var info = dendaTable.page.info();
                            var total = info.recordsDisplay;
                            var start = total ? info.start + 1 : 0;
                            $('#denda-pager-info').text('Menampilkan '+start+'–'+info.end + ' dari ' + total + ' data');
                            var pages = Math.max(info.pages, 1);
                            var page = info.page + 1;
                            $('#denda-pager-pages').text('Halaman ' + (pages ? info.page + 1 : 0) + ' / ' + pages);
                            $('#denda-pager-first, #denda-pager-prev').toggleClass('disabled', page <= 1);
                            $('#denda-pager-next, #denda-pager-last').toggleClass('disabled', page >= pages);
                        }

                        dendaTable.on('draw.dt', renderDendaPager);
                        renderDendaPager();

                        $('#denda-pager-first').on('click', function() {
                            dendaTable.page('first').draw('page');
                        });
                        $('#denda-pager-prev').on('click', function() {
                            dendaTable.page('previous').draw('page');
                        });
                        $('#denda-pager-next').on('click', function() {
                            dendaTable.page('next').draw('page');
                        });
                        $('#denda-pager-last').on('click', function() {
                            dendaTable.page('last').draw('page');
                        });
                        $('#denda-pager-len').on('change', function() {
                            var v = $(this).val();
                            if (v === 'custom') { $('#pager-custom-denda').focus(); return; }
                            var n = Number(v);
                            $('#pager-custom-denda').val(n);
                            dendaTable.page.len(n).draw();
                        });
                        $('#pager-custom-denda').on('change', function() {
                            var n = parseInt($(this).val(), 10) || 1;
                            n = Math.min(Math.max(n, 1), 500);
                            $(this).val(n);
                            var $len = $('#denda-pager-len');
                            if ($len.find('option[value="' + n + '"]').length) { $len.val(String(n)); }
                            else { $len.val('custom'); }
                            dendaTable.page.len(n).draw();
                        });

                    });

                    function deleteDenda(id, pelanggan) {
                        Swal.fire({
                            title: 'Konfirmasi',
                            text: 'Apakah Anda yakin ingin menghapus denda untuk pelanggan "' + pelanggan + '"?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, hapus',
                            cancelButtonText: 'Batal',
                        }).then(function(result) {
                            if (!result.isConfirmed) return;

                            $.ajax({
                                url: "{{ route('dendas.destroy', '__ID__') }}".replace('__ID__', id),
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': CSRF_TOKEN,
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                success: function(result) {
                                    $('#dendas-table').DataTable().ajax.reload();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: (result && result.message) ? result.message : 'Denda berhasil dihapus.',
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
                                            'Terjadi kesalahan saat menghapus denda.',
                                    });
                                }
                            });
                        });
                    }

                    function verifikasiDenda(id, status) {
                        const data = $('#dendas-table').DataTable().rows().data().toArray()
                            .find(r => r.id == id);

                        const isLunas = status === 'lunas';

                        Swal.fire({
                            title: isLunas ? 'Verifikasi Lunas?' : 'Tolak Bukti Bayar?',
                            text: isLunas
                                ? 'Bukti pembayaran customer akan disetujui dan denda menjadi lunas.'
                                : 'Denda dikembalikan menjadi belum bayar agar customer upload ulang.',
                            imageUrl: (data && data.bukti_bayar_url) ? data.bukti_bayar_url : undefined,
                            imageWidth: 320,
                            icon: isLunas ? 'question' : 'warning',
                            showCancelButton: true,
                            confirmButtonText: isLunas ? 'Ya, Lunaskan' : 'Ya, Tolak',
                            cancelButtonText: 'Batal',
                        }).then(function(result) {
                            if (!result.isConfirmed) return;

                            $.ajax({
                                url: "{{ route('dendas.updateStatus', '__ID__') }}".replace('__ID__', id),
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': CSRF_TOKEN,
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                data: {
                                    status: status
                                },
                                success: function(result) {
                                    $('#dendas-table').DataTable().ajax.reload();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: (result && result.message) ? result.message : 'Status denda berhasil diperbarui.',
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
                                            'Terjadi kesalahan saat memverifikasi denda.',
                                    });
                                }
                            });
                        });
                    }

                    function editDenda(id) {
                        const data = $('#dendas-table').DataTable().rows().data().toArray()
                            .find(r => r.id == id);

                        if (!data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Data denda tidak ditemukan.',
                            });
                            return;
                        }

                        $('#editRentalIdDenda').val(data.rental_id);
                        $('#editJenisDenda').val(data.jenis);
                        $('#editNominalDendaDisplay').val(formatRupiah(data.nominal));
                        $('#editNominalDenda').val(data.nominal);
                        $('#editStatusDenda').val(data.status);
                        $('#editSyaratDenda').val(data.syarat_dan_ketentuan);

                        if (data.foto_bukti) {
                            $('#editFotoBuktiPreview').attr('src', '{{ asset('__PHOTO__') }}'.replace('__PHOTO__', data.foto_bukti)).show();
                        } else {
                            $('#editFotoBuktiPreview').hide();
                        }

                        $('#formEditDenda').attr('action',
                            "{{ route('dendas.update', '__ID__') }}".replace('__ID__', id));

                        bootstrap.Modal.getOrCreateInstance($('#editDendaModal')[0]).show();
                    }

                    $(document).on('submit', '#formTambahDenda', function(e) {
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
                                bootstrap.Modal.getInstance($('#tambahDendaModal')[0]).hide();
                                $('#formTambahDenda')[0].reset();
                                $('#dendas-table').DataTable().ajax.reload();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: result.message || 'Denda berhasil ditambahkan.',
                                    timer: 1500,
                                    showConfirmButton: false,
                                });
                            },
                            error: function(xhr) {
                                const r = xhr.responseJSON || {};
                                const msg = r.errors ? Object.values(r.errors)[0][0] :
                                    (r.message || 'Terjadi kesalahan saat menambahkan denda.');

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: msg,
                                });
                            }
                        });
                    });

                    $(document).on('submit', '#formEditDenda', function(e) {
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
                                bootstrap.Modal.getInstance($('#editDendaModal')[0]).hide();
                                $('#dendas-table').DataTable().ajax.reload();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: result.message || 'Denda berhasil diperbarui.',
                                    timer: 1500,
                                    showConfirmButton: false,
                                });
                            },
                            error: function(xhr) {
                                const r = xhr.responseJSON || {};
                                const msg = r.errors ? Object.values(r.errors)[0][0] :
                                    (r.message || 'Terjadi kesalahan saat memperbarui denda.');

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
