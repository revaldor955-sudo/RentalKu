<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Settings - RentalKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        body { background: #f5f7f6; font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif; color: #1f2937; margin: 0; }
        .page-card { background: white; border: 1px solid #edf0ee; border-radius: 20px; box-shadow: 0 8px 25px rgba(0,0,0,.05); padding: 24px; }
        .page-title { font-size: 30px; font-weight: 800; }
        .nav-pills .nav-link { color: #4b5563; font-weight: 600; border-radius: 10px; padding: 10px 16px; transition: all 0.2s; }
        .nav-pills .nav-link.active { background: #dcfce7; color: #166534; }
        .form-label { font-weight: 700; color: #374151; font-size: 14px; margin-bottom: 8px; }
        .form-control { border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; font-size: 15px; }
        .form-control:focus { border-color: #198754; box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.1); }
        .tab-pane.fade { animation-duration: 0.3s; }
    </style>
</head>
<body>

@include('layouts.partials.sidebar')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainContent = document.getElementById('mainContent');
        const pageContent = mainContent?.querySelector('.page-content');
        if (mainContent && pageContent) {
            const navbar = document.querySelector('header.topbar');
            if (navbar) mainContent.insertBefore(navbar, pageContent);
        }
    });
</script>

<div class="page-content">
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Landing Settings</h1>
            <p class="text-muted mb-0">Kelola konten halaman utama website RentalKu.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form id="landingSettingsForm" action="{{ route('admin.landing-settings.update') }}" method="POST">
        @csrf @method('PUT')

        <ul class="nav nav-pills mb-4 gap-2 bg-white p-2 rounded-4 shadow-sm border border-light" id="landingTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#hero" type="button">Hero</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#about" type="button">About</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#brand" type="button">Brand</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#promo" type="button">Promo</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#feature" type="button">Feature</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#steps" type="button">Steps</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#testimonial" type="button">Testi</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#faq" type="button">FAQ</button></li>
        </ul>

        <div class="tab-content" id="landingTabsContent">
            <div class="tab-pane fade show active" id="hero">
                <div class="page-card">
                    <div class="mb-3"><label class="form-label">Hero Badge</label><input type="text" name="hero_badge" class="form-control" value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">Hero Title</label><input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">Hero Description</label><textarea name="hero_description" class="form-control" rows="3">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea></div>
                </div>
            </div>
            <div class="tab-pane fade" id="about">
                <div class="page-card">
                    <div class="mb-3"><label class="form-label">About Title</label><input type="text" name="about_title" class="form-control" value="{{ old('about_title', $settings['about_title'] ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">About Description</label><textarea name="about_description" class="form-control" rows="3">{{ old('about_description', $settings['about_description'] ?? '') }}</textarea></div>
                </div>
            </div>
            <div class="tab-pane fade" id="brand">
                <div class="page-card">
                    <div class="mb-3"><label class="form-label">Brand Title</label><input type="text" name="brand_title" class="form-control" value="{{ old('brand_title', $settings['brand_title'] ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">Brand Description</label><textarea name="brand_description" class="form-control" rows="3">{{ old('brand_description', $settings['brand_description'] ?? '') }}</textarea></div>
                </div>
            </div>
            <div class="tab-pane fade" id="promo">
                <div class="page-card">
                    <div class="mb-3"><label class="form-label">Promo Title</label><input type="text" name="promo_title" class="form-control" value="{{ old('promo_title', $settings['promo_title'] ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">Promo Description</label><textarea name="promo_description" class="form-control" rows="3">{{ old('promo_description', $settings['promo_description'] ?? '') }}</textarea></div>
                </div>
            </div>
            <div class="tab-pane fade" id="feature">
                <div class="page-card">
                    <div class="mb-3"><label class="form-label">Feature Title</label><input type="text" name="feature_title" class="form-control" value="{{ old('feature_title', $settings['feature_title'] ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">Feature Description</label><textarea name="feature_description" class="form-control" rows="3">{{ old('feature_description', $settings['feature_description'] ?? '') }}</textarea></div>
                </div>
            </div>
            <div class="tab-pane fade" id="steps">
                <div class="page-card">
                    <div class="mb-3"><label class="form-label">Steps Title</label><input type="text" name="steps_title" class="form-control" value="{{ old('steps_title', $settings['steps_title'] ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">Steps Description</label><textarea name="steps_description" class="form-control" rows="3">{{ old('steps_description', $settings['steps_description'] ?? '') }}</textarea></div>
                </div>
            </div>
            <div class="tab-pane fade" id="testimonial">
                <div class="page-card">
                    <div class="mb-3"><label class="form-label">Testimonial Title</label><input type="text" name="testimonial_title" class="form-control" value="{{ old('testimonial_title', $settings['testimonial_title'] ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">Testimonial Description</label><textarea name="testimonial_description" class="form-control" rows="3">{{ old('testimonial_description', $settings['testimonial_description'] ?? '') }}</textarea></div>
                </div>
            </div>
            <div class="tab-pane fade" id="faq">
                <div class="page-card">
                    <div class="mb-3"><label class="form-label">FAQ Title</label><input type="text" name="faq_title" class="form-control" value="{{ old('faq_title', $settings['faq_title'] ?? '') }}"></div>
                    <div class="mb-3"><label class="form-label">FAQ Description</label><textarea name="faq_description" class="form-control" rows="3">{{ old('faq_description', $settings['faq_description'] ?? '') }}</textarea></div>

                    <div class="mb-3">
                        <label class="form-label">Pilih FAQ yang ditampilkan</label>
                        @php $selected = json_decode($settings['selected_faq_ids'] ?? '[]', true); @endphp
                        @forelse($faqs as $faq)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="selected_faq_ids[]" value="{{ $faq->id }}" id="faq_{{ $faq->id }}" {{ in_array($faq->id, $selected ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label" for="faq_{{ $faq->id }}">
                                    {{ $faq->pertanyaan }}
                                </label>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada FAQ. <a href="{{ route('faqs.index') }}">Tambah FAQ</a></p>
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
<script>
    // Track active tab in URL hash
    document.querySelectorAll('[data-bs-toggle="pill"]').forEach(btn => {
        btn.addEventListener('shown.bs.tab', e => {
            const pane = document.querySelector(e.target.getAttribute('data-bs-target'));
            pane.classList.add('animate__animated', 'animate__fadeIn');
            history.replaceState(null, '', '#' + pane.id);
        });
    });

    // Restore active tab from URL hash on load
    const hash = window.location.hash;
    if (hash) {
        const trigger = document.querySelector(`[data-bs-target="${hash}"]`);
        if (trigger) new bootstrap.Tab(trigger).show();
    }

    const form = document.getElementById('landingSettingsForm');
    const btn = document.getElementById('btnSave');

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-bg-${type} border-0 position-fixed top-0 end-0 m-4 shadow`;
        toast.style.zIndex = 9999;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-check-circle-fill me-2"></i>${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.body.appendChild(toast);
        new bootstrap.Toast(toast, { delay: 3000 }).show();
        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    }

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
                showToast(data.message || 'Berhasil disimpan.');
            } else {
                const errs = data.errors || {};
                const first = Object.values(errs)[0];
                showToast(first || data.message || 'Gagal menyimpan.', 'danger');
            }
        } catch (err) {
            showToast('Terjadi kesalahan jaringan.', 'danger');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Simpan Perubahan';
        }
    });
</script>
</body>
</html>