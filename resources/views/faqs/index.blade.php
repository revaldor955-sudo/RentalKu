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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f5f7f6;
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        .modal-header {
            background: #198754;
            color: white;
        }

        /* Sidebar layout base styles are in admin-sidebar.blade.php */

        .page-content {
            padding: 24px;
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
    // Inject navbar into sidebar layout
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

        <div class="d-flex gap-2">

            <button
                type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#tambahFaqModal">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah FAQ

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

                                <th class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>
                            {{-- Diisi oleh DataTables (server-side) --}}
                        </tbody>

                    </table>

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

                <div class="modal-header">

                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-plus-circle text-success me-2"></i>
                        Tambah FAQ
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

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

                <div class="modal-header">

                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-pencil-square text-primary me-2"></i>
                        Edit FAQ
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

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

        $('#faqs-table').DataTable({
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
            method: 'PUT',
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