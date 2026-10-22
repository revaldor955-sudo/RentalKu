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
        }

        .nav-btn-back::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 4px;
            width: 0;
            height: 2px;
            border-radius: 1px;
            background: #198754;
            transform: translateX(-50%);
            transition: width 0.25s ease-out;
        }

        .nav-btn-back:hover {
            color: #198754;
        }

        .nav-btn-back:hover::after,
        .nav-btn-back:focus-visible::after {
            width: calc(100% - 24px);
        }

        @media (prefers-reduced-motion: reduce) {
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

        .bukti-preview-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px
        }

        .bukti-preview-grid img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            cursor: zoom-in
        }

        .bukti-preview-item {
            position: relative;
            width: 72px;
            height: 72px
        }

        .bukti-preview-item img {
            display: block
        }

        .bukti-del {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: none;
            background: #dc3545;
            color: #fff;
            font-size: 12px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0
        }

        .bukti-del:hover {
            background: #b02a37;
            color: #fff
        }

        #buktiCount {
            font-size: 12px
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

        .klaim-step {
            display: none
        }

        .klaim-step.active {
            display: block
        }

        .klaim-progress-label {
            font-size: 13px;
            font-weight: 700;
            color: #198754
        }

        .klaim-progress-wrap .progress {
            height: 8px;
            background: #e9ecef;
            border-radius: 99px
        }

        .klaim-progress-wrap .progress-bar {
            background: #198754;
            border-radius: 99px;
            transition: width .25s ease-out
        }

        .klaim-ringkas-thumb {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e9ecef
        }

        @media (prefers-reduced-motion: reduce) {

            .bukti-thumb,
            .bukti-grid img {
                transition: none
            }

            .klaim-progress-wrap .progress-bar {
                transition: none
            }
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
                    Klaim Kompensasi Saya
                </h2>

                <p class="text-muted mb-0">
                    Lihat dan ajukan klaim kompensasi untuk rental yang sudah selesai.
                </p>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('customer.dashboard') }}" class="nav-btn-back">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Dashboard
                </a>

            </div>

        </div>


        @if (session('success'))
            <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
        @endif


        @if ($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Terdapat kesalahan:
                </strong>

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

                    <div class="p-4 border-bottom">

                        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    Ajukan Klaim
                                </h5>

                                <small class="text-muted">
                                    Ajukan klaim baru dan pantau riwayat klaim Anda.
                                </small>

                            </div>

                            <div class="d-flex gap-2">

                                <button type="button" class="btn btn-green" data-bs-toggle="modal"
                                    data-bs-target="#ajukanKompensasiModal">

                                    <i class="bi bi-plus-circle me-1"></i>
                                    Ajukan Klaim

                                </button>

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


        <div class="modal fade" id="ajukanKompensasiModal" tabindex="-1">

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content">

                    @include('layouts.partials.modal-head', [
                        'title' => 'Ajukan Klaim Kompensasi',
                        'icon' => 'bi-plus-circle',
                    ])

                    <form action="{{ route('customer.kompensasi.store') }}" method="POST" id="formAjukanKompensasi"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="modal-body">

                            <div class="klaim-progress-wrap mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="klaim-progress-label" id="klaimStepLabel">Langkah 1 dari 5</span>
                                    <small class="text-muted" id="klaimStepName">Rental &amp; Mobil</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" id="klaimProgressBar" role="progressbar"
                                        style="width: 20%" aria-valuenow="1" aria-valuemin="1" aria-valuemax="5">
                                    </div>
                                </div>
                            </div>

                            <div class="klaim-step active" data-step="1">

                                <label class="form-label fw-semibold" for="ajuanRentalId">
                                    Rental (Status Selesai)
                                </label>

                                <select name="rental_id" id="ajuanRentalId" class="form-select">
                                    <option value="">-- Pilih Rental --</option>
                                    @foreach ($rentals as $rental)
                                        <option value="{{ $rental->id }}" data-mobil="{{ $rental->mobil->id }}"
                                            data-mobil-name="{{ $rental->mobil->name }}"
                                            data-plate="{{ $rental->mobil->plate_number }}"
                                            data-image="{{ $rental->mobil->image ? asset($rental->mobil->image) : '' }}"
                                            data-mulai="{{ $rental->tanggal_mulai->format('d/m/Y') }}"
                                            data-selesai="{{ $rental->tanggal_selesai->format('d/m/Y') }}">
                                            {{ $rental->mobil->name ?? '-' }}
                                            ({{ $rental->mobil->plate_number ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="fb-ajuanRentalId">Pilih rental terlebih dahulu.
                                </div>

                                <label class="form-label fw-semibold mt-3" for="ajuanMobilId">
                                    Mobil
                                </label>

                                <input type="hidden" name="mobil_id" id="ajuanMobilId">

                                <div id="mobilEmpty" class="text-muted small border rounded-3 p-3">
                                    Pilih rental dulu untuk melihat mobil.
                                </div>

                                <div id="mobilCard" class="d-none border rounded-3 p-3" style="background: #f5f8f6;">

                                    <div class="d-flex gap-3 align-items-center">

                                        <img id="mobilCardImg" src="" alt="Foto mobil"
                                            style="width: 96px; height: 72px; object-fit: cover; border-radius: 10px;">

                                        <div>

                                            <div id="mobilCardName" class="fw-bold"></div>

                                            <small id="mobilCardPlate" class="text-muted d-block"></small>

                                            <small id="mobilCardPeriod" class="text-muted d-block"></small>

                                        </div>

                                    </div>

                                </div>
                                <div class="invalid-feedback" id="fb-ajuanMobilId">Mobil belum terisi. Pilih ulang
                                    rental.</div>

                            </div>

                            <div class="klaim-step" data-step="2">

                                <label class="form-label fw-semibold" for="ajuanJenis">
                                    Jenis Kompensasi
                                </label>

                                <select name="jenis" id="ajuanJenis" class="form-select">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="pengembalian_dana">Pengembalian Dana</option>
                                    <option value="diskon">Diskon Sewa Berikutnya</option>
                                    <option value="gratis_sewa">Gratis Sewa Berikutnya</option>
                                </select>
                                <div class="invalid-feedback" id="fb-ajuanJenis">Pilih jenis kompensasi.</div>

                                <div id="nominalWrap" style="display: none;">
                                    <label class="form-label fw-semibold mt-3" for="ajuanNominalDisplay">
                                        Nominal (Rp)
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" name="nominal_display" id="ajuanNominalDisplay"
                                            class="form-control rupiah-input" placeholder="50.000"
                                            inputmode="numeric" autocomplete="off" data-target="nominal">
                                        <input type="hidden" name="nominal" id="nominal">
                                    </div>
                                    <div class="invalid-feedback" id="fb-ajuanNominalDisplay">Nominal wajib diisi
                                        lebih dari 0 untuk Pengembalian Dana.</div>

                                    <small class="text-muted d-block" id="nominalHint">Wajib diisi untuk jenis
                                        "Pengembalian Dana"</small>
                                </div>

                            </div>

                            <div class="klaim-step" data-step="3">

                                <label class="form-label fw-semibold" for="ajuanAlasan">
                                    Alasan
                                </label>

                                <textarea name="alasan" id="ajuanAlasan" class="form-control" rows="3"
                                    placeholder="Jelaskan alasan klaim kompensasi..."></textarea>
                                <div class="invalid-feedback" id="fb-ajuanAlasan">Alasan wajib diisi.</div>

                                <label class="form-label fw-semibold mt-3" for="ajuanTanggal">
                                    Tanggal Kejadian
                                </label>

                                <input type="date" name="tanggal" id="ajuanTanggal" class="form-control"
                                    value="{{ now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}">
                                <div class="invalid-feedback" id="fb-ajuanTanggal">Tanggal wajib diisi dan tidak boleh
                                    melebihi hari ini.</div>

                            </div>

                            <div class="klaim-step" data-step="4">

                                <label class="form-label fw-semibold" for="ajuanBukti">
                                    Bukti Foto
                                </label>

                                <input type="file" name="bukti[]" id="ajuanBukti" class="form-control" multiple
                                    accept=".jpg,.jpeg,.png">

                                <div class="form-text">
                                    Minimal 2, maksimal 5 foto. Format JPG, JPEG, atau PNG, masing-masing maksimal 2 MB.
                                </div>
                                <div class="invalid-feedback" id="fb-ajuanBukti">Pilih 2 sampai 5 foto (JPG/JPEG/PNG,
                                    masing-masing maksimal 2 MB).</div>

                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <small id="buktiCount" class="fw-semibold text-muted">0/5 foto dipilih</small>
                                    <button type="button" id="buktiReset" class="bukti-link d-none">Pilih
                                        ulang</button>
                                </div>

                                <div id="buktiPreview" class="bukti-preview-grid mt-2"></div>

                            </div>

                            <div class="klaim-step" data-step="5">

                                <p class="text-muted small mb-3">Periksa kembali data klaim sebelum dikirim. Klaim yang
                                    dikirim tidak bisa diubah.</p>

                                <div id="klaimRingkasan"></div>

                            </div>

                        </div>

                        <div class="modal-footer justify-content-between">

                            <button type="button" class="btn btn-secondary invisible" id="btnKlaimBack">

                                <i class="bi bi-arrow-left me-1"></i>
                                Kembali

                            </button>

                            <div class="d-flex gap-2">

                                <button type="button" class="btn btn-green" id="btnKlaimNext">

                                    Lanjut
                                    <i class="bi bi-arrow-right ms-1"></i>

                                </button>

                                <button type="submit" class="btn btn-green d-none" id="btnKlaimSubmit">

                                    <i class="bi bi-send me-1"></i>
                                    Ajukan

                                </button>

                            </div>

                        </div>

                    </form>

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

            $('#ajuanRentalId').on('change', function() {
                const opt = $(this).find('option:selected');
                const mobilId = opt.data('mobil');

                if (mobilId) {
                    $('#ajuanMobilId').val(mobilId);
                    $('#mobilCardName').text(opt.data('mobil-name'));
                    $('#mobilCardPlate').text(opt.data('plate'));
                    $('#mobilCardPeriod').text('Disewa ' + opt.data('mulai') + ' - ' + opt.data('selesai'));

                    const img = opt.data('image');
                    if (img) {
                        $('#mobilCardImg').attr('src', img).attr('alt', opt.data('mobil-name')).show();
                    } else {
                        $('#mobilCardImg').hide();
                    }

                    $('#mobilCard').removeClass('d-none');
                    $('#mobilEmpty').addClass('d-none');
                } else {
                    $('#ajuanMobilId').val('');
                    $('#mobilCard').addClass('d-none');
                    $('#mobilEmpty').removeClass('d-none');
                }
            });

            $('#ajuanJenis').on('change', function() {
                const jenis = $(this).val();
                if (jenis === 'pengembalian_dana') {
                    $('#nominalWrap').show();
                    $('#ajuanNominalDisplay').prop('disabled', false);
                    $('#nominalHint').text('Wajib diisi untuk jenis "Pengembalian Dana"');
                } else {
                    $('#nominalWrap').hide();
                    $('#ajuanNominalDisplay').prop('disabled', true).val('')
                        .removeClass('is-invalid');
                    $('#nominal').val('');
                    $('#nominalHint').text('Tidak diisi untuk Diskon/Gratis Sewa (nominal = 0)');
                }
            });
            $('#nominalWrap').hide();

            $(document).on('hidden.bs.modal', '#ajukanKompensasiModal', function() {
                klaimRevokeRingkasanUrls();
                klaimGoToStep(1);
            });

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
                        render: function(data, type, row) {
                            return '<div class="d-flex justify-content-center gap-2">' +
                                '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" ' +
                                'title="Detail" onclick="openDetail(' + data + ')">' +
                                '<i class="bi bi-eye"></i></button>' +
                                '</div>';
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

            @if (request('baru'))
                @if (request('rental') && $rentals->contains('id', (int) request('rental')))
                    $('#ajuanRentalId').val('{{ (int) request('rental') }}');
                @endif
                bootstrap.Modal.getOrCreateInstance($('#ajukanKompensasiModal')[0]).show();
                $('#ajuanRentalId').trigger('change');
                klaimGoToStep(1);
            @endif
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

        var klaimPreviewToken = 0;

        function renderBuktiPreview(input) {
            const files = input.files ? Array.prototype.slice.call(input.files) : [];
            const myToken = ++klaimPreviewToken;
            const $grid = $('#buktiPreview');
            const $count = $('#buktiCount');
            $grid.empty();
            $count.text(files.length + '/5 foto dipilih');
            $count.toggleClass('text-danger', files.length > 5);
            $count.toggleClass('text-muted', files.length <= 5);
            $('#buktiReset').toggleClass('d-none', !files.length);
            files.forEach(function(file, idx) {
                if (!file.type || !/^image\//.test(file.type)) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (myToken !== klaimPreviewToken) return;
                    const url = e.target.result;
                    const $wrap = $('<div class="bukti-preview-item"></div>');
                    const $img = $('<img>').attr({
                        src: url,
                        alt: 'Preview bukti ' + (idx + 1)
                    }).on('click', function() {
                        openBuktiLightbox(url);
                    });
                    const $del = $('<button type="button" class="bukti-del" aria-label="Hapus foto ' + (idx +
                        1) + '"><i class="bi bi-x"></i></button>').on('click', function(ev) {
                        ev.stopPropagation();
                        hapusBuktiPilihan(idx);
                    });
                    $wrap.append($img).append($del);
                    $grid.append($wrap);
                };
                reader.readAsDataURL(file);
            });
        }

        function hapusBuktiPilihan(idx) {
            const input = $('#ajuanBukti')[0];
            const sisa = new DataTransfer();
            Array.prototype.forEach.call(input.files, function(file, i) {
                if (i !== idx) sisa.items.add(file);
            });
            input.files = sisa.files;
            renderBuktiPreview(input);
            klaimSetInvalid($('#ajuanBukti'), 'fb-ajuanBukti', klaimBuktiInvalid());
        }

        $(document).on('change', '#ajuanBukti', function() {
            renderBuktiPreview(this);
            klaimSetInvalid($('#ajuanBukti'), 'fb-ajuanBukti', klaimBuktiInvalid());
            const pesan = klaimBuktiError();
            if (pesan) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: pesan
                });
            }
        });

        $(document).on('click', '#buktiReset', function() {
            $('#ajuanBukti').val('');
            renderBuktiPreview($('#ajuanBukti')[0]);
            klaimSetInvalid($('#ajuanBukti'), 'fb-ajuanBukti', klaimBuktiInvalid());
        });

        var klaimStep = 1;
        var klaimStepNames = {
            1: 'Rental & Mobil',
            2: 'Jenis & Nominal',
            3: 'Alasan & Tanggal',
            4: 'Bukti Foto',
            5: 'Konfirmasi'
        };

        function klaimEsc(s) {
            return String(s ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
                '&quot;');
        }

        function klaimSetInvalid($el, fbId, bad) {
            $el.toggleClass('is-invalid', !!bad);
            $('#' + fbId).toggleClass('d-block', !!bad);
            return !bad;
        }

        function klaimBuktiError() {
            const files = $('#ajuanBukti')[0].files;
            if (files.length > 5) return 'Maksimal 5 foto bukti yang bisa diunggah.';
            for (let i = 0; i < files.length; i++) {
                if (files[i].size > 2 * 1024 * 1024) return 'Foto ke-' + (i + 1) + ' melebihi 2 MB.';
                if (!/^image\//.test(files[i].type || '') && !/\.(jpe?g|png)$/i.test(files[i].name || ''))
                return 'Foto ke-' + (i + 1) + ' harus JPG/JPEG/PNG.';
            }
            return null;
        }

        function klaimBuktiInvalid() {
            const files = $('#ajuanBukti')[0].files;
            if (files.length < 2 || files.length > 5) return true;
            for (let i = 0; i < files.length; i++) {
                if (files[i].size > 2 * 1024 * 1024) return true;
                if (!/^image\//.test(files[i].type || '') && !/\.(jpe?g|png)$/i.test(files[i].name || '')) return true;
            }
            return false;
        }

        function klaimValidateStep(step) {
            let ok = true;
            if (step === 1) {
                if (!klaimSetInvalid($('#ajuanRentalId'), 'fb-ajuanRentalId', !$('#ajuanRentalId').val())) ok = false;
                if (!klaimSetInvalid($('#ajuanMobilId'), 'fb-ajuanMobilId', !$('#ajuanMobilId').val())) ok = false;
            } else if (step === 2) {
                const jenis = $('#ajuanJenis').val();
                if (!klaimSetInvalid($('#ajuanJenis'), 'fb-ajuanJenis', !jenis)) ok = false;
                const nominalBad = jenis === 'pengembalian_dana' && !(Number($('#nominal').val() || 0) > 0);
                if (!klaimSetInvalid($('#ajuanNominalDisplay'), 'fb-ajuanNominalDisplay', nominalBad)) ok = false;
            } else if (step === 3) {
                if (!klaimSetInvalid($('#ajuanAlasan'), 'fb-ajuanAlasan', !$('#ajuanAlasan').val().trim())) ok = false;
                const tgl = $('#ajuanTanggal').val();
                const today = new Date().toISOString().slice(0, 10);
                if (!klaimSetInvalid($('#ajuanTanggal'), 'fb-ajuanTanggal', !tgl || tgl > today)) ok = false;
            } else if (step === 4) {
                if (!klaimSetInvalid($('#ajuanBukti'), 'fb-ajuanBukti', klaimBuktiInvalid())) ok = false;
            }
            return ok;
        }

        function klaimGoToStep(n) {
            klaimStep = Math.min(5, Math.max(1, n));
            $('#formAjukanKompensasi .klaim-step').removeClass('active')
                .filter('[data-step="' + klaimStep + '"]').addClass('active');
            $('#klaimStepLabel').text('Langkah ' + klaimStep + ' dari 5');
            $('#klaimStepName').text(klaimStepNames[klaimStep]);
            const bar = $('#klaimProgressBar');
            bar.css('width', (klaimStep * 20) + '%').attr('aria-valuenow', klaimStep);
            $('#btnKlaimBack').toggleClass('invisible', klaimStep === 1);
            $('#btnKlaimNext').toggleClass('d-none', klaimStep === 5);
            $('#btnKlaimSubmit').toggleClass('d-none', klaimStep !== 5);
            if (klaimStep === 5) renderKlaimRingkasan();
        }

        var klaimRingkasanUrls = [];

        function klaimRevokeRingkasanUrls() {
            klaimRingkasanUrls.forEach(function(u) {
                try {
                    URL.revokeObjectURL(u);
                } catch (e) { /* abaikan */ }
            });
            klaimRingkasanUrls = [];
        }

        function renderKlaimRingkasan() {
            klaimRevokeRingkasanUrls();
            const opt = $('#ajuanRentalId option:selected');
            const jenisLabels = {
                pengembalian_dana: 'Pengembalian Dana',
                diskon: 'Diskon Sewa Berikutnya',
                gratis_sewa: 'Gratis Sewa Berikutnya'
            };
            const jenis = $('#ajuanJenis').val();
            const nominalRaw = Number($('#nominal').val() || 0);
            const files = $('#ajuanBukti')[0].files ? Array.prototype.slice.call($('#ajuanBukti')[0].files) : [];
            const mobilImg = opt.data('image') || $('#mobilCardImg').attr('src') || '';
            const mobilFoto = mobilImg ? '<div class="mb-3 text-center"><img src="' + klaimEsc(mobilImg) +
                '" alt="Foto mobil" class="img-fluid rounded" style="max-height:180px;object-fit:cover"></div>' : '';
            let thumbs = '';
            files.forEach(function(f) {
                try {
                    const u = URL.createObjectURL(f);
                    klaimRingkasanUrls.push(u);
                    thumbs += '<img src="' + klaimEsc(u) + '" alt="Bukti" class="klaim-ringkas-thumb">';
                } catch (e) {
                    /* abaikan */ }
            });
            $('#klaimRingkasan').html(
                mobilFoto +
                '<dl class="row mb-0 small">' +
                '<dt class="col-4 text-muted">Rental</dt><dd class="col-8 fw-semibold">' + klaimEsc(opt.text().trim() ||
                    '-') + '</dd>' +
                '<dt class="col-4 text-muted">Mobil</dt><dd class="col-8 fw-semibold">' + klaimEsc($('#mobilCardName')
                    .text() || opt.data('mobil-name') || '-') + ' (' + klaimEsc($('#mobilCardPlate').text() || opt.data(
                    'plate') || '-') + ')</dd>' +
                '<dt class="col-4 text-muted">Jenis</dt><dd class="col-8 fw-semibold">' + klaimEsc(jenisLabels[jenis] ||
                    '-') + '</dd>' +
                '<dt class="col-4 text-muted">Nominal</dt><dd class="col-8 fw-semibold">' + (jenis ===
                    'pengembalian_dana' ? klaimEsc(formatRupiah(nominalRaw)) : 'Rp 0 (non-tunai)') + '</dd>' +
                '<dt class="col-4 text-muted">Alasan</dt><dd class="col-8">' + klaimEsc($('#ajuanAlasan').val()
            .trim()) + '</dd>' +
                '<dt class="col-4 text-muted">Tanggal</dt><dd class="col-8">' + klaimEsc($('#ajuanTanggal').val()) +
                '</dd>' +
                '<dt class="col-4 text-muted">Bukti</dt><dd class="col-8">' + files.length +
                ' foto<div class="d-flex flex-wrap gap-2 mt-2">' + thumbs + '</div></dd>' +
                '</dl>'
            );
        }

        $(document).on('click', '#btnKlaimNext', function() {
            if (klaimValidateStep(klaimStep)) klaimGoToStep(klaimStep + 1);
        });

        $(document).on('click', '#btnKlaimBack', function() {
            if (klaimStep > 1) klaimGoToStep(klaimStep - 1);
        });

        $(document).on('input change', '#formAjukanKompensasi .is-invalid', function() {
            $(this).removeClass('is-invalid');
            $(this).closest('.klaim-step').find('.invalid-feedback.d-block').removeClass('d-block');
        });

        $(document).on('submit', '#formAjukanKompensasi', function(e) {
            e.preventDefault();

            const form = this;

            if (klaimStep < 5) {
                if (klaimValidateStep(klaimStep)) klaimGoToStep(klaimStep + 1);
                return;
            }

            const files = $('#ajuanBukti')[0].files;

            if (files.length < 2) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Minimal 2 foto bukti wajib diunggah.',
                });
                return;
            }

            if (files.length > 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Maksimal 5 foto bukti yang bisa diunggah.',
                });
                return;
            }

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Foto ke-' + (i + 1) + ' melebihi 2 MB.',
                    });
                    return;
                }
            }

            const rentalText = $('#ajuanRentalId option:selected').text().trim();
            const jenisText = $('#ajuanJenis option:selected').text().trim();

            Swal.fire({
                title: 'Ajukan klaim ini?',
                html: 'Klaim <strong>' + klaimEsc(jenisText) + '</strong> untuk <strong>' + klaimEsc(rentalText) +
                    '</strong> akan dikirim dan tidak bisa diubah.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, ajukan',
                cancelButtonText: 'Periksa lagi',
            }).then(function(result) {
                if (result.isConfirmed) kirimKlaim(form);
            });
        });

        function kirimKlaim(form) {
            const formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
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
                    klaimRevokeRingkasanUrls();
                    bootstrap.Modal.getInstance($('#ajukanKompensasiModal')[0]).hide();
                    $('#formAjukanKompensasi')[0].reset();
                    $('#formAjukanKompensasi .is-invalid').removeClass('is-invalid');
                    $('#formAjukanKompensasi .invalid-feedback.d-block').removeClass('d-block');
                    $('#buktiPreview').empty();
                    $('#buktiCount').text('0/5 foto dipilih').removeClass('text-danger').addClass('text-muted');
                    $('#buktiReset').addClass('d-none');
                    $('#mobilCard').addClass('d-none');
                    $('#mobilEmpty').removeClass('d-none');
                    klaimGoToStep(1);
                    $('#kompensasis-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message || 'Klaim kompensasi berhasil diajukan.',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                },
                error: function(xhr) {
                    const r = xhr.responseJSON || {};
                    const msg = r.errors ? Object.values(r.errors)[0][0] :
                        (r.message || 'Terjadi kesalahan saat mengajukan klaim.');

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg,
                    });
                }
            });
        }
    </script>

</body>

</html>
