<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Promo - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @include('layouts.partials.modal-head-style')

    <style>
        body {
            background: #f5f7f6;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }

        .page-content {
            padding: 24px;
        }

        .page-card {
            background: #fff;
            border: 1px solid #edf0ee;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .04);
        }

        .btn-green {
            background: #198754;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 600;
        }

        .btn-green:hover {
            background: #146c43;
            color: #fff;
        }

        .modal-footer .btn {
            padding: 7px 14px;
            min-width: 100px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .12);
        }

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 12px 16px;
        }

        .table tbody td {
            vertical-align: middle;
        }

        #kupons-table thead .dt-column-order {
            display: none !important;
        }

        .code {
            display: inline-block;
            background: #e9f7ef;
            color: #198754;
            padding: 7px 10px;
            border-radius: 8px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-active {
            background: #dff7e8;
            color: #198754;
        }

        .status-expired {
            background: #f8d7da;
            color: #b02a37;
        }

        .status-waiting {
            background: #fff3cd;
            color: #997404;
        }

        .rupiah-input {
            font-weight: 600;
        }

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .action-btn {
            border: none;
            background: transparent;
            padding: 5px 7px;
            font-size: 17px;
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

        @media (max-width: 576px) {
            .page-content {
                padding: 12px;
            }

            .page-heading {
                align-items: flex-start !important;
                gap: 12px;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

@include('layouts.partials.sidebar')

<script>
    document.addEventListener('DOMContentLoaded', function () {
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

        <div class="page-heading d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Management Promo</h2>
                <p class="text-muted mb-0">
                    Kelola kode promo dan kupon RentalKu.
                </p>
            </div>

            <button
                type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#tambahModal">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Promo
            </button>
        </div>

        @if(session('success'))
            <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="page-card">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="kupons-table">
                    <thead>
                        <tr>
                            <th class="px-3 py-3">No</th>
                            <th>Kode</th>
                            <th>Jenis</th>
                            <th>Nilai</th>
                            <th>Kuota</th>
                            <th>Terpakai</th>
                            <th>Min. Pembelian</th>
                            <th>Aktif</th>
                            <th>Berakhir</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="text-secondary small" id="kupons-info">Menampilkan 0–0 dari 0 data</div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <select id="kupons-perPage" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                            <option value="10">10 / halaman</option>
                            <option value="20">20 / halaman</option>
                            <option value="50">50 / halaman</option>
                        </select>
                        <input type="number" id="kupons-jump" class="form-control form-control-sm pager-jump" min="1" max="1" value="1" aria-label="Lompat ke halaman">
                        <span class="text-secondary" id="kupons-pageLabel">Halaman 1 / 1</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm pager-btn" id="kupons-first">First Page</button>
                        <button type="button" class="btn btn-sm pager-btn" id="kupons-prev" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                        <button type="button" class="btn btn-sm pager-btn pager-next" id="kupons-next" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                        <button type="button" class="btn btn-sm pager-btn" id="kupons-last">Last Page</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- =========================================================
     MODAL TAMBAH PROMO
========================================================= --}}
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            @include('layouts.partials.modal-head', [
                'title' => 'Tambah Promo',
                'icon' => 'bi-ticket-perforated'
            ])

            <form action="{{ route('kupons.store') }}" method="POST" id="formTambahKupon">
                @csrf

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kode Promo</label>
                            <input
                                type="text"
                                name="code"
                                id="tambahCode"
                                class="form-control text-uppercase"
                                placeholder="Contoh: HEMAT20"
                                maxlength="50"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jenis Promo</label>
                            <select name="jenis" id="tambahJenis" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="persen">Persentase (%)</option>
                                <option value="nominal">Nominal (Rp)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nilai Promo</label>
                            <input
                                type="number"
                                name="value"
                                class="form-control"
                                placeholder="Contoh: 20"
                                min="1"
                                required>
                            <small class="text-muted">
                                Isi persentase untuk jenis persen atau nominal rupiah untuk jenis nominal.
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kuota</label>
                            <input
                                type="number"
                                name="kuota"
                                class="form-control"
                                placeholder="Contoh: 100"
                                min="1"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Minimal Pembelian</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input
                                    type="text"
                                    id="minimalPembelianDisplay"
                                    class="form-control rupiah-input"
                                    placeholder="100.000"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    required>
                                <input
                                    type="hidden"
                                    name="minimal_pembelian"
                                    id="minimalPembelian">
                            </div>
                            <small class="text-muted">Contoh: Rp 100.000</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Mulai Aktif</label>
                            <input
                                type="datetime-local"
                                name="active_at"
                                class="form-control"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Berakhir</label>
                            <input
                                type="datetime-local"
                                name="expired_at"
                                class="form-control"
                                required>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-green">
                        <i class="bi bi-save me-1"></i>Simpan Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- =========================================================
     MODAL EDIT PROMO
========================================================= --}}
<div class="modal fade" id="editKuponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            @include('layouts.partials.modal-head', [
                'title' => 'Edit Promo',
                'icon' => 'bi-pencil-square'
            ])

            <form action="" method="POST" id="formEditKupon">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kode Promo</label>
                            <input
                                type="text"
                                name="code"
                                id="editCode"
                                class="form-control text-uppercase"
                                maxlength="50"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jenis Promo</label>
                            <select name="jenis" id="editJenis" class="form-select" required>
                                <option value="persen">Persentase (%)</option>
                                <option value="nominal">Nominal (Rp)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nilai Promo</label>
                            <input
                                type="number"
                                name="value"
                                id="editValue"
                                class="form-control"
                                min="1"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kuota</label>
                            <input
                                type="number"
                                name="kuota"
                                id="editKuota"
                                class="form-control"
                                min="1"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Terpakai</label>
                            <input
                                type="number"
                                id="editTerpakai"
                                class="form-control"
                                readonly>
                            <small class="text-muted">
                                Jumlah penggunaan dikelola sistem.
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Minimal Pembelian</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input
                                    type="text"
                                    id="editMinimalPembelianDisplay"
                                    class="form-control rupiah-input"
                                    placeholder="100.000"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    required>
                                <input
                                    type="hidden"
                                    name="minimal_pembelian"
                                    id="editMinimalPembelian">
                            </div>
                            <small class="text-muted">Contoh: Rp 100.000</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Mulai Aktif</label>
                            <input
                                type="datetime-local"
                                name="active_at"
                                id="editActiveAt"
                                class="form-control"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Berakhir</label>
                            <input
                                type="datetime-local"
                                name="expired_at"
                                id="editExpiredAt"
                                class="form-control"
                                required>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-green">
                        <i class="bi bi-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const CSRF_TOKEN = '{{ csrf_token() }}';

    let kuponTable;

    // =========================================================
    // NOTIFIKASI
    // =========================================================
    $(function () {
        const flashSuccess = $('#flashSuccess');

        if (flashSuccess.length) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: flashSuccess.text(),
                timer: 1800,
                showConfirmButton: false
            });
        }

        // =====================================================
        // DATATABLES
        // =====================================================
        kuponTable = $('#kupons-table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            info: false,
            dom: 'frt',
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],

            ajax: {
                url: '{{ route('kupons.data') }}',
                type: 'GET'
            },

            // Urutan awal diatur oleh controller: promo terbaru di atas.
            order: [],

            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'px-3',
                    width: '60px',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'code',
                    orderable: true,
                    searchable: true,
                    render: function (data, type) {
                        if (type !== 'display') return data || '';

                        return '<span class="code">' +
                            escapeHtml(data) +
                            '</span>';
                    }
                },
                {
                    data: 'jenis',
                    orderable: true,
                    searchable: true,
                    render: function (data, type) {
                        if (type !== 'display') return data || '';

                        if (data === 'persen') {
                            return '<span class="badge bg-primary">Persen</span>';
                        }

                        return '<span class="badge bg-success">Nominal</span>';
                    }
                },
                {
                    data: 'value',
                    orderable: true,
                    searchable: false,
                    render: function (data, type, row) {
                        const formatted = Number(data || 0).toLocaleString('id-ID');

                        if (type !== 'display') return data;

                        return row.jenis === 'persen'
                            ? formatted + '%'
                            : 'Rp ' + formatted;
                    }
                },
                {
                    data: 'kuota',
                    orderable: true,
                    searchable: false,
                    render: function (data, type) {
                        return type === 'display'
                            ? Number(data || 0).toLocaleString('id-ID')
                            : data;
                    }
                },
                {
                    data: 'terpakai',
                    orderable: true,
                    searchable: false,
                    render: function (data, type) {
                        return type === 'display'
                            ? Number(data || 0).toLocaleString('id-ID')
                            : data;
                    }
                },
                {
                    data: 'minimal_pembelian',
                    orderable: true,
                    searchable: false,
                    render: function (data, type) {
                        return type === 'display'
                            ? 'Rp ' + Number(data || 0).toLocaleString('id-ID')
                            : data;
                    }
                },
                {
                    data: 'status',
                    orderable: true,
                    searchable: false,
                    render: function (data, type, row) {
                        if (type !== 'display') return data || '';

                        const map = {
                            active: 'status-active',
                            expired: 'status-expired',
                            waiting: 'status-waiting'
                        };

                        const cls = map[data] || 'status-waiting';

                        return '<span class="status ' + cls + '">' +
                            escapeHtml(row.status_text || '-') +
                            '</span>';
                    }
                },
                {
                    data: 'expired_at',
                    orderable: true,
                    searchable: false,
                    render: function (data, type) {
                        if (!data) return '-';

                        if (type !== 'display') return data;

                        return formatTanggal(data);
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '100px',
                    render: function (data, type, row) {
                        if (type !== 'display') return data;

                        const id = Number(data);

                        return `
                            <div class="d-flex justify-content-center gap-2">
                                <button
                                    type="button"
                                    class="action-btn text-primary"
                                    title="Edit"
                                    onclick="editKupon(${id})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <button
                                    type="button"
                                    class="action-btn text-danger"
                                    title="Hapus"
                                    onclick="deleteKupon(${id}, ${JSON.stringify(String(row.code || ''))})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                }
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
                emptyTable: 'Belum ada promo',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                }
            }
        });

        function renderKuponsPager() {
            var info = kuponTable.page.info();
            var pages = info.pages;
            var total = info.recordsDisplay;
            var start = total ? info.start + 1 : 0;
            $('#kupons-info').text('Menampilkan '+start+'–'+info.end + ' dari ' + total + ' data');
            $('#kupons-jump').attr('max', pages ? pages : 1).val(pages ? info.page + 1 : 0);
            $('#kupons-pageLabel').text('Halaman ' + (pages ? info.page + 1 : 0) + ' / ' + pages);
            $('#kupons-first').toggleClass('disabled', info.page <= 0);
            $('#kupons-prev').toggleClass('disabled', info.page <= 0);
            $('#kupons-next').toggleClass('disabled', info.page >= pages - 1);
            $('#kupons-last').toggleClass('disabled', info.page >= pages - 1);
        }

        $('#kupons-table').on('draw.dt', renderKuponsPager);
        $('#kupons-first').on('click', function() { kuponTable.page('first').draw('page'); });
        $('#kupons-prev').on('click', function() { kuponTable.page('previous').draw('page'); });
        $('#kupons-next').on('click', function() { kuponTable.page('next').draw('page'); });
        $('#kupons-last').on('click', function() { kuponTable.page('last').draw('page'); });
        $('#kupons-perPage').on('change', function() { kuponTable.page.len(Number($(this).val())).draw(); });
        $('#kupons-jump').on('change', function() {
            var info = kuponTable.page.info();
            var pages = info.pages > 0 ? info.pages : 1;
            var n = parseInt($(this).val(), 10) || 1;
            if (n < 1) { n = 1; }
            if (n > pages) { n = pages; }
            kuponTable.page(n - 1).draw('page');
        });
        renderKuponsPager();

        // =====================================================
        // FORMAT RUPIAH TAMBAH PROMO
        // =====================================================
        $('#minimalPembelianDisplay').on('input', function () {
            const angka = this.value.replace(/\D/g, '');

            this.value = formatRupiah(angka);
            $('#minimalPembelian').val(angka);
        });

        // =====================================================
        // FORMAT RUPIAH EDIT PROMO
        // =====================================================
        $('#editMinimalPembelianDisplay').on('input', function () {
            const angka = this.value.replace(/\D/g, '');

            this.value = formatRupiah(angka);
            $('#editMinimalPembelian').val(angka);
        });

        // Otomatis huruf besar untuk kode promo.
        $('#tambahCode, #editCode').on('input', function () {
            this.value = this.value.toUpperCase();
        });

        // Bersihkan form tambah setelah modal ditutup.
        $('#tambahModal').on('hidden.bs.modal', function () {
            $('#formTambahKupon')[0].reset();
            $('#minimalPembelian').val('');
        });
    });

    // =========================================================
    // HELPER
    // =========================================================
    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function formatRupiah(angka) {
        angka = String(angka ?? '').replace(/\D/g, '');

        if (angka === '') return '';

        return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function formatTanggal(value) {
        if (!value) return '-';

        const parts = String(value).split('T');
        const date = parts[0].split('-');
        const time = parts[1] || '00:00';

        if (date.length !== 3) return value;

        return date[2] + '/' + date[1] + '/' + date[0] + ' ' +
            time.substring(0, 5);
    }

    function getFormErrors(xhr) {
        const result = xhr.responseJSON || {};
        const messages = Object.values(result.errors || {}).flat();

        return messages.length
            ? messages.join('\n')
            : (result.message || 'Terjadi kesalahan. Silakan coba kembali.');
    }

    function reloadKuponTable() {
        if (kuponTable) {
            // true mengembalikan tampilan ke halaman pertama,
            // sehingga promo terbaru langsung terlihat.
            kuponTable.ajax.reload(null, true);
        }
    }

    // =========================================================
    // EDIT PROMO
    // =========================================================
    function editKupon(id) {
        const row = kuponTable
            .rows()
            .data()
            .toArray()
            .find(item => Number(item.id) === Number(id));

        if (!row) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data promo tidak ditemukan. Silakan muat ulang halaman.'
            });
            return;
        }

        $('#editCode').val(row.code);
        $('#editJenis').val(row.jenis);
        $('#editValue').val(row.value);
        $('#editKuota').val(row.kuota);
        $('#editTerpakai').val(row.terpakai);

        $('#editMinimalPembelian').val(row.minimal_pembelian);
        $('#editMinimalPembelianDisplay').val(
            formatRupiah(row.minimal_pembelian)
        );

        $('#editActiveAt').val(row.active_at || '');
        $('#editExpiredAt').val(row.expired_at || '');

        const url = @json(route('kupons.update', '__ID__'));
        $('#formEditKupon').attr(
            'action',
            url.replace('__ID__', encodeURIComponent(id))
        );

        bootstrap.Modal
            .getOrCreateInstance(document.getElementById('editKuponModal'))
            .show();
    }

    // =========================================================
    // HAPUS PROMO
    // =========================================================
    function deleteKupon(id, code) {
        Swal.fire({
            title: 'Hapus Promo?',
            text: 'Apakah Anda yakin ingin menghapus promo "' + code + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545',
            reverseButtons: true
        }).then(function (result) {
            if (!result.isConfirmed) return;

            const url = @json(route('kupons.destroy', '__ID__'));

            $.ajax({
                url: url.replace('__ID__', encodeURIComponent(id)),
                method: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    _method: 'DELETE'
                },
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (response) {
                    reloadKuponTable();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message || 'Promo berhasil dihapus.',
                        timer: 1600,
                        showConfirmButton: false
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: getFormErrors(xhr)
                    });
                }
            });
        });
    }

    // =========================================================
    // TAMBAH PROMO
    // =========================================================
    $(document).on('submit', '#formTambahKupon', function (e) {
        e.preventDefault();

        const form = this;
        const button = $('#formTambahKupon button[type="submit"]');

        // Pastikan nilai Rupiah masuk sebagai angka tanpa titik.
        const nominal = $('#minimalPembelianDisplay')
            .val()
            .replace(/\D/g, '');

        $('#minimalPembelian').val(nominal);

        if (nominal === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Periksa Data',
                text: 'Minimal pembelian wajib diisi.'
            });
            return;
        }

        button.prop('disabled', true);

        $.ajax({
            url: form.action,
            method: 'POST',
            data: new FormData(form),
            processData: false,
            contentType: false,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (response) {
                bootstrap.Modal
                    .getOrCreateInstance(document.getElementById('tambahModal'))
                    .hide();

                form.reset();
                $('#minimalPembelian').val('');

                reloadKuponTable();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message || 'Promo berhasil ditambahkan.',
                    timer: 1600,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menambahkan Promo',
                    text: getFormErrors(xhr)
                });
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    });

    // =========================================================
    // SIMPAN PERUBAHAN PROMO
    // =========================================================
    $(document).on('submit', '#formEditKupon', function (e) {
        e.preventDefault();

        const form = this;
        const button = $('#formEditKupon button[type="submit"]');

        const nominal = $('#editMinimalPembelianDisplay')
            .val()
            .replace(/\D/g, '');

        $('#editMinimalPembelian').val(nominal);

        if (nominal === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Periksa Data',
                text: 'Minimal pembelian wajib diisi.'
            });
            return;
        }

        button.prop('disabled', true);

        $.ajax({
            url: form.action,
            method: 'POST',
            data: new FormData(form),
            processData: false,
            contentType: false,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (response) {
                bootstrap.Modal
                    .getOrCreateInstance(document.getElementById('editKuponModal'))
                    .hide();

                reloadKuponTable();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message || 'Promo berhasil diperbarui.',
                    timer: 1600,
                    showConfirmButton: false
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memperbarui Promo',
                    text: getFormErrors(xhr)
                });
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    });
</script>

</body>
</html>
