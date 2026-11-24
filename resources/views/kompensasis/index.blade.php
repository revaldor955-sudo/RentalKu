<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Kompensasi - RentalKu</title>

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

        /* Sort DataTables disembunyikan: server-side diurut via kolom Tanggal (order) */
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
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            padding: 12px 16px;
            font-size: 14px;
        }

        .pager-bar .text-secondary {
            font-size: 14px;
            font-weight: 500;
        }

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

        @media (prefers-reduced-motion: reduce) {

            .bukti-thumb,
            .bukti-grid img {
                transition: none
            }
        }

        .rental-search-wrapper {
            position: relative;
        }

        .rental-search-box {
            position: relative;
        }

        .rental-search-box .form-control {
            padding-right: 42px;
        }

        .rental-search-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
            pointer-events: none;
        }

        .rental-search-results {
            position: absolute;
            top: calc(100% + 5px);
            left: 0;
            right: 0;
            z-index: 1060;
            max-height: 260px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .12);
            display: none;
        }

        .rental-search-results.show {
            display: block;
        }

        .rental-search-item {
            padding: 12px 14px;
            cursor: pointer;
            border-bottom: 1px solid #F3F4F6;
            transition: .15s;
        }

        .rental-search-item:last-child {
            border-bottom: none;
        }

        .rental-search-item:hover,
        .rental-search-item.active {
            background: #e9f7ef;
        }

        .rental-item-main {
            font-weight: 700;
            color: #1F2937;
            font-size: 13px;
        }

        .rental-sub {
            font-size: 11px;
            color: #6B7280;
            margin-top: 4px;
        }

        .rental-search-empty {
            padding: 16px;
            text-align: center;
            font-size: 13px;
            color: #6B7280;
        }

        .rental-selected-card {
            display: none;
            margin-top: 10px;
            padding: 12px;
            border: 1px solid #198754;
            background: #e9f7ef;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(25, 135, 84, .12);
        }

        .rental-selected-card.show {
            display: block;
        }

        .selected-main {
            font-size: 13px;
            font-weight: 700;
            color: #1F2937;
        }

        .selected-detail {
            font-size: 11px;
            color: #6B7280;
            margin-top: 4px;
            line-height: 1.6;
        }

        .btn-remove-rental {
            border: 0;
            background: #f8d7da;
            color: #dc3545;
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .btn-remove-rental:hover {
            background: #f5c2c7;
        }

        .rc-head {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .rc-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #198754;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .rc-name {
            font-size: 14px;
            font-weight: 800;
            color: #1F2937;
            line-height: 1.2;
        }

        .rc-id {
            font-size: 11px;
            font-weight: 600;
            color: #6B7280;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .rc-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 700;
            background: #E5E7EB;
            color: #374151;
        }

        .rc-badge.status-selesai {
            background: #d1e7dd;
            color: #0f5132;
        }

        .rc-meta {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px dashed rgba(25, 135, 84, .35);
        }

        .rc-meta-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 500;
            color: #374151;
        }

        .rc-meta-row i {
            color: #198754;
            font-size: 14px;
            width: 16px;
            text-align: center;
        }

        .rc-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 12px;
        }

        .rc-stat {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            padding: 8px 10px;
            min-width: 0;
        }

        .rc-stat-label {
            font-size: 10px;
            font-weight: 600;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .rc-stat-value {
            font-size: 12px;
            font-weight: 800;
            color: #1F2937;
            margin-top: 2px;
            overflow-wrap: anywhere;
        }

        .rc-stat.total .rc-stat-value {
            color: #146c43;
        }

        @media (max-width: 575.98px) {
            .rc-stats {
                grid-template-columns: 1fr;
            }
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
            if (!mainContent) return;
            const pageContent = mainContent.querySelector('.page-content');
            const navbar = document.querySelector('header.topbar');
            if (pageContent && navbar) mainContent.insertBefore(navbar, pageContent);
        });
    </script>

    <div class="page-content">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="page-title mb-1">Management Kompensasi</h2>
                    <p class="text-muted mb-0">Kelola kompensasi pelanggan (pengembalian dana, diskon, gratis sewa).</p>
                </div>
                <button type="button" class="btn btn-green" data-bs-toggle="modal"
                    data-bs-target="#createKompensasiModal">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Kompensasi
                </button>
            </div>

            @if (session('success'))
                <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="page-card">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="kompensasis-table">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-3">No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis</th>
                                        <th>Pelanggan</th>
                                        <th>Mobil</th>
                                        <th>Rental</th>
                                        <th>Nominal</th>
                                        <th>Staff</th>
                                        <th>Bukti</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <div class="p-3">
                                <div
                                    class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                                    <div class="text-secondary" id="komp-pager-info">
                                        Menampilkan 0–0 dari 0 data
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <select id="komp-pager-len" class="form-select form-select-sm pager-select"
                                            aria-label="Jumlah per halaman">
                                            <option value="10">10 / halaman</option>
                                            <option value="20">20 / halaman</option>
                                            <option value="50">50 / halaman</option>
                                            <option value="100">100 / halaman</option>
                                            <option value="custom">Custom</option>
                                        </select>
                                        <input type="number" id="komp-pager-custom"
                                            class="form-control form-control-sm pager-jump" min="1"
                                            max="100" value="10" aria-label="Jumlah custom per halaman">
                                        <span class="text-secondary" id="komp-pager-pages">
                                            Halaman 1 / 1
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-sm pager-btn" id="komp-pager-first"
                                            aria-label="Halaman pertama">First</button>
                                        <button type="button" class="btn btn-sm pager-btn" id="komp-pager-prev"
                                            aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                                        <button type="button" class="btn btn-sm pager-btn pager-next"
                                            id="komp-pager-next" aria-label="Halaman berikutnya"><i
                                                class="bi bi-chevron-right"></i></button>
                                        <button type="button" class="btn btn-sm pager-btn" id="komp-pager-last"
                                            aria-label="Halaman terakhir">Last</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <div class="modal fade" id="detailKompensasiModal" tabindex="-1" aria-labelledby="detailKompensasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                @include('layouts.partials.modal-head', [
                    'title' => 'Detail Kompensasi',
                    'icon' => 'bi-eye',
                    'titleId' => 'detailKompensasiModalLabel',
                ])
                <div class="modal-body">
                    <div class="border rounded-4 p-3 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Informasi Kompensasi</h6>
                            <span class="rc-badge status-selesai">Tercatat</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Tanggal</small>
                                <div class="fw-semibold" id="detailTanggal">-</div>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Jenis Kompensasi</small>
                                <div class="fw-semibold" id="detailJenis">-</div>
                            </div>

                            <div class="col-12">
                                <div class="bg-light rounded-3 p-3">
                                    <small class="text-muted d-block mb-1">Nominal Kompensasi</small>
                                    <h3 class="fw-bold text-success mb-0" id="detailNominal">-</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Informasi Pelanggan</h6>

                        <div class="border rounded-4 p-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rc-avatar"><i class="bi bi-person-fill"></i></div>

                                <div class="overflow-hidden">
                                    <div class="fw-bold text-truncate" id="detailCustomerName">-</div>
                                    <small class="text-muted text-truncate d-block" id="detailCustomerEmail">-</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Informasi Rental</h6>

                        <div class="border rounded-4 p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <small class="text-muted d-block">ID Rental</small>
                                    <span class="fw-bold" id="detailRentalId">-</span>
                                </div>

                                <span class="rc-badge status-selesai">Selesai</span>
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rc-avatar"><i class="bi bi-car-front-fill"></i></div>

                                <div class="overflow-hidden">
                                    <div class="fw-bold" id="detailMobil">-</div>
                                    <small class="text-muted" id="detailPeriodeRental">-</small>
                                </div>
                            </div>

                            <hr class="border-secondary-subtle">

                            <div class="row g-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Petugas</small>
                                    <span class="fw-semibold" id="detailStaff">-</span>
                                </div>

                                <div class="col-6" id="detailDiskonWrap">
                                    <small class="text-muted d-block">Diskon</small>
                                    <span class="fw-semibold" id="detailDiskon">-</span>
                                </div>

                                <div class="col-4">
                                    <small class="text-muted d-block">Harga / Hari</small>
                                    <span class="fw-semibold small" id="detailHargaPerhari">-</span>
                                </div>

                                <div class="col-4">
                                    <small class="text-muted d-block">Total Rental</small>
                                    <span class="fw-semibold small" id="detailTotalHarga">-</span>
                                </div>

                                <div class="col-4">
                                    <small class="text-muted d-block">Deposit</small>
                                    <span class="fw-semibold small" id="detailDeposit">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Keterangan Kompensasi</h6>

                        <div class="border rounded-4 p-3 mb-3">
                            <small class="text-muted d-block mb-2">Alasan</small>
                            <p class="mb-0" id="detailAlasan">-</p>
                        </div>

                        <div class="border rounded-4 p-3">
                            <small class="text-muted d-block mb-2">Catatan Tambahan</small>
                            <p class="mb-0" id="detailCatatan">-</p>
                        </div>
                    </div>

                    <div>
                        <h6 class="fw-bold mb-3">Bukti Dokumentasi</h6>
                        <div id="detailBuktiGrid" class="row g-2"></div>
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

    <div class="modal fade" id="createKompensasiModal" tabindex="-1" aria-labelledby="createKompensasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                @include('layouts.partials.modal-head', [
                    'title' => 'Tambah Kompensasi',
                    'icon' => 'bi-plus-circle',
                    'titleId' => 'createKompensasiModalLabel',
                ])
                <form action="{{ route('kompensasis.store') }}" method="POST" id="formCreateKompensasi"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="createCustomerId">Customer</label>
                                <select name="customer_id" id="createCustomerId" class="form-select" required>
                                    <option value="">Pilih customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}
                                            ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="createRentalSearch">Rental Selesai</label>
                                <div class="rental-search-wrapper">
                                    <div class="rental-search-box">
                                        <input type="text" id="createRentalSearch" class="form-control"
                                            placeholder="Pilih customer terlebih dahulu" autocomplete="off" disabled>
                                        <i class="bi bi-search rental-search-icon"></i>
                                    </div>
                                    <div id="createRentalSearchResults" class="rental-search-results"></div>
                                </div>
                                <div id="createRentalSelectedCard" class="rental-selected-card">
                                    <div class="d-flex align-items-start justify-content-between gap-2">
                                        <div class="flex-grow-1">
                                            <div class="selected-main" id="createRentalSelectedMain"></div>
                                            <div class="selected-detail" id="createRentalSelectedDetail"></div>
                                        </div>
                                        <button type="button" class="btn-remove-rental" id="createRentalRemove"
                                            title="Hapus pilihan rental">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="rental_id" id="createRentalId">
                                <div class="form-text" id="createRentalHelp">Pilih customer terlebih dahulu untuk
                                    mencari rental.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="createJenis">Jenis Kompensasi</label>
                                <select name="jenis" id="createJenis" class="form-select" required>
                                    <option value="">Pilih jenis</option>
                                    <option value="pengembalian_dana">Pengembalian Dana</option>
                                    <option value="diskon">Diskon</option>
                                    <option value="gratis_sewa">Gratis Sewa</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-none" id="createNominalWrap">
                                <label class="form-label fw-semibold" for="createNominalDisplay">Nominal (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="createNominalDisplay" class="form-control rupiah-input"
                                        placeholder="50.000" inputmode="numeric" autocomplete="off"
                                        data-target="createNominal">
                                    <input type="hidden" name="nominal" id="createNominal">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="createAlasan">Alasan</label>
                                <textarea name="alasan" id="createAlasan" class="form-control" rows="3" required
                                    placeholder="Alasan kompensasi..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold" for="createCatatan">Catatan (opsional)</label>
                                <textarea name="catatan" id="createCatatan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="createTanggal">Tanggal Kejadian</label>
                                <input type="date" name="tanggal" id="createTanggal" class="form-control"
                                    value="{{ now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="createBukti">Bukti Foto</label>
                                <input type="file" name="bukti[]" id="createBukti" class="form-control"
                                    accept="image/jpeg,image/png" multiple required>
                                <div class="form-text">Wajib 2–5 foto, maksimal 2MB per file (jpg/jpeg/png).</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-green">
                            <i class="bi bi-save me-1"></i>
                            Simpan Kompensasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="buktiZoomModal" tabindex="-1" aria-labelledby="buktiZoomTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                @include('layouts.partials.modal-head', [
                    'title' => 'Bukti Foto Kompensasi',
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

    <div class="modal fade" id="buktiLightbox" tabindex="-1" aria-label="Bukti foto" aria-hidden="true">
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

        function esc(s) {
            return String(s ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
                '&quot;');
        }

        function formatRupiahInput(value) {
            let angka = String(value || '').replace(/\D/g, '');
            if (!angka) return '';
            return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
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

        function jenisBadge(jenis) {
            const map = {
                'pengembalian_dana': ['jenis-pengembalian-dana', 'Pengembalian Dana'],
                'diskon': ['jenis-diskon', 'Diskon'],
                'gratis_sewa': ['jenis-gratis-sewa', 'Gratis Sewa'],
            };
            const item = map[jenis] || ['bg-secondary text-white', '-'];
            return '<span class="jenis-badge ' + item[0] + '">' + esc(item[1]) + '</span>';
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
                html += '<img src="' + esc(src) +
                    '" alt="Bukti kompensasi" class="bukti-thumb" onclick="openBuktiGaleri(\'' + row.id + '\')">';
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
                    alt: 'Bukti foto kompensasi'
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

            var kompTable = $('#kompensasis-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                pageLength: 10,
                info: false,
                dom: 'frt',
                ajax: {
                    url: '{{ route('kompensasis.data') }}',
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
                            return '<strong>' + esc(data.customer_name ?? '-') + '</strong>' +
                                '<div class="small text-muted">' + esc(data.customer_email ?? '-') +
                                '</div>';
                        },
                    },
                    {
                        data: null,
                        orderable: true,
                        searchable: true,
                        render: function(data) {
                            return '<div class="fw-bold">' + esc(data.mobil_name ?? '-') +
                                '</div>' +
                                '<small class="text-muted">' + esc(data.mobil_plate ?? '-') +
                                '</small>';
                        },
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            const rental = data.rental || {};
                            if (!rental.id) return '<span class="text-muted">-</span>';
                            const periode = rental.tanggal_mulai && rental.tanggal_selesai ?
                                rental.tanggal_mulai + ' s/d ' + rental.tanggal_selesai :
                                '-';
                            return '<div class="fw-bold">Rental #' + esc(rental.id) + '</div>' +
                                '<small class="text-muted">' + esc(periode) + '</small>';
                        },
                    },
                    {
                        data: 'nominal',
                        orderable: true,
                        searchable: false,
                        render: function(data, type, row) {
                            if (row.jenis !== 'pengembalian_dana') {
                                return '<span class="text-muted">-</span>';
                            }
                            return '<span class="fw-semibold">' + esc(formatRupiah(data)) +
                                '</span>';
                        },
                    },
                    {
                        data: 'staff_name',
                        orderable: false,
                        searchable: true,
                        render: function(data) {
                            return esc(data ?? '-');
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
                        width: '70px',
                        render: function(data, type, row) {
                            return '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" ' +
                                'title="Detail" onclick="openDetail(' + data + ')">' +
                                '<i class="bi bi-eye"></i></button>';
                        },
                    },
                ],
                order: [
                    [1, 'desc']
                ],
                language: {
                    processing: 'Memproses...',
                    search: 'Cari:',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    loadingRecords: 'Memuat...',
                    zeroRecords: 'Tidak ditemukan data yang cocok',
                    emptyTable: 'Belum ada kompensasi',
                    aria: {
                        sortAscending: ': aktifkan untuk urut naik',
                        sortDescending: ': aktifkan untuk urut turun',
                    },
                },
            });

            function renderKompPager() {
                var info = kompTable.page.info();
                var total = info.recordsDisplay;
                var start = total ? info.start + 1 : 0;
                $('#komp-pager-info').text('Menampilkan ' + start + '–' + info.end + ' dari ' + total + ' data');
                var pages = Math.max(info.pages, 1);
                var page = info.page + 1;
                $('#komp-pager-pages').text('Halaman ' + (pages ? info.page + 1 : 0) + ' / ' + pages);
                $('#komp-pager-first, #komp-pager-prev').toggleClass('disabled', page <= 1);
                $('#komp-pager-next, #komp-pager-last').toggleClass('disabled', page >= pages);
            }

            kompTable.on('draw.dt', renderKompPager);
            renderKompPager();

            $('#komp-pager-first').on('click', function() {
                kompTable.page('first').draw('page');
            });
            $('#komp-pager-prev').on('click', function() {
                kompTable.page('previous').draw('page');
            });
            $('#komp-pager-next').on('click', function() {
                kompTable.page('next').draw('page');
            });
            $('#komp-pager-last').on('click', function() {
                kompTable.page('last').draw('page');
            });
            $('#komp-pager-len').on('change', function() {
                var v = $(this).val();
                if (v === 'custom') {
                    $('#komp-pager-custom').focus();
                    return;
                }
                var n = parseInt(v, 10) || 10;
                $('#komp-pager-custom').val(n);
                kompTable.page.len(n).draw();
            });
            $('#komp-pager-custom').on('change', function() {
                var n = parseInt($(this).val(), 10) || 1;
                n = Math.min(Math.max(n, 1), 100);
                $(this).val(n);
                if (['10', '20', '50', '100'].indexOf(String(n)) !== -1) {
                    $('#komp-pager-len').val(String(n));
                } else {
                    $('#komp-pager-len').val('custom');
                }
                kompTable.page.len(n).draw();
            });

        });




        function openDetail(id) {
            const table = $('#kompensasis-table').DataTable();
            const data = table.rows().data().toArray().find(row => row.id == id);

            if (!data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data tidak ditemukan',
                    text: 'Data kompensasi tidak tersedia pada halaman ini.'
                });
                return;
            }

            const rental = data.rental || {};

            const jenisLabels = {
                pengembalian_dana: 'Pengembalian Dana',
                diskon: 'Diskon',
                gratis_sewa: 'Gratis Sewa'
            };
            $('#detailTanggal').text(data.tanggal || '-');
            $('#detailJenis').text(jenisLabels[data.jenis] || data.jenis || '-');

            $('#detailNominal').text(
                data.jenis === 'pengembalian_dana' ?
                formatRupiah(data.nominal) :
                '-'
            );
            $('#detailCustomerName').text(data.customer_name || '-');
            $('#detailCustomerEmail').text(data.customer_email || '-');
            $('#detailRentalId').text(rental.id ? '#' + rental.id : '-');

            $('#detailMobil').text(
                data.mobil_name && data.mobil_name !== '-' ?
                `${data.mobil_name} (${data.mobil_plate || '-'})` :
                '-'
            );

            const periode = rental.tanggal_mulai && rental.tanggal_selesai ?
                `${rental.tanggal_mulai} - ${rental.tanggal_selesai} (${rental.jumlah_hari || 0} hari)` :
                '-';
            $('#detailPeriodeRental').text(periode);
            $('#detailStaff').text(data.staff_name || '-');
            $('#detailDiskon').text(formatRupiah(rental.diskon));
            $('#detailHargaPerhari').text(formatRupiah(rental.harga_perhari));
            $('#detailTotalHarga').text(formatRupiah(rental.total_harga));
            $('#detailDeposit').text(formatRupiah(rental.deposit));
            $('#detailDiskonWrap').toggle(Number(rental.diskon || 0) > 0);
            $('#detailAlasan').text(data.alasan || '-');
            $('#detailCatatan').text(data.catatan || '-');

            const $grid = $('#detailBuktiGrid');
            const urls = buktiList(data);

            $grid.empty();

            if (urls.length) {
                urls.forEach(function(url) {
                    const $column = $('<div>').addClass('col-4 col-md-3');

                    const $image = $('<img>').attr({
                        src: url,
                        alt: 'Bukti kompensasi'
                    }).addClass('img-fluid rounded-3 border').css({
                        width: '100%',
                        height: '110px',
                        objectFit: 'cover',
                        cursor: 'zoom-in'
                    });

                    $image.on('click', function() {
                        openBuktiLightbox(url);
                    });

                    $column.append($image);
                    $grid.append($column);
                });
            } else {
                $grid.append(`
            <div class="col-12">
                <div class="bg-light rounded-3 p-3 text-muted small">
                    <i class="bi bi-image me-2"></i>
                    Tidak ada bukti dokumentasi.
                </div>
            </div>
        `);
            }
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('detailKompensasiModal')
            ).show();
        }




        var rentalPicker = (function() {
            var $search = $('#createRentalSearch');
            var $results = $('#createRentalSearchResults');
            var $card = $('#createRentalSelectedCard');
            var $main = $('#createRentalSelectedMain');
            var $detail = $('#createRentalSelectedDetail');
            var $hidden = $('#createRentalId');
            var $help = $('#createRentalHelp');
            var $wrap = $search.closest('.rental-search-wrapper');
            var rows = [];
            var selectedId = null;
            var HELP_DEFAULT = 'Pilih customer terlebih dahulu untuk mencari rental.';

            function hay(r) {
                return [r.id, 'rental #' + r.id, r.pelanggan, r.mobil, r.plat, r.status, r.mulai, r.selesai]
                    .join(' ').toLowerCase();
            }

            function renderResults() {
                var q = $search.val().toLowerCase().trim();
                var found = rows.filter(function(r) {
                    return hay(r).indexOf(q) !== -1;
                });
                $results.empty();

                if (!found.length) {
                    $results.append($('<div class="rental-search-empty">').text('Rental tidak ditemukan.'));
                }

                found.forEach(function(r) {
                    var $item = $('<div class="rental-search-item">')
                        .toggleClass('active', String(r.id) === String(selectedId))
                        .attr('data-id', r.id);
                    $('<div class="rental-item-main">').text('Rental #' + r.id + ' — ' + r.pelanggan)
                        .appendTo($item);
                    $('<div class="rental-sub">')
                        .text(r.mobil + (r.plat ? ' • ' + r.plat : '') + ' • ' + r.status).appendTo($item);
                    $('<div class="rental-sub">').text(r.mulai + ' s/d ' + r.selesai).appendTo($item);
                    $results.append($item);
                });

                $results.addClass('show');
            }

            function renderCard(r) {
                $main.empty();
                var $head = $('<div class="rc-head">').appendTo($main);
                $('<div class="rc-avatar"><i class="bi bi-person-fill"></i></div>').appendTo($head);
                var $info = $('<div>').appendTo($head);
                $('<div class="rc-name">').text(r.pelanggan).appendTo($info);
                var $idRow = $('<div class="rc-id">').appendTo($info);
                $('<span>').text('Rental #' + r.id).appendTo($idRow);
                $('<span class="rc-badge">').toggleClass('status-selesai', r.status === 'Selesai')
                    .text(r.status).appendTo($idRow);

                $detail.empty();
                var $meta = $('<div class="rc-meta">').appendTo($detail);

                function metaRow(icon, text) {
                    var $row = $('<div class="rc-meta-row">').appendTo($meta);
                    $('<i>').addClass('bi ' + icon).appendTo($row);
                    $('<span>').text(text).appendTo($row);
                }
                metaRow('bi-car-front-fill', r.mobil + ' • ' + (r.plat || 'Plat belum tersedia'));
                metaRow('bi-calendar-range',
                    r.mulai + ' s/d ' + r.selesai + (r.jumlah_hari ? ' • ' + r.jumlah_hari + ' hari' : ''));
                if (r.diskon > 0) metaRow('bi-tag-fill', 'Diskon ' + formatRupiah(r.diskon));

                var $stats = $('<div class="rc-stats">').appendTo($detail);

                function stat(label, value, extra) {
                    var $s = $('<div class="rc-stat">').addClass(extra || '').appendTo($stats);
                    $('<div class="rc-stat-label">').text(label).appendTo($s);
                    $('<div class="rc-stat-value">').text(value).appendTo($s);
                }
                stat('Harga / hari', formatRupiah(r.harga_perhari));
                stat('Total', formatRupiah(r.total_harga), 'total');
                stat('Deposit', formatRupiah(r.deposit));

                $card.addClass('show');
            }

            function select(r) {
                selectedId = r.id;
                $hidden.val(r.id);
                renderCard(r);
                $search.val('');
                $results.removeClass('show').empty();
            }

            function clearSelection() {
                selectedId = null;
                $hidden.val('');
                $card.removeClass('show');
                $main.empty();
                $detail.empty();
            }

            function resetAll() {
                clearSelection();
                rows = [];
                $search.val('').prop('disabled', true).attr('placeholder', 'Pilih customer terlebih dahulu');
                $results.removeClass('show').empty();
                $help.text(HELP_DEFAULT).removeClass('text-danger');
            }

            function setLoading() {
                resetAll();
                $search.attr('placeholder', 'Memuat rental...');
                $help.text('Memuat rental...');
            }

            function setRows(list) {
                rows = list.map(function(x) {
                    return {
                        id: x.id,
                        pelanggan: x.pelanggan || '-',
                        mobil: x.mobil_name || '-',
                        plat: x.plate_number && x.plate_number !== '-' ? x.plate_number : '',
                        status: x.status,
                        mulai: x.tanggal_mulai || '-',
                        selesai: x.tanggal_selesai || '-',
                        jumlah_hari: x.jumlah_hari,
                        harga_perhari: x.harga_perhari,
                        deposit: x.deposit,
                        diskon: x.diskon,
                        total_harga: x.total_harga
                    };
                });

                if (!rows.length) {
                    $search.prop('disabled', true).attr('placeholder', 'Tidak ada rental');
                    $help.text('Tidak ada rental Selesai.').addClass('text-danger');
                    return;
                }

                $search.prop('disabled', false).attr('placeholder', 'Cari pelanggan, mobil, plat, atau rental...');
                $help.text('Cari dan pilih rental Selesai milik customer ini.').removeClass('text-danger');
            }

            function setError() {
                resetAll();
                $help.text('Gagal memuat rental.').addClass('text-danger');
            }

            $search.on('focus', function() {
                if (!selectedId && rows.length) renderResults();
            });
            $search.on('input', function() {
                if (selectedId) clearSelection();
                renderResults();
            });

            $results.on('click', '.rental-search-item', function() {
                var id = String($(this).attr('data-id'));
                var r = rows.find(function(x) {
                    return String(x.id) === id;
                });
                if (r) select(r);
            });

            $card.find('.btn-remove-rental').on('click', function() {
                clearSelection();
                $search.trigger('focus');
            });

            $(document).on('click', function(e) {
                if (!$wrap[0].contains(e.target)) $results.removeClass('show');
            });

            $search.on('keydown', function(e) {
                if (e.key === 'Escape' && $results.hasClass('show')) {
                    e.stopPropagation();
                    $results.removeClass('show');
                }
            });

            return {
                resetAll: resetAll,
                setLoading: setLoading,
                setRows: setRows,
                setError: setError
            };
        })();

        function resetCreateKompensasi() {
            var form = document.getElementById('formCreateKompensasi');
            if (form) form.reset();
            rentalPicker.resetAll();
            $('#createNominalWrap').addClass('d-none');
            $('#createNominalDisplay').val('');
            $('#createNominal').val('');
            $('#createTanggal').val('{{ now()->format('Y-m-d') }}');
        }

        $('#createCustomerId').on('change', function() {
            var customerId = $(this).val();

            if (!customerId) {
                rentalPicker.resetAll();
                return;
            }

            rentalPicker.setLoading();

            $.getJSON('{{ route('kompensasis.rentals') }}', {
                    customer_id: customerId
                })
                .done(function(rows) {
                    // abaikan respons lama kalau customer sudah diganti lagi
                    if ($('#createCustomerId').val() !== customerId) return;
                    rentalPicker.setRows(rows);
                })
                .fail(function() {
                    if ($('#createCustomerId').val() !== customerId) return;
                    rentalPicker.setError();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak bisa memuat daftar rental customer.'
                    });
                });
        });

        $(document).on('show.bs.modal', '#createKompensasiModal', resetCreateKompensasi);

        $('#createJenis').on('change', function() {
            var isDana = $(this).val() === 'pengembalian_dana';
            $('#createNominalWrap').toggleClass('d-none', !isDana);
            if (!isDana) {
                $('#createNominalDisplay').val('');
                $('#createNominal').val('');
            }
        });


        $(document).on('submit', '#formCreateKompensasi', function(e) {
            e.preventDefault();
            if (!$('#createRentalId').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Rental belum dipilih',
                    text: 'Pilih rental terlebih dahulu.'
                });
                return;
            }

            var files = document.getElementById('createBukti').files;
            if (files.length < 2 || files.length > 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'Bukti tidak valid',
                    text: 'Unggah 2 sampai 5 foto bukti.',
                });
                return;
            }

            for (var i = 0; i < files.length; i++) {
                if (files[i].size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File terlalu besar',
                        text: 'Setiap bukti maksimal 2MB.',
                    });
                    return;
                }
            }

            var formData = new FormData(this);
            var $btn = $(this).find('button[type=submit]');

            $.ajax({
                url: '{{ route('kompensasis.store') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                beforeSend: function() {
                    $btn.prop('disabled', true);
                },
                complete: function() {
                    $btn.prop('disabled', false);
                },
                success: function(result) {
                    bootstrap.Modal.getOrCreateInstance($('#createKompensasiModal')[0]).hide();
                    $('#kompensasis-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message || 'Kompensasi berhasil dibuat.',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                },
                error: function(xhr) {
                    var r = xhr.responseJSON || {};
                    var msg = r.errors ? Object.values(r.errors)[0][0] :
                        (r.message || 'Terjadi kesalahan saat membuat kompensasi.');

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg,
                    });
                },
            });
        });
    </script>

</body>

</html>