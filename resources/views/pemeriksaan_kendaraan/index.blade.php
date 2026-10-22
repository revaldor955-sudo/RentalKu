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
            background: #fff;
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
        }

        .table th {
            font-size: 12px;
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
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 18px;
        }

        .btn-green:hover {
            background: #146c43;
            color: #fff;
        }

        .page-content {
            padding: 24px;
        }

        .pager-bar {
            background: #fff;
            border: 1px solid #edf0ee;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
            padding: 12px 16px;
            font-size: 14px;
        }

        .pager-bar .text-secondary {
            font-size: 13px;
            font-weight: 500;
        }

        .pager-select {
            width: auto;
            border-radius: 10px;
            font-size: 13px;
            height: 34px;
            padding: 6px 28px 6px 10px;
        }

        .pager-jump {
            width: 72px;
            border-radius: 10px;
            text-align: center;
            font-size: 13px;
            height: 34px;
        }

        .pager-btn {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            color: #1f2937;
            font-weight: 600;
            background: #fff;
            font-size: 13px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
        }

        .pager-btn:hover {
            border-color: #198754;
            color: #198754;
            background: #f5f7f6;
        }

        .pager-btn.disabled {
            opacity: .4;
            pointer-events: none;
        }

        .pager-next {
            background: #198754;
            border-color: #198754;
            color: #fff;
        }

        .pager-next:hover {
            background: #146c43;
            border-color: #146c43;
            color: #fff;
        }

        .damage-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 16px;
            height: 100%;
            background: #fff;
            transition: border-color .2s, background .2s;
        }

        .damage-card:has(.kerusakan-check:checked) {
            border-color: #198754;
            background: #f8fcf9;
        }

        .damage-title {
            font-weight: 700;
            color: #273444;
            overflow-wrap: anywhere;
        }

        .damage-detail {
            border-top: 1px solid #e9ecef;
            margin-top: 14px;
            padding-top: 14px;
        }

        .damage-detail.d-none {
            display: none !important;
        }

        .saved-photo {
            background: #f1f5f9;
            border-radius: 10px;
            padding: 10px;
            margin-top: 8px;
        }

        .saved-photo img {
            width: 100%;
            max-width: 180px;
            max-height: 120px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
            margin-bottom: 8px;
        }

        .damage-check-wrap {
            min-height: 30px;
        }

        .section-heading {
            font-weight: 800;
            color: #1f2937;
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
    document.addEventListener('DOMContentLoaded', function () {
        const mainContent = document.getElementById('mainContent');
        const pageContent = mainContent?.querySelector('.page-content');
        const navbar = document.querySelector('header.topbar');

        if (mainContent && pageContent && navbar) {
            mainContent.insertBefore(navbar, pageContent);
        }
    });
</script>

<div class="page-content">
    <div class="container-fluid px-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="page-title mb-1">Pemeriksaan Kendaraan</h2>
                <p class="text-muted mb-0">
                    Catat kondisi kendaraan sebelum dan sesudah sewa.
                </p>
            </div>

            <button type="button" class="btn btn-green" onclick="openTambahModal()">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Pemeriksaan
            </button>
        </div>

        <div class="card-custom">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="pemeriksaan-table">
                        <thead>
                            <tr>
                                <th class="px-3 py-3">No</th>
                                <th>Pelanggan</th>
                                <th>Mobil</th>
                                <th>Jenis</th>
                                <th>Kondisi</th>
                                <th>Tanggal</th>
                                <th>Kerusakan</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
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
</div>

<div class="modal fade" id="pemeriksaanModal" tabindex="-1" aria-labelledby="pemeriksaanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            @include('layouts.partials.modal-head', [
                'title' => 'Tambah Pemeriksaan',
                'icon' => 'bi-clipboard-check',
                'titleId' => 'pemeriksaanModalLabel'
            ])

            <form id="formPemeriksaan" enctype="multipart/form-data">
                <div class="modal-body p-4">

                    <input type="hidden" id="pemeriksaanId" name="id">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="rentalId" class="form-label fw-bold">Rental</label>
                            <select name="rental_id" id="rentalId" class="form-select" required>
                                <option value="">-- Pilih Rental --</option>
                                @foreach ($rentals as $rental)
                                    <option value="{{ $rental->id }}">
                                        {{ $rental->user->name ?? '-' }} —
                                        {{ $rental->mobil->name ?? '-' }}
                                        ({{ $rental->status }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal" class="form-label fw-bold">Tanggal Pemeriksaan</label>
                            <input type="datetime-local" name="tanggal" id="tanggal" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jenis" class="form-label fw-bold">Jenis Pemeriksaan</label>
                            <select name="jenis" id="jenis" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="sebelum_sewa">Sebelum Sewa</option>
                                <option value="setelah_sewa">Setelah Sewa</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="kondisi" class="form-label fw-bold">Kondisi Kendaraan</label>
                            <select name="kondisi" id="kondisi" class="form-select" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                                <div>
                                    <h5 class="section-heading mb-1">Detail Bagian Kendaraan</h5>
                                    <p class="text-muted small mb-0">
                                        Pilih bagian yang perlu diperiksa. Setiap bagian memiliki keterangan, catatan, dan foto bukti sendiri.
                                    </p>
                                </div>
                                <span class="badge text-bg-light border">Foto maksimal 2 MB per bagian</span>
                            </div>

                            <div class="row g-3" id="kerusakanContainer">
                                @foreach ($kerusakanList as $kerusakan)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="damage-card">

                                            <div class="form-check damage-check-wrap">
                                                <input
                                                    class="form-check-input kerusakan-check"
                                                    type="checkbox"
                                                    name="kerusakan[]"
                                                    value="{{ $kerusakan->id }}"
                                                    id="kerusakan-{{ $kerusakan->id }}"
                                                >

                                                <label class="form-check-label damage-title" for="kerusakan-{{ $kerusakan->id }}">
                                                    {{ $kerusakan->jenis_kerusakan }}
                                                </label>
                                            </div>

                                            <div class="damage-detail d-none" id="detail-kerusakan-{{ $kerusakan->id }}">

                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">
                                                        Keterangan Bagian
                                                    </label>

                                                    <input
                                                        type="text"
                                                        class="form-control form-control-sm"
                                                        name="keterangan[{{ $kerusakan->id }}]"
                                                        placeholder="Contoh: goresan pada sisi kiri"
                                                        maxlength="1000"
                                                        disabled
                                                    >
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label small fw-bold">
                                                        Catatan Bagian
                                                    </label>

                                                    <textarea
                                                        class="form-control form-control-sm"
                                                        name="catatan_kerusakan[{{ $kerusakan->id }}]"
                                                        rows="3"
                                                        maxlength="1000"
                                                        placeholder="Catatan khusus bagian ini"
                                                        disabled
                                                    ></textarea>
                                                </div>

                                                <div>
                                                    <label class="form-label small fw-bold">
                                                        Foto Bukti Bagian
                                                    </label>

                                                    <input
                                                        type="file"
                                                        class="form-control form-control-sm foto-kerusakan-input"
                                                        name="foto_kerusakan[{{ $kerusakan->id }}]"
                                                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                                        disabled
                                                    >

                                                    <div class="form-text">
                                                        Format JPG, JPEG, PNG. Maksimal 2 MB.
                                                    </div>

                                                    <div class="saved-photo d-none" id="foto-lama-{{ $kerusakan->id }}"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <hr>
                            <h5 class="section-heading mb-1">Catatan Umum Pemeriksaan</h5>
                            <p class="text-muted small">
                                Bagian ini bersifat umum dan berbeda dari catatan pada masing-masing bagian kendaraan.
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label for="fotoBukti" class="form-label fw-bold">
                                Foto Bukti Umum (opsional)
                            </label>

                            <input
                                type="file"
                                name="foto_bukti"
                                id="fotoBukti"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                            >

                            <div class="form-text">JPG, JPEG, atau PNG. Maksimal 2 MB.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="catatan" class="form-label fw-bold">
                                Catatan Umum
                            </label>

                            <textarea
                                name="catatan"
                                id="catatan"
                                class="form-control"
                                rows="3"
                                maxlength="1000"
                                placeholder="Catatan keseluruhan pemeriksaan (opsional)"
                            ></textarea>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-info mb-0 small">
                                <i class="bi bi-info-circle me-1"></i>
                                Foto lama akan tetap digunakan jika kamu tidak memilih foto pengganti saat mengedit pemeriksaan.
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-green" id="btnSimpanPemeriksaan">
                        <i class="bi bi-save me-1"></i>
                        Simpan Pemeriksaan
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

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function(char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

    function resetForm() {
        $('#formPemeriksaan')[0].reset();
        $('#pemeriksaanId').val('');

        $('.detail-kerusakan').addClass('d-none');
        $('.detail-kerusakan').find('input, textarea').prop('disabled', true);
        $('.saved-photo').addClass('d-none').empty();
        $('.foto-kerusakan-input').val('');
    }

    function openTambahModal() {
        resetForm();

        $('#pemeriksaanModalLabel').html(
            '<i class="bi bi-clipboard-check me-2"></i>Tambah Pemeriksaan'
        );

        $('#btnSimpanPemeriksaan').html(
            '<i class="bi bi-save me-1"></i>Simpan Pemeriksaan'
        );

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('pemeriksaanModal')
        ).show();
    }

    function openEditModal(id) {
        const table = $('#pemeriksaan-table').DataTable();

        const row = table.rows().data().toArray().find(function(item) {
            return Number(item.id) === Number(id);
        });

        if (!row) {
            Swal.fire('Data tidak ditemukan', 'Muat ulang tabel lalu coba kembali.', 'warning');
            return;
        }

        resetForm();

        $('#pemeriksaanModalLabel').html(
            '<i class="bi bi-pencil-square me-2"></i>Edit Pemeriksaan'
        );

        $('#btnSimpanPemeriksaan').html(
            '<i class="bi bi-save me-1"></i>Simpan Perubahan'
        );

        $('#pemeriksaanId').val(row.id);
        $('#rentalId').val(row.rental_id);
        $('#jenis').val(row.jenis);
        $('#kondisi').val(row.kondisi);
        $('#catatan').val(row.catatan === '-' ? '' : (row.catatan || ''));

        if (row.tanggal && row.tanggal !== '-') {
            const parts = row.tanggal.split(' ');
            const dateParts = parts[0].split('/');
            const timePart = parts[1] || '00:00';

            if (dateParts.length === 3) {
                const [dd, mm, yyyy] = dateParts;
                $('#tanggal').val(
                    yyyy + '-' + mm + '-' + dd + 'T' + timePart
                );
            }
        }

        (row.kerusakan_ids || []).forEach(function(kerusakanId) {
            const idBagian = String(kerusakanId);
            const detail = (row.detail_kerusakan || {})[idBagian] || {};

            $('#kerusakan-' + idBagian).prop('checked', true);

            const panel = $('#detail-kerusakan-' + idBagian);
            panel.removeClass('d-none');
            panel.find('input, textarea').prop('disabled', false);

            panel.find('[name="keterangan[' + idBagian + ']"]')
                .val(detail.keterangan || '');

            panel.find('[name="catatan_kerusakan[' + idBagian + ']"]')
                .val(detail.catatan || '');

            const photoBox = $('#foto-lama-' + idBagian);
            photoBox.empty();

            if (detail.foto_url) {
                const image = $('<img>', {
                    src: detail.foto_url,
                    alt: 'Foto bukti tersimpan'
                });

                const link = $('<a>', {
                    href: detail.foto_url,
                    target: '_blank',
                    rel: 'noopener noreferrer',
                    class: 'small d-inline-block',
                    text: 'Lihat foto ukuran penuh'
                });

                photoBox.append(
                    $('<div>').append(
                        $('<div class="small fw-bold mb-2">').text('Foto yang tersimpan'),
                        image,
                        link
                    )
                );

                photoBox.removeClass('d-none');
            } else {
                photoBox
                    .append($('<span class="small text-muted">').text('Belum ada foto bukti.'))
                    .removeClass('d-none');
            }
        });

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('pemeriksaanModal')
        ).show();
    }

    $(document).on('change', '.kerusakan-check', function() {
        const idBagian = String(this.value);
        const panel = $('#detail-kerusakan-' + idBagian);

        panel.toggleClass('d-none', !this.checked);
        panel.find('input, textarea').prop('disabled', !this.checked);

        if (!this.checked) {
            panel.find('input[type="text"], textarea').val('');
            panel.find('input[type="file"]').val('');
            $('#foto-lama-' + idBagian).addClass('d-none').empty();
        }
    });

    function hapusPemeriksaan(id) {
        Swal.fire({
            title: 'Hapus Pemeriksaan?',
            text: 'Data pemeriksaan dan foto bukti terkait akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545'
        }).then(function(result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('pemeriksaan-kendaraan.destroy', '__ID__') }}".replace('__ID__', id),
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                success: function(res) {
                    $('#pemeriksaan-table').DataTable().ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message || 'Pemeriksaan berhasil dihapus.'
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.message || 'Pemeriksaan gagal dihapus.'
                    });
                }
            });
        });
    }

    $('#formPemeriksaan').on('submit', function(e) {
        e.preventDefault();

        const form = this;
        const id = $('#pemeriksaanId').val();

        // Pemeriksaan dasar sebelum mengirim data.
        if (!form.reportValidity()) return;

        const formData = new FormData(form);

        const url = id
            ? "{{ route('pemeriksaan-kendaraan.update', '__ID__') }}".replace('__ID__', id)
            : "{{ route('pemeriksaan-kendaraan.store') }}";

        if (id) {
            formData.append('_method', 'PUT');
        }

        const button = $('#btnSimpanPemeriksaan');
        const originalHtml = button.html();

        button.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...'
        );

        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            data: formData,
            processData: false,
            contentType: false,

            success: function(res) {
                const modalElement = document.getElementById('pemeriksaanModal');

                bootstrap.Modal.getOrCreateInstance(modalElement).hide();

                $('#pemeriksaan-table').DataTable().ajax.reload(null, false);

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message || 'Pemeriksaan berhasil disimpan.'
                });
            },

            error: function(xhr) {
                const res = xhr.responseJSON || {};
                let message = res.message || 'Terjadi kesalahan saat menyimpan pemeriksaan.';

                if (res.errors) {
                    const firstError = Object.values(res.errors).flat()[0];

                    if (firstError) {
                        message = firstError;
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: xhr.status === 422 ? 'Validasi Gagal' : 'Gagal',
                    text: message
                });
            },

            complete: function() {
                button.prop('disabled', false).html(originalHtml);
            }
        });
    });

    function statusBadge(kondisi) {
        const baik = kondisi === 'baik';
        const cls = baik ? 'status-baik' : 'status-rusak';
        const label = baik ? 'Baik' : 'Rusak';

        return '<span class="status ' + cls + '">' + label + '</span>';
    }

    $(document).ready(function() {
        const pemeriksaanTable = $('#pemeriksaan-table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            pageLength: 10,
            lengthChange: false,
            info: false,
            dom: 'frt',
            ajax: {
                url: "{{ route('pemeriksaan-kendaraan.data') }}",
                type: 'GET'
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
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<div class="fw-bold">' + escapeHtml(row.user_name) + '</div>' +
                            '<small class="text-muted">' + escapeHtml(row.user_email) + '</small>';
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<div class="fw-bold">' + escapeHtml(row.mobil_name) + '</div>' +
                            '<small class="text-muted">' + escapeHtml(row.mobil_plate) + '</small>';
                    }
                },
                {
                    data: 'jenis',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        const label = data === 'sebelum_sewa' ? 'Sebelum Sewa' : 'Setelah Sewa';
                        return '<span class="badge-jenis">' + label + '</span>';
                    }
                },
                {
                    data: 'kondisi',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return statusBadge(data);
                    }
                },
                {
                    data: 'tanggal',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kerusakan',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (!data || !data.length) {
                            return '<span class="text-muted">-</span>';
                        }

                        return data.map(function(item) {
                            return '<span class="badge bg-danger me-1 mb-1">' +
                                escapeHtml(item) + '</span>';
                        }).join('');
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-end pe-4',
                    width: '140px',
                    render: function(data, type, row) {
                        return '<div class="d-flex justify-content-end gap-2">' +
                            '<button type="button" class="btn p-1 text-primary" title="Edit" ' +
                            'onclick="openEditModal(' + Number(row.id) + ')">' +
                            '<i class="bi bi-pencil-square"></i></button>' +
                            '<button type="button" class="btn p-1 text-danger" title="Hapus" ' +
                            'onclick="hapusPemeriksaan(' + Number(row.id) + ')">' +
                            '<i class="bi bi-trash"></i></button>' +
                            '</div>';
                    }
                }
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
                searchPlaceholder: 'Cari pelanggan, mobil, atau kondisi...',
                paginate: {
                    first: 'First',
                    last: 'Last',
                    next: 'Berikutnya',
                    previous: 'Sebelumnya'
                }
            }
        });

        function renderPemeriksaanPager() {
            const info = pemeriksaanTable.page.info();
            const total = info.recordsDisplay;
            const start = total ? info.start + 1 : 0;

            $('#pemeriksaan-info').text(
                'Menampilkan ' + start + '–' + info.end + ' dari ' + total + ' data'
            );

            const pages = info.pages || 1;
            const page = info.page + 1;

            $('#pemeriksaan-page').text('Halaman ' + page + ' / ' + pages);

            $('#pemeriksaan-first, #pemeriksaan-prev')
                .toggleClass('disabled', page <= 1);

            $('#pemeriksaan-next, #pemeriksaan-last')
                .toggleClass('disabled', page >= pages);
        }

        pemeriksaanTable.on('draw.dt', renderPemeriksaanPager);
        renderPemeriksaanPager();

        $('#pemeriksaan-first').on('click', function() {
            pemeriksaanTable.page('first').draw('page');
        });

        $('#pemeriksaan-prev').on('click', function() {
            pemeriksaanTable.page('previous').draw('page');
        });

        $('#pemeriksaan-next').on('click', function() {
            pemeriksaanTable.page('next').draw('page');
        });

        $('#pemeriksaan-last').on('click', function() {
            pemeriksaanTable.page('last').draw('page');
        });

        $('#pemeriksaan-len').on('change', function() {
            if ($(this).val() === 'custom') {
                $('#pemeriksaan-custom').focus();
                return;
            }

            const n = Number($(this).val());

            $('#pemeriksaan-custom').val(n);
            pemeriksaanTable.page.len(n).draw();
        });

        $('#pemeriksaan-custom').on('change', function() {
            let n = parseInt($(this).val(), 10) || 1;

            n = Math.min(Math.max(n, 1), 500);
            $(this).val(n);

            if (['10', '20', '50', '100'].includes(String(n))) {
                $('#pemeriksaan-len').val(String(n));
            } else {
                $('#pemeriksaan-len').val('custom');
            }

            pemeriksaanTable.page.len(n).draw();
        });
    });
</script>

</body>
</html>
