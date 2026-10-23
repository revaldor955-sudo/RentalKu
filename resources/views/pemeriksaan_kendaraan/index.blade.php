
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemeriksaan Kendaraan - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            background: #f6f8f7;
            font-family: 'Montserrat', sans-serif;
        }

        .page-content { padding: 24px; }

        .page-title {
            font-weight: 800;
            color: #1f2937;
        }

        .card-custom {
            background: #fff;
            border: 0;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,.05);
            padding: 18px;
        }

        .btn-green {
            background: #198754;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-weight: 700;
        }

        .btn-green:hover {
            background: #146c43;
            color: #fff;
        }

        #pemeriksaan-table th {
            font-size: 12px;
            color: #6b7280;
            white-space: nowrap;
            background: #f8faf9;
        }

        #pemeriksaan-table td { vertical-align: middle; }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-baik {
            color: #0f5132;
            background: #d1e7dd;
        }

        .status-rusak {
            color: #842029;
            background: #f8d7da;
        }

        .badge-jenis {
            display: inline-block;
            background: #e2e8f0;
            color: #334155;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .damage-card {
            height: 100%;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #fff;
        }

        .damage-card:has(.kerusakan-check:checked) {
            border-color: #198754;
            background: #f8fcf9;
        }

        .damage-title {
            font-weight: 700;
            color: #334155;
        }

        .damage-detail {
            border-top: 1px solid #e5e7eb;
            margin-top: 14px;
            padding-top: 14px;
        }

        .saved-photo {
            margin-top: 8px;
            padding: 10px;
            border-radius: 10px;
            background: #f1f5f9;
        }

        .saved-photo img {
            display: block;
            width: 100%;
            max-width: 180px;
            max-height: 130px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .pager-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 16px;
        }

        #pemeriksaanModal { overflow: hidden !important; }

        #pemeriksaanModal .modal-dialog {
            width: calc(100% - 24px);
            max-width: 1100px;
            height: calc(100dvh - 24px);
            margin: 12px auto;
        }

        #pemeriksaanModal .modal-content {
            height: 100%;
            max-height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 0;
            border-radius: 16px;
        }

        #pemeriksaanModal .modal-header {
            flex: 0 0 auto;
            background: linear-gradient(110deg, #075b3a, #198754);
            color: #fff;
            padding: 18px 24px;
        }

        #pemeriksaanModal .modal-header .modal-title {
            font-weight: 800;
        }

        #pemeriksaanModal .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        #pemeriksaanModal .modal-body {
            flex: 1 1 0;
            min-height: 0;
            height: 0;
            overflow-y: scroll !important;
            overflow-x: hidden;
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
            padding: 22px !important;
        }

        #pemeriksaanModal .modal-footer {
            flex: 0 0 auto;
            padding: 14px 22px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            box-shadow: 0 -3px 10px rgba(0,0,0,.03);
            z-index: 2;
        }

        #pemeriksaanModal .form-label { font-weight: 700; }

        #pemeriksaanModal .section-heading {
            color: #1f2937;
            font-weight: 800;
        }

        @media (max-width: 768px) {
            .page-content { padding: 12px; }

            #pemeriksaanModal .modal-dialog {
                width: calc(100% - 12px);
                height: calc(100dvh - 12px);
                margin: 6px auto;
            }

            #pemeriksaanModal .modal-body {
                padding: 15px !important;
            }

            #pemeriksaanModal .modal-header,
            #pemeriksaanModal .modal-footer {
                padding: 12px 15px;
            }
        }
    </style>
</head>

<body>

@include('layouts.partials.sidebar')

<div class="page-content">
    <div class="container-fluid">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h2 class="page-title mb-1">Pemeriksaan Kendaraan</h2>
                <p class="text-muted mb-0">
                    Kelola pemeriksaan kendaraan sebelum dan sesudah penyewaan.
                </p>
            </div>

            <button type="button" class="btn btn-green" onclick="openTambahModal()">
                <i class="bi bi-plus-lg me-1"></i>
                Tambah Pemeriksaan
            </button>
        </div>

        <div class="card-custom">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="pemeriksaan-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Mobil</th>
                            <th>Jenis</th>
                            <th>Kondisi</th>
                            <th>Tanggal</th>
                            <th>Kerusakan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="pager-bar">
                <div class="small text-muted" id="pemeriksaan-info"></div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select id="pemeriksaan-len" class="form-select form-select-sm" style="width:auto">
                        <option value="10">10 / halaman</option>
                        <option value="20">20 / halaman</option>
                        <option value="50">50 / halaman</option>
                        <option value="100">100 / halaman</option>
                    </select>

                    <button class="btn btn-sm btn-outline-secondary" id="pemeriksaan-prev" type="button">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <span id="pemeriksaan-page" class="small"></span>
                    <button class="btn btn-sm btn-outline-secondary" id="pemeriksaan-next" type="button">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL PEMERIKSAAN -->
<div class="modal fade" id="pemeriksaanModal" tabindex="-1"
     aria-labelledby="pemeriksaanModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="pemeriksaanModalLabel">
                    <i class="bi bi-clipboard-check me-2"></i>
                    Tambah Pemeriksaan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
            </div>

            <form id="formPemeriksaan" enctype="multipart/form-data"
                  style="display:flex;flex-direction:column;flex:1;min-height:0;overflow:hidden">

                <div class="modal-body">
                    <input type="hidden" id="pemeriksaanId" name="id">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="rentalId" class="form-label">Rental</label>
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
                            <label for="tanggal" class="form-label">Tanggal Pemeriksaan</label>
                            <input type="datetime-local" name="tanggal" id="tanggal"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jenis" class="form-label">Jenis Pemeriksaan</label>
                            <select name="jenis" id="jenis" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="sebelum_sewa">Sebelum Sewa</option>
                                <option value="setelah_sewa">Setelah Sewa</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="kondisi" class="form-label">Kondisi Kendaraan</label>
                            <select name="kondisi" id="kondisi" class="form-select" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="section-heading mb-0">Detail Bagian Kendaraan</h5>
                                <span class="badge text-bg-light">Foto maksimal 2 MB per bagian</span>
                            </div>
                            <p class="text-muted small mt-2">
                                Pilih bagian yang diperiksa. Setiap bagian memiliki keterangan,
                                catatan, dan foto bukti sendiri.
                            </p>
                        </div>

                        <div class="col-12">
                            <div class="row g-3">
                                @foreach ($kerusakanList as $kerusakan)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="damage-card">
                                            <div class="form-check">
                                                <input class="form-check-input kerusakan-check"
                                                       type="checkbox"
                                                       name="kerusakan[]"
                                                       value="{{ $kerusakan->id }}"
                                                       id="kerusakan-{{ $kerusakan->id }}">

                                                <label class="form-check-label damage-title"
                                                       for="kerusakan-{{ $kerusakan->id }}">
                                                    {{ $kerusakan->jenis_kerusakan }}
                                                </label>
                                            </div>

                                            <div class="damage-detail d-none"
                                                 id="detail-kerusakan-{{ $kerusakan->id }}">

                                                <div class="mb-3">
                                                    <label class="form-label small">Keterangan Bagian</label>
                                                    <input type="text"
                                                           class="form-control form-control-sm"
                                                           name="keterangan[{{ $kerusakan->id }}]"
                                                           maxlength="1000"
                                                           placeholder="Keterangan bagian"
                                                           disabled>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label small">Catatan Bagian</label>
                                                    <textarea
                                                        class="form-control form-control-sm"
                                                        name="catatan_kerusakan[{{ $kerusakan->id }}]"
                                                        rows="3" maxlength="1000"
                                                        placeholder="Catatan bagian ini"
                                                        disabled></textarea>
                                                </div>

                                                <div>
                                                    <label class="form-label small">Foto Bukti Bagian</label>
                                                    <input type="file"
                                                           class="form-control form-control-sm foto-kerusakan-input"
                                                           name="foto_kerusakan[{{ $kerusakan->id }}]"
                                                           accept=".jpg,.jpeg,.png"
                                                           disabled>
                                                    <div class="form-text">JPG/PNG, maksimal 2 MB.</div>

                                                    <div class="saved-photo d-none"
                                                         id="foto-lama-{{ $kerusakan->id }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <hr>
                            <h5 class="section-heading">Catatan Umum Pemeriksaan</h5>
                            <p class="text-muted small">
                                Informasi tambahan untuk keseluruhan kendaraan.
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label for="fotoBukti" class="form-label">Foto Bukti Umum (opsional)</label>
                            <input type="file" name="foto_bukti" id="fotoBukti"
                                   class="form-control" accept=".jpg,.jpeg,.png">
                            <div class="form-text">JPG/PNG, maksimal 2 MB.</div>

                            <div id="fotoBuktiLama" class="saved-photo d-none">
                                <div class="small fw-bold mb-2">Foto bukti yang tersimpan</div>
                                <img id="previewFotoBuktiLama"
                                     src=""
                                     alt="Foto bukti pemeriksaan sebelumnya">

                                <a id="linkFotoBuktiLama"
                                   href=""
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="small">Lihat foto</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="catatan" class="form-label">Catatan Umum</label>
                            <textarea name="catatan" id="catatan" class="form-control"
                                      rows="3" maxlength="1000"
                                      placeholder="Catatan keseluruhan pemeriksaan"></textarea>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net@2.3.8/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.3.8/js/dataTables.bootstrap5.min.js"></script>

<script>
const CSRF_TOKEN = @json(csrf_token());
const URL_DATA = @json(route('pemeriksaan-kendaraan.data'));
const URL_STORE = @json(route('pemeriksaan-kendaraan.store'));
const URL_UPDATE = @json(route('pemeriksaan-kendaraan.update', '__ID__'));
const URL_DESTROY = @json(route('pemeriksaan-kendaraan.destroy', '__ID__'));
const STORAGE_URL = @json(asset('storage'));

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    }[char]));
}

/*
|--------------------------------------------------------------------------
| RESET FORM - PERBAIKAN FOTO BUKTI UMUM
|--------------------------------------------------------------------------
| Jangan gunakan $('.saved-photo').empty() secara langsung karena
| itu menghapus elemen gambar dan tautan foto bukti umum.
*/
function resetForm() {
    document.getElementById('formPemeriksaan').reset();
    $('#pemeriksaanId').val('');

    $('.kerusakan-check').prop('checked', false);

    $('[id^="detail-kerusakan-"]')
        .addClass('d-none')
        .find('input, textarea')
        .prop('disabled', true);

    // Reset tampilan foto bukti umum, tetapi jangan hapus HTML-nya.
    $('#previewFotoBuktiLama').attr('src', '');
    $('#linkFotoBuktiLama').attr('href', '');
    $('#fotoBuktiLama').addClass('d-none');

    // Bersihkan foto lama pada bagian kerusakan saja.
    // Container foto bukti umum dikecualikan.
    $('.saved-photo')
        .not('#fotoBuktiLama')
        .addClass('d-none')
        .empty();
}

function openTambahModal() {
    resetForm();

    $('#pemeriksaanModalLabel').html(
        '<i class="bi bi-clipboard-check me-2"></i>Tambah Pemeriksaan'
    );

    $('#btnSimpanPemeriksaan').html(
        '<i class="bi bi-save me-1"></i>Simpan Pemeriksaan'
    );

    const modalElement = document.getElementById('pemeriksaanModal');

    bootstrap.Modal.getOrCreateInstance(modalElement).show();

    setTimeout(() => {
        const body = modalElement.querySelector('.modal-body');
        if (body) body.scrollTop = 0;
    }, 100);
}

function renderSavedPhoto(container, url) {
    container.empty();

    if (!url) {
        container.addClass('d-none');
        return;
    }

    $('<div class="small fw-bold mb-2">')
        .text('Foto yang tersimpan')
        .appendTo(container);

    $('<img>')
        .attr('src', url)
        .attr('alt', 'Foto bukti tersimpan')
        .appendTo(container);

    $('<a>')
        .attr('href', url)
        .attr('target', '_blank')
        .attr('rel', 'noopener noreferrer')
        .addClass('small')
        .text('Lihat foto')
        .appendTo(container);

    container.removeClass('d-none');
}

function buatUrlFoto(path) {
    if (!path) return '';

    if (/^https?:\/\//i.test(path)) {
        return path;
    }

    if (path.startsWith('/')) {
        return window.location.origin + path;
    }

    return STORAGE_URL + '/' + path.replace(/^\/+/, '');
}

function openEditModal(id) {
    const table = $('#pemeriksaan-table').DataTable();

    const row = table.rows().data().toArray()
        .find(item => Number(item.id) === Number(id));

    if (!row) {
        Swal.fire(
            'Data tidak ditemukan',
            'Silakan muat ulang halaman.',
            'warning'
        );
        return;
    }

    resetForm();

    $('#pemeriksaanId').val(row.id);
    $('#rentalId').val(row.rental_id);
    $('#jenis').val(row.jenis);
    $('#kondisi').val(row.kondisi);
    $('#catatan').val(row.catatan || '');

    // Tampilkan kembali foto bukti umum yang tersimpan.
    const fotoLama = row.foto_bukti_url || row.foto_bukti || '';
    const fotoUrl = buatUrlFoto(fotoLama);

    if (fotoUrl) {
        $('#previewFotoBuktiLama')
            .attr('src', fotoUrl)
            .off('error')
            .on('error', function() {
                $(this).attr('alt', 'Foto tidak dapat dimuat. Periksa lokasi penyimpanan foto.');
            });

        $('#linkFotoBuktiLama').attr('href', fotoUrl);
        $('#fotoBuktiLama').removeClass('d-none');
    } else {
        $('#previewFotoBuktiLama').attr('src', '');
        $('#linkFotoBuktiLama').attr('href', '');
        $('#fotoBuktiLama').addClass('d-none');
    }

    if (row.tanggal_input) {
        $('#tanggal').val(row.tanggal_input);
    }

    $('#pemeriksaanModalLabel').html(
        '<i class="bi bi-pencil-square me-2"></i>Edit Pemeriksaan'
    );

    $('#btnSimpanPemeriksaan').html(
        '<i class="bi bi-save me-1"></i>Simpan Perubahan'
    );

    (row.kerusakan_ids || []).forEach(function(damageId) {
        const key = String(damageId);
        const detail = (row.detail_kerusakan || {})[key] || {};
        const panel = $('#detail-kerusakan-' + key);

        $('#kerusakan-' + key).prop('checked', true);

        panel.removeClass('d-none')
            .find('input, textarea')
            .prop('disabled', false);

        panel.find(`[name="keterangan[${key}]"]`)
            .val(detail.keterangan || '');

        panel.find(`[name="catatan_kerusakan[${key}]"]`)
            .val(detail.catatan || '');

        const photoUrl = buatUrlFoto(detail.foto_url || '');

        renderSavedPhoto($('#foto-lama-' + key), photoUrl);
    });

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById('pemeriksaanModal')
    ).show();
}

$(document).on('change', '.kerusakan-check', function() {
    const key = String(this.value);
    const panel = $('#detail-kerusakan-' + key);

    panel.toggleClass('d-none', !this.checked);
    panel.find('input, textarea').prop('disabled', !this.checked);

    if (!this.checked) {
        panel.find('input[type="text"], textarea, input[type="file"]').val('');
        $('#foto-lama-' + key).addClass('d-none').empty();
    }
});

function hapusPemeriksaan(id) {
    Swal.fire({
        title: 'Hapus Pemeriksaan?',
        text: 'Data pemeriksaan akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545'
    }).then(result => {
        if (!result.isConfirmed) return;

        $.ajax({
            url: URL_DESTROY.replace('__ID__', id),
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            success: function(response) {
                $('#pemeriksaan-table').DataTable().ajax.reload(null, false);

                Swal.fire(
                    'Berhasil',
                    response.message || 'Data berhasil dihapus.',
                    'success'
                );
            },
            error: function(xhr) {
                Swal.fire(
                    'Gagal',
                    xhr.responseJSON?.message || 'Data gagal dihapus.',
                    'error'
                );
            }
        });
    });
}

$('#formPemeriksaan').on('submit', function(e) {
    e.preventDefault();

    const form = this;
    if (!form.reportValidity()) return;

    const id = $('#pemeriksaanId').val();
    const formData = new FormData(form);

    const url = id
        ? URL_UPDATE.replace('__ID__', id)
        : URL_STORE;

    if (id) formData.append('_method', 'PUT');

    const button = $('#btnSimpanPemeriksaan');
    const originalHtml = button.html();

    button.prop('disabled', true).text('Menyimpan...');

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

        success: function(response) {
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('pemeriksaanModal')
            ).hide();

            $('#pemeriksaan-table').DataTable().ajax.reload(null, false);

            Swal.fire(
                'Berhasil',
                response.message || 'Pemeriksaan berhasil disimpan.',
                'success'
            );
        },

        error: function(xhr) {
            const response = xhr.responseJSON || {};

            const errorMessage = response.errors
                ? Object.values(response.errors).flat()[0]
                : response.message;

            Swal.fire(
                'Gagal menyimpan',
                errorMessage || 'Terjadi kesalahan. Periksa kembali data yang dimasukkan.',
                'error'
            );
        },

        complete: function() {
            button.prop('disabled', false).html(originalHtml);
        }
    });
});

$(document).ready(function() {
    const table = $('#pemeriksaan-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        lengthChange: false,
        searching: true,
        info: false,
        order: [],

        ajax: {
            url: URL_DATA,
            type: 'GET'
        },

        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: (data, type, row, meta) =>
                    meta.row + meta.settings._iDisplayStart + 1
            },
            {
                data: null,
                orderable: false,
                render: (data, type, row) =>
                    `<strong>${escapeHtml(row.user_name)}</strong><br>
                     <small class="text-muted">${escapeHtml(row.user_email)}</small>`
            },
            {
                data: null,
                orderable: false,
                render: (data, type, row) =>
                    `<strong>${escapeHtml(row.mobil_name)}</strong><br>
                     <small class="text-muted">${escapeHtml(row.mobil_plate)}</small>`
            },
            {
                data: 'jenis',
                orderable: false,
                render: data =>
                    `<span class="badge-jenis">${data === 'sebelum_sewa' ? 'Sebelum Sewa' : 'Setelah Sewa'}</span>`
            },
            {
                data: 'kondisi',
                orderable: false,
                render: data => data === 'baik'
                    ? '<span class="status status-baik">Baik</span>'
                    : '<span class="status status-rusak">Rusak</span>'
            },
            {
                data: 'tanggal',
                orderable: false
            },
            {
                data: 'kerusakan',
                orderable: false,
                render: data => {
                    if (!data || !data.length) return '-';

                    return data.map(item =>
                        `<span class="badge bg-danger me-1">${escapeHtml(item)}</span>`
                    ).join(' ');
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-end',
                render: (data, type, row) =>
                    `<button type="button" class="btn btn-sm text-primary"
                        onclick="openEditModal(${Number(row.id)})" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-sm text-danger"
                        onclick="hapusPemeriksaan(${Number(row.id)})" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>`
            }
        ],

        language: {
            processing: 'Memproses...',
            search: 'Cari:',
            searchPlaceholder: 'Cari data pemeriksaan...',
            zeroRecords: 'Data tidak ditemukan',
            emptyTable: 'Belum ada data pemeriksaan',
            paginate: {
                first: 'Pertama',
                last: 'Terakhir',
                next: 'Berikutnya',
                previous: 'Sebelumnya'
            }
        }
    });

    function updatePager() {
        const info = table.page.info();
        const start = info.recordsDisplay ? info.start + 1 : 0;

        $('#pemeriksaan-info').text(
            `Menampilkan ${start}–${info.end} dari ${info.recordsDisplay} data`
        );

        $('#pemeriksaan-page').text(
            `Halaman ${info.pages ? info.page + 1 : 0} / ${info.pages}`
        );

        $('#pemeriksaan-prev').prop('disabled', info.page <= 0);
        $('#pemeriksaan-next').prop('disabled', info.page >= info.pages - 1);
    }

    table.on('draw', updatePager);
    updatePager();

    $('#pemeriksaan-len').on('change', function() {
        table.page.len(Number(this.value)).draw();
    });

    $('#pemeriksaan-prev').on('click', function() {
        table.page('previous').draw('page');
    });

    $('#pemeriksaan-next').on('click', function() {
        table.page('next').draw('page');
    });
});
</script>

</body>
</html>
