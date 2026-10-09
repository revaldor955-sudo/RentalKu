<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Servis Mobil - RentalKu</title>

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

        #servisMobils-table thead .dt-column-order {
            display: none !important;
        }

        .jenis-badge {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .jenis-rutin { background: #e7f1ff; color: #0d6efd; }
        .jenis-perbaikan { background: #d1e7dd; color: #0f5132; }

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
                Management Servis Mobil
            </h2>

            <p class="text-muted mb-0">
                Kelola riwayat servis kendaraan (rutin & perbaikan).
            </p>

        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                class="btn btn-green"
                data-bs-toggle="modal"
                data-bs-target="#tambahServisMobilModal">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah Servis

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
                                Daftar Servis Mobil
                            </h5>

                            <small class="text-muted">
                                Riwayat servis kendaraan (rutin & perbaikan).
                            </small>

                        </div>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0" id="servisMobils-table">

                        <thead>

                            <tr>

                                <th class="px-3 py-3">
                                    No
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Mobil
                                </th>

                                <th>
                                    Jenis
                                </th>

                                <th>
                                    Biaya
                                </th>

                                <th>
                                    Bengkel
                                </th>

                                <th>
                                    Keterangan
                                </th>

                                <th class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="tambahServisMobilModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Tambah Servis Mobil', 'icon' => 'bi-plus-circle'])

                <form
                    action="{{ route('servis_mobils.store') }}"
                    method="POST"
                    id="formTambahServisMobil">

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
                            Tanggal Servis
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="{{ now()->format('Y-m-d') }}"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Jenis Servis
                        </label>

                        <select name="jenis" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="rutin">Rutin</option>
                            <option value="perbaikan">Perbaikan</option>
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Biaya
                        </label>

                        <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input
                                                        type="text"
                                                        name="biaya_display"
                                                        id="biayaDisplay"
                                                        class="form-control rupiah-input"
                                                        placeholder="50.000"
                                                        inputmode="numeric"
                                                        autocomplete="off"
                                                        data-target="biaya"
                                                        required>
                                                    <input type="hidden" name="biaya" id="biaya">
                                                </div>

                        <label class="form-label fw-semibold mt-3">
                            Bengkel
                        </label>

                        <input
                            type="text"
                            name="bengkel"
                            class="form-control"
                            placeholder="Nama bengkel"
                            maxlength="100">

                        <label class="form-label fw-semibold mt-3">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="3"
                            placeholder="Keterangan servis..."></textarea>

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
                            Simpan Servis

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div
        class="modal fade"
        id="editServisMobilModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                @include('layouts.partials.modal-head', ['title' => 'Edit Servis Mobil', 'icon' => 'bi-pencil-square'])

                <form
                    action=""
                    method="POST"
                    id="formEditServisMobil">

                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <label class="form-label fw-semibold">
                            Mobil
                        </label>

                        <select name="mobil_id" id="editMobilIdServis" class="form-select" required>
                            <option value="">-- Pilih Mobil --</option>
                            @foreach($mobils as $mobil)
                                <option value="{{ $mobil->id }}">
                                    {{ $mobil->name }} ({{ $mobil->plate_number }})
                                </option>
                            @endforeach
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Tanggal Servis
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            id="editTanggalServis"
                            class="form-control"
                            required>

                        <label class="form-label fw-semibold mt-3">
                            Jenis Servis
                        </label>

                        <select name="jenis" id="editJenisServis" class="form-select" required>
                            <option value="rutin">Rutin</option>
                            <option value="perbaikan">Perbaikan</option>
                        </select>

                        <label class="form-label fw-semibold mt-3">
                            Biaya
                        </label>

                        <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input
                                                        type="text"
                                                        name="biaya_display"
                                                        id="editBiayaServisDisplay"
                                                        class="form-control rupiah-input"
                                                        placeholder="50.000"
                                                        inputmode="numeric"
                                                        autocomplete="off"
                                                        data-target="editBiayaServis"
                                                        required>
                                                    <input type="hidden" name="biaya" id="editBiayaServis">
                                                </div>

                        <label class="form-label fw-semibold mt-3">
                            Bengkel
                        </label>

                        <input
                            type="text"
                            name="bengkel"
                            id="editBengkelServis"
                            class="form-control"
                            placeholder="Nama bengkel"
                            maxlength="100">

                        <label class="form-label fw-semibold mt-3">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            id="editKeteranganServis"
                            class="form-control"
                            rows="3"
                            placeholder="Keterangan servis..."></textarea>

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

    function jenisBadge(jenis) {
        const map = {
            'rutin': 'jenis-rutin',
            'perbaikan': 'jenis-perbaikan',
        };

        const cls = map[jenis] || 'bg-secondary text-white';
        const label = jenis.charAt(0).toUpperCase() + jenis.slice(1);

        return '<span class="jenis-badge ' + cls + '">' + label + '</span>';
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

    $(document).ready(function() {

        $('#servisMobils-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('servis_mobils.data') }}',
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
                    data: null,
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return '<div class="fw-bold">' + data.mobil_name + '</div>' +
                            '<small class="text-muted">' + data.mobil_plate + '</small>';
                    },
                },
                {
                    data: 'jenis',
                    orderable: true,
                    searchable: true,
                    render: jenisBadge,
                },
                {
                    data: 'biaya',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<span class="fw-semibold">Rp ' + formatRupiahInput(data) + '</span>';
                    },
                },
                {
                    data: 'bengkel',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return data
                            ? data
                            : '<span class="text-muted">-</span>';
                    },
                },
                {
                    data: 'keterangan',
                    orderable: false,
                    searchable: true,
                    render: function(data) {
                        return data
                            ? data
                            : '<span class="text-muted">-</span>';
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
                            'title="Edit" onclick="editServisMobil(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" ' +
                            'title="Hapus" onclick="deleteServisMobil(' + data +
                            ', \'' + row.mobil_name.replace(/'/g, "\\'") + '\')">' +
                            '<i class="bi bi-trash"></i></button>' +
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
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data',
                infoFiltered: '(difilter dari _MAX_ total data)',
                loadingRecords: 'Memuat...',
                zeroRecords: 'Tidak ditemukan data yang cocok',
                emptyTable: 'Belum ada servis mobil',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

    });

    function deleteServisMobil(id, mobilName) {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin menghapus servis mobil "' + mobilName + '"?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('servis_mobils.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {
                    $('#servisMobils-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: (result && result.message) ? result.message : 'Servis mobil berhasil dihapus.',
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
                            'Terjadi kesalahan saat menghapus servis mobil.',
                    });
                }
            });
        });
    }

    function editServisMobil(id) {
        const data = $('#servisMobils-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data servis mobil tidak ditemukan.',
            });
            return;
        }

        $('#editMobilIdServis').val(data.mobil_id);
        $('#editTanggalServis').val(data.tanggal_input || data.tanggal);
        $('#editJenisServis').val(data.jenis);
        $('#editBiayaServis').val(data.biaya);
        $('#editBiayaServisDisplay').val(formatRupiahInput(data.biaya));
        $('#editBengkelServis').val(data.bengkel);
        $('#editKeteranganServis').val(data.keterangan);

        $('#formEditServisMobil').attr('action',
            "{{ route('servis_mobils.update', '__ID__') }}".replace('__ID__', id));

        bootstrap.Modal.getOrCreateInstance($('#editServisMobilModal')[0]).show();
    }

    $(document).on('submit', '#formTambahServisMobil', function(e) {
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
                bootstrap.Modal.getInstance($('#tambahServisMobilModal')[0]).hide();
                $('#formTambahServisMobil')[0].reset();
                $('#servisMobils-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Servis mobil berhasil ditambahkan.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat menambahkan servis mobil.');

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });

    $(document).on('submit', '#formEditServisMobil', function(e) {
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
                bootstrap.Modal.getInstance($('#editServisMobilModal')[0]).hide();
                $('#servisMobils-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Servis mobil berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui servis mobil.');

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