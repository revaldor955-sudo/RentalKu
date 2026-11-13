<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Klaim Kompensasi Saya - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: #f5f7f6;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            color: #1f2937;
            padding-top: 70px;
            padding-bottom: 30px;
        }

        @media (max-width: 991.98px) {
            body {
                padding-bottom: 70px;
            }
        }

        .navbar {
            background: rgba(255, 255, 255, .95);
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 27px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .user-box.no-caret.dropdown-toggle::after {
            display: none;
        }

        .user-box {
            background: #f5f8f6;
            border-radius: 50px;
            padding: 6px 12px 6px 7px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .user-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #198754;
            color: white;
            font-size: 16px;
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

        #kompensasis-table thead .dt-column-order {
            display: none !important;
        }

        .jenis-badge {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .jenis-pengembalian-dana {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .jenis-diskon {
            background: #d1e7dd;
            color: #0f5132;
        }

        .jenis-gratis-sewa {
            background: #fff3cd;
            color: #997404;
        }

        .status-diajukan {
            background: #fff3cd;
            color: #997404;
        }

        .status-disetujui {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #b02a37;
        }

        .status-selesai {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .modal-footer .btn {
            padding: 6px 14px;
            min-width: 100px;
        }

        .nav-btn-back {
            border: none;
            color: #374151;
            background: transparent;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: color 0.2s ease;
        }

        .nav-btn-back::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 2px;
            border-radius: 1px;
            background-color: #2c666e;
            transition: width 0.2s ease, left 0.2s ease;
        }

        .nav-btn-back:hover,
        .nav-btn-back:focus {
            color: #2c666e;
        }

        .nav-btn-back:hover::after,
        .nav-btn-back:focus::after {
            left: 12px;
            width: calc(100% - 24px);
        }

        @media (prefers-reduced-motion: reduce) {
            .nav-btn-back,
            .nav-btn-back::after {
                transition: none;
            }
        }

        .dropdown-item {
            font-size: 14px;
            padding: 10px 16px;
            color: #1f2937;
            transition: all 0.15s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background: #f5f7f6;
            color: #198754;
        }

        .dropdown-item.text-danger:hover,
        .dropdown-item.text-danger:focus {
            background: #fee;
            color: #dc3545;
        }

        .dropdown-divider {
            margin: 6px 0;
            opacity: 0.5;
        }

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .pager-bar {
            background: #fff;
            border: 1px solid #edf0ee;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            padding: 12px 16px;
            font-size: 14px
        }

        .pager-bar .text-secondary {
            font-size: 14px;
            font-weight: 500
        }

        .pager-select {
            width: auto;
            border-radius: 10px;
            font-size: 13px;
            height: 34px;
            padding: 6px 28px 6px 10px
        }

        .pager-jump {
            width: 72px;
            border-radius: 10px;
            text-align: center;
            font-size: 13px;
            height: 34px;
            padding: 6px 8px
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
            padding: 6px 12px
        }

        .pager-btn:hover {
            border-color: #198754;
            color: #198754;
            background: #f5f7f6
        }

        .pager-btn.disabled {
            opacity: 0.4;
            pointer-events: none
        }

        .pager-next {
            background: #198754;
            border-color: #198754;
            color: #fff
        }

        .pager-next:hover {
            background: #146c43;
            border-color: #146c43;
            color: #fff
        }

        #buktiLightboxImg {
            max-width: 100%;
            max-height: 85vh;
            object-fit: contain;
            user-select: none;
            -webkit-user-drag: none;
            will-change: transform
        }

        #buktiLightbox {
            z-index: 1065;
            background: rgba(31, 41, 55, .55)
        }

        #buktiLightbox .modal-content {
            background: transparent;
            border: none;
            box-shadow: none
        }

        .bukti-zoom-wrap {
            overflow: hidden;
            max-height: 85vh;
            touch-action: none;
            cursor: zoom-in
        }

        @media (max-width: 480px) {
            .bukti-grid {
                grid-template-columns: repeat(2, 1fr)
            }
        }

        .bukti-thumb {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            cursor: zoom-in
        }

        .bukti-count {
            font-size: 12px;
            font-weight: 700;
            color: #198754
        }

        .bukti-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px
        }

        .bukti-grid img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 12px;
            cursor: zoom-in;
            border: 1px solid #e9ecef
        }

        .bukti-link {
            border: none;
            background: none;
            color: #198754;
            font-size: 12px;
            font-weight: 600;
            padding: 0
        }

        .bukti-link:hover {
            color: #146c43;
            text-decoration: underline
        }
    </style>

    @include('layouts.partials.modal-head-style')
</head>

<body>

    @include('layouts.partials.customer-nav')

    <div class="container py-5">

        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">

            <div>
                <h2 class="page-title mb-1">
                    Riwayat Kompensasi
                </h2>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('customer.dashboard') }}" class="nav-btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Dashboard
                </a>

            </div>

        </div>


        <div class="row g-4">

            <div class="col-lg-12">

                <div class="page-card">

                    <div class="p-4 border-bottom">

                        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Daftar Klaim Kompensasi
                                </h5>

                            </div>


                        </div>

                    </div>

                    <div class="table-responsive">

                        <table class="table align-middle mb-0" id="kompensasis-table">

                            <thead>

                                <tr>

                                    <th class="px-3 py-3">
                                        No
                                    </th>

                                    <th>
                                        Tanggal
                                    </th>

                                    <th>
                                        Jenis
                                    </th>

                                    <th>
                                        Mobil
                                    </th>

                                    <th>
                                        Nominal
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Staff
                                    </th>

                                    <th>
                                        Bukti
                                    </th>

                                    <th class="text-center">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                            <tbody>
                            </tbody>

                        </table>

                        <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3"
                            id="kompensasi-pager">
                            <div class="text-secondary small" id="kompensasi-info">
                                Menampilkan 0–0 dari 0 data
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <select id="kompensasi-len" class="form-select form-select-sm pager-select"
                                    aria-label="Jumlah per halaman">
                                    <option value="10">10 / halaman</option>
                                    <option value="20">20 / halaman</option>
                                    <option value="50">50 / halaman</option>
                                    <option value="100">100 / halaman</option>
                                    <option value="custom">Custom</option>
                                </select>
                                <input type="number" id="kompensasi-custom"
                                    class="form-control form-control-sm pager-jump" min="1" max="500"
                                    value="10" aria-label="Jumlah custom per halaman">
                                <span class="text-secondary" id="kompensasi-page">Halaman 1 / 1</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm pager-btn" id="kompensasi-first" aria-label="Halaman pertama">First</button>
                                <button type="button" class="btn btn-sm pager-btn" id="kompensasi-prev"
                                    aria-label="Halaman sebelumnya">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm pager-btn pager-next" id="kompensasi-next"
                                    aria-label="Halaman berikutnya">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                                <button type="button" class="btn btn-sm pager-btn" id="kompensasi-last" aria-label="Halaman terakhir">Last</button>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="modal fade" id="detailKompensasiModal" tabindex="-1">

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content">

                    @include('layouts.partials.modal-head', [
                        'title' => 'Detail Klaim Kompensasi',
                        'icon' => 'bi-eye',
                    ])

                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="detailTanggal">Tanggal</label>
                                <input type="text" id="detailTanggal" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="detailJenis">Jenis</label>
                                <input type="text" id="detailJenis" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="detailMobil">Mobil</label>
                                <input type="text" id="detailMobil" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="detailNominal">Nominal</label>
                                <input type="text" id="detailNominal" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="detailStatus">Status</label>
                                <input type="text" id="detailStatus" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="detailStaff">Staff</label>
                                <input type="text" id="detailStaff" class="form-control" readonly>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold" for="detailAlasan">Alasan</label>
                                <textarea id="detailAlasan" class="form-control" rows="3" readonly></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold" for="detailCatatan">Catatan Staff</label>
                                <textarea id="detailCatatan" class="form-control" rows="3" readonly></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold" for="detailBuktiGrid">Bukti Foto</label>
                                <div id="detailBuktiGrid" class="bukti-grid"></div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            <i class="bi bi-x-circle me-1"></i>
                            Tutup

                        </button>

                    </div>

                </div>

            </div>

        </div>


        <div class="modal fade" id="buktiZoomModal" tabindex="-1" aria-labelledby="buktiZoomTitle"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    @include('layouts.partials.modal-head', [
                        'title' => 'Bukti Foto Klaim',
                        'icon' => 'bi-image',
                        'titleId' => 'buktiZoomTitle',
                    ])

                    <div class="modal-body">

                        <div id="buktiZoomGrid" class="bukti-grid"></div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            <i class="bi bi-x-circle me-1"></i>
                            Tutup

                        </button>

                    </div>

                </div>

            </div>

        </div>

        <div class="modal fade" id="buktiLightbox" tabindex="-1" aria-label="Bukti foto"
            aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-body text-center p-2">

                        <div class="bukti-zoom-wrap rounded" id="buktiZoomWrap">
                            <img id="buktiLightboxImg" src="" alt="Bukti foto" class="img-fluid rounded"
                                draggable="false">
                        </div>
                        <small class="text-muted d-block mt-2">Scroll untuk zoom, geser untuk pan, klik backdrop untuk
                            tutup</small>

                    </div>

                </div>

            </div>

        </div>
        



    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @include('layouts.partials.profile-modal')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var CSRF_TOKEN = '{{ csrf_token() }}';

        function jenisBadge(jenis) {
            const map = {
                'pengembalian_dana': 'jenis-pengembalian-dana',
                'diskon': 'jenis-diskon',
                'gratis_sewa': 'jenis-gratis-sewa',
            };

            const cls = map[jenis] || 'bg-secondary text-white';
            const labels = {
                'pengembalian_dana': 'Pengembalian Dana',
                'diskon': 'Diskon',
                'gratis_sewa': 'Gratis Sewa',
            };

            return '<span class="jenis-badge ' + cls + '">' + klaimEsc(labels[jenis] || '-') + '</span>';
        }

        function statusBadge(status) {
            if (status === null || status === undefined || status === '') {
                return '<span class="text-muted">-</span>';
            }
            const map = {
                'diajukan': 'status-diajukan',
                'disetujui': 'status-disetujui',
                'ditolak': 'status-ditolak',
                'selesai': 'status-selesai',
            };

            const cls = map[status] || 'bg-secondary text-white';
            const labels = {
                'diajukan': 'Diajukan',
                'disetujui': 'Disetujui',
                'ditolak': 'Ditolak',
                'selesai': 'Selesai',
            };

            return '<span class="jenis-badge ' + cls + '">' + klaimEsc(labels[status] || '-') + '</span>';
        }

        function formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }


        function buktiSrc(path) {
            if (!path) return '';
            if (/^https?:\/\//.test(path) || path.charAt(0) === '/') return path;
            return '/storage/' + String(path).replace(/^storage\//, '');
        }

        function buktiList(row) {
            const raw = row ? (row.bukti_urls ?? row.bukti) : null;
            if (Array.isArray(raw)) return raw.map(function(b) {
                return buktiSrc(b.path || b.url || b);
            }).filter(Boolean);
            if (typeof raw === 'string' && raw.trim() !== '') return [buktiSrc(raw)];
            return [];
        }

        function buktiCell(row) {
            const urls = buktiList(row);
            if (!urls.length) return '<span class="text-muted">-</span>';
            let html = '<div class="d-flex align-items-center gap-1">';
            urls.slice(0, 2).forEach(function(src) {
                html += '<img src="' + klaimEsc(src) + '" alt="Bukti klaim" class="bukti-thumb" onclick="openBuktiGaleri(\'' +
                    row.id + '\')">';
            });
            html += '</div><div class="mt-1"><span class="bukti-count">' + urls.length + ' foto</span> ';
            html += '<button type="button" class="bukti-link" onclick="openBuktiGaleri(\'' + row.id +
                '\')">Lihat semua</button></div>';
            return html;
        }

        function openBuktiLightbox(src) {
            if (!src) return;
            buktiZoomReset();
            $('#buktiLightboxImg').attr('src', src);
            bootstrap.Modal.getOrCreateInstance($('#buktiLightbox')[0]).show();
        }
        var buktiZoom = {
            z: 1,
            x: 0,
            y: 0
        };

        function buktiZoomApply() {
            $('#buktiLightboxImg').css('transform', 'translate(' + buktiZoom.x + 'px,' + buktiZoom.y + 'px) scale(' +
                buktiZoom.z + ')');
        }

        function buktiZoomReset() {
            buktiZoom = {
                z: 1,
                x: 0,
                y: 0
            };
            buktiZoomApply();
        }
        var buktiZoomTick = false;
        $(document).on('wheel', '#buktiZoomWrap', function(e) {
            e.preventDefault();
            if (buktiZoomTick) return;
            buktiZoomTick = true;
            requestAnimationFrame(function() {
                buktiZoom.z = Math.min(4, Math.max(1, +(buktiZoom.z - e.originalEvent.deltaY * 0.0015)
                    .toFixed(2)));
                if (buktiZoom.z === 1) {
                    buktiZoom.x = 0;
                    buktiZoom.y = 0;
                }
                buktiZoomApply();
                buktiZoomTick = false;
            });
        });
        $(document).on('pointerdown', '#buktiZoomWrap', function(e) {
            if (buktiZoom.z <= 1) return;
            const sx = e.clientX - buktiZoom.x,
                sy = e.clientY - buktiZoom.y;
            const move = function(ev) {
                buktiZoom.x = ev.clientX - sx;
                buktiZoom.y = ev.clientY - sy;
                buktiZoomApply();
            };
            const up = function() {
                $(document).off('pointermove', move);
                $(document).off('pointerup', up);
            };
            $(document).on('pointermove', move);
            $(document).on('pointerup', up);
        });
        $(document).on('hidden.bs.modal', '#buktiLightbox', function() {
            buktiZoomReset();
            $('#buktiLightboxImg').attr('src', '');
        });

        function renderBuktiGrid($grid, urls) {
            $grid.empty();
            if (!urls.length) {
                $grid.append('<span class="text-muted small">Belum ada bukti foto.</span>');
                return;
            }
            urls.forEach(function(src) {
                $grid.append($('<img>').attr({
                    src: src,
                    alt: 'Bukti foto klaim'
                }).on('click', function() {
                    openBuktiLightbox(src);
                }));
            });
        }

        function openBuktiGaleri(id) {
            const data = $('#kompensasis-table').DataTable().rows().data().toArray()
                .find(r => r.id == id);
            if (!data) return;
            renderBuktiGrid($('#buktiZoomGrid'), buktiList(data));
            bootstrap.Modal.getOrCreateInstance($('#buktiZoomModal')[0]).show();
        }

        $(document).ready(function() {

            $('#kompensasis-table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                info: false,
                dom: 'frt',
                ajax: {
                    url: '{{ route('customer.kompensasi.data') }}',
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
                        data: 'tanggal',
                        orderable: true,
                        searchable: false,
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
                        data: null,
                        orderable: true,
                        searchable: true,
                        render: function(data) {
                            return '<div class="fw-bold">' + klaimEsc(data.mobil_name ?? '-') + '</div>' +
                                '<small class="text-muted">' + klaimEsc(data.mobil_plate ?? '-') + '</small>';
                        },
                    },
                    {
                        data: 'nominal',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            if (data === null || data === undefined || data === '') return '<span class="text-muted">-</span>';
                            return '<span class="fw-semibold">' + klaimEsc(formatRupiah(data)) + '</span>';
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
                        data: 'staff_name',
                        orderable: false,
                        searchable: true,
                        render: function(data) {
                            return klaimEsc(data ?? '-');
                        },
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return buktiCell(data);
                        },
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '140px',
                       
render: function(data) {
    return '<div class="d-flex justify-content-center gap-2">' +
        '<button type="button" class="btn p-1 text-primary" ' +
        'style="border:none;background:none;" title="Detail" ' +
        'onclick="openDetail(' + data + ')">' +
        '<i class="bi bi-eye"></i></button></div>';
},

                    },
                ],
                order: [
                    [5, 'desc']
                ],
                language: {
                    processing: 'Memproses...',
                    search: 'Cari:',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    loadingRecords: 'Memuat...',
                    zeroRecords: 'Tidak ditemukan data yang cocok',
                    emptyTable: 'Belum ada klaim kompensasi',
                    aria: {
                        sortAscending: ': aktifkan untuk urut naik',
                        sortDescending: ': aktifkan untuk urut turun',
                    },
                },
            });

            var kompensasiTable = $('#kompensasis-table').DataTable();

            function renderKompensasiPager() {
                var info = kompensasiTable.page.info();
                var total = info.recordsDisplay;
                var start = total ? info.start + 1 : 0;
                $('#kompensasi-info').text('Menampilkan ' + start + '–' + info.end + ' dari ' + total + ' data');
                var pages = info.pages || 1;
                var page = info.page + 1;
                $('#kompensasi-page').text('Halaman ' + (pages ? info.page + 1 : 0) + ' / ' + pages);
                $('#kompensasi-first').toggleClass('disabled', page <= 1);
                $('#kompensasi-prev').toggleClass('disabled', page <= 1);
                $('#kompensasi-next').toggleClass('disabled', page >= pages);
                $('#kompensasi-last').toggleClass('disabled', page >= pages);
            }

            kompensasiTable.on('draw.dt', renderKompensasiPager);
            renderKompensasiPager();

            $('#kompensasi-first').on('click', function() {
                kompensasiTable.page('first').draw('page');
            });
            $('#kompensasi-prev').on('click', function() {
                kompensasiTable.page('previous').draw('page');
            });
            $('#kompensasi-next').on('click', function() {
                kompensasiTable.page('next').draw('page');
            });
            $('#kompensasi-last').on('click', function() {
                kompensasiTable.page('last').draw('page');
            });
            $('#kompensasi-len').on('change', function() {
                var v = $(this).val();
                if (v === 'custom') {
                    $('#kompensasi-custom').focus();
                    return;
                }
                var n = parseInt(v, 10) || 10;
                $('#kompensasi-custom').val(n);
                kompensasiTable.page.len(n).draw();
            });
            $('#kompensasi-custom').on('change', function() {
                var n = parseInt($(this).val(), 10) || 1;
                n = Math.min(Math.max(n, 1), 500);
                $(this).val(n);
                if (['10', '20', '50', '100'].indexOf(String(n)) !== -1) {
                    $('#kompensasi-len').val(String(n));
                } else {
                    $('#kompensasi-len').val('custom');
                }
                kompensasiTable.page.len(n).draw();
            });

        });

        function openDetail(id) {
            const data = $('#kompensasis-table').DataTable().rows().data().toArray()
                .find(r => r.id == id);

            if (!data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Data kompensasi tidak ditemukan.',
                });
                return;
            }

            $('#detailTanggal').val(data.tanggal);
            var jenisLabels = {
                pengembalian_dana: 'Pengembalian Dana',
                diskon: 'Diskon',
                gratis_sewa: 'Gratis Sewa'
            };
            var statusLabels = {
                diajukan: 'Diajukan',
                disetujui: 'Disetujui',
                ditolak: 'Ditolak',
                selesai: 'Selesai'
            };
            $('#detailJenis').val(jenisLabels[data.jenis] || data.jenis || '-');
            $('#detailMobil').val((data.mobil_name ?? '-') + ' (' + (data.mobil_plate ?? '-') + ')');
            $('#detailNominal').val(formatRupiah(data.nominal));
            $('#detailStatus').val(statusLabels[data.status] || data.status || '-');
            $('#detailStaff').val(data.staff_name ?? '-');
            $('#detailAlasan').val(data.alasan);
            $('#detailCatatan').val(data.catatan || '-');
            renderBuktiGrid($('#detailBuktiGrid'), buktiList(data));

            bootstrap.Modal.getOrCreateInstance($('#detailKompensasiModal')[0]).show();
        }

        function klaimEsc(s) {
            return String(s ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
                '&quot;');
        }


    </script>
</body>

</html>
