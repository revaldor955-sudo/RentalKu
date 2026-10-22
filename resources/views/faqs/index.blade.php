<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management FAQ - RentalKu</title>

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
            border-bottom: 1px solid #e9ecef;
            padding: 12px 16px;
        }

        .table tbody td {
            vertical-align: middle;
        }

        /* Sembunyikan ikon sort di semua kolom */
        #faqs-table thead .dt-column-order {
            display: none !important;
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
            <h2 class="page-title mb-1">
                Management FAQ
            </h2>

            <p class="text-muted mb-0">
                Kelola pertanyaan yang sering diajukan (FAQ).
            </p>

        </div>

        <button
            type="button"
            class="btn btn-green"
            data-bs-toggle="modal"
            data-bs-target="#tambahFaqModal">

            <i class="bi bi-plus-circle me-1"></i>
            Tambah FAQ

        </button>

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
                                Daftar FAQ
                            </h5>

                            <small class="text-muted">
                                Seluruh pertanyaan yang terdaftar.
                            </small>

                        </div>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0" id="faqs-table">

                        <thead>

                            <tr>

                                <th class="px-3 py-3">
                                    No
                                </th>

                                <th>
                                    Pertanyaan
                                </th>

                                <th>
                                    Jawaban
                                </th>

                                <th>
                                    Urutan
                                </th>

                                <th>
                                    Tampil
                                </th>

                                <th class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>
                            {{-- Diisi oleh DataTables (server-side) --}}
                        </tbody>

                    </table>

                    <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3" id="faqs-pager">
                        <div class="text-secondary small" id="faqs-info">Menampilkan 0–0 dari 0 data</div>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <select class="form-select form-select-sm pager-select" id="faqs-perpage" aria-label="Jumlah per halaman">
                                <option value="10">10 / halaman</option>
                                <option value="20">20 / halaman</option>
                                <option value="50">50 / halaman</option>
                                <option value="100">100 / halaman</option>
                                <option value="custom">Custom</option>
                            </select>
                            <input type="number" class="form-control form-control-sm pager-jump" id="pager-custom-faqs" min="1" max="500" value="10" aria-label="Jumlah custom per halaman">
                            <span class="text-secondary" id="faqs-page-label">Halaman 1 / 1</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm pager-btn" id="faqs-first">First</button>
                            <button type="button" class="btn btn-sm pager-btn" id="faqs-prev" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>
                            <button type="button" class="btn btn-sm pager-btn pager-next" id="faqs-next" aria-label="Halaman berikutnya"><i class="bi bi-chevron-right"></i></button>
                            <button type="button" class="btn btn-sm pager-btn" id="faqs-last">Last</button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="tambahFaqModal"
        tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Tambah FAQ', 'icon' => 'bi-plus-circle'])

                <form
                    action="{{ route('faqs.store') }}"
                    method="POST"
                    id="formTambahFaq">

                    @csrf

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Pertanyaan
                        </label>

                        <textarea
                            name="pertanyaan"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan pertanyaan..."
                            required></textarea>

                        <label class="form-label fw-semibold mt-3">
                            Jawaban
                        </label>

                        <textarea
                            name="jawaban"
                            class="form-control"
                            rows="4"
                            placeholder="Masukkan jawaban..."
                            required></textarea>

                        <label class="form-label fw-semibold mt-3">
                            Urutan
                        </label>

                        <input
                            type="number"
                            name="urutan"
                            class="form-control"
                            placeholder="0"
                            min="0"
                            value="0">

                        <div class="form-check mt-3">

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="form-check-input"
                                id="tambahIsActive"
                                checked>

                            <label class="form-check-label fw-semibold" for="tambahIsActive">
                                Tampilkan di landing
                            </label>

                        </div>

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
                            Simpan FAQ

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="editFaqModal"
        tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Edit FAQ', 'icon' => 'bi-pencil-square'])

                <form
                    action=""
                    method="POST"
                    id="formEditFaq">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Pertanyaan
                        </label>

                        <textarea
                            name="pertanyaan"
                            id="editPertanyaan"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan pertanyaan..."
                            required></textarea>

                        <label class="form-label fw-semibold mt-3">
                            Jawaban
                        </label>

                        <textarea
                            name="jawaban"
                            id="editJawaban"
                            class="form-control"
                            rows="4"
                            placeholder="Masukkan jawaban..."
                            required></textarea>

                        <label class="form-label fw-semibold mt-3">
                            Urutan
                        </label>

                            <input
                                type="number"
                                name="urutan"
                                id="editUrutan"
                                class="form-control"
                                placeholder="0"
                                min="0"
                                value="0">

                            <div class="form-check mt-3">

                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    class="form-check-input"
                                    id="editIsActive">

                                <label class="form-check-label fw-semibold" for="editIsActive">
                                    Tampilkan di landing
                                </label>

                            </div>

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

    $(document).ready(function() {

        var faqsTable = $('#faqs-table').DataTable({
            paging: false,
            info: false,
            dom: 'frt',
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('faqs.data') }}',
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
                    data: 'pertanyaan',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return '<strong>' + data + '</strong>';
                    },
                },
                {
                    data: 'jawaban',
                    orderable: false,
                    searchable: true,
                    render: function(data) {
                        return data
                            ? data
                            : '<span class="text-muted">Belum ada jawaban.</span>';
                    },
                },
                {
                    data: 'urutan',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'is_active',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return data
                            ? '<span class="badge text-bg-success">Aktif</span>'
                            : '<span class="badge text-bg-secondary">Nonaktif</span>';
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
                            'title="Edit" onclick="editFaq(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                            'title="Hapus" onclick="deleteFaq(' + data +
                            ', \'' + row.pertanyaan.replace(/'/g, "\\'") + '\')">' +
                            '<i class="bi bi-trash"></i></button>' +
                            '</div>';
                    },
                },
            ],
            order: [
                [3, 'asc']
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
                emptyTable: 'Belum ada FAQ',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });
        function renderFaqsPager() {
            var info = faqsTable.page.info();
            var total=info.recordsDisplay;
            var start=total?info.start+1:0;
            var pages=info.pages;
            $('#faqs-info').text('Menampilkan '+start+'–'+info.end+' dari '+total+' data');
            $('#faqs-page-label').text('Halaman '+(pages?info.page+1:0)+' / '+pages);
            var first = (info.page === 0 || info.pages <= 1);
            var last = (info.pages <= 1 || info.page === info.pages - 1);
            $('#faqs-first').toggleClass('disabled', first);
            $('#faqs-prev').toggleClass('disabled', first);
            $('#faqs-next').toggleClass('disabled', last);
            $('#faqs-last').toggleClass('disabled', last);
        }
        faqsTable.on('draw.dt', renderFaqsPager);
        renderFaqsPager();
        $('#faqs-first').on('click', function() { faqsTable.page('first').draw('page'); });
        $('#faqs-prev').on('click', function() { faqsTable.page('previous').draw('page'); });
        $('#faqs-next').on('click', function() { faqsTable.page('next').draw('page'); });
        $('#faqs-last').on('click', function() { faqsTable.page('last').draw('page'); });
        $('#faqs-perpage').on('change', function() { var v = $(this).val(); if (v === 'custom') { $('#pager-custom-faqs').focus(); return; } var n = Number(v); $('#pager-custom-faqs').val(n); faqsTable.page.len(n).draw(); });
        $('#pager-custom-faqs').on('change', function() { var n = parseInt($(this).val(), 10) || 1; n = Math.min(Math.max(n, 1), 500); $(this).val(n); var $len = $('#faqs-perpage'); if ($len.find('option[value="' + n + '"]').length) { $len.val(String(n)); } else { $len.val('custom'); } faqsTable.page.len(n).draw(); });

    });

    function deleteFaq(id, pertanyaan) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus FAQ "' + pertanyaan.substring(0, 50) + '..."?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('faqs.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {
                    $('#faqs-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'FAQ berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus FAQ.',
                    });
                }
            });
        });
    }

    function editFaq(id) {
        const data = $('#faqs-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data FAQ tidak ditemukan.',
            });
            return;
        }

        $('#editPertanyaan').val(data.pertanyaan);
        $('#editJawaban').val(data.jawaban);
        $('#editUrutan').val(data.urutan);
        $('#editIsActive').prop('checked', !!data.is_active);

        $('#formEditFaq').attr('action',
            "{{ route('faqs.update', '__ID__') }}".replace('__ID__', id));

        bootstrap.Modal.getOrCreateInstance($('#editFaqModal')[0]).show();
    }

    $(document).on('submit', '#formTambahFaq', function(e) {
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
                bootstrap.Modal.getInstance($('#tambahFaqModal')[0]).hide();
                $('#formTambahFaq')[0].reset();
                $('#faqs-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'FAQ berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan FAQ.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditFaq', function(e) {
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
                bootstrap.Modal.getInstance($('#editFaqModal')[0]).hide();
                $('#faqs-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'FAQ berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui FAQ.');

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