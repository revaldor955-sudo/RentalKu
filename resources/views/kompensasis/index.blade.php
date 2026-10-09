<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Management Kompensasi - RentalKu</title>

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

        /* Sort DataTables disembunyikan: server-side diurut via kolom Status (order) */
        #kompensasis-table thead .dt-column-order {
            display: none !important;
        }

        .jenis-badge {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .jenis-pengembalian-dana { background: #e7f1ff; color: #0d6efd; }
        .jenis-diskon { background: #d1e7dd; color: #0f5132; }
        .jenis-gratis-sewa { background: #fff3cd; color: #997404; }

        .status-diajukan { background: #fff3cd; color: #997404; }
        .status-disetujui { background: #d1e7dd; color: #0f5132; }
        .status-ditolak { background: #f8d7da; color: #b02a37; }
        .status-selesai { background: #e7f1ff; color: #0d6efd; }

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
        if (!mainContent) return;
        const pageContent = mainContent.querySelector('.page-content');
        const navbar = document.querySelector('header.topbar');
        if (pageContent && navbar) mainContent.insertBefore(navbar, pageContent);
    });
</script>

<div class="page-content">
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Management Kompensasi</h2>
            <p class="text-muted mb-0">Kelola klaim kompensasi pelanggan (pengembalian dana, diskon, gratis sewa).</p>
        </div>
    </div>

    @if(session('success'))
        <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <strong>Terdapat kesalahan:</strong>
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
                <div class="table-responsive">
                    <table class="table align-middle mb-0" id="kompensasis-table">
                        <thead>
                            <tr>
                                <th class="px-3 py-3">No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Pelanggan</th>
                                <th>Mobil</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Staff</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailKompensasiModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                @include('layouts.partials.modal-head', ['title' => 'Detail Kompensasi', 'icon' => 'bi-eye'])
                <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal</label>
                                <input type="text" id="detailTanggal" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis</label>
                                <input type="text" id="detailJenis" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pelanggan</label>
                                <input type="text" id="detailPelanggan" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mobil</label>
                                <input type="text" id="detailMobil" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nominal</label>
                                <input type="text" id="detailNominal" class="form-control" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <input type="text" id="detailStatus" class="form-control" readonly>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Alasan</label>
                                <textarea id="detailAlasan" class="form-control" rows="3" readonly></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Catatan Staff</label>
                                <textarea id="detailCatatan" class="form-control" rows="3" readonly></textarea>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>
                            Tutup
                        </button>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editKompensasiModal" tabindex="-1" aria-labelledby="editKompensasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            @include('layouts.partials.modal-head', ['title' => 'Edit Status Kompensasi', 'icon' => 'bi-pencil-square', 'titleId' => 'editKompensasiModalLabel'])
            <form action="" method="POST" id="formUpdateKompensasi">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" id="editStatusKompensasi" class="form-select" required>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Catatan Staff</label>
                        <textarea name="catatan" id="editCatatanKompensasi" class="form-control" rows="3" placeholder="Catatan staff..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        Batal
                    </button>
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
            'pengembalian_dana': ['jenis-pengembalian-dana', 'Pengembalian Dana'],
            'diskon': ['jenis-diskon', 'Diskon'],
            'gratis_sewa': ['jenis-gratis-sewa', 'Gratis Sewa'],
        };
        const item = map[jenis] || ['bg-secondary text-white', jenis];
        return '<span class="jenis-badge ' + item[0] + '">' + item[1] + '</span>';
    }

    function statusBadge(status) {
        const map = {
            'diajukan': 'status-diajukan',
            'disetujui': 'status-disetujui',
            'ditolak': 'status-ditolak',
            'selesai': 'status-selesai',
        };

        const cls = map[status] || 'bg-secondary text-white';
        const label = status.charAt(0).toUpperCase() + status.slice(1);

        return '<span class="jenis-badge ' + cls + '">' + label + '</span>';
    }

    function formatRupiah(value) {
        return 'Rp ' + Number(value).toLocaleString('id-ID');
    }

    $(document).ready(function() {

        $('#kompensasis-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('kompensasis.data') }}',
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
                    data: 'jenis',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return jenisBadge(data);
                    },
                },
                {
                    data: null,
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return '<strong>' + data.customer_name + '</strong>' +
                            '<div class="small text-muted">' + data.customer_email + '</div>';
                    },
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
                    data: 'nominal',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<span class="fw-semibold">' + formatRupiah(data) + '</span>';
                    },
                },
                {
                    data: 'status',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return statusBadge(data);
                    },
                },
                {
                    data: 'staff_name',
                    orderable: false,
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
                            'title="Detail" onclick="openDetail(' + data + ')">' +
                            '<i class="bi bi-eye"></i></button>' +
                            '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" ' +
                            'title="Edit" onclick="openEditKompensasi(' + data + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '</div>';
                    },
                },
            ],
            order: [
                [6, 'desc']
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
                emptyTable: 'Belum ada klaim kompensasi',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

    });

    function openDetail(id) {
        const data = $('#kompensasis-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data kompensasi tidak ditemukan.',
            });
            return;
        }

        $('#detailTanggal').val(data.tanggal);
        $('#detailJenis').val(({ 'pengembalian_dana': 'Pengembalian Dana', 'diskon': 'Diskon', 'gratis_sewa': 'Gratis Sewa' })[data.jenis] || data.jenis);
        $('#detailPelanggan').val(data.customer_name + ' (' + data.customer_email + ')');
        $('#detailMobil').val(data.mobil_name + ' (' + data.mobil_plate + ')');
        $('#detailNominal').val(formatRupiah(data.nominal));
        $('#detailStatus').val(data.status.charAt(0).toUpperCase() + data.status.slice(1));
        $('#detailAlasan').val(data.alasan);
        $('#detailCatatan').val(data.catatan || '');

        bootstrap.Modal.getOrCreateInstance($('#detailKompensasiModal')[0]).show();
    }

    function openEditKompensasi(id) {
        const data = $('#kompensasis-table').DataTable().rows().data().toArray()
            .find(r => r.id == id);

        if (!data) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Data kompensasi tidak ditemukan.',
            });
            return;
        }

        const statusValid = ['disetujui', 'ditolak', 'selesai'].includes(data.status)
            ? data.status
            : 'disetujui';

        $('#editStatusKompensasi').val(statusValid);
        $('#editCatatanKompensasi').val(data.catatan || '');

        $('#formUpdateKompensasi').attr('action',
            "{{ route('kompensasis.update', '__ID__') }}".replace('__ID__', id));

        bootstrap.Modal.getOrCreateInstance($('#editKompensasiModal')[0]).show();
    }

    $(document).on('submit', '#formUpdateKompensasi', function(e) {
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
                bootstrap.Modal.getInstance($('#editKompensasiModal')[0]).hide();
                $('#kompensasis-table').DataTable().ajax.reload();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: result.message || 'Kompensasi berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(xhr) {
                const r = xhr.responseJSON || {};
                const msg = r.errors ? Object.values(r.errors)[0][0] :
                    (r.message || 'Terjadi kesalahan saat memperbarui kompensasi.');

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