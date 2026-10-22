<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengembalian Mobil - RentalKu</title>

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
            background: #fff;
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
        }

        .table th {
            font-size: 12px;
            color: #6b7280;
            white-space: nowrap;
            text-transform: uppercase;
            background: #f8faf9;
            border-bottom: 1px solid #e9ecef;
        }

        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            padding: 12px 16px;
        }

        #pengembalian-table thead .dt-column-order {
            display: none !important;
        }

        .pager-bar {
            background: #fff;
            border: 1px solid #edf0ee;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
            padding: 12px 16px;
            font-size: 14px;
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

        .page-content {
            padding: 24px;
        }

        .detail-label {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            overflow-wrap: anywhere;
        }

        .detail-item {
            background: #f8faf9;
            border: 1px solid #edf0ee;
            border-radius: 12px;
            padding: 13px;
            height: 100%;
        }

        .detail-heading {
            font-weight: 800;
            font-size: 15px;
            color: #2C666E;
            margin-bottom: 15px;
        }

        .modal-content {
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }

        .modal-header-custom {
            background: #2C666E;
            color: #fff;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="page-title mb-1">Pengembalian Mobil</h2>
                <p class="text-muted mb-0">
                    Lihat detail rental dan proses pengembalian kendaraan pelanggan.
                </p>
            </div>
        </div>

        <div class="card-custom">
            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-hover mb-0" id="pengembalian-table">
                        <thead>
                            <tr>
                                <th class="px-3 py-3">No</th>
                                <th>Pelanggan</th>
                                <th>Mobil</th>
                                <th>Tanggal Sewa</th>
                                <th>Hari</th>
                                <th>Total</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3"
                        id="pengembalian-pager">

                        <div class="text-secondary small" id="pengembalian-info">
                            Menampilkan 0–0 dari 0 data
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <select id="pengembalian-len"
                                class="form-select form-select-sm pager-select"
                                aria-label="Jumlah per halaman">
                                <option value="10">10 / halaman</option>
                                <option value="20">20 / halaman</option>
                                <option value="50">50 / halaman</option>
                                <option value="100">100 / halaman</option>
                                <option value="custom">Custom</option>
                            </select>

                            <input type="number" id="pengembalian-custom"
                                class="form-control form-control-sm pager-jump"
                                min="1" max="500" value="10"
                                aria-label="Jumlah custom per halaman">

                            <span class="text-secondary" id="pengembalian-page">
                                Halaman 1 / 1
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm pager-btn"
                                id="pengembalian-first">First</button>

                            <button type="button" class="btn btn-sm pager-btn"
                                id="pengembalian-prev" aria-label="Halaman sebelumnya">
                                <i class="bi bi-chevron-left"></i>
                            </button>

                            <button type="button" class="btn btn-sm pager-btn pager-next"
                                id="pengembalian-next" aria-label="Halaman berikutnya">
                                <i class="bi bi-chevron-right"></i>
                            </button>

                            <button type="button" class="btn btn-sm pager-btn"
                                id="pengembalian-last">Last</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL DETAIL RENTAL -->
<div class="modal fade" id="pengembalianDetailModal" tabindex="-1"
    aria-labelledby="pengembalianDetailTitle" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header modal-header-custom p-4">
                <div>
                    <h5 class="modal-title fw-bold" id="pengembalianDetailTitle">
                        <i class="bi bi-file-earmark-text me-2"></i>Detail Rental
                    </h5>
                    <small>Informasi lengkap penyewaan kendaraan</small>
                </div>

                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body p-4">

                <div id="pengembalianDetailLoading" class="text-center py-5">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="text-muted mt-3 mb-0">Memuat detail rental...</p>
                </div>

                <div id="pengembalianDetailContent" class="d-none">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div>
                            <span class="detail-label">Nomor Rental</span>
                            <h5 class="fw-bold mb-0" id="rd-id">-</h5>
                        </div>
                        <div>
                            <span class="detail-label">Status Rental</span>
                            <span class="badge bg-success-subtle text-success fs-6"
                                id="rd-status">-</span>
                        </div>
                    </div>

                    <div class="detail-heading">
                        <i class="bi bi-person-circle me-2"></i>Data Pelanggan
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Nama Pelanggan</span>
                                <div class="detail-value" id="rd-pelanggan">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Email</span>
                                <div class="detail-value" id="rd-email">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Nomor Telepon</span>
                                <div class="detail-value" id="rd-telepon">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Alamat</span>
                                <div class="detail-value" id="rd-alamat">-</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="detail-heading">
                        <i class="bi bi-car-front-fill me-2"></i>Detail Penyewaan
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Mobil</span>
                                <div class="detail-value" id="rd-mobil">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Nomor Polisi</span>
                                <div class="detail-value" id="rd-plat">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Tanggal Mulai</span>
                                <div class="detail-value" id="rd-mulai">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Tanggal Selesai</span>
                                <div class="detail-value" id="rd-selesai">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Durasi Sewa</span>
                                <div class="detail-value" id="rd-hari">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Harga per Hari</span>
                                <div class="detail-value" id="rd-harga">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Cabang Pengambilan</span>
                                <div class="detail-value" id="rd-cabang-ambil">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Cabang Pengembalian</span>
                                <div class="detail-value" id="rd-cabang-kembali">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Supir</span>
                                <div class="detail-value" id="rd-supir">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">Catatan</span>
                                <div class="detail-value" id="rd-catatan">-</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="detail-heading">
                        <i class="bi bi-receipt me-2"></i>Rincian Biaya
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <td>Subtotal Sewa</td>
                                    <td class="text-end" id="rd-subtotal">-</td>
                                </tr>
                                <tr>
                                    <td>Deposit</td>
                                    <td class="text-end" id="rd-deposit">-</td>
                                </tr>
                                <tr>
                                    <td>Kode Promo</td>
                                    <td class="text-end" id="rd-promo">-</td>
                                </tr>
                                <tr>
                                    <td>Diskon</td>
                                    <td class="text-end" id="rd-diskon">-</td>
                                </tr>
                                <tr class="table-light fw-bold">
                                    <td>Total Rental</td>
                                    <td class="text-end text-success" id="rd-total">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="detail-heading">
                        <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="detail-item">
                                <span class="detail-label">Metode Pembayaran</span>
                                <div class="detail-value" id="rd-metode">-</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <span class="detail-label">Status Pembayaran</span>
                                <div class="detail-value" id="rd-status-bayar">-</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <span class="detail-label">Jumlah Pembayaran</span>
                                <div class="detail-value" id="rd-jumlah-bayar">-</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="pengembalianDetailError" class="alert alert-danger d-none mb-0"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Tutup</button>
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

    function formatRupiah(value) {
        return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
    }

    function escapeHtml(value) {
        return String(value ?? '-').replace(/[&<>"']/g, function(char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    // Menampilkan detail rental
    function openPengembalianDetail(id) {
        const modalElement = document.getElementById('pengembalianDetailModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

        $('#pengembalianDetailLoading').removeClass('d-none');
        $('#pengembalianDetailContent').addClass('d-none');
        $('#pengembalianDetailError').addClass('d-none').text('');

        modal.show();

        const url = "{{ route('pengembalian.detail', '__ID__') }}"
            .replace('__ID__', encodeURIComponent(id));

        $.ajax({
            url: url,
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            },

            success: function(data) {
                const isi = function(elementId, value) {
                    document.getElementById(elementId).textContent =
                        value === null || value === undefined || value === ''
                            ? '-'
                            : value;
                };

                isi('rd-id', 'Rental #' + data.id);
                isi('rd-status', data.status);
                isi('rd-pelanggan', data.pelanggan);
                isi('rd-email', data.email);
                isi('rd-telepon', data.telepon);
                isi('rd-alamat', data.alamat);
                isi('rd-mobil', data.mobil);
                isi('rd-plat', data.plat);
                isi('rd-mulai', data.tanggal_mulai);
                isi('rd-selesai', data.tanggal_selesai);
                isi('rd-hari', data.jumlah_hari + ' hari');
                isi('rd-harga', formatRupiah(data.harga_perhari));
                isi('rd-cabang-ambil', data.cabang_ambil);
                isi('rd-cabang-kembali', data.cabang_kembali);

                isi(
                    'rd-supir',
                    Array.isArray(data.supirs) && data.supirs.length
                        ? data.supirs.join(', ')
                        : 'Tanpa supir'
                );

                isi('rd-catatan', data.catatan);
                isi('rd-subtotal', formatRupiah(data.subtotal));
                isi('rd-deposit', formatRupiah(data.deposit));
                isi('rd-promo', data.kode_promo);
                isi('rd-diskon', formatRupiah(data.diskon));
                isi('rd-total', formatRupiah(data.total_harga));

                const pembayaran = data.pembayaran;

                isi('rd-metode', pembayaran?.metode ?? '-');
                isi(
                    'rd-status-bayar',
                    pembayaran?.status ?? 'Belum ada pembayaran'
                );
                isi(
                    'rd-jumlah-bayar',
                    pembayaran ? formatRupiah(pembayaran.jumlah) : '-'
                );

                $('#pengembalianDetailLoading').addClass('d-none');
                $('#pengembalianDetailContent').removeClass('d-none');
            },

            error: function(xhr) {
                $('#pengembalianDetailLoading').addClass('d-none');

                const message = xhr.responseJSON?.message
                    || 'Detail rental gagal dimuat. Periksa controller dan relasi model.';

                $('#pengembalianDetailError')
                    .text(message)
                    .removeClass('d-none');
            }
        });
    }

    // Memproses pengembalian
    function prosesPengembalian(id, mobil) {
        Swal.fire({
            title: 'Proses Pengembalian?',
            text: 'Mobil ' + mobil + ' akan ditandai selesai dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kembalikan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('rentals.updateStatus', '__ID__') }}"
                    .replace('__ID__', encodeURIComponent(id)),
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                data: {
                    status: 'Selesai'
                },

                success: function(res) {
                    $('#pengembalian-table').DataTable().ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message || 'Pengembalian berhasil diproses.'
                    });
                },

                error: function(xhr) {
                    const res = xhr.responseJSON || {};

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message || 'Pengembalian gagal diproses.'
                    });
                }
            });
        });
    }

    $(document).ready(function() {

        const pengembalianTable = $('#pengembalian-table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            lengthChange: false,
            info: false,
            dom: 'frt',
            order: [],

            ajax: {
                url: "{{ route('rentals.data') }}",
                type: 'GET',
                data: function(d) {
                    d.status = 'Disetujui';
                }
            },

            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'px-3',
                    width: '60px',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: null,
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<div class="fw-bold">' +
                            escapeHtml(data.user_name) + '</div>' +
                            '<small class="text-muted">' +
                            escapeHtml(data.user_email) + '</small>';
                    }
                },
                {
                    data: null,
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<div class="fw-bold">' +
                            escapeHtml(data.mobil_name) + '</div>' +
                            '<small class="text-muted">' +
                            escapeHtml(data.mobil_plate) + '</small>';
                    }
                },
                {
                    data: null,
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return escapeHtml(data.tanggal_mulai) +
                            '<br><small class="text-muted">s/d ' +
                            escapeHtml(data.tanggal_selesai) +
                            '</small>';
                    }
                },
                {
                    data: 'jumlah_hari',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return escapeHtml(data) + ' hari';
                    }
                },
                {
                    data: 'total_harga',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<strong>' + formatRupiah(data) + '</strong>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-end pe-4',
                    width: '220px',
                    render: function(data) {
                        const id = Number(data.id);
                        const namaMobil = escapeHtml(data.mobil_name || '-');

                        return `
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    onclick="openPengembalianDetail(${id})">
                                    <i class="bi bi-eye"></i> Detail
                                </button>

                                <button type="button"
                                    class="btn btn-sm btn-success"
                                    onclick="prosesPengembalian(${id}, '${namaMobil}')">
                                    <i class="bi bi-arrow-return-left"></i> Proses
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
                emptyTable: 'Tidak ada rental yang dapat diproses pengembaliannya',
                paginate: {
                    first: 'First',
                    last: 'Last',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                },
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun'
                }
            }
        });

        // Pagination khusus
        function renderPengembalianPager() {
            const info = pengembalianTable.page.info();

            const total = info.recordsDisplay;
            const start = total ? info.start + 1 : 0;
            const end = total ? info.end : 0;
            const pages = info.pages || 1;
            const page = total ? info.page + 1 : 0;

            $('#pengembalian-info').text(
                'Menampilkan ' + start + '–' + end + ' dari ' + total + ' data'
            );

            $('#pengembalian-page').text(
                'Halaman ' + page + ' / ' + pages
            );

            $('#pengembalian-first, #pengembalian-prev')
                .toggleClass('disabled', info.page <= 0);

            $('#pengembalian-next, #pengembalian-last')
                .toggleClass('disabled', info.page >= pages - 1 || total === 0);
        }

        pengembalianTable.on('draw.dt', renderPengembalianPager);

        $('#pengembalian-first').on('click', function() {
            pengembalianTable.page('first').draw('page');
        });

        $('#pengembalian-prev').on('click', function() {
            pengembalianTable.page('previous').draw('page');
        });

        $('#pengembalian-next').on('click', function() {
            pengembalianTable.page('next').draw('page');
        });

        $('#pengembalian-last').on('click', function() {
            pengembalianTable.page('last').draw('page');
        });

        $('#pengembalian-len').on('change', function() {
            if ($(this).val() === 'custom') {
                $('#pengembalian-custom').focus();
                return;
            }

            const jumlah = Number($(this).val());

            $('#pengembalian-custom').val(jumlah);
            pengembalianTable.page.len(jumlah).draw();
        });

        $('#pengembalian-custom').on('change', function() {
            let jumlah = parseInt($(this).val(), 10) || 1;
            jumlah = Math.min(Math.max(jumlah, 1), 500);

            $(this).val(jumlah);

            if (['10', '20', '50', '100'].includes(String(jumlah))) {
                $('#pengembalian-len').val(String(jumlah));
            } else {
                $('#pengembalian-len').val('custom');
            }

            pengembalianTable.page.len(jumlah).draw();
        });

        renderPengembalianPager();
    });
</script>

</body>
</html>
