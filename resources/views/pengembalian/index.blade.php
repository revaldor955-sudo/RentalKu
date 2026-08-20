<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengembalian Mobil - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background: #f6f8f7;
            font-family: Arial, sans-serif;
        }

        .page-title {
            font-weight: 800;
            color: #1f2937;
        }

        .card-custom {
            background: white;
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
        }

        .table th {
            font-size: 13px;
            color: #6b7280;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-disetujui {
            background: #d1e7dd;
            color: #0f5132;
        }

        .btn-action {
            border-radius: 9px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    @include('layouts.partials.admin-navbar')


    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="page-title mb-1">
                    Pengembalian Mobil
                </h2>

                <p class="text-muted mb-0">
                    Proses pengembalian kendaraan yang sedang disewa pelanggan.
                </p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>
                Dashboard

            </a>

        </div>


        <div class="card-custom">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0" id="pengembalian-table">

                        <thead>

                            <tr>

                                <th class="px-4 py-3">
                                    #
                                </th>

                                <th>
                                    Pelanggan
                                </th>

                                <th>
                                    Mobil
                                </th>

                                <th>
                                    Tanggal Sewa
                                </th>

                                <th>
                                    Hari
                                </th>

                                <th>
                                    Total
                                </th>

                                <th class="text-end pe-4">
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        const CSRF_TOKEN = '{{ csrf_token() }}';

        function formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }

        function prosesPengembalian(id, mobil) {
            Swal.fire({
                title: 'Proses Pengembalian?',
                text: 'Mobil ' + mobil + ' akan dikembalikan dan berstatus "Tersedia".',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kembalikan',
                cancelButtonText: 'Batal',
            }).then(function(result) {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: "{{ route('rentals.updateStatus', '__ID__') }}".replace('__ID__', id),
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                    },
                    data: {
                        status: 'Selesai'
                    },
                    success: function(res) {
                        $('#pengembalian-table').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message || 'Pengembalian berhasil diproses.',
                        });
                    },
                    error: function(xhr) {
                        const res = xhr.responseJSON || {};
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message || 'Terjadi kesalahan',
                        });
                    },
                });
            });
        }

        $(document).ready(function() {

            $('#pengembalian-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('rentals.data') }}",
                    type: 'GET',
                    data: function(d) {
                        d.status = 'Disetujui';
                    },
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
                        data: null,
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return '<div class="fw-bold">' + data.user_name + '</div>' +
                                '<small class="text-muted">' + data.user_email + '</small>';
                        },
                    },
                    {
                        data: null,
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return '<div class="fw-bold">' + data.mobil_name + '</div>' +
                                '<small class="text-muted">' + data.mobil_plate + '</small>';
                        },
                    },
                    {
                        data: null,
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return data.tanggal_mulai + '<br>' +
                                '<small class="text-muted">s/d ' + data.tanggal_selesai +
                                '</small>';
                        },
                    },
                    {
                        data: 'jumlah_hari',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return data + ' hari';
                        },
                    },
                    {
                        data: 'total_harga',
                        orderable: true,
                        searchable: false,
                        render: function(data) {
                            return '<strong>' + formatRupiah(data) + '</strong>';
                        },
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-end pe-4',
                        render: function(data) {
                            return '<button type="button" class="btn btn-primary btn-sm btn-action" ' +
                                'onclick="prosesPengembalian(' + data.id + ', \'' +
                                data.mobil_name.replace(/'/g, "\\'") + '\')">' +
                                '<i class="bi bi-arrow-return-left"></i> Proses Pengembalian</button>';
                        },
                    },
                ],
                order: [
                    [3, 'desc']
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
                    emptyTable: 'Tidak ada rental yang sedang berjalan',
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
    </script>

</body>

</html>