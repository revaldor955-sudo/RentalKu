<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Metode Pembayaran - RentalKu</title>

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

        /* Sembunyikan ikon sort di semua kolom */
        #metodePembayarans-table thead .dt-column-order {
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
                Management Metode Pembayaran
            </h2>

            <p class="text-muted mb-0">
                Kelola metode pembayaran yang tersedia di RentalKu.
            </p>

        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#tambahMetodePembayaranModal">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah Metode

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

                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Daftar Metode Pembayaran
                            </h5>

                            <small class="text-muted">
                                Seluruh metode pembayaran yang terdaftar di RentalKu.
                            </small>

                        </div>

                        <div class="d-flex gap-2 align-items-center">

                            <label class="text-muted small mb-0" for="filterCabang">
                                Cabang
                            </label>

                            <select
                                id="filterCabang"
                                class="form-select"
                                style="width: auto;">

                                <option value="">
                                    Semua cabang
                                </option>

                                <option value="pusat">
                                    Pusat
                                </option>

                                @foreach($cabangs as $cabang)

                                    <option value="{{ $cabang->id }}">
                                        {{ $cabang->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0" id="metodePembayarans-table">

                        <thead>

                            <tr>

                                <th class="px-3 py-3">
                                    No
                                </th>

                                <th>
                                    Nama
                                </th>

                                <th>
                                    Nomor Akun
                                </th>

                                <th>
                                    Cabang
                                </th>

                                <th>
                                    Atas Nama
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
        id="tambahMetodePembayaranModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Tambah Metode Pembayaran', 'icon' => 'bi-plus-circle'])

                <form
                    action="{{ route('metode_pembayarans.store') }}"
                    method="POST"
                    id="formTambahMetodePembayaran">

                    @csrf

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Nama Metode
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Contoh: BCA, BRI, Mandiri, DANA, OVO"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Nomor Akun
                        </label>

                        <input
                            type="text"
                            name="nomor_akun"
                            class="form-control"
                            placeholder="Contoh: 1234567890"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Cabang Pemilik Rekening
                        </label>

                        <select
                            name="cabang_id"
                            id="tambahCabangMetodePembayaran"
                            class="form-select">

                            <option value="">
                                Pusat (berlaku semua cabang)
                            </option>

                            @foreach($cabangs as $cabang)

                                <option value="{{ $cabang->id }}">
                                    {{ $cabang->name }}
                                </option>

                            @endforeach

                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Atas Nama
                        </label>

                        <input
                            type="text"
                            name="atas_nama"
                            class="form-control"
                            placeholder="Contoh: PT RentalKu Cabang Bandung">

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
                            Simpan Metode

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="editMetodePembayaranModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Edit Metode Pembayaran', 'icon' => 'bi-pencil-square'])

                <form
                    action=""
                    method="POST"
                    id="formEditMetodePembayaran">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Nama Metode
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="editNamaMetodePembayaran"
                            class="form-control"
                            placeholder="Contoh: BCA, BRI, Mandiri, DANA, OVO"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Nomor Akun
                        </label>

                        <input
                            type="text"
                            name="nomor_akun"
                            id="editNomorAkunMetodePembayaran"
                            class="form-control"
                            placeholder="Contoh: 1234567890"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Cabang Pemilik Rekening
                        </label>

                        <select
                            name="cabang_id"
                            id="editCabangMetodePembayaran"
                            class="form-select">

                            <option value="">
                                Pusat (berlaku semua cabang)
                            </option>

                            @foreach($cabangs as $cabang)

                                <option value="{{ $cabang->id }}">
                                    {{ $cabang->name }}
                                </option>

                            @endforeach

                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Atas Nama
                        </label>

                        <input
                            type="text"
                            name="atas_nama"
                            id="editAtasNamaMetodePembayaran"
                            class="form-control"
                            placeholder="Contoh: PT RentalKu Cabang Bandung">

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

    $(document).on('change', '#filterCabang', function() {
$('#metodePembayarans-table').DataTable().ajax.reload(null, true);    });

    // Preset cabang di modal tambah mengikuti filter aktif.
    $(document).on('show.bs.modal', '#tambahMetodePembayaranModal', function() {
        var cabang = $('#filterCabang').val();
        $('#tambahCabangMetodePembayaran').val(cabang === 'pusat' ? '' : cabang);
    });

    $(document).ready(function() {

        $('#metodePembayarans-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('metode_pembayarans.data') }}',
                type: 'GET',
                data: function(d) {
                    d.cabang_id = $('#filterCabang').val();
                },
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
                    data: 'name',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return '<strong>' + data + '</strong>';
                    },
                },
                {
                    data: 'nomor_akun',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'cabang_name',
                    orderable: true,
                    searchable: true,
                },
                {
                    data: 'atas_nama',
                    orderable: true,
                    searchable: true,
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
                            'title="Edit" onclick="editMetodePembayaran(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                            'title="Hapus" onclick="deleteMetodePembayaran(' + data +
                            ', \'' + row.name.replace(/'/g, "\\'") + '\')">' +
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
                loadingRecords: 'Memuat...',
                zeroRecords: 'Tidak ditemukan data yang cocok',
                emptyTable: 'Belum ada metode pembayaran',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

    });

    function deleteMetodePembayaran(id, name) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus metode pembayaran "' + name + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('metode_pembayarans.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {
                    $('#metodePembayarans-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Metode pembayaran berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus metode pembayaran.',
                    });
                }
            });
        });
    }

    function editMetodePembayaran(id) {
        const data = $('#metodePembayarans-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data metode pembayaran tidak ditemukan.',
            });
            return;
        }

        $('#editNamaMetodePembayaran').val(data.name);
        $('#editNomorAkunMetodePembayaran').val(data.nomor_akun);
        $('#editCabangMetodePembayaran').val(data.cabang_id || '');
        $('#editAtasNamaMetodePembayaran').val(data.atas_nama === '-' ? '' : data.atas_nama);

        $('#formEditMetodePembayaran').attr('action',
            "{{ route('metode_pembayarans.update', '__ID__') }}".replace('__ID__', id));

        bootstrap.Modal.getOrCreateInstance($('#editMetodePembayaranModal')[0]).show();
    }

    $(document).on('submit', '#formTambahMetodePembayaran', function(e) {
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
                bootstrap.Modal.getInstance($('#tambahMetodePembayaranModal')[0]).hide();
                $('#formTambahMetodePembayaran')[0].reset();
                $('#metodePembayarans-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Metode pembayaran berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan metode pembayaran.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditMetodePembayaran', function(e) {
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
                bootstrap.Modal.getInstance($('#editMetodePembayaranModal')[0]).hide();
                $('#metodePembayarans-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Metode pembayaran berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui metode pembayaran.');

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