<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Brand - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f5f7f6;
            color: #1f2937;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }

        .page-card {
            background: white;
            border: 1px solid #edf0ee;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,.05);
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

        #brands-table thead .dt-column-order {
            display: none !important;
        }

        .pager-bar{background:#fff;border:1px solid #edf0ee;border-radius:16px;box-shadow:0 8px 20px rgba(0,0,0,0.05);padding:12px 16px;font-size:14px}
        .pager-bar .text-secondary{font-size:14px;font-weight:500}.pager-select{width:auto;border-radius:10px;font-size:13px;height:34px;padding:6px 28px 6px 10px}
        .pager-jump{width:72px;border-radius:10px;text-align:center;font-size:13px;height:34px;padding:6px 8px}
        .pager-btn{border:1px solid #dee2e6;border-radius:10px;color:#1f2937;font-weight:600;background:#fff;font-size:13px;height:34px;display:inline-flex;align-items:center;padding:6px 12px}
        .pager-btn:hover{border-color:#198754;color:#198754;background:#f5f7f6}
        .pager-btn.disabled{opacity:0.4;pointer-events:none}
        .pager-next{background:#198754;border-color:#198754;color:#fff}
        .pager-next:hover{background:#146c43;border-color:#146c43;color:#fff}

        .brand-logo {
            width: 55px;
            height: 55px;
            object-fit: contain;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: white;
            padding: 5px;
        }

        .no-logo {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            background: #e9f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .brand-name {
            font-weight: 700;
        }

        .description {
            max-width: 300px;
            color: #6b7280;
            font-size: 14px;
        }

        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .form-control {
            border-radius: 10px;
            padding: 11px 13px;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25,135,84,.12);
        }

        .modal-footer .btn {
            padding: 6px 14px;
            min-width: 100px;
        }

        .page-content {
            padding: 24px;
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Kategori Merek</h1>
            <p class="text-muted mb-0">Kelola merek kendaraan yang tersedia di RentalKu.</p>
        </div>

        <button
            type="button"
            class="btn btn-green"
            data-bs-toggle="modal"
            data-bs-target="#tambahBrandModal">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Merek
        </button>
    </div>

    <div class="page-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="brands-table">
                <thead>
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th>Logo</th>
                        <th>Nama Merek</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Jumlah Mobil</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3" id="pager-brands">
                <div class="text-secondary" id="pager-info-brands">Menampilkan 0–0 dari 0 data</div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select id="pager-len-brands" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                        <option value="10">10 / halaman</option>
                        <option value="20">20 / halaman</option>
                        <option value="50">50 / halaman</option>
                        <option value="100">100 / halaman</option>
                        <option value="custom">Custom</option>
                    </select>
                    <input type="number" id="pager-custom-brands" class="form-control form-control-sm pager-jump" min="1" max="500" value="10" aria-label="Jumlah custom per halaman">
                    <span class="text-secondary" id="pager-page-brands">Halaman 1 / 1</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm pager-btn" id="pager-first-brands">First</button>
                    <button type="button" class="btn btn-sm pager-btn" id="pager-prev-brands" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                    <button type="button" class="btn btn-sm pager-btn pager-next" id="pager-next-brands" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                    <button type="button" class="btn btn-sm pager-btn" id="pager-last-brands">Last</button>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="fotoBrandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Logo Merek'])
            <div class="modal-body p-3 text-center">
                <img id="fotoBrandPreview" src="" class="img-fluid rounded" alt="Logo merek">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahBrandModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Tambah Merek'])
            <form id="formTambahBrand" action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Merek</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Toyota" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Logo</label>
                        <input type="file" name="logo" class="form-control" accept=".jpg,.jpeg,.png,.svg">
                        <small class="text-muted">JPG, JPEG, PNG, atau SVG. Maksimal 2 MB.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Deskripsi singkat mengenai merek..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i>Batal</button>
                    <button type="submit" class="btn btn-green">
                        <i class="bi bi-save me-1"></i>
                        Simpan Merek
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editBrandModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Edit Merek'])
            <form id="formEditBrand" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Merek</label>
                        <input type="text" name="name" id="editNamaBrand" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Logo</label>
                        <input type="file" name="logo" class="form-control" accept=".jpg,.jpeg,.png,.svg">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti logo.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" id="editDeskripsiBrand" class="form-control" rows="4"></textarea>
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

    function openFotoBrand(url, name) {
        $('#fotoBrandPreview').attr('src', url).attr('alt', name);
        bootstrap.Modal.getOrCreateInstance($('#fotoBrandModal')[0]).show();
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

        var tabelBrands = $('#brands-table').DataTable({
            paging: false,
            info: false,
            dom: 'frt',
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("brands.data") }}',
                type: 'GET',
            },
            columns: [
                {
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
                    data: 'logo',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        if (data) {
                            const full = '{{ asset('__LOGO__') }}'.replace('__LOGO__', data);
                            return '<a href="#" onclick="openFotoBrand(\'' + full + '\', \'' + row.name.replace(/'/g, "\\'") + '\');return false;">' +
                                '<img src="' + full + '" class="brand-logo" alt="' + row.name + '"></a>';
                        }
                        return '<div class="no-logo"><i class="bi bi-car-front-fill"></i></div>';
                    },
                },
                {
                    data: 'name',
                    render: function(data) {
                        return '<div class="brand-name">' + data + '</div>';
                    },
                },
                {
                    data: 'description',
                    orderable: false,
                    render: function(data) {
                        return data
                            ? '<div class="description">' + data + '</div>'
                            : '<span class="text-muted">Tidak ada deskripsi.</span>';
                    },
                },
                {
                    data: 'mobils_count',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data) {
                        return '<span class="badge bg-success-subtle text-success px-3 py-2">' + data + ' Mobil</span>';
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
                        html += '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" title="Edit" onclick="editBrand(' + data + ')"><i class="bi bi-pencil-square"></i></button>';
                        if (row.mobils_count == 0) {
                            html += '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" title="Hapus" onclick="deleteBrand(' + data + ', \'' + row.name.replace(/'/g, "\\'") + '\')"><i class="bi bi-trash"></i></button>';
                        } else {
                            html += '<button type="button" class="btn p-1 text-secondary" style="border:none;background:none;" disabled title="Brand masih digunakan mobil"><i class="bi bi-lock"></i></button>';
                        }
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
                emptyTable: 'Belum ada merek',
            },
        });

        function renderPagerBrands() {
            var info = tabelBrands.page.info();
            var total=info.recordsDisplay;
            var start=total?info.start+1:0;
            $('#pager-info-brands').text('Menampilkan '+start+'–'+info.end+' dari '+total+' data');
            var pages=info.pages;
            $('#pager-page-brands').text('Halaman '+(pages?info.page+1:0)+' / '+pages);
            var page=pages?info.page+1:0;
            $('#pager-first-brands, #pager-prev-brands').toggleClass('disabled', page <= 1);
            $('#pager-next-brands, #pager-last-brands').toggleClass('disabled', page >= pages);
        }

        $('#pager-first-brands').on('click', function() {
            tabelBrands.page('first').draw('page');
        });
        $('#pager-prev-brands').on('click', function() {
            tabelBrands.page('previous').draw('page');
        });
        $('#pager-next-brands').on('click', function() {
            tabelBrands.page('next').draw('page');
        });
        $('#pager-last-brands').on('click', function() {
            tabelBrands.page('last').draw('page');
        });
        $('#pager-len-brands').on('change', function() {
            if ($(this).val() === 'custom') { $('#pager-custom-brands').focus(); return; }
            var n = Number($(this).val());
            $('#pager-custom-brands').val(n);
            tabelBrands.page.len(n).draw();
        });
        $('#pager-custom-brands').on('change', function() {
            var n = parseInt($(this).val(), 10) || 1;
            n = Math.min(Math.max(n, 1), 500);
            $(this).val(n);
            if (['10','20','50','100'].indexOf(String(n)) !== -1) { $('#pager-len-brands').val(String(n)); }
            else { $('#pager-len-brands').val('custom'); }
            tabelBrands.page.len(n).draw();
        });
        tabelBrands.on('draw.dt', renderPagerBrands);
        renderPagerBrands();

    });

    function editBrand(id) {
        $.ajax({
            url: '{{ url("brands") }}/' + id,
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
            success: function(data) {
                $('#editNamaBrand').val(data.name);
                $('#editDeskripsiBrand').val(data.description);
                $('#formEditBrand').attr('action', '{{ url("brands") }}/' + id);
                bootstrap.Modal.getOrCreateInstance($('#editBrandModal')[0]).show();
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Data brand tidak ditemukan.',
                });
            }
        });
    }

    function deleteBrand(id, name) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus merek "' + name + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: '{{ url("brands") }}/' + id,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(res) {
                    $('#brands-table').DataTable().ajax.reload();
                    flashSuccess(res.message || 'Brand berhasil dihapus.');
                },
                error: function(xhr) {
                    var r = xhr.responseJSON || {};
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: r.message || 'Terjadi kesalahan saat menghapus brand.',
                    });
                }
            });
        });
    }

    $(document).on('submit', '#formTambahBrand', function(e) {
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
                bootstrap.Modal.getInstance($('#tambahBrandModal')[0]).hide();
                $('#formTambahBrand')[0].reset();
                $('#brands-table').DataTable().ajax.reload();
                flashSuccess(result.message || 'Brand berhasil ditambahkan.');
            },
            error: function(xhr) {
                var r = xhr.responseJSON || {};
                var msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan brand.');
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditBrand', function(e) {
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
                bootstrap.Modal.getInstance($('#editBrandModal')[0]).hide();
                $('#brands-table').DataTable().ajax.reload();
                flashSuccess(result.message || 'Brand berhasil diperbarui.');
            },
            error: function(xhr) {
                var r = xhr.responseJSON || {};
                var msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui brand.');
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
