<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Halaman Utama - RentalKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        body {
            background: #f5f7f6;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            color: #1f2937;
            margin: 0;
        }

        .page-card {
            background: white;
            border: 1px solid #edf0ee;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
            padding: 24px;
        }

        .page-title {
            font-size: 30px;
            font-weight: 800;
        }

        .nav-pills .nav-link {
            color: #4b5563;
            font-weight: 600;
            border-radius: 10px;
            padding: 10px 16px;
            transition: all 0.2s;
        }

        .nav-pills .nav-link.active {
            background: #dcfce7;
            color: #166534;
        }

        .form-label {
            font-weight: 700;
            color: #374151;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.1);
        }

        .tab-pane.fade {
            animation-duration: 0.3s;
        }
    </style>
</head>

<body>

    @include('layouts.partials.sidebar')

    <div class="page-content">
        <div class="container-fluid px-4 py-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-title mb-1">Pengaturan Halaman Utama</h1>
                    <p class="text-muted mb-0">Atur teks yang tampil di halaman utama. Setiap kolom diberi keterangan
                        lokasinya.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form id="landingSettingsForm" action="{{ route('admin.landing-settings.update') }}" method="POST">
                @csrf @method('PUT')

                <ul class="nav nav-pills mb-4 gap-2 bg-white p-2 rounded-4 shadow-sm border border-light"
                    id="landingTabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#hero"
                            type="button">Bagian Pembuka</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#about"
                            type="button">Tentang Kami</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#steps"
                            type="button">Langkah Penyewaan</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#faq"
                            type="button">Tanya Jawab</button></li>
                </ul>

                <div class="tab-content" id="landingTabsContent">
                    <div class="tab-pane fade show active" id="hero">
                        <div class="page-card">
                            <p class="text-muted small mb-3">Bagian paling atas halaman utama. Berisi label kecil, judul
                                besar, dan deskripsi singkat.</p>
                            <div class="mb-3"><label class="form-label">Teks Label Kecil</label><input type="text"
                                    name="hero_badge" class="form-control" maxlength="255"
                                    value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}"
                                    placeholder="Rental mobil mudah & terpercaya">
                                <div class="form-text text-muted">Tulisan kecil di atas judul, contoh: Rental mobil
                                    mudah & terpercaya.</div>
                            </div>
                            <div class="mb-3"><label class="form-label">Judul Utama</label><input type="text"
                                    name="hero_title" class="form-control" maxlength="255"
                                    value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                                    placeholder="Perjalanan lebih mudah dengan Rentalku.">
                                <div class="form-text text-muted">Judul besar yang pertama dilihat pengunjung.</div>
                            </div>
                            <div class="mb-3"><label class="form-label">Deskripsi Singkat</label>
                                <textarea name="hero_description" class="form-control" rows="3"
                                    placeholder="Temukan mobil yang sesuai kebutuhanmu. Pilih kendaraan, tentukan tanggal rental, dan lakukan rental dengan mudah secara online.">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                                <div class="form-text text-muted">Satu sampai dua kalimat di bawah judul.</div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="about">
                        <div class="page-card">
                            <p class="text-muted small mb-3">Bagian penjelasan keunggulan RentalKu: teks di kiri, empat
                                kartu keunggulan di kanan.</p>
                            <div class="mb-3"><label class="form-label">Teks Label Kecil</label><input type="text"
                                    name="about_badge" class="form-control" maxlength="255"
                                    value="{{ old('about_badge', $settings['about_badge'] ?? '') }}"
                                    placeholder="KENAPA RENTALKU?">
                                <div class="form-text text-muted">Tulisan kecil di atas judul bagian.</div>
                            </div>
                            <div class="mb-3"><label class="form-label">Judul Bagian</label><input type="text"
                                    name="about_title" class="form-control" maxlength="255"
                                    value="{{ old('about_title', $settings['about_title'] ?? '') }}"
                                    placeholder="Rental mobil tanpa ribet.">
                                <div class="form-text text-muted">Judul utama bagian Tentang Kami.</div>
                            </div>
                            <div class="mb-3"><label class="form-label">Deskripsi Bagian</label>
                                <textarea name="about_description" class="form-control" rows="3">{{ old('about_description', $settings['about_description'] ?? '') }}</textarea>
                                <div class="form-text text-muted">Penjelasan singkat di bawah judul.</div>
                            </div>
                            <h6 class="fw-bold text-success mt-4 mb-1">Kartu Keunggulan</h6>
                            <div class="mb-3"><label class="form-label">Keunggulan 1: Judul</label><input
                                    type="text" name="about_feature_1_title" class="form-control" maxlength="255"
                                    value="{{ old('about_feature_1_title', $settings['about_feature_1_title'] ?? '') }}"
                                    placeholder="Aman & Terpercaya"></div>
                            <div class="mb-3"><label class="form-label">Keunggulan 1: Deskripsi</label>
                                <textarea name="about_feature_1_desc" class="form-control" rows="2">{{ old('about_feature_1_desc', $settings['about_feature_1_desc'] ?? '') }}</textarea>
                            </div>
                            <div class="mb-3"><label class="form-label">Keunggulan 2: Judul</label><input
                                    type="text" name="about_feature_2_title" class="form-control" maxlength="255"
                                    value="{{ old('about_feature_2_title', $settings['about_feature_2_title'] ?? '') }}"
                                    placeholder="Proses Cepat"></div>
                            <div class="mb-3"><label class="form-label">Keunggulan 2: Deskripsi</label>
                                <textarea name="about_feature_2_desc" class="form-control" rows="2">{{ old('about_feature_2_desc', $settings['about_feature_2_desc'] ?? '') }}</textarea>
                            </div>
                            <div class="mb-3"><label class="form-label">Keunggulan 3: Judul</label><input
                                    type="text" name="about_feature_3_title" class="form-control" maxlength="255"
                                    value="{{ old('about_feature_3_title', $settings['about_feature_3_title'] ?? '') }}"
                                    placeholder="Harga Transparan"></div>
                            <div class="mb-3"><label class="form-label">Keunggulan 3: Deskripsi</label>
                                <textarea name="about_feature_3_desc" class="form-control" rows="2">{{ old('about_feature_3_desc', $settings['about_feature_3_desc'] ?? '') }}</textarea>
                            </div>
                            <div class="mb-0"><label class="form-label">Keunggulan 4: Judul</label><input
                                    type="text" name="about_feature_4_title" class="form-control" maxlength="255"
                                    value="{{ old('about_feature_4_title', $settings['about_feature_4_title'] ?? '') }}"
                                    placeholder="Layanan Support"></div>
                            <div class="mb-0"><label class="form-label">Keunggulan 4: Deskripsi</label>
                                <textarea name="about_feature_4_desc" class="form-control" rows="2">{{ old('about_feature_4_desc', $settings['about_feature_4_desc'] ?? '') }}</textarea>
                            </div>
                            <div class="form-text text-muted">Urutan kartu: 1 kiri atas, 2 kanan atas, 3 kiri bawah, 4
                                kanan bawah. Ikon kartu sudah otomatis.</div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="steps">
                        <div class="page-card">
                            <p class="text-muted small mb-3">Bagian penjelasan langkah-langkah cara menyewa mobil.</p>
                            <div class="mb-3"><label class="form-label">Teks Label Kecil</label><input
                                    type="text" name="steps_badge" class="form-control" maxlength="255"
                                    value="{{ old('steps_badge', $settings['steps_badge'] ?? '') }}"
                                    placeholder="CARA RENTAL"></div>
                            <div class="mb-3"><label class="form-label">Judul Bagian</label><input type="text"
                                    name="steps_title" class="form-control" maxlength="255"
                                    value="{{ old('steps_title', $settings['steps_title'] ?? '') }}"
                                    placeholder="Rental mobil dalam beberapa langkah"></div>
                            <div class="mb-3"><label class="form-label">Deskripsi Bagian</label>
                                <textarea name="steps_description" class="form-control" rows="3"
                                    placeholder="Proses sederhana untuk mendapatkan mobil yang kamu butuhkan.">{{ old('steps_description', $settings['steps_description'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="faq">
                        <div class="page-card">
                            <p class="text-muted small mb-3">Bagian pertanyaan yang sering ditanyakan. Centang
                                pertanyaan yang ingin ditampilkan.</p>
                            <div class="mb-3"><label class="form-label">Judul Bagian</label><input type="text"
                                    name="faq_title" class="form-control" maxlength="255"
                                    value="{{ old('faq_title', $settings['faq_title'] ?? '') }}"
                                    placeholder="Pertanyaan yang sering ditanyakan"></div>
                            <div class="mb-3"><label class="form-label">Deskripsi Bagian (Opsional)</label>
                                <textarea name="faq_description" class="form-control" rows="3"
                                    placeholder="Deskripsi opsional di bawah judul Tanya Jawab.">{{ old('faq_description', $settings['faq_description'] ?? '') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih Pertanyaan yang Ditampilkan</label>
                                <div class="form-text text-muted">Centang pertanyaan yang muncul di halaman utama.
                                </div>
                                @php $selected = json_decode($settings['selected_faq_ids'] ?? '[]', true); @endphp
                                @forelse($faqs as $faq)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="selected_faq_ids[]"
                                            value="{{ $faq->id }}" id="faq_{{ $faq->id }}"
                                            {{ in_array($faq->id, $selected ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="faq_{{ $faq->id }}">
                                            {{ $faq->pertanyaan }}
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted">Belum ada Tanya Jawab. <a
                                            href="{{ route('faqs.index') }}">Tambah Tanya Jawab</a></p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4 py-2" id="btnSave">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(btn => {
            btn.addEventListener('shown.bs.tab', e => {
                const pane = document.querySelector(e.target.getAttribute('data-bs-target'));
                pane.classList.add('animate__animated', 'animate__fadeIn');
                history.replaceState(null, '', '#' + pane.id);
            });
        });
        const hash = window.location.hash;
        if (hash) {
            const trigger = document.querySelector(`[data-bs-target="${hash}"]`);
            if (trigger) new bootstrap.Tab(trigger).show();
        }
        const form = document.getElementById('landingSettingsForm');
        const btn = document.getElementById('btnSave');

        form.addEventListener('submit', async e => {
            e.preventDefault();
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new FormData(form),
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message || 'Berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                } else {
                    const errs = data.errors || {};
                    const first = Object.values(errs)[0];
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: (Array.isArray(first) ? first[0] : first) || data.message ||
                            'Gagal menyimpan.',
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan jaringan.',
                });
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Simpan Perubahan';
            }
        });
    </script>
</body>

</html>
