<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Banner - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: #f5f7f6;
            color: #1f2937;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
        }

        .page-card {
            background: white;
            border: 1px solid #edf0ee;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
        }

        .page-title {
            font-size: 30px;
            font-weight: 800;
        }

        .btn-green {
            background: #198754;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 18px;
        }

        .modal-footer .btn {
            padding: 6px 14px;
            min-width: 100px;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }

        .table thead th {
            background: #f8faf9;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            border-bottom: 1px solid #e9ecef;
            white-space: nowrap;
            padding: 12px 16px;
        }

        .table tbody td {
            vertical-align: middle;
        }

        /* Sembunyikan ikon sort di semua kolom */
        #banners-table thead .dt-column-order {
            display: none !important;
        }

        .banner-image {
            width: 150px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        .image-placeholder {
            width: 150px;
            height: 80px;
            border-radius: 12px;
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .status-active {
            background: #dff7e8;
            color: #198754;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-inactive {
            background: #f8d7da;
            color: #b02a37;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px 13px;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .12);
        }

        .page-content {
            padding: 24px;
        }

        @media (max-width: 1024px) {
            .page-content {
                padding: 16px;
            }
        }
        .pager-bar{background:#fff;border:1px solid #edf0ee;border-radius:16px;box-shadow:0 8px 20px rgba(0,0,0,0.05);padding:12px 16px;font-size:14px}
        .pager-bar .text-secondary{font-size:14px;font-weight:500}.pager-select{width:auto;border-radius:10px;font-size:13px;height:34px;padding:6px 28px 6px 10px}
        .pager-jump{width:72px;border-radius:10px;text-align:center;font-size:13px;height:34px;padding:6px 8px}
        .pager-btn{border:1px solid #dee2e6;border-radius:10px;color:#1f2937;font-weight:600;background:#fff;font-size:13px;height:34px;display:inline-flex;align-items:center;padding:6px 12px}
        .pager-btn:hover{border-color:#198754;color:#198754;background:#f5f7f6}
        .pager-btn.disabled{opacity:0.4;pointer-events:none}
        .pager-next{background:#198754;border-color:#198754;color:#fff}
        .pager-next:hover{background:#146c43;border-color:#146c43;color:#fff}
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Management Banner</h1>
            <p class="text-muted mb-0">Kelola banner yang ditampilkan pada halaman utama RentalKu.</p>
        </div>

        <button
            type="button"
            class="btn btn-green"
            data-bs-toggle="modal"
            data-bs-target="#tambahBannerModal">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Banner
        </button>
    </div>

    <div class="page-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="banners-table">
                <thead>
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th>Banner</th>
                        <th>Judul</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3" id="banners-pager">
                <div class="text-secondary small" id="banners-info">Menampilkan 0–0 dari 0 data</div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select class="form-select form-select-sm pager-select" id="banners-perpage" aria-label="Jumlah per halaman">
                        <option value="10">10 / halaman</option>
                        <option value="20">20 / halaman</option>
                        <option value="50">50 / halaman</option>
                    </select>
                    <input type="number" class="form-control form-control-sm pager-jump" id="banners-jump" min="1" value="1" aria-label="Lompat ke halaman">
                    <span class="text-secondary" id="banners-page-label">Halaman 1 / 1</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm pager-btn" id="banners-first">First</button>
                    <button type="button" class="btn btn-sm pager-btn" id="banners-prev" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                    <button type="button" class="btn btn-sm pager-btn pager-next" id="banners-next" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                    <button type="button" class="btn btn-sm pager-btn" id="banners-last">Last</button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="fotoBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Gambar Banner'])
            <div class="modal-body p-3 text-center">
                <img id="fotoBannerPreview" src="" class="img-fluid rounded" alt="Banner">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahBannerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Tambah Banner'])
            <form id="formTambahBanner" action="{{ route('banners.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Judul Banner</label>
                            <input type="text" name="judul" class="form-control"
                                placeholder="Contoh: Promo RentalKu" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Urutan</label>
                            <input type="number" name="urutan" class="form-control" min="0" value="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Gambar Banner</label>
                            <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.svg">
                            <small class="text-muted">JPG, JPEG, PNG, atau SVG. Maksimal 2 MB.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi banner..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Link CTA <span
                                    class="text-secondary">(opsional)</span></label>
                            <input type="text" name="link" class="form-control"
                                placeholder="https://wa.me/6281234567890">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i>Batal</button>
                    <button type="submit" class="btn btn-green">
                        <i class="bi bi-save me-1"></i>
                        Simpan Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editBannerModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Edit Banner'])
            <form id="formEditBanner" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Judul Banner</label>
                            <input type="text" name="judul" id="editJudul" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Urutan</label>
                            <input type="number" name="urutan" id="editUrutan" class="form-control"
                                min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Gambar Banner</label>
                            <input type="file" name="gambar" class="form-control"
                                accept=".jpg,.jpeg,.png,.svg">
                            <small class="text-muted">Kosongkan jika gambar tidak ingin diubah.</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Link CTA <span
                                    class="text-secondary">(opsional)</span></label>
                            <input type="text" name="link" id="editLink" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" id="editStatus" class="form-select" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i>Batal</button>
                    <button type="submit" class="btn btn-green">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
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
    var ASSET_BASE_URL = '{{ asset('') }}';

    function statusBadge(status) {
        if (status === 'aktif') {
            return '<span class="status-active">Aktif</span>';
        }
        return '<span class="status-inactive">Tidak Aktif</span>';
    }

    function openFotoBanner(url) {
        $('#fotoBannerPreview').attr('src', url);
        bootstrap.Modal.getOrCreateInstance($('#fotoBannerModal')[0]).show();
    }

    function flashSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: message,
            timer: 1800,
            showConfirmButton: false,
        });
    }

    $(document).ready(function() {

        var bannersTable = $('#banners-table').DataTable({
            paging: false,
            info: false,
            dom: 'frt',
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('banners.data') }}',
                type: 'GET',
            },
            columns: [
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'px-3',
                    width: '70px',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'gambar',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data) {
                            const full = ASSET_BASE_URL + data;
                            return '<a href="#" onclick="openFotoBanner(\'' + full + '\');return false;">' +
                                '<img src="' + full + '" class="banner-image" alt="Banner"></a>';
                        }
                        return '<div class="image-placeholder"><i class="bi bi-image"></i></div>';
                    },
                },
                {
                    data: 'judul',
                    orderable: true,
                    render: function(data, type, row) {
                        var html = '<strong>' + data + '</strong>';
                        if (row.description) {
                            html += '<div class="small text-muted">' + row.description
                                .substring(0, 60) + '</div>';
                        }
                        return html;
                    },
                },
                {
                    data: 'urutan',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return data ?? 0;
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
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '140px',
                    render: function(data, type, row) {
                        var html = '<div class="d-flex justify-content-center gap-2">';
                        html +=
                            '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" title="Edit" onclick="editBanner(' +
                            data + ')"><i class="bi bi-pencil-square"></i></button>';
                        html +=
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" title="Hapus" onclick="deleteBanner(' +
                            data + ', \'' + row.judul.replace(/'/g, "\\'") +
                            '\')"><i class="bi bi-trash"></i></button>';
                        html += '</div>';
                        return html;
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
                emptyTable: 'Belum ada banner',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });
        function renderBannersPager() {
            var info = bannersTable.page.info();
            var total=info.recordsDisplay;
            var start=total?info.start+1:0;
            var pages=info.pages;
            $('#banners-info').text('Menampilkan '+start+'–'+info.end+' dari '+total+' data');
            var max = Math.max(pages, 1);
            $('#banners-jump').attr('max', max);
            $('#banners-jump').val(pages ? (info.page + 1) : 1);
            $('#banners-page-label').text('Halaman '+(pages?info.page+1:0)+' / '+pages);
            var first = (info.page === 0 || info.pages <= 1);
            var last = (info.pages <= 1 || info.page === info.pages - 1);
            $('#banners-first').toggleClass('disabled', first);
            $('#banners-prev').toggleClass('disabled', first);
            $('#banners-next').toggleClass('disabled', last);
            $('#banners-last').toggleClass('disabled', last);
        }
        bannersTable.on('draw.dt', renderBannersPager);
        renderBannersPager();
        $('#banners-first').on('click', function() { bannersTable.page('first').draw('page'); });
        $('#banners-prev').on('click', function() { bannersTable.page('previous').draw('page'); });
        $('#banners-next').on('click', function() { bannersTable.page('next').draw('page'); });
        $('#banners-last').on('click', function() { bannersTable.page('last').draw('page'); });
        $('#banners-perpage').on('change', function() { bannersTable.page.len($(this).val()).draw(); });
        $('#banners-jump').on('change', function() { var info = bannersTable.page.info(); var max = Math.max(info.pages, 1); var n = parseInt($(this).val(), 10) || 1; if (n < 1) n = 1; if (n > max) n = max; bannersTable.page(n - 1).draw('page'); });

    });

    function editBanner(id) {
        $.ajax({
            url: '{{ url('banners') }}/' + id,
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
            success: function(data) {
                $('#editJudul').val(data.judul);
                $('#editUrutan').val(data.urutan);
                $('#editDescription').val(data.description);
                $('#editLink').val(data.link);
                $('#editStatus').val(data.status);
                $('#formEditBanner').attr('action', '{{ url('banners') }}/' + id);
                bootstrap.Modal.getOrCreateInstance($('#editBannerModal')[0]).show();
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Data banner tidak ditemukan.',
                });
            }
        });
    }

    function deleteBanner(id, judul) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus banner "' + judul + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: '{{ url('banners') }}/' + id,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(res) {
                    $('#banners-table').DataTable().ajax.reload();
                    flashSuccess(res.message || 'Banner berhasil dihapus.');
                },
                error: function(xhr) {
                    var r = xhr.responseJSON || {};
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: r.message || 'Terjadi kesalahan saat menghapus banner.',
                    });
                }
            });
        });
    }

    $(document).on('submit', '#formTambahBanner', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

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
                bootstrap.Modal.getInstance($('#tambahBannerModal')[0]).hide();
                $('#formTambahBanner')[0].reset();
                $('#banners-table').DataTable().ajax.reload();
                flashSuccess(result.message || 'Banner berhasil ditambahkan.');
            },
            error: function(xhr) {
                var r = xhr.responseJSON || {};
                var msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan banner.');
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditBanner', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var url = $(this).attr('action');

        $.ajax({
            url: url,
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
                bootstrap.Modal.getInstance($('#editBannerModal')[0]).hide();
                $('#banners-table').DataTable().ajax.reload();
                flashSuccess(result.message || 'Banner berhasil diperbarui.');
            },
            error: function(xhr) {
                var r = xhr.responseJSON || {};
                var msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui banner.');
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