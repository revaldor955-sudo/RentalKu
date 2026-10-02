<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Klaim Kompensasi Saya - RentalKu</title>

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
        }

        .navbar {
            background: rgba(255,255,255,.95);
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 27px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .user-box {
            background: #f5f8f6;
            border-radius: 50px;
            padding: 6px 12px 6px 7px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .user-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #198754;
            color: white;
            font-size: 16px;
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

    </style>

    @include('layouts.partials.modal-head-style')
</head>

<body>

<nav class="navbar navbar-expand-lg sticky-top">

    <div class="container py-3">

        <a href="{{ route('customer.dashboard') }}" class="text-decoration-none brand">
            Rental<span>ku</span>.
        </a>

        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#customerNav" aria-controls="customerNav" aria-expanded="false" aria-label="Menu navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="customerNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('customer.dashboard') }}#mobil">Cari Mobil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('customer.dashboard') }}#rental-saya">Rental Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('customer.kompensasi.index') }}">Kompensasi</a>
                </li>
                <li class="nav-item d-lg-none">
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center gap-3 ms-2">

            <div class="user-box d-none d-md-flex"
                 data-bs-toggle="modal"
                 data-bs-target="#profileModal"
                 style="cursor: pointer;">

                <div class="user-icon">
                    <i class="bi bi-person"></i>
                </div>

                <span>
                    {{ Auth::user()->name }}
                </span>

            </div>

        </div>

    </div>

</nav>

    <div class="container py-5">

        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">

            <div>
                <h2 class="page-title mb-1">
                    Klaim Kompensasi Saya
                </h2>

                <p class="text-muted mb-0">
                    Lihat dan ajukan klaim kompensasi untuk rental yang sudah selesai.
                </p>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Dashboard
                </a>

            </div>

        </div>


        @if(session('success'))
            <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
        @endif


        @if($errors->any())

            <div class="alert alert-danger">

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
                                    Ajukan Klaim
                                </h5>

                                <small class="text-muted">
                                    Ajukan klaim baru dan pantau riwayat klaim Anda.
                                </small>

                            </div>

                            <div class="d-flex gap-2">

                                <button
                                    type="button"
                                    class="btn btn-green"
                                    data-bs-toggle="modal"
                                    data-bs-target="#ajukanKompensasiModal">

                                    <i class="bi bi-plus-circle me-1"></i>
                                    Ajukan Klaim

                                </button>

                            </div>

                        </div>

                    </div>

                    <div class="table-responsive">

                        <table class="table align-middle mb-0" id="kompensasis-table">

                            <thead>

                                <tr>

                                    <th class="px-3 py-3">
                                        No
                                    </th>

                                    <th>
                                        Tanggal
                                    </th>

                                    <th>
                                        Jenis
                                    </th>

                                    <th>
                                        Mobil
                                    </th>

                                    <th>
                                        Nominal
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Staff
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
            id="detailKompensasiModal"
            tabindex="-1">

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content">

                    @include('layouts.partials.modal-head', ['title' => 'Detail Klaim Kompensasi', 'icon' => 'bi-eye'])

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

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Staff</label>
                                <input type="text" id="detailStaff" class="form-control" readonly>
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

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            <i class="bi bi-x-circle me-1"></i>
                            Tutup

                        </button>

                    </div>

                </div>

            </div>

        </div>


        <div
            class="modal fade"
            id="ajukanKompensasiModal"
            tabindex="-1">

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content">

                    @include('layouts.partials.modal-head', ['title' => 'Ajukan Klaim Kompensasi', 'icon' => 'bi-plus-circle'])

                    <form
                        action="{{ route('customer.kompensasi.store') }}"
                        method="POST"
                        id="formAjukanKompensasi">

                        @csrf

                        <div class="modal-body">

                            <label class="form-label fw-semibold">
                                Rental (Status Selesai)
                            </label>

                            <select name="rental_id" id="ajuanRentalId" class="form-select" required>
                                <option value="">-- Pilih Rental --</option>
                                @foreach($rentals as $rental)
                                    <option value="{{ $rental->id }}" data-mobil="{{ $rental->mobil->id }}" data-mobil-name="{{ $rental->mobil->name }}" data-plate="{{ $rental->mobil->plate_number }}" data-image="{{ $rental->mobil->image ? asset($rental->mobil->image) : '' }}" data-mulai="{{ $rental->tanggal_mulai->format('d/m/Y') }}" data-selesai="{{ $rental->tanggal_selesai->format('d/m/Y') }}">
                                        {{ $rental->mobil->name ?? '-' }} ({{ $rental->mobil->plate_number ?? '-' }})
                                    </option>
                                @endforeach
                            </select>

                            <label class="form-label fw-semibold mt-3">
                                Mobil
                            </label>

                            <input type="hidden" name="mobil_id" id="ajuanMobilId">

                            <div id="mobilEmpty" class="text-muted small border rounded-3 p-3">
                                Pilih rental dulu untuk melihat mobil.
                            </div>

                            <div id="mobilCard" class="d-none border rounded-3 p-3" style="background: #f5f8f6;">

                                <div class="d-flex gap-3 align-items-center">

                                    <img id="mobilCardImg" src="" alt="Foto mobil" style="width: 96px; height: 72px; object-fit: cover; border-radius: 10px;">

                                    <div>

                                        <div id="mobilCardName" class="fw-bold"></div>

                                        <small id="mobilCardPlate" class="text-muted d-block"></small>

                                        <small id="mobilCardPeriod" class="text-muted d-block"></small>

                                    </div>

                                </div>

                            </div>

                            <label class="form-label fw-semibold mt-3">
                                Jenis Kompensasi
                            </label>

                            <select name="jenis" id="ajuanJenis" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="pengembalian_dana">Pengembalian Dana</option>
                                <option value="diskon">Diskon Sewa Berikutnya</option>
                                <option value="gratis_sewa">Gratis Sewa Berikutnya</option>
                            </select>

                            <label class="form-label fw-semibold mt-3">
                                Nominal (Rp)
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input
                                    type="text"
                                    name="nominal_display"
                                    id="ajuanNominalDisplay"
                                    class="form-control rupiah-input"
                                    placeholder="50.000"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    data-target="nominal"
                                    required>
                                <input
                                    type="hidden"
                                    name="nominal"
                                    id="nominal">
                            </div>

                                <script>
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
                                        </script>
                                        </div>

                            <small class="text-muted" id="nominalHint">Wajib diisi untuk jenis "Pengembalian Dana"</small>

                            <label class="form-label fw-semibold mt-3">
                                Alasan
                            </label>

                            <textarea
                                name="alasan"
                                class="form-control"
                                rows="3"
                                placeholder="Jelaskan alasan klaim kompensasi..."
                                required></textarea>

                            <label class="form-label fw-semibold mt-3">
                                Tanggal Kejadian
                            </label>

                            <input
                                type="date"
                                name="tanggal"
                                class="form-control"
                                value="{{ now()->format('Y-m-d') }}"
                                max="{{ now()->format('Y-m-d') }}"
                                required>

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

                                <i class="bi bi-send me-1"></i>
                                Kirim Klaim

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

    @include('layouts.partials.profile-modal')

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
                'pengembalian_dana': 'jenis-pengembalian-dana',
                'diskon': 'jenis-diskon',
                'gratis_sewa': 'jenis-gratis-sewa',
            };

            const cls = map[jenis] || 'bg-secondary text-white';
            const labels = {
                'pengembalian_dana': 'Pengembalian Dana',
                'diskon': 'Diskon',
                'gratis_sewa': 'Gratis Sewa',
            };

            return '<span class="jenis-badge ' + cls + '">' + (labels[jenis] || jenis) + '</span>';
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

            $('#ajuanRentalId').on('change', function() {
                const opt = $(this).find('option:selected');
                const mobilId = opt.data('mobil');

                if (mobilId) {
                    $('#ajuanMobilId').val(mobilId);
                    $('#mobilCardName').text(opt.data('mobil-name'));
                    $('#mobilCardPlate').text(opt.data('plate'));
                    $('#mobilCardPeriod').text('Disewa ' + opt.data('mulai') + ' - ' + opt.data('selesai'));

                    const img = opt.data('image');
                    if (img) {
                        $('#mobilCardImg').attr('src', img).attr('alt', opt.data('mobil-name')).show();
                    } else {
                        $('#mobilCardImg').hide();
                    }

                    $('#mobilCard').removeClass('d-none');
                    $('#mobilEmpty').addClass('d-none');
                } else {
                    $('#ajuanMobilId').val('');
                    $('#mobilCard').addClass('d-none');
                    $('#mobilEmpty').removeClass('d-none');
                }
            });

            $('#ajuanJenis').on('change', function() {
                const jenis = $(this).val();
                if (jenis === 'pengembalian_dana') {
                    $('#ajuanNominal').prop('required', true);
                    $('#nominalHint').text('Wajib diisi untuk jenis "Pengembalian Dana"');
                } else {
                    $('#ajuanNominal').prop('required', false).val('');
                    $('#nominalHint').text('Tidak diisi untuk Diskon/Gratis Sewa (nominal = 0)');
                }
            });

            $('#kompensasis-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('customer.kompensasi.data') }}',
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

            @if(request('baru'))
                @if(request('rental') && $rentals->contains('id', (int) request('rental')))
                    $('#ajuanRentalId').val('{{ (int) request('rental') }}');
                @endif
                bootstrap.Modal.getOrCreateInstance($('#ajukanKompensasiModal')[0]).show();
                $('#ajuanRentalId').trigger('change');
            @endif
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
            var jenisLabels = { pengembalian_dana: 'Pengembalian Dana', diskon: 'Diskon', gratis_sewa: 'Gratis Sewa' };
            var statusLabels = { diajukan: 'Diajukan', disetujui: 'Disetujui', ditolak: 'Ditolak', selesai: 'Selesai' };
            $('#detailJenis').val(jenisLabels[data.jenis] || 'Gratis Sewa');
            $('#detailMobil').val(data.mobil_name + ' (' + data.mobil_plate + ')');
            $('#detailNominal').val(formatRupiah(data.nominal));
            $('#detailStatus').val(statusLabels[data.status] || 'Selesai');
            $('#detailStaff').val(data.staff_name);
            $('#detailAlasan').val(data.alasan);
            $('#detailCatatan').val(data.catatan || '-');

            bootstrap.Modal.getOrCreateInstance($('#detailKompensasiModal')[0]).show();
        }

        $(document).on('submit', '#formAjukanKompensasi', function(e) {
            e.preventDefault();

            const form = this;
            const rentalText = $('#ajuanRentalId option:selected').text().trim();
            const jenisText = $('#ajuanJenis option:selected').text().trim();

            Swal.fire({
                title: 'Ajukan klaim ini?',
                html: 'Klaim <strong>' + jenisText + '</strong> untuk <strong>' + rentalText + '</strong> akan dikirim dan tidak bisa diubah.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, ajukan',
                cancelButtonText: 'Periksa lagi',
            }).then(function(result) {
                if (result.isConfirmed) kirimKlaim(form);
            });
        });

        function kirimKlaim(form) {
            const formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
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
                    bootstrap.Modal.getInstance($('#ajukanKompensasiModal')[0]).hide();
                    $('#formAjukanKompensasi')[0].reset();
                    $('#kompensasis-table').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message || 'Klaim kompensasi berhasil diajukan.',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                },
                error: function(xhr) {
                    const r = xhr.responseJSON || {};
                    const msg = r.errors ? Object.values(r.errors)[0][0] :
                        (r.message || 'Terjadi kesalahan saat mengajukan klaim.');

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg,
                    });
                }
            });
        }

    </script>

</body>

</html>