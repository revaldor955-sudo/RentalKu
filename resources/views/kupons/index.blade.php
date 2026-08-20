<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Promo - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css"
    >

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background: #f5f7f6;
            font-family: Arial, Helvetica, sans-serif;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .page-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,.04);
        }

        .btn-green {
            background: #198754;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25,135,84,.12);
        }

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .code {
            background: #e9f7ef;
            color: #198754;
            padding: 7px 10px;
            border-radius: 8px;
            font-weight: 700;
        }

        .status-active {
            background: #dff7e8;
            color: #198754;
        }

        .status-expired {
            background: #f8d7da;
            color: #b02a37;
        }

        .status-waiting {
            background: #fff3cd;
            color: #997404;
        }

        .status {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>
</head>

<body>

@include('layouts.partials.admin-navbar')


<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Management Promo
            </h2>

            <p class="text-muted mb-0">
                Kelola kode promo dan kupon RentalKu.
            </p>
        </div>

        <button
            class="btn btn-green px-3 py-2"
            data-bs-toggle="modal"
            data-bs-target="#tambahModal"
        >
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Promo
        </button>

    </div>


    @if(session('success'))
        <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
    @endif


    @if($errors->any())
        <div class="alert alert-danger">

            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    <div class="page-card">

        <div class="table-responsive">

            <table class="table align-middle mb-0" id="kupons-table">

                <thead>
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Nilai</th>
                        <th>Kuota</th>
                        <th>Terpakai</th>
                        <th>Min. Pembelian</th>
                        <th>Aktif</th>
                        <th>Berakhir</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- Diisi oleh DataTables (server-side) --}}
                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- MODAL TAMBAH --}}

<div
    class="modal fade"
    id="tambahModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-ticket-perforated me-2"></i>
                    Tambah Promo
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <form
                action="{{ route('kupons.store') }}"
                method="POST"
                id="formTambahKupon"
            >

                @csrf

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Kode Promo
                            </label>

                            <input
                                type="text"
                                name="code"
                                class="form-control"
                                placeholder="Contoh: HEMAT20"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Jenis Promo
                            </label>

                            <select
                                name="jenis"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    -- Pilih Jenis --
                                </option>

                                <option value="persen">
                                    Persentase (%)
                                </option>

                                <option value="nominal">
                                    Nominal (Rp)
                                </option>

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Nilai Promo
                            </label>

                            <input
                                type="number"
                                name="value"
                                class="form-control"
                                placeholder="Contoh: 20"
                                min="0"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Kuota
                            </label>

                            <input
                                type="number"
                                name="kuota"
                                class="form-control"
                                placeholder="Contoh: 100"
                                min="1"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Minimal Pembelian
                            </label>

                            <input
                                type="number"
                                name="minimal_pembelian"
                                class="form-control"
                                placeholder="Contoh: 100000"
                                min="0"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Mulai Aktif
                            </label>

                            <input
                                type="datetime-local"
                                name="active_at"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-bold">
                                Tanggal Berakhir
                            </label>

                            <input
                                type="datetime-local"
                                name="expired_at"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-green"
                    >
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Promo
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- MODAL EDIT --}}

<div
    class="modal fade"
    id="editKuponModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Promo
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <form
                action=""
                method="POST"
                id="formEditKupon"
            >

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Kode Promo
                            </label>

                            <input
                                type="text"
                                name="code"
                                id="editCode"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Jenis
                            </label>

                            <select
                                name="jenis"
                                id="editJenis"
                                class="form-select"
                                required
                            >

                                <option value="persen">
                                    Persentase
                                </option>

                                <option value="nominal">
                                    Nominal
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Nilai Promo
                            </label>

                            <input
                                type="number"
                                name="value"
                                id="editValue"
                                class="form-control"
                                min="0"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Kuota
                            </label>

                            <input
                                type="number"
                                name="kuota"
                                id="editKuota"
                                class="form-control"
                                min="1"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Terpakai
                            </label>

                            <input
                                type="number"
                                name="terpakai"
                                id="editTerpakai"
                                class="form-control"
                                min="0"
                                readonly
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Minimal Pembelian
                            </label>

                            <input
                                type="number"
                                name="minimal_pembelian"
                                id="editMinimalPembelian"
                                class="form-control"
                                min="0"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Mulai Aktif
                            </label>

                            <input
                                type="datetime-local"
                                name="active_at"
                                id="editActiveAt"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                Tanggal Berakhir
                            </label>

                            <input
                                type="datetime-local"
                                name="expired_at"
                                id="editExpiredAt"
                                class="form-control"
                                required
                            >
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        form="formEditKupon"
                        class="btn btn-green"
                    >
                        <i class="bi bi-save me-1"></i>
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    const CSRF_TOKEN = '{{ csrf_token() }}';

    const flashSuccess = document.getElementById('flashSuccess');

    if (flashSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: flashSuccess.textContent,
            timer: 1800,
            showConfirmButton: false,
        });
    }

    function formatTanggal(value) {
        if (!value) return '-';

        const parts = value.split('T');
        const date = parts[0].split('-');
        const time = parts[1] || '00:00';

        return date[2] + '/' + date[1] + '/' + date[0] + ' ' + time;
    }

    $(document).ready(function() {

        $('#kupons-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('kupons.data') }}',
                type: 'GET',
            },
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'px-4',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'code',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<span class="code">' + data + '</span>';
                    },
                },
                {
                    data: 'jenis',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        if (data === 'persen') {
                            return '<span class="badge bg-primary">Persen</span>';
                        }
                        return '<span class="badge bg-success">Nominal</span>';
                    },
                },
                {
                    data: 'value',
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        const formatted = Number(data).toLocaleString('id-ID');
                        return row.jenis === 'persen' ? formatted + '%' : 'Rp ' + formatted;
                    },
                },
                {
                    data: 'kuota',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return Number(data).toLocaleString('id-ID');
                    },
                },
                {
                    data: 'terpakai',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return Number(data).toLocaleString('id-ID');
                    },
                },
                {
                    data: 'minimal_pembelian',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return 'Rp ' + Number(data).toLocaleString('id-ID');
                    },
                },
                {
                    data: 'status',
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<span class="status status-' + data + '">' +
                            row.status_text + '</span>';
                    },
                },
                {
                    data: 'expired_at',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return formatTanggal(data);
                    },
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<div class="d-flex justify-content-center gap-2">' +
                            '<button type="button" class="btn btn-warning btn-sm btn-action" ' +
                            'title="Edit" onclick="editKupon(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn btn-danger btn-sm btn-action" ' +
                            'title="Hapus" onclick="deleteKupon(' + data +
                            ', \'' + row.code.replace(/'/g, "\\'") + '\')">' +
                            '<i class="bi bi-trash"></i></button>' +
                            '</div>';
                    },
                },
            ],
            order: [
                [7, 'asc']
            ],
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
                emptyTable: 'Belum ada promo',
                paginate: {
                    previous: 'Sebelumnya',
                    next: 'Berikutnya'
                },
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

    });

    function deleteKupon(id, code) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus promo "' + code + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('kupons.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {
                    $('#kupons-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Promo berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus promo.',
                    });
                }
            });
        });
    }

    function editKupon(id) {
        const data = $('#kupons-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data promo tidak ditemukan.',
            });
            return;
        }

        $('#editCode').val(data.code);
        $('#editJenis').val(data.jenis);
        $('#editValue').val(data.value);
        $('#editKuota').val(data.kuota);
        $('#editTerpakai').val(data.terpakai);
        $('#editMinimalPembelian').val(data.minimal_pembelian);
        $('#editActiveAt').val(data.active_at);
        $('#editExpiredAt').val(data.expired_at);

        $('#formEditKupon').attr('action',
            "{{ route('kupons.update', '__ID__') }}".replace('__ID__', id));

        new bootstrap.Modal(document.getElementById('editKuponModal')).show();
    }

    $(document).on('submit', '#formTambahKupon', function(e) {
        e.preventDefault();

        var form = this;
        var btn = $('#formTambahKupon button[type=submit]');
        btn.prop('disabled', true);

        $.ajax({
            url: '{{ route('kupons.store') }}',
            method: 'POST',
            data: new FormData(form),
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(result) {
                bootstrap.Modal.getInstance(document.getElementById('tambahModal')).hide();
                form.reset();
                $('#kupons-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Promo berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                var r = xhr.responseJSON || {};
                var msgs = Object.values(r.errors || {}).flat();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msgs.length ? msgs.join(', ') : (r.message || 'Terjadi kesalahan.'),
                });
            },
            complete: function() {
                btn.prop('disabled', false);
            }
        });
    });

    $(document).on('submit', '#formEditKupon', function(e) {
        e.preventDefault();

        var form = this;
        var btn = $('#formEditKupon button[type=submit]');
        btn.prop('disabled', true);

        $.ajax({
            url: form.getAttribute('action'),
            method: 'PUT',
            data: new FormData(form),
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(result) {
                bootstrap.Modal.getInstance(document.getElementById('editKuponModal')).hide();
                $('#kupons-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Promo berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                var r = xhr.responseJSON || {};
                var msgs = Object.values(r.errors || {}).flat();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msgs.length ? msgs.join(', ') : (r.message || 'Terjadi kesalahan.'),
                });
            },
            complete: function() {
                btn.prop('disabled', false);
            }
        });
    });

</script>

</body>
</html>