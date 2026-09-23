<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pemeriksaan Kendaraan - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background: #f6f8f7;
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            text-transform: uppercase;
            background: #f8faf9;
            border-bottom: 1px solid #e9ecef;
        }

        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        #pemeriksaan-table thead .dt-column-order {
            display: none !important;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-baik {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-rusak {
            background: #f8d7da;
            color: #842029;
        }

        .badge-jenis {
            background: #e2e8f0;
            color: #334155;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 20px;
        }

    </style>
</head>

<body>

    @include('layouts.partials.admin-navbar')


    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="page-title mb-1">
                    Pemeriksaan Kendaraan
                </h2>

                <p class="text-muted mb-0">
                    Catat kondisi kendaraan sebelum dan sesudah sewa.
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-1"></i>
                    Dashboard

                </a>

                <button type="button" class="btn btn-success" onclick="openTambahModal()">

                    <i class="bi bi-plus-lg me-1"></i>
                    Tambah Pemeriksaan

                </button>

            </div>

        </div>


        <div class="card-custom">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0" id="pemeriksaan-table">

                        <thead>

                            <tr>

                                <th class="px-3 py-3">
                                    No
                                </th>

                                <th>
                                    Pelanggan
                                </th>

                                <th>
                                    Mobil
                                </th>

                                <th>
                                    Jenis
                                </th>

                                <th>
                                    Kondisi
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Kerusakan
                                </th>

                                <th>
                                    Foto Bukti
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


    <div class="modal fade" id="pemeriksaanModal" tabindex="-1" aria-labelledby="pemeriksaanModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title" id="pemeriksaanModalLabel">
                        <i class="bi bi-clipboard-check me-2"></i>
                        Tambah Pemeriksaan
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>

                </div>

                <form id="formPemeriksaan">

                    <div class="modal-body p-4">

                        <input type="hidden" id="pemeriksaanId" name="id">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Rental
                                </label>

                                <select name="rental_id" id="rentalId" class="form-select" required>

                                    <option value="">
                                        -- Pilih Rental --
                                    </option>

                                    @foreach ($rentals as $rental)
                                        <option value="{{ $rental->id }}">
                                            {{ $rental->user->name ?? '-' }} — {{ $rental->mobil->name ?? '-' }}
                                            ({{ $rental->status }})
                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Tanggal Pemeriksaan
                                </label>

                                <input
                                    type="datetime-local"
                                    name="tanggal"
                                    id="tanggal"
                                    class="form-control"
                                    required
                                >

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Jenis Pemeriksaan
                                </label>

                                <select name="jenis" id="jenis" class="form-select" required>

                                    <option value="">
                                        -- Pilih Jenis --
                                    </option>

                                    <option value="sebelum_sewa">
                                        Sebelum Sewa
                                    </option>

                                    <option value="setelah_sewa">
                                        Setelah Sewa
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-bold">
                                    Kondisi
                                </label>

                                <select name="kondisi" id="kondisi" class="form-select" required>

                                    <option value="">
                                        -- Pilih Kondisi --
                                    </option>

                                    <option value="baik">
                                        Baik
                                    </option>

                                    <option value="rusak">
                                        Rusak
                                    </option>

                                </select>

                            </div>

                            <div class="col-12">

                                <label class="form-label fw-bold">
                                    Kerusakan (jika ada)
                                </label>

                                <div class="row g-2" id="kerusakanContainer">

                                    @foreach ($kerusakanList as $kerusakan)
                                        <div class="col-md-4">

                                            <div class="form-check border rounded-3 px-3 py-2">

                                                <input
                                                    class="form-check-input kerusakan-check"
                                                    type="checkbox"
                                                    name="kerusakan[]"
                                                    value="{{ $kerusakan->id }}"
                                                    id="kerusakan-{{ $kerusakan->id }}"
                                                >

                                                <label class="form-check-label" for="kerusakan-{{ $kerusakan->id }}">
                                                    {{ $kerusakan->jenis_kerusakan }}
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control form-control-sm mt-1 kerusakan-keterangan"
                                                    name="keterangan[{{ $kerusakan->id }}]"
                                                    placeholder="Keterangan (opsional)"
                                                    disabled
                                                >

                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                            </div>

                            <div class="col-12">

                                <label class="form-label fw-bold">
                                    Foto Bukti
                                </label>

                                <input
                                    type="file"
                                    name="foto_bukti"
                                    id="fotoBukti"
                                    class="form-control"
                                    accept="image/*"
                                >

                            </div>

                            <div class="col-12">

                                <label class="form-label fw-bold">
                                    Catatan
                                </label>

                                <textarea
                                    name="catatan"
                                    id="catatan"
                                    class="form-control"
                                    rows="3"
                                    placeholder="Catatan pemeriksaan (opsional)"
                                ></textarea>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-success">
                            Simpan
                        </button>

                    </div>

                </form>

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

        function resetForm() {
            $('#formPemeriksaan')[0].reset();
            $('#pemeriksaanId').val('');
            $('.kerusakan-keterangan').prop('disabled', true);
            $('#fotoBukti').val('');
        }

        function openTambahModal() {
            resetForm();
            $('#pemeriksaanModalLabel').text('Tambah Pemeriksaan');
            bootstrap.Modal.getOrCreateInstance($('#pemeriksaanModal')[0]).show();
        }

        function openEditModal(id) {
            const row = $('#pemeriksaan-table').DataTable().rows().data().toArray().find(r => r.id === id);
            if (!row) return;

            resetForm();
            $('#pemeriksaanModalLabel').text('Edit Pemeriksaan');
            $('#pemeriksaanId').val(row.id);
            $('#rentalId').val(row.rental_id);
            $('#jenis').val(row.jenis);
            $('#kondisi').val(row.kondisi);
            $('#catatan').val(row.catatan === '-' ? '' : row.catatan);

            if (row.tanggal && row.tanggal !== '-') {
                const [d, t] = row.tanggal.split(' ');
                const [dd, mm, yyyy] = d.split('/');
                $('#tanggal').val(yyyy + '-' + mm + '-' + dd + 'T' + t);
            }

            (row.kerusakan_ids || []).forEach(function(kerusakanId) {
                $('#kerusakan-' + kerusakanId).prop('checked', true);
                const keterangan = (row.keterangan || {})[kerusakanId] || '';
                $('#kerusakan-' + kerusakanId).closest('.form-check')
                    .find('.kerusakan-keterangan')
                    .prop('disabled', false)
                    .val(keterangan);
            });

            bootstrap.Modal.getOrCreateInstance($('#pemeriksaanModal')[0]).show();
        }

        function hapusPemeriksaan(id) {
            Swal.fire({
                title: 'Hapus Pemeriksaan?',
                text: 'Data pemeriksaan akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then(function(result) {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: "{{ route('pemeriksaan-kendaraan.destroy', '__ID__') }}".replace('__ID__', id),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                    },
                    success: function(res) {
                        $('#pemeriksaan-table').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message || 'Pemeriksaan berhasil dihapus.',
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

        $(document).on('change', '.kerusakan-check', function() {
            $(this).closest('.form-check').find('.kerusakan-keterangan')
                .prop('disabled', !this.checked);
        });

        $('#formPemeriksaan').on('submit', function(e) {
            e.preventDefault();

            const id = $('#pemeriksaanId').val();
            const url = id ?
                "{{ route('pemeriksaan-kendaraan.update', '__ID__') }}".replace('__ID__', id) :
                "{{ route('pemeriksaan-kendaraan.store') }}";

            const formData = new FormData(this);
            if (id) formData.append('_method', 'PUT');

            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    bootstrap.Modal.getInstance($('#pemeriksaanModal')[0]).hide();
                    $('#pemeriksaan-table').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message || 'Pemeriksaan berhasil disimpan.',
                    });
                },
                error: function(xhr) {
                    const res = xhr.responseJSON || {};
                    const msg = res.message || 'Terjadi kesalahan';

                    if (res.errors) {
                        const first = Object.values(res.errors)[0][0];
                        Swal.fire({ icon: 'error', title: 'Validasi Gagal', text: first });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                    }
                },
            });
        });

        $(document).ready(function() {

            $('#pemeriksaan-table').DataTable({
                processing: true,
                serverSide: true,
               
ajax: {
    url: "{{ route('pemeriksaan-kendaraan.data') }}",
    dataType: 'json',
    headers: {
        'Accept': 'application/json',
    },
    error: function(xhr, status, error) {

        console.error('STATUS:', xhr.status);
        console.error('ERROR:', error);
        console.error('RESPONSE:', xhr.responseText);

        let pesan = 'Gagal memuat data pemeriksaan.';

        if (xhr.status === 500) {
            pesan = 'Terjadi error pada server Laravel. Cek terminal atau log Laravel.';
        } else if (xhr.status === 419) {
            pesan = 'Sesi halaman telah kedaluwarsa. Silakan refresh halaman.';
        } else if (xhr.status === 403) {
            pesan = 'Kamu tidak memiliki izin mengakses data ini.';
        } else if (xhr.status === 404) {
            pesan = 'Route data pemeriksaan tidak ditemukan.';
        }

        alert(
            pesan +
            '\n\nStatus HTTP: ' + xhr.status +
            '\n\nBuka F12 → Console untuk melihat detail.'
        );
    },
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
            data: null,
            searchable: false,
            render: function(data) {
                return '<div class="fw-bold">' + (data.user_name || '-') + '</div>' +
                '<small class="text-muted">' + (data.user_email || '-') + '</small>';
        },
    },

        {
            data: null,
            searchable: false,
            render: function(data) {
                return '<div class="fw-bold">' + (data.mobil_name || '-') + '</div>' +
                '<small class="text-muted">' + (data.mobil_plate || '-') + '</small>';
        },
    },

        {
            data: 'jenis',
        searchable: false,
        render: function(data) {
            return '<span class="badge-jenis">' +
                (data === 'sebelum_sewa' ? 'Sebelum Sewa' : 'Setelah Sewa') +
                '</span>';
        },
    },

        {
            data: 'kondisi',
        searchable: false,
        render: function(data) {
            return '<span class="status status-' + data + '">' +
                (data === 'baik' ? 'Baik' : 'Rusak') +
                '</span>';
        },
    },

        {
            data: 'tanggal',
        searchable: false,
    },

        {
            data: 'kerusakan',
        orderable: false,
        searchable: false,
        render: function(data) {
            if (!data || data.trim() === '') {
                return '<span class="text-muted">Tidak ada kerusakan</span>';
            }

            return '<span class="text-danger fw-semibold">' +
                data +
                '</span>';
        },
    },

        {
            data: 'foto_bukti',
        orderable: false,
        searchable: false,
        render: function(data) {
            if (!data) {
                return '<span class="text-muted">Tidak ada foto</span>';
            }

            const fotoUrl = "{{ asset('storage') }}/" + data;

            return `
                <a href="${fotoUrl}" target="_blank" title="Lihat Foto Bukti">
                    <img src="${fotoUrl}"
                         alt="Foto Bukti"
                         style="width: 65px;
                                height: 50px;
                                object-fit: cover;
                                border-radius: 8px;
                                border: 1px solid #ddd;">
                </a>
            `;
        },
    },

        {
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-end pe-4',
        width: '140px',
        render: function(data) {
            return '<div class="d-flex justify-content-end gap-2">' +

                '<button type="button" class="btn p-1 text-primary" ' +
                'style="border:none;background:none;" ' +
                'onclick="openEditModal(' + data.id + ')">' +
                '<i class="bi bi-pencil-square"></i></button>' +

                '<button type="button" class="btn p-1 text-danger" ' +
                'style="border:none;background:none;" ' +
                'onclick="hapusPemeriksaan(' + data.id + ')">' +
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
                    emptyTable: 'Belum ada pemeriksaan',
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