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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background: #f6f8f7;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            margin: 0;
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

        .table thead th {
            background: #f8faf9;
            color: #6c757d;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
            border-bottom: 1px solid #e9ecef;
            padding: 12px 16px;
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

        .page-content {
            padding: 24px;
        }

        .pager-bar{background:#fff;border:1px solid #edf0ee;border-radius:16px;box-shadow:0 8px 20px rgba(0,0,0,0.05);padding:12px 16px;font-size:14px}
        .pager-bar .text-secondary{font-size:14px;font-weight:500}.pager-select{width:auto;border-radius:10px;font-size:13px;height:34px;padding:6px 28px 6px 10px}
        .pager-jump{width:72px;border-radius:10px;text-align:center;font-size:13px;height:34px;padding:6px 8px}
        .pager-btn{border:1px solid #dee2e6;border-radius:10px;color:#1f2937;font-weight:600;background:#fff;font-size:13px;height:34px;display:inline-flex;align-items:center;padding:6px 12px}
        .pager-btn:hover{border-color:#198754;color:#198754;background:#f5f7f6}
        .pager-btn.disabled{opacity:0.4;pointer-events:none}
        .pager-next{background:#198754;border-color:#198754;color:#fff}
        .pager-next:hover{background:#146c43;border-color:#146c43;color:#fff}

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
                Pemeriksaan Kendaraan
            </h2>

            <p class="text-muted mb-0">
                Catat kondisi kendaraan sebelum dan sesudah sewa.
            </p>
        </div>

        <div class="d-flex gap-2">

            <button type="button" class="btn btn-green" onclick="openTambahModal()">

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

                            <th class="text-end pe-4">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>
                    </tbody>

                </table>

                <div class="pager-bar mt-3 d-flex flex-wrap align-items-center justify-content-between gap-3" id="pemeriksaan-pager">
                    <div class="text-secondary small" id="pemeriksaan-info">
                        Menampilkan 0–0 dari 0 data
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <select id="pemeriksaan-len" class="form-select form-select-sm pager-select" aria-label="Jumlah per halaman">
                            <option value="10">10 / halaman</option>
                            <option value="20">20 / halaman</option>
                            <option value="50">50 / halaman</option>
                            <option value="100">100 / halaman</option>
                            <option value="custom">Custom</option>
                        </select>
                        <input type="number" id="pemeriksaan-custom" class="form-control form-control-sm pager-jump" min="1" max="500" value="10" aria-label="Jumlah custom per halaman">
                        <span class="text-secondary" id="pemeriksaan-page">Halaman 1 / 1</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm pager-btn" id="pemeriksaan-first">First</button>
                        <button type="button" class="btn btn-sm pager-btn" id="pemeriksaan-prev" aria-label="Halaman sebelumnya">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm pager-btn pager-next" id="pemeriksaan-next" aria-label="Halaman berikutnya">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <button type="button" class="btn btn-sm pager-btn" id="pemeriksaan-last">Last</button>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="pemeriksaanModal" tabindex="-1" aria-labelledby="pemeriksaanModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            @include('layouts.partials.modal-head', ['title' => 'Tambah Pemeriksaan', 'icon' => 'bi-clipboard-check', 'titleId' => 'pemeriksaanModalLabel'])

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

                    <button type="submit" class="btn btn-green">
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
    }

    function openTambahModal() {
        resetForm();
        $('#pemeriksaanModalLabel').html('<i class="bi bi-clipboard-check me-2"></i>Tambah Pemeriksaan');
        bootstrap.Modal.getOrCreateInstance($('#pemeriksaanModal')[0]).show();
    }

    function openEditModal(id) {
        const row = $('#pemeriksaan-table').DataTable().rows().data().toArray().find(r => r.id === id);
        if (!row) return;

        resetForm();
        $('#pemeriksaanModalLabel').html('<i class="bi bi-clipboard-check me-2"></i>Edit Pemeriksaan');
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

    function statusBadge(kondisi) {
        const map = {
            'baik': 'status-baik',
            'rusak': 'status-rusak',
        };

        const cls = map[kondisi] || 'status-rusak';

        return '<span class="status ' + cls + '">' + (kondisi === 'baik' ? 'Baik' : 'Rusak') + '</span>';
    }

    $(document).ready(function() {

        $('#pemeriksaan-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            dom: 'frt',
            ajax: {
                url: "{{ route('pemeriksaan-kendaraan.data') }}",
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
                    data: 'jenis',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return '<span class="badge-jenis">' +
                            (data === 'sebelum_sewa' ? 'Sebelum Sewa' : 'Setelah Sewa') +
                            '</span>';
                    },
                },
                {
                    data: 'kondisi',
                    orderable: true,
                    searchable: false,
                    render: function(data) {
                        return statusBadge(data);
                    },
                },
                {
                    data: 'tanggal',
                    orderable: true,
                    searchable: false,
                },
                {
                    data: 'kerusakan',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (!data || !data.length) return '<span class="text-muted">-</span>';
                        return data.map(function(k) {
                            return '<span class="badge bg-danger me-1">' + k + '</span>';
                        }).join('');
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
                            '<button type="button" class="btn p-1 text-primary" style="border:none;background:none;" title="Edit" ' +
                            'onclick="openEditModal(' + data.id + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" style="border:none;background:none;" title="Hapus" ' +
                            'onclick="hapusPemeriksaan(' + data.id + ')">' +
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
                emptyTable: 'Belum ada pemeriksaan',
                aria: {
                    sortAscending: ': aktifkan untuk urut naik',
                    sortDescending: ': aktifkan untuk urut turun',
                },
            },
        });

        var pemeriksaanTable = $('#pemeriksaan-table').DataTable();

        function renderPemeriksaanPager() {
            var info = pemeriksaanTable.page.info();
            var total=info.recordsDisplay; var start=total?info.start+1:0;
            $('#pemeriksaan-info').text('Menampilkan '+start+'–'+info.end+' dari '+total+' data');
            var pages = info.pages || 1;
            var page = info.page + 1;
            $('#pemeriksaan-page').text('Halaman '+(pages?info.page+1:0)+' / '+pages);
            $('#pemeriksaan-first').toggleClass('disabled', page <= 1);
            $('#pemeriksaan-prev').toggleClass('disabled', page <= 1);
            $('#pemeriksaan-next').toggleClass('disabled', page >= pages);
            $('#pemeriksaan-last').toggleClass('disabled', page >= pages);
        }

        pemeriksaanTable.on('draw.dt', renderPemeriksaanPager);
        renderPemeriksaanPager();

        $('#pemeriksaan-first').on('click', function() { pemeriksaanTable.page('first').draw('page'); });
        $('#pemeriksaan-prev').on('click', function() { pemeriksaanTable.page('previous').draw('page'); });
        $('#pemeriksaan-next').on('click', function() { pemeriksaanTable.page('next').draw('page'); });
        $('#pemeriksaan-last').on('click', function() { pemeriksaanTable.page('last').draw('page'); });
        $('#pemeriksaan-len').on('change', function() {
            if ($(this).val() === 'custom') { $('#pemeriksaan-custom').focus(); return; }
            var n = Number($(this).val());
            $('#pemeriksaan-custom').val(n);
            pemeriksaanTable.page.len(n).draw();
        });
        $('#pemeriksaan-custom').on('change', function() {
            var n = parseInt($(this).val(), 10) || 1;
            n = Math.min(Math.max(n, 1), 500);
            $(this).val(n);
            if (['10','20','50','100'].indexOf(String(n)) !== -1) { $('#pemeriksaan-len').val(String(n)); }
            else { $('#pemeriksaan-len').val('custom'); }
            pemeriksaanTable.page.len(n).draw();
        });

    });

</script>

</body>

</html>
