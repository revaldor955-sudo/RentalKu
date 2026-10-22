<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Dokumen Mobil - RentalKu</title>

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

        #dokumenMobils-table thead .dt-column-order {
            display: none !important;
        }

        .jenis-badge {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .jenis-stnk { background: #e7f1ff; color: #0d6efd; }
        .jenis-asuransi { background: #d1e7dd; color: #0f5132; }
        .jenis-bpkb { background: #fff3cd; color: #997404; }

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

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="page-title mb-1">
                Management Dokumen Mobil
            </h2>

            <p class="text-muted mb-0">
                Kelola dokumen-dokumen mobil (STNK, Asuransi, BPKB) di RentalKu.
            </p>

        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#tambahDokumenMobilModal">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah Dokumen

            </button>

        </div>

    </div>

    @if(session('success'))
        <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
    @endif

    @if($errors->any())

        <div class="alert alert-danger mb-4">

            <strong>
                Terdapat kesalahan:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="row g-4">

        <div class="col-lg-12">

            <div class="page-card">

                <div class="p-4 border-bottom">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Daftar Dokumen Mobil
                            </h5>

                            <small class="text-muted">
                                Seluruh dokumen mobil yang terdaftar di RentalKu.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0" id="dokumenMobils-table">

                        <thead>

                            <tr>

                                <th class="px-3 py-3">
                                    No
                                </th>

                                <th>
                                    Mobil
                                </th>

                                <th>
                                    Jenis
                                </th>

                                <th>
                                    Nomor Dokumen
                                </th>

                                <th>
                                    Berlaku Sampai
                                </th>

                                <th>
                                    File
                                </th>

                                <th class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                    <div class="p-3">
                        <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div class="text-secondary" id="dm-pager-info">
                                Menampilkan 0–0 dari 0 data
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <select id="dm-pager-len" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                                    <option value="10">10 / halaman</option>
                                    <option value="20">20 / halaman</option>
                                    <option value="50">50 / halaman</option>
                                    <option value="100">100 / halaman</option>
                                    <option value="custom">Custom</option>
                                </select>
                                <input type="number" id="pager-custom-dm" class="form-control form-control-sm pager-jump" min="1" max="500" value="10" aria-label="Jumlah custom per halaman">
                                <span class="text-secondary" id="dm-pager-pages">
                                    Halaman 1 / 1
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm pager-btn" id="dm-pager-first">First</button>
                                <button type="button" class="btn btn-sm pager-btn" id="dm-pager-prev" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                                <button type="button" class="btn btn-sm pager-btn pager-next" id="dm-pager-next" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                                <button type="button" class="btn btn-sm pager-btn" id="dm-pager-last">Last</button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="modal fade" id="fileDokumenModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                @include('layouts.partials.modal-head', ['title' => 'File Dokumen'])
                <div class="modal-body p-3 text-center">
                    <img id="fileDokumenImg" src="" class="img-fluid rounded" alt="Dokumen" style="display:none;">
                    <iframe id="fileDokumenPdf" src="" title="Dokumen PDF" style="display:none;width:100%;height:70vh;border:0;border-radius:8px;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div
        class="modal fade"
        id="tambahDokumenMobilModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Tambah Dokumen Mobil', 'icon' => 'bi-plus-circle'])

                <form
                    action="{{ route('dokumen_mobils.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="formTambahDokumenMobil">

                    @csrf

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Mobil
                        </label>

                        <select name="mobil_id" class="form-select" required>
                            <option value="">-- Pilih Mobil --</option>
                            @foreach($mobils as $mobil)
                                <option value="{{ $mobil->id }}">
                                    {{ $mobil->name }} ({{ $mobil->plate_number }})
                                </option>
                            @endforeach
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Jenis Dokumen
                        </label>

                        <select name="jenis" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="stnk">STNK</option>
                            <option value="asuransi">Asuransi</option>
                            <option value="bpkb">BPKB</option>
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Nomor Dokumen
                        </label>

                        <input
                            type="text"
                            name="nomor_dokumen"
                            class="form-control"
                            placeholder="Contoh: STNK 12345"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Berlaku Sampai
                        </label>

                        <input
                            type="date"
                            name="berlaku_sampai"
                            class="form-control"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            File Dokumen
                        </label>

                        <input
                            type="file"
                            name="file"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.pdf">

                        <small class="text-muted">JPG, PNG, JPEG, PDF, Maksimal 2MB</small>

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
                            Simpan Dokumen

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="editDokumenMobilModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Edit Dokumen Mobil', 'icon' => 'bi-pencil-square'])

                <form
                    action=""
                    method="POST"
                    enctype="multipart/form-data"
                    id="formEditDokumenMobil">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Mobil
                        </label>

                        <select name="mobil_id" id="editMobilIdDokumen" class="form-select" required>
                            <option value="">-- Pilih Mobil --</option>
                            @foreach($mobils as $mobil)
                                <option value="{{ $mobil->id }}">
                                    {{ $mobil->name }} ({{ $mobil->plate_number }})
                                </option>
                            @endforeach
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Jenis Dokumen
                        </label>

                        <select name="jenis" id="editJenisDokumen" class="form-select" required>
                            <option value="stnk">STNK</option>
                            <option value="asuransi">Asuransi</option>
                            <option value="bpkb">BPKB</option>
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Nomor Dokumen
                        </label>

                        <input
                            type="text"
                            name="nomor_dokumen"
                            id="editNomorDokumen"
                            class="form-control"
                            placeholder="Contoh: STNK 12345"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Berlaku Sampai
                        </label>

                        <input
                            type="date"
                            name="berlaku_sampai"
                            id="editBerlakuSampai"
                            class="form-control"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            File Dokumen
                        </label>

                        <input
                            type="file"
                            name="file"
                            id="editFileDokumen"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.pdf">

                        <small class="text-muted">JPG, PNG, JPEG, PDF, Maksimal 2MB, Kosongkan jika file tidak diganti</small>

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

    function openFileDokumen(url) {
        const isPdf = url.split('?')[0].toLowerCase().endsWith('.pdf');
        const $img = $('#fileDokumenImg');
        const $pdf = $('#fileDokumenPdf');
        if (isPdf) {
            $img.hide().attr('src', '');
            $pdf.attr('src', url).show();
        } else {
            $pdf.hide().attr('src', '');
            $img.attr('src', url).show();
        }
        bootstrap.Modal.getOrCreateInstance($('#fileDokumenModal')[0]).show();
    }

    function jenisBadge(jenis) {
        const map = {
            'stnk': 'jenis-stnk',
            'asuransi': 'jenis-asuransi',
            'bpkb': 'jenis-bpkb',
        };

        const cls = map[jenis] || 'bg-secondary text-white';
        const label = jenis.charAt(0).toUpperCase() + jenis.slice(1);

        return '<span class="jenis-badge ' + cls + '">' + label + '</span>';
    }

    function formatTanggal(value) {
        if (!value) return '-';
        const parts = value.split('-');
        return parts[2] + '/' + parts[1] + '/' + parts[0];
    }

    $(document).ready(function() {

        var dmTable = $('#dokumenMobils-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            dom: 'frt',
            ajax: {
                url: '{{ route('dokumen_mobils.data') }}',
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
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return '<strong>' + data.mobil_name + '</strong>' +
                            '<div class="small text-muted">' + data.mobil_plate + '</div>';
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
                    data: 'nomor_dokumen',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'berlaku_sampai',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return formatTanggal(data);
                    },
                },
                {
                    data: 'file',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data) {
                            const full = ('{{ asset('__PHOTO__') }}'.replace('__PHOTO__', data)).replace(/'/g, '%27');
                            return '<button type="button" class="btn btn-sm btn-outline-primary" ' +
                                'onclick="openFileDokumen(\'' + full + '\')">' +
                                '<i class="bi bi-file-earmark me-1"></i>Lihat</button>';
                        }
                        return '<span class="text-muted">-</span>';
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
                            'title="Edit" onclick="editDokumenMobil(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                            'title="Hapus" onclick="deleteDokumenMobil(' + data +
                            ', \'' + row.nomor_dokumen.replace(/'/g, "\\'") + '\')">' +
                            '<i class="bi bi-trash"></i></button>' +
                            '</div>';
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
                infoPostFix: '',
                loadingRecords: 'Memuat...',
                zeroRecords: 'Tidak ditemukan data yang cocok',
                emptyTable: 'Belum ada dokumen mobil',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

        function renderDmPager() {
            var info = dmTable.page.info();
            var total = info.recordsDisplay;
            var start = total ? info.start + 1 : 0;
            $('#dm-pager-info').text('Menampilkan '+start+'–'+info.end + ' dari ' + total + ' data');
            var pages = Math.max(info.pages, 1);
            var page = info.page + 1;
            $('#dm-pager-pages').text('Halaman ' + (pages ? info.page + 1 : 0) + ' / ' + pages);
            $('#dm-pager-first, #dm-pager-prev').toggleClass('disabled', page <= 1);
            $('#dm-pager-next, #dm-pager-last').toggleClass('disabled', page >= pages);
        }

        dmTable.on('draw.dt', renderDmPager);
        renderDmPager();

        $('#dm-pager-first').on('click', function() {
            dmTable.page('first').draw('page');
        });
        $('#dm-pager-prev').on('click', function() {
            dmTable.page('previous').draw('page');
        });
        $('#dm-pager-next').on('click', function() {
            dmTable.page('next').draw('page');
        });
        $('#dm-pager-last').on('click', function() {
            dmTable.page('last').draw('page');
        });
        $('#dm-pager-len').on('change', function() {
            var v = $(this).val();
            if (v === 'custom') { $('#pager-custom-dm').focus(); return; }
            var n = Number(v);
            $('#pager-custom-dm').val(n);
            dmTable.page.len(n).draw();
        });
        $('#pager-custom-dm').on('change', function() {
            var n = parseInt($(this).val(), 10) || 1;
            n = Math.min(Math.max(n, 1), 500);
            $(this).val(n);
            var $len = $('#dm-pager-len');
            if ($len.find('option[value="' + n + '"]').length) { $len.val(String(n)); }
            else { $len.val('custom'); }
            dmTable.page.len(n).draw();
        });

    });

    function deleteDokumenMobil(id, nomor) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus dokumen "' + nomor + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('dokumen_mobils.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {

$('#dokumenMobils-table').DataTable().ajax.reload(null, true);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Dokumen mobil berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus dokumen mobil.',
                    });
                }
            });
        });
    }

    function editDokumenMobil(id) {
        const data = $('#dokumenMobils-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data dokumen mobil tidak ditemukan.',
            });
            return;
        }

        $('#editMobilIdDokumen').val(data.mobil_id);
        $('#editJenisDokumen').val(data.jenis);
        $('#editNomorDokumen').val(data.nomor_dokumen);
        $('#editBerlakuSampai').val(data.berlaku_sampai);

        $('#formEditDokumenMobil').attr('action',
            "{{ route('dokumen_mobils.update', '__ID__') }}".replace('__ID__', id));

        bootstrap.Modal.getOrCreateInstance($('#editDokumenMobilModal')[0]).show();
    }

    $(document).on('submit', '#formTambahDokumenMobil', function(e) {
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
                bootstrap.Modal.getInstance($('#tambahDokumenMobilModal')[0]).hide();
                $('#formTambahDokumenMobil')[0].reset();
                $('#dokumenMobils-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Dokumen mobil berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan dokumen mobil.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditDokumenMobil', function(e) {
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
                bootstrap.Modal.getInstance($('#editDokumenMobilModal')[0]).hide();
                $('#dokumenMobils-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Dokumen mobil berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui dokumen mobil.');

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
