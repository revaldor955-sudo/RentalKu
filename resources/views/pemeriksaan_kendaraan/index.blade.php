<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemeriksaan Kendaraan - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css"
        rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f6f8f7;
            font-family: 'Montserrat', sans-serif;
        }

        .page-content {
            padding: 24px;
        }

        .page-title {
            font-weight: 800;
            color: #1f2937;
        }

        .card-custom {
            background: #fff;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
            overflow: hidden;
        }

        .btn-green {
            background: #198754;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 700;
        }

        .btn-green:hover {
            background: #146c43;
            color: #fff;
        }

        #pemeriksaan-table th {
            font-size: 12px;
            color: #6b7280;
            white-space: nowrap;
            background: #f8faf9;
        }

        #pemeriksaan-table td {
            vertical-align: middle;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-baik {
            color: #0f5132;
            background: #d1e7dd;
        }

        .status-rusak {
            color: #842029;
            background: #f8d7da;
        }

        .badge-jenis {
            display: inline-block;
            background: #e2e8f0;
            color: #334155;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .damage-card {
            height: 100%;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #fff;
        }

        .damage-card:has(.kerusakan-check:checked) {
            border-color: #198754;
            background: #f8fcf9;
        }

        .damage-title {
            font-weight: 700;
            color: #334155;
        }

        .damage-detail {
            border-top: 1px solid #e5e7eb;
            margin-top: 14px;
            padding-top: 14px;
        }

        .saved-photo {
            margin-top: 8px;
            padding: 10px;
            border-radius: 10px;
            background: #f1f5f9;
        }

        .saved-photo img {
            display: block;
            width: 100%;
            max-width: 180px;
            max-height: 130px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .pager-bar {
            background: #fff;
            border: 1px solid #edf0ee;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
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
            opacity: .4;
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
            color: #64748b;
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
            border: 1px solid #dee2e6;
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
            border-bottom: 1px solid #f1f5f9;
            transition: .15s;
        }

        .rental-search-item:last-child {
            border-bottom: none;
        }

        .rental-search-item:hover {
            background: #f0fdf4;
        }

        .rental-search-item.active {
            background: #e8f5ee;
        }

        .rental-search-item .rental-main {
            font-weight: 700;
            color: #1f2937;
            font-size: 13px;
        }

        .rental-search-item .rental-sub {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }

        .rental-search-empty {
            padding: 16px;
            text-align: center;
            font-size: 13px;
            color: #64748b;
        }

        .rental-selected-card {
            display: none;
            margin-top: 10px;
            padding: 12px;
            border: 1px solid #198754;
            background: #f0fdf4;
            border-radius: 12px;
        }

        .rental-selected-card.show {
            display: block;
        }

        .rental-selected-card .selected-title {
            font-size: 12px;
            font-weight: 800;
            color: #166534;
            margin-bottom: 5px;
        }

        .rental-selected-card .selected-main {
            font-size: 13px;
            font-weight: 700;
            color: #1f2937;
        }

        .rental-selected-card .selected-detail {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
        }

        .btn-remove-rental {
            border: 0;
            background: #fee2e2;
            color: #dc2626;
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .btn-remove-rental:hover {
            background: #fecaca;
        }

        .rental-selected-card {
            box-shadow: 0 4px 14px rgba(25, 135, 84, .12);
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

        #pemeriksaanModal {
            overflow: hidden !important;
        }

        #pemeriksaanModal .modal-dialog {
            width: calc(100% - 24px);
            max-width: 1100px;
            height: calc(100dvh - 24px);
            margin: 12px auto;
        }

        #pemeriksaanModal .modal-content {
            height: 100%;
            max-height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 0;
            border-radius: 16px;
        }

        #pemeriksaanModal .modal-header {
            flex: 0 0 auto;
            background: linear-gradient(110deg, #075b3a, #198754);
            color: #fff;
            padding: 18px 24px;
        }

        #pemeriksaanModal .modal-header .modal-title {
            font-weight: 800;
        }

        #pemeriksaanModal .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        #pemeriksaanModal .modal-body {
            flex: 1 1 0;
            min-height: 0;
            height: 0;
            overflow-y: scroll !important;
            overflow-x: hidden;
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
            padding: 22px !important;
        }

        #pemeriksaanModal .modal-footer {
            flex: 0 0 auto;
            padding: 14px 22px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 -3px 10px rgba(0, 0, 0, .03);
            z-index: 2;
        }

        #pemeriksaanModal .form-label {
            font-weight: 700;
        }

        #pemeriksaanModal .section-heading {
            color: #1f2937;
            font-weight: 800;
        }

        @media (max-width: 768px) {
            .page-content {
                padding: 12px;
            }

            #pemeriksaanModal .modal-dialog {
                width: calc(100% - 12px);
                height: calc(100dvh - 12px);
                margin: 6px auto;
            }

            #pemeriksaanModal .modal-body {
                padding: 15px !important;
            }

            #pemeriksaanModal .modal-header,
            #pemeriksaanModal .modal-footer {
                padding: 12px 15px;
            }
        }
    </style>
</head>

<body>

    @include('layouts.partials.sidebar')

    <div class="page-content">
        <div class="container-fluid">

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h2 class="page-title mb-1">Pemeriksaan Kendaraan</h2>
                    <p class="text-muted mb-0">
                        Kelola pemeriksaan kendaraan sebelum dan sesudah penyewaan.
                    </p>
                </div>

                <button type="button" class="btn btn-green" onclick="openTambahModal()">
                    <i class="bi bi-plus-lg me-1"></i>
                    Tambah Pemeriksaan
                </button>
            </div>

            <div class="card-custom">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="pemeriksaan-table">
                        <thead>
                            <tr>
                                <th class="px-3 py-3">No</th>
                                <th>Nama Mobil</th>
                                <th>Jenis</th>
                                <th>Kondisi</th>
                                <th>Tanggal</th>
                                <th>Kerusakan</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3"
                    id="pemeriksaan-pager">

                    <div class="text-secondary small" id="pemeriksaan-info">
                        Menampilkan 0–0 dari 0 data
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <select id="pemeriksaan-len" class="form-select form-select-sm pager-select"
                            aria-label="Jumlah per halaman">
                            <option value="10">10 / halaman</option>
                            <option value="20">20 / halaman</option>
                            <option value="50">50 / halaman</option>
                            <option value="100">100 / halaman</option>
                            <option value="custom">Custom</option>
                        </select>

                        <input type="number" id="pemeriksaan-custom" class="form-control form-control-sm pager-jump"
                            min="1" max="500" value="10" aria-label="Jumlah custom per halaman">

                        <span class="text-secondary" id="pemeriksaan-page">
                            Halaman 1 / 1
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm pager-btn" id="pemeriksaan-first">First</button>

                        <button type="button" class="btn btn-sm pager-btn" id="pemeriksaan-prev"
                            aria-label="Halaman sebelumnya">
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <button type="button" class="btn btn-sm pager-btn pager-next" id="pemeriksaan-next"
                            aria-label="Halaman berikutnya">
                            <i class="bi bi-chevron-right"></i>
                        </button>

                        <button type="button" class="btn btn-sm pager-btn" id="pemeriksaan-last">Last</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="pemeriksaanModal" tabindex="-1" aria-labelledby="pemeriksaanModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="pemeriksaanModalLabel">
                        <i class="bi bi-clipboard-check me-2"></i>
                        Tambah Pemeriksaan
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <form id="formPemeriksaan" enctype="multipart/form-data"
                    style="display:flex;flex-direction:column;flex:1;min-height:0;overflow:hidden">

                    <div class="modal-body">
                        <input type="hidden" id="pemeriksaanId" name="id">
                        <input type="hidden" id="rentalId" name="rental_id">

                        @if ($rentals->isEmpty())
                            <div class="alert alert-warning mb-3">
                                Belum ada rental berstatus Disetujui atau Selesai. Setujui rental terlebih dahulu.
                            </div>
                        @endif

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="mobilId" class="form-label">Nama Mobil</label>
                                <select name="mobil_id" id="mobilId" class="form-select" required>
                                    <option value="">-- Pilih Nama Mobil --</option>
                                    @foreach ($mobils as $mobil)
                                        <option value="{{ $mobil->id }}" data-kode="{{ $mobil->kode_unit }}">
                                            {{ $mobil->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="kodeUnit" class="form-label">Kode Unit Mobil</label>
                                <input type="text" id="kodeUnit" class="form-control"
                                    placeholder="Kode unit otomatis muncul" readonly>
                            </div>

                            <div class="col-md-12">
                                <label for="rentalSearch" class="form-label">Rental</label>

                                <div class="rental-search-wrapper">
                                    <div class="rental-search-box">
                                        <input type="text" id="rentalSearch" class="form-control"
                                            placeholder="Cari nama pelanggan, mobil, plat, atau rental..."
                                            autocomplete="off" disabled>

                                        <i class="bi bi-search rental-search-icon"></i>
                                    </div>

                                    <div id="rentalSearchResults" class="rental-search-results"></div>
                                </div>

                                <div id="rentalSelectedCard" class="rental-selected-card">
                                    <div class="d-flex align-items-start justify-content-between gap-2">
                                        <div class="flex-grow-1">
                                            <div class="selected-title">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                Rental Terpilih
                                            </div>

                                            <div class="selected-main" id="rentalSelectedMain"></div>
                                            <div class="selected-detail" id="rentalSelectedDetail"></div>
                                        </div>

                                        <button type="button" class="btn-remove-rental" id="btnRemoveRental"
                                            title="Hapus pilihan rental">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-text" id="rentalHelp">
                                    Pilih nama mobil terlebih dahulu untuk mencari rental.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="tanggal" class="form-label">Tanggal Pemeriksaan</label>
                                <input type="datetime-local" name="tanggal" id="tanggal" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label for="jenis" class="form-label">Jenis Pemeriksaan</label>
                                <select name="jenis" id="jenis" class="form-select" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="sebelum_sewa">Sebelum Sewa</option>
                                    <option value="setelah_sewa">Setelah Sewa</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="kondisi" class="form-label">Kondisi Kendaraan</label>
                                <select name="kondisi" id="kondisi" class="form-select" required>
                                    <option value="">-- Pilih Kondisi --</option>
                                    <option value="baik">Baik</option>
                                    <option value="rusak">Rusak</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4">
                                <p class="text-muted small mt-2">
                                    Pilih bagian yang diperiksa. Setiap bagian memiliki keterangan,
                                    catatan, dan foto bukti sendiri.
                                </p>
                            </div>

                            <div class="col-12">
                                <div class="row g-3">
                                    @foreach ($kerusakanList as $kerusakan)
                                        <div class="col-md-6 col-xl-4">
                                            <div class="damage-card">

                                                <div class="form-check">
                                                    <input class="form-check-input kerusakan-check" type="checkbox"
                                                        name="kerusakan[]" value="{{ $kerusakan->id }}"
                                                        id="kerusakan-{{ $kerusakan->id }}">

                                                    <label class="form-check-label damage-title"
                                                        for="kerusakan-{{ $kerusakan->id }}">
                                                        {{ $kerusakan->jenis_kerusakan }}
                                                    </label>
                                                </div>

                                                <div class="damage-detail d-none"
                                                    id="detail-kerusakan-{{ $kerusakan->id }}">

                                                    <div class="mb-3">
                                                        <label class="form-label small">Keterangan Bagian</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="keterangan[{{ $kerusakan->id }}]" maxlength="1000"
                                                            placeholder="Keterangan bagian" disabled>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label small">Catatan Bagian</label>
                                                        <textarea class="form-control form-control-sm" name="catatan_kerusakan[{{ $kerusakan->id }}]" rows="3"
                                                            maxlength="1000" placeholder="Catatan bagian ini" disabled></textarea>
                                                    </div>

                                                    <div>
                                                        <label class="form-label small">Foto Bukti Bagian</label>
                                                        <input type="file"
                                                            class="form-control form-control-sm foto-kerusakan-input"
                                                            name="foto_kerusakan[{{ $kerusakan->id }}]"
                                                            accept=".jpg,.jpeg,.png" disabled>

                                                        <div class="form-text">JPG/PNG, maksimal 2 MB.</div>

                                                        <div class="saved-photo d-none"
                                                            id="foto-lama-{{ $kerusakan->id }}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <hr>
                                <h5 class="section-heading">Catatan Umum dan Bukti</h5>
                                <p class="text-muted small">
                                    Informasi tambahan untuk keseluruhan kendaraan.
                                </p>
                            </div>

                            <div class="col-md-6">
                                <label for="catatan" class="form-label">Catatan Umum</label>

                                <textarea name="catatan" id="catatan" class="form-control" rows="3" maxlength="1000"
                                    placeholder="Catatan keseluruhan pemeriksaan"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="fotoBukti" class="form-label">Foto Bukti Umum (opsional)</label>

                                <input type="file" name="foto_bukti" id="fotoBukti" class="form-control"
                                    accept=".jpg,.jpeg,.png">

                                <div class="form-text">JPG/PNG, maksimal 2 MB.</div>

                                <div id="fotoBuktiLama" class="saved-photo d-none">
                                    <div class="small fw-bold mb-2">Foto bukti yang tersimpan</div>

                                    <img id="previewFotoBuktiLama" src=""
                                        alt="Foto bukti pemeriksaan sebelumnya">

                                    <a id="linkFotoBuktiLama" href="" target="_blank"
                                        rel="noopener noreferrer" class="small">Lihat foto</a>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-green" id="btnSimpanPemeriksaan">
                            <i class="bi bi-save me-1"></i>
                            Simpan Pemeriksaan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

    @php
        $rentalOptions = $rentals
            ->map(function ($rental) {
                return [
                    'id' => $rental->id,
                    'mobil_id' => $rental->mobil_id,
                    'kode' => $rental->mobil?->kode_unit ?? '',
                    'mobil' => $rental->mobil?->name ?? '-',
                    'plat' =>
                        $rental->mobil?->plat_nomor ??
                        ($rental->mobil?->nomor_plat ?? ($rental->mobil?->plate_number ?? '')),
                    'pelanggan' => $rental->user?->name ?? '-',
                    'status' => $rental->status,
                    'mulai' => $rental->tanggal_mulai?->format('d/m/Y') ?? '-',
                    'selesai' => $rental->tanggal_selesai?->format('d/m/Y') ?? '-',
                    'jumlah_hari' => (int) $rental->jumlah_hari,
                    'harga_perhari' => (float) $rental->harga_perhari,
                    'deposit' => (float) $rental->deposit,
                    'total_harga' => (float) $rental->total_harga,
                    'label' =>
                        'Rental #' .
                        $rental->id .
                        ' — ' .
                        ($rental->user?->name ?? '-') .
                        ' — ' .
                        ($rental->mobil?->name ?? '-') .
                        ' — ' .
                        $rental->status .
                        ' — ' .
                        ($rental->tanggal_mulai?->format('d/m/Y') ?? '-') .
                        ' s/d ' .
                        ($rental->tanggal_selesai?->format('d/m/Y') ?? '-'),
                ];
            })
            ->values();
    @endphp

    <script>
        const CSRF_TOKEN = @json(csrf_token());
        const URL_DATA = @json(route('pemeriksaan-kendaraan.data'));
        const URL_STORE = @json(route('pemeriksaan-kendaraan.store'));
        const URL_UPDATE = @json(route('pemeriksaan-kendaraan.update', '__ID__'));
        const URL_DESTROY = @json(route('pemeriksaan-kendaraan.destroy', '__ID__'));
        const STORAGE_URL = @json(asset('storage'));

        const RENTALS = {!! json_encode($rentalOptions, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};

        let selectedRental = null;

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            } [char]));
        }

        function formatRupiah(value) {
            return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
        }

        function getRentalById(id) {
            return RENTALS.find(item => String(item.id) === String(id));
        }

        function getRentalListByMobil(mobilId) {
            return RENTALS.filter(item => String(item.mobil_id) === String(mobilId));
        }

        function isiKodeUnit() {
            if (selectedRental) {
                $('#kodeUnit').val(selectedRental.kode || '');
                return;
            }

            $('#kodeUnit').val(
                $('#mobilId').find(':selected').data('kode') || ''
            );
        }

        function renderRentalSelected(rental) {
            selectedRental = rental || null;

            $('#rentalId').val(rental ? rental.id : '');

            if (!rental) {
                $('#rentalSelectedCard').removeClass('show');
                $('#rentalSelectedMain').empty();
                $('#rentalSelectedDetail').empty();
                isiKodeUnit();
                return;
            }

            const $main = $('#rentalSelectedMain').empty();
            const $head = $('<div class="rc-head">').appendTo($main);
            $('<div class="rc-avatar"><i class="bi bi-person-fill"></i></div>').appendTo($head);

            const $info = $('<div>').appendTo($head);
            $('<div class="rc-name">').text(rental.pelanggan).appendTo($info);

            const $idRow = $('<div class="rc-id">').appendTo($info);
            $('<span>').text('Rental #' + rental.id).appendTo($idRow);
            $('<span class="rc-badge">')
                .toggleClass('status-selesai', rental.status === 'Selesai')
                .text(rental.status)
                .appendTo($idRow);

            const $detail = $('#rentalSelectedDetail').empty();
            const $meta = $('<div class="rc-meta">').appendTo($detail);

            const metaRow = (icon, text) => {
                const $row = $('<div class="rc-meta-row">').appendTo($meta);
                $('<i>').addClass('bi ' + icon).appendTo($row);
                $('<span>').text(text).appendTo($row);
            };

            metaRow('bi-car-front-fill', rental.mobil + ' • ' + (rental.plat || 'Plat belum tersedia'));
            metaRow('bi-calendar-range',
                rental.mulai + ' s/d ' + rental.selesai +
                (rental.jumlah_hari ? ' • ' + rental.jumlah_hari + ' hari' : ''));

            if (rental.harga_perhari !== undefined) {
                const $stats = $('<div class="rc-stats">').appendTo($detail);
                const stat = (label, value, extra) => {
                    const $s = $('<div class="rc-stat">').addClass(extra || '').appendTo($stats);
                    $('<div class="rc-stat-label">').text(label).appendTo($s);
                    $('<div class="rc-stat-value">').text(value).appendTo($s);
                };
                stat('Harga / hari', formatRupiah(rental.harga_perhari));
                stat('Total', formatRupiah(rental.total_harga), 'total');
                stat('Deposit', formatRupiah(rental.deposit));
            }

            $('#rentalSelectedCard').addClass('show');
            $('#rentalSearch').val('');
            $('#rentalSearchResults').removeClass('show').empty();

            isiKodeUnit();
        }

        function renderRentalSearchResults(keyword = '') {
            const mobilId = $('#mobilId').val();
            const resultContainer = $('#rentalSearchResults');

            if (!mobilId) {
                resultContainer.removeClass('show').empty();
                return;
            }

            const normalizedKeyword = keyword.toLowerCase().trim();

            const rentals = getRentalListByMobil(mobilId).filter(item => {
                const searchable = [
                    item.id,
                    item.pelanggan,
                    item.mobil,
                    item.plat,
                    item.status,
                    item.mulai,
                    item.selesai,
                    item.label
                ].join(' ').toLowerCase();

                return searchable.includes(normalizedKeyword);
            });

            if (!rentals.length) {
                resultContainer.html(
                    '<div class="rental-search-empty">' +
                    '<i class="bi bi-search me-1"></i>' +
                    'Rental tidak ditemukan.' +
                    '</div>'
                ).addClass('show');

                return;
            }

            const html = rentals.map(item => {
                const active = selectedRental &&
                    String(selectedRental.id) === String(item.id);

                return `
            <div class="rental-search-item ${active ? 'active' : ''}"
                 data-rental-id="${Number(item.id)}">

                <div class="rental-main">
                    Rental #${Number(item.id)} — ${escapeHtml(item.pelanggan)}
                </div>

                <div class="rental-sub">
                    ${escapeHtml(item.mobil)}
                    ${item.plat ? ' • ' + escapeHtml(item.plat) : ''}
                    • ${escapeHtml(item.status)}
                </div>

                <div class="rental-sub">
                    ${escapeHtml(item.mulai)} s/d ${escapeHtml(item.selesai)}
                </div>
            </div>
        `;
            }).join('');

            resultContainer.html(html).addClass('show');
        }

        function isiPilihanRental(mobilId, selectedId = '') {
            const searchInput = $('#rentalSearch');
            const help = $('#rentalHelp');

            renderRentalSelected(null);

            searchInput.val('');
            $('#rentalSearchResults').removeClass('show').empty();

            if (!mobilId) {
                searchInput.prop('disabled', true);
                searchInput.attr('placeholder', 'Pilih nama mobil dahulu');
                help.text('Pilih nama mobil terlebih dahulu untuk mencari rental.')
                    .removeClass('text-danger');

                isiKodeUnit();
                return;
            }

            const options = getRentalListByMobil(mobilId);

            searchInput.prop('disabled', options.length === 0);
            searchInput.attr(
                'placeholder',
                options.length ?
                'Cari nama pelanggan, mobil, plat, atau rental...' :
                'Tidak ada rental untuk mobil ini'
            );

            if (options.length === 0) {
                help.text('Belum ada rental Disetujui/Selesai untuk mobil ini.')
                    .addClass('text-danger');

                isiKodeUnit();
                return;
            }

            help.text('Cari dan pilih rental yang sesuai dengan mobil.')
                .removeClass('text-danger');

            if (selectedId) {
                const rental = getRentalById(selectedId);

                if (rental && String(rental.mobil_id) === String(mobilId)) {
                    renderRentalSelected(rental);
                } else {
                    renderRentalSelected({
                        id: selectedId,
                        mobil_id: mobilId,
                        kode: $('#mobilId').find(':selected').data('kode') || '',
                        mobil: $('#mobilId').find(':selected').text().trim(),
                        plat: '',
                        pelanggan: 'Rental tidak tersedia',
                        status: 'Tidak tersedia',
                        mulai: '-',
                        selesai: '-'
                    });
                }
            }

            isiKodeUnit();
        }

        $('#mobilId').on('change', function() {
            isiPilihanRental(this.value);
        });

        $('#rentalSearch').on('focus', function() {
            if (!selectedRental && $('#mobilId').val()) {
                renderRentalSearchResults($(this).val());
            }
        });

        $('#rentalSearch').on('input', function() {
            if (selectedRental) {
                renderRentalSelected(null);
            }

            renderRentalSearchResults(this.value);
        });

        $(document).on('click', '.rental-search-item', function() {
            const id = $(this).data('rental-id');
            const rental = getRentalById(id);

            if (rental) {
                renderRentalSelected(rental);
            }
        });

        $('#btnRemoveRental').on('click', function() {
            renderRentalSelected(null);
            $('#rentalSearch').prop('disabled', false).val('').focus();
            renderRentalSearchResults('');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.rental-search-wrapper').length) {
                $('#rentalSearchResults').removeClass('show');
            }
        });

        function resetForm() {
            document.getElementById('formPemeriksaan').reset();

            $('#pemeriksaanId').val('');
            $('#rentalId').val('');
            selectedRental = null;

            isiPilihanRental('');
            $('#kodeUnit').val('');

            $('.kerusakan-check').prop('checked', false);

            $('[id^="detail-kerusakan-"]')
                .addClass('d-none')
                .find('input, textarea')
                .prop('disabled', true);

            $('#previewFotoBuktiLama').attr('src', '');
            $('#linkFotoBuktiLama').attr('href', '');
            $('#fotoBuktiLama').addClass('d-none');

            $('.saved-photo')
                .not('#fotoBuktiLama')
                .addClass('d-none')
                .empty();
        }

        function openTambahModal() {
            resetForm();

            $('#pemeriksaanModalLabel').html(
                '<i class="bi bi-clipboard-check me-2"></i>Tambah Pemeriksaan'
            );

            $('#btnSimpanPemeriksaan').html(
                '<i class="bi bi-save me-1"></i>Simpan Pemeriksaan'
            );

            const modalElement = document.getElementById('pemeriksaanModal');

            bootstrap.Modal.getOrCreateInstance(modalElement).show();

            setTimeout(() => {
                const body = modalElement.querySelector('.modal-body');

                if (body) {
                    body.scrollTop = 0;
                }
            }, 100);
        }

        function renderSavedPhoto(container, url) {
            container.empty();

            if (!url) {
                container.addClass('d-none');
                return;
            }

            $('<div class="small fw-bold mb-2">')
                .text('Foto yang tersimpan')
                .appendTo(container);

            $('<img>')
                .attr('src', url)
                .attr('alt', 'Foto bukti tersimpan')
                .appendTo(container);

            $('<a>')
                .attr('href', url)
                .attr('target', '_blank')
                .attr('rel', 'noopener noreferrer')
                .addClass('small')
                .text('Lihat foto')
                .appendTo(container);

            container.removeClass('d-none');
        }

        function buatUrlFoto(path) {
            if (!path) return '';

            if (/^https?:\/\//i.test(path)) {
                return path;
            }

            if (path.startsWith('/')) {
                return window.location.origin + path;
            }

            return STORAGE_URL + '/' + path.replace(/^\/+/, '');
        }

        function openEditModal(id) {
            const table = $('#pemeriksaan-table').DataTable();

            const row = table.rows().data().toArray()
                .find(item => Number(item.id) === Number(id));

            if (!row) {
                Swal.fire(
                    'Data tidak ditemukan',
                    'Silakan muat ulang halaman.',
                    'warning'
                );
                return;
            }

            resetForm();

            $('#pemeriksaanId').val(row.id);
            $('#mobilId').val(row.mobil_id);
            isiPilihanRental(row.mobil_id, row.rental_id);

            if (!$('#kodeUnit').val()) {
                $('#kodeUnit').val(row.mobil_kode || '');
            }

            $('#jenis').val(row.jenis);
            $('#kondisi').val(row.kondisi);
            $('#catatan').val(row.catatan || '');

            const fotoLama = row.foto_bukti_url || row.foto_bukti || '';
            const fotoUrl = buatUrlFoto(fotoLama);

            if (fotoUrl) {
                $('#previewFotoBuktiLama')
                    .attr('src', fotoUrl)
                    .off('error')
                    .on('error', function() {
                        $(this).attr('alt', 'Foto tidak dapat dimuat.');
                    });

                $('#linkFotoBuktiLama').attr('href', fotoUrl);
                $('#fotoBuktiLama').removeClass('d-none');
            } else {
                $('#previewFotoBuktiLama').attr('src', '');
                $('#linkFotoBuktiLama').attr('href', '');
                $('#fotoBuktiLama').addClass('d-none');
            }

            if (row.tanggal_input) {
                $('#tanggal').val(row.tanggal_input);
            }

            $('#pemeriksaanModalLabel').html(
                '<i class="bi bi-pencil-square me-2"></i>Edit Pemeriksaan'
            );

            $('#btnSimpanPemeriksaan').html(
                '<i class="bi bi-save me-1"></i>Simpan Perubahan'
            );

            (row.kerusakan_ids || []).forEach(function(damageId) {
                const key = String(damageId);
                const detail = (row.detail_kerusakan || {})[key] || {};
                const panel = $('#detail-kerusakan-' + key);

                $('#kerusakan-' + key).prop('checked', true);

                panel.removeClass('d-none')
                    .find('input, textarea')
                    .prop('disabled', false);

                panel.find(`[name="keterangan[${key}]"]`)
                    .val(detail.keterangan || '');

                panel.find(`[name="catatan_kerusakan[${key}]"]`)
                    .val(detail.catatan || '');

                const photoUrl = buatUrlFoto(detail.foto_url || '');

                renderSavedPhoto($('#foto-lama-' + key), photoUrl);
            });

            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('pemeriksaanModal')
            ).show();
        }

        $(document).on('change', '.kerusakan-check', function() {
            const key = String(this.value);
            const panel = $('#detail-kerusakan-' + key);

            panel.toggleClass('d-none', !this.checked);

            panel.find('input, textarea').prop('disabled', !this.checked);

            if (!this.checked) {
                panel.find('input[type="text"], textarea, input[type="file"]').val('');
                $('#foto-lama-' + key).addClass('d-none').empty();
            }
        });

        function hapusPemeriksaan(id) {
            Swal.fire({
                title: 'Hapus Pemeriksaan?',
                text: 'Data pemeriksaan akan dihapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545'
            }).then(result => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: URL_DESTROY.replace('__ID__', id),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    },

                    success: function(response) {
                        $('#pemeriksaan-table').DataTable().ajax.reload(null, false);

                        Swal.fire(
                            'Berhasil',
                            response.message || 'Data berhasil dihapus.',
                            'success'
                        );
                    },

                    error: function(xhr) {
                        Swal.fire(
                            'Gagal',
                            xhr.responseJSON?.message || 'Data gagal dihapus.',
                            'error'
                        );
                    }
                });
            });
        }

        $('#formPemeriksaan').on('submit', function(e) {
            e.preventDefault();

            const form = this;

            if (!form.reportValidity()) return;

            if (!$('#rentalId').val()) {
                Swal.fire(
                    'Rental belum dipilih',
                    'Cari dan pilih rental yang sesuai dengan nama mobil.',
                    'warning'
                );
                return;
            }

            const id = $('#pemeriksaanId').val();
            const formData = new FormData(form);

            const url = id ?
                URL_UPDATE.replace('__ID__', id) :
                URL_STORE;

            if (id) {
                formData.append('_method', 'PUT');
            }

            const button = $('#btnSimpanPemeriksaan');
            const originalHtml = button.html();

            button.prop('disabled', true).text('Menyimpan...');

            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                data: formData,
                processData: false,
                contentType: false,

                success: function(response) {
                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('pemeriksaanModal')
                    ).hide();

                    $('#pemeriksaan-table').DataTable().ajax.reload(null, false);

                    Swal.fire(
                        'Berhasil',
                        response.message || 'Pemeriksaan berhasil disimpan.',
                        'success'
                    );
                },

                error: function(xhr) {
                    const response = xhr.responseJSON || {};

                    const errorMessage = response.errors ?
                        Object.values(response.errors).flat()[0] :
                        response.message;

                    Swal.fire(
                        'Gagal menyimpan',
                        errorMessage || 'Terjadi kesalahan. Periksa kembali data yang dimasukkan.',
                        'error'
                    );
                },

                complete: function() {
                    button.prop('disabled', false).html(originalHtml);
                }
            });
        });

        $(document).ready(function() {
            const table = $('#pemeriksaan-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                lengthChange: false,
                searching: true,
                info: false,
                dom: 'frt',
                order: [],

                ajax: {
                    url: URL_DATA,
                    type: 'GET'
                },

                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: (data, type, row, meta) =>
                            meta.row + meta.settings._iDisplayStart + 1
                    },
                    {
                        data: 'mobil_name',
                        orderable: false,
                        render: (data, type, row) => {
                            const rental = row.rental_id ?
                                `Rental #${Number(row.rental_id)} · ${escapeHtml(row.rental_user_name || '-')}` :
                                'Tanpa rental';

                            return `<strong>${escapeHtml(data)}</strong><br>
                        <small class="text-muted">${escapeHtml(row.mobil_plate)}</small><br>
                        <small class="text-muted">${rental}</small>`;
                        }
                    },
                    {
                        data: 'jenis',
                        orderable: false,
                        render: data =>
                            `<span class="badge-jenis">${data === 'sebelum_sewa' ? 'Sebelum Sewa' : 'Setelah Sewa'}</span>`
                    },
                    {
                        data: 'kondisi',
                        orderable: false,
                        render: data => data === 'baik' ?
                            '<span class="status status-baik">Baik</span>' :
                            '<span class="status status-rusak">Rusak</span>'
                    },
                    {
                        data: 'tanggal',
                        orderable: false
                    },
                    {
                        data: 'kerusakan',
                        orderable: false,
                        render: data => {
                            if (!data || !data.length) return '-';

                            return data.map(item =>
                                `<span class="badge bg-danger me-1">${escapeHtml(item)}</span>`
                            ).join(' ');
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-end',
                        render: (data, type, row) =>
                            `<button type="button" class="btn btn-sm text-primary"
                        onclick="openEditModal(${Number(row.id)})" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-sm text-danger"
                        onclick="hapusPemeriksaan(${Number(row.id)})" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>`
                    }
                ],

                language: {
                    processing: 'Memproses...',
                    search: 'Cari:',
                    searchPlaceholder: 'Cari data pemeriksaan...',
                    zeroRecords: 'Data tidak ditemukan',
                    emptyTable: 'Belum ada data pemeriksaan',
                    paginate: {
                        first: 'Pertama',
                        last: 'Terakhir',
                        next: 'Berikutnya',
                        previous: 'Sebelumnya'
                    }
                }
            });

            function renderPemeriksaanPager() {
                const info = table.page.info();

                const total = info.recordsDisplay;
                const start = total ? info.start + 1 : 0;
                const end = total ? info.end : 0;
                const pages = info.pages || 1;
                const page = total ? info.page + 1 : 0;

                $('#pemeriksaan-info').text(
                    'Menampilkan ' + start + '–' + end + ' dari ' + total + ' data'
                );

                $('#pemeriksaan-page').text(
                    'Halaman ' + page + ' / ' + pages
                );

                $('#pemeriksaan-first, #pemeriksaan-prev')
                    .toggleClass('disabled', info.page <= 0);

                $('#pemeriksaan-next, #pemeriksaan-last')
                    .toggleClass('disabled', info.page >= pages - 1 || total === 0);
            }

            table.on('draw.dt', renderPemeriksaanPager);

            $('#pemeriksaan-first').on('click', function() {
                table.page('first').draw('page');
            });

            $('#pemeriksaan-prev').on('click', function() {
                table.page('previous').draw('page');
            });

            $('#pemeriksaan-next').on('click', function() {
                table.page('next').draw('page');
            });

            $('#pemeriksaan-last').on('click', function() {
                table.page('last').draw('page');
            });

            $('#pemeriksaan-len').on('change', function() {
                if ($(this).val() === 'custom') {
                    $('#pemeriksaan-custom').focus();
                    return;
                }

                const jumlah = Number($(this).val());

                $('#pemeriksaan-custom').val(jumlah);
                table.page.len(jumlah).draw();
            });

            $('#pemeriksaan-custom').on('change', function() {
                let jumlah = parseInt($(this).val(), 10) || 1;
                jumlah = Math.min(Math.max(jumlah, 1), 500);

                $(this).val(jumlah);

                if (['10', '20', '50', '100'].includes(String(jumlah))) {
                    $('#pemeriksaan-len').val(String(jumlah));
                } else {
                    $('#pemeriksaan-len').val('custom');
                }

                table.page.len(jumlah).draw();
            });

            renderPemeriksaanPager();
        });
    </script>

</body>

</html>
