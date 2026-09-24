{{-- Partial konten modal detail mobil (dashboard customer).
     Dimuat via AJAX dari MobilController@show — tanpa reload halaman. --}}

<style>
    .mobil-modal .mm-photo {
        width: 100%;
        height: 260px;
        object-fit: contain;
        object-position: center;
        background: #f8faf9;
        display: block;
    }

    .mobil-modal .mm-content {
        padding: 28px;
    }

    .mobil-modal .mm-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
    }

    .mobil-modal .mm-badge-available {
        background: #e8f7ef;
        color: #198754;
    }

    .mobil-modal .mm-badge-unavailable {
        background: #fde8e8;
        color: #dc3545;
    }

    .mobil-modal .mm-title {
        font-size: 26px;
        font-weight: 800;
        margin-top: 16px;
        margin-bottom: 8px;
        color: #1f2937;
    }

    .mobil-modal .mm-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 0;
    }

    .mobil-modal .mm-price-box {
        background: #f1faf5;
        border-radius: 18px;
        padding: 18px;
        margin-top: 20px;
    }

    .mobil-modal .mm-price-label {
        color: #6b7280;
        font-size: 13px;
    }

    .mobil-modal .mm-price {
        color: #198754;
        font-size: 26px;
        font-weight: 800;
    }

    .mobil-modal .mm-price small {
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
    }

    .mobil-modal .mm-spec-card {
        background: #f8faf9;
        border: 1px solid #edf0ee;
        border-radius: 14px;
        padding: 14px;
        height: 100%;
    }

    .mobil-modal .mm-spec-icon {
        color: #198754;
        font-size: 18px;
        margin-bottom: 6px;
    }

    .mobil-modal .mm-spec-title {
        color: #6b7280;
        font-size: 12px;
    }

    .mobil-modal .mm-spec-value {
        color: #1f2937;
        font-size: 14px;
        font-weight: 700;
    }

    .mobil-modal .btn-rental {
        background: #198754;
        color: #fff;
        border: none;
        border-radius: 13px;
        padding: 14px 25px;
        font-weight: 700;
    }

    .mobil-modal .btn-rental:hover {
        background: #157347;
        color: #fff;
    }

    @media (min-width: 992px) {
        .mobil-modal .mm-photo {
            height: 100%;
            min-height: 420px;
        }
    }
</style>

<div class="mobil-modal">

    <div class="row g-0">

        <div class="col-lg-6">

            @if($mobil->image)
                <img
                    src="{{ asset($mobil->image) }}"
                    class="mm-photo"
                    alt="{{ $mobil->name }}"
                >
            @else
                <img
                    src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg"
                    class="mm-photo"
                    alt="{{ $mobil->name }}"
                >
            @endif

        </div>

        <div class="col-lg-6">

            <div class="mm-content">

                @if($mobil->status === 'Tersedia')

                    <span class="mm-badge mm-badge-available">
                        <i class="bi bi-check-circle-fill"></i>
                        Tersedia untuk disewa
                    </span>

                @else

                    <span class="mm-badge mm-badge-unavailable">
                        <i class="bi bi-x-circle-fill"></i>
                        Tidak Tersedia untuk disewa
                    </span>

                @endif

                <h3 class="mm-title">
                    {{ $mobil->name }}
                </h3>

                <p class="mm-subtitle">
                    <i class="bi bi-car-front me-1"></i>
                    {{ $mobil->tipeMobil->name ?? '-' }}
                </p>

                <div class="mm-price-box">

                    <div class="mm-price-label">
                        Harga sewa mulai dari
                    </div>

                    <div class="mm-price">
                        Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}
                        <small>/ hari</small>
                    </div>

                </div>

                <div class="row g-2 mt-2">

                    <div class="col-6">

                        <div class="mm-spec-card">

                            <div class="mm-spec-icon">
                                <i class="bi bi-award"></i>
                            </div>

                            <div class="mm-spec-title">
                                Brand
                            </div>

                            <div class="mm-spec-value">
                                {{ $mobil->brand->name ?? '-' }}
                            </div>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="mm-spec-card">

                            <div class="mm-spec-icon">
                                <i class="bi bi-car-front"></i>
                            </div>

                            <div class="mm-spec-title">
                                Tipe Mobil
                            </div>

                            <div class="mm-spec-value">
                                {{ $mobil->tipeMobil->name ?? '-' }}
                            </div>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="mm-spec-card">

                            <div class="mm-spec-icon">
                                <i class="bi bi-people"></i>
                            </div>

                            <div class="mm-spec-title">
                                Kapasitas
                            </div>

                            <div class="mm-spec-value">
                                {{ $mobil->kapasitas }} Orang
                            </div>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="mm-spec-card">

                            <div class="mm-spec-icon">
                                <i class="bi bi-gear"></i>
                            </div>

                            <div class="mm-spec-title">
                                Transmisi
                            </div>

                            <div class="mm-spec-value">
                                {{ $mobil->transmisi }}
                            </div>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="mm-spec-card">

                            <div class="mm-spec-icon">
                                <i class="bi bi-palette"></i>
                            </div>

                            <div class="mm-spec-title">
                                Warna
                            </div>

                            <div class="mm-spec-value">
                                {{ $mobil->warna }}
                            </div>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="mm-spec-card">

                            <div class="mm-spec-icon">
                                <i class="bi bi-calendar3"></i>
                            </div>

                            <div class="mm-spec-title">
                                Tahun
                            </div>

                            <div class="mm-spec-value">
                                {{ $mobil->tahun }}
                            </div>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="mm-spec-card">

                            <div class="mm-spec-icon">
                                <i class="bi bi-wallet2"></i>
                            </div>

                            <div class="mm-spec-title">
                                Deposit
                            </div>

                            <div class="mm-spec-value">
                                Rp {{ number_format($mobil->deposit, 0, ',', '.') }}
                            </div>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="mm-spec-card">

                            <div class="mm-spec-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div class="mm-spec-title">
                                Cabang
                            </div>

                            <div class="mm-spec-value">
                                {{ $mobil->cabang->name ?? '-' }}
                            </div>

                        </div>

                    </div>

                </div>

                <div class="mt-3">

                    @if($mobil->status === 'Tersedia')

                        <button
                            type="button"
                            class="btn btn-rental w-100 d-flex align-items-center justify-content-center"
                            onclick="openSewaPopup()">

                            <i class="bi bi-calendar-check me-2"></i>
                            Sewa Sekarang

                        </button>

                    @else

                        <button
                            type="button"
                            class="btn btn-secondary w-100"
                            style="border-radius: 13px; padding: 14px 25px;"
                            disabled>

                            <i class="bi bi-x-circle me-2"></i>
                            Mobil Tidak Tersedia

                        </button>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

{{-- FORM SEWA (server-rendered, di-inject ke SweetAlert saat klik "Sewa Sekarang") --}}
<div id="sewaFormTemplate" class="d-none">

    <form
        action="{{ route('rentals.store', $mobil->id) }}"
        method="POST"
        id="sewaForm">

        @csrf

        <div class="row g-3 text-start">

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Cabang Ambil
                </label>

                <select
                    name="cabang_ambil_id"
                    class="form-select"
                    required>

                    <option value="" disabled selected>
                        Pilih cabang ambil
                    </option>

                    @foreach($cabangs as $cabang)

                        <option
                            value="{{ $cabang->id }}"
                            @selected(old('cabang_ambil_id', $mobil->cabang_id) == $cabang->id)>
                            {{ $cabang->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Cabang Kembali
                </label>

                <select
                    name="cabang_kembali_id"
                    class="form-select"
                    required>

                    <option value="" disabled selected>
                        Pilih cabang kembali
                    </option>

                    @foreach($cabangs as $cabang)

                        <option
                            value="{{ $cabang->id }}"
                            @selected(old('cabang_kembali_id', $mobil->cabang_id) == $cabang->id)>
                            {{ $cabang->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    class="form-control"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('tanggal_mulai', date('Y-m-d')) }}"
                    required>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Tanggal Selesai
                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    class="form-control"
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    value="{{ old('tanggal_selesai', date('Y-m-d', strtotime('+1 day'))) }}"
                    required>

            </div>

            <div class="col-12">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Pilih Supir (Opsional)</label>
                    <select name="supir_id" class="form-select" id="supirSelectModal">
                        <option value="">Tanpa Supir (Lepas Kunci)</option>
                        @foreach($supirs as $supir)
                            <option value="{{ $supir->id }}" 
                                data-cabang-id="{{ $supir->cabang_id }}"
                                data-name="{{ $supir->name }}" 
                                data-phone="{{ $supir->phone }}" 
                                data-tarif="{{ number_format($supir->tarif_perhari, 0, ',', '.') }}"
                                data-image="{{ $supir->image ?? 'https://ui-avatars.com/api/?name='.urlencode($supir->name) }}">
                                {{ $supir->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Profile Supir Card (selalu tampil, data di-update via JS di dashboard) -->
                <div id="supirProfileCardModal" class="card mb-3 shadow-sm border-primary">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <img id="supirImgModal" src="https://ui-avatars.com/api/?name=Pilih+Supir" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold text-primary" id="supirNameModal">Silakan pilih supir</h6>
                                <div class="small text-muted mb-1">
                                    <i class="bi bi-telephone me-1"></i> <span id="supirPhoneModal">-</span>
                                </div>
                                <div class="fw-bold text-success" id="supirTarifModalContainer">
                                    + <span id="supirTarifModal">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12">

                <label class="form-label fw-semibold">
                    Catatan
                </label>

                <textarea
                    name="catatan"
                    class="form-control"
                    rows="3"
                    placeholder="Catatan tambahan jika diperlukan...">{{ old('catatan') }}</textarea>

            </div>

            <div class="col-12">

                <div class="alert alert-success py-2 mb-0">

                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Harga: Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}/hari.
                        Deposit Rp {{ number_format($mobil->deposit, 0, ',', '.') }}
                        ditambahkan ke total.
                    </small>

                </div>

            </div>

            <div class="col-12">

                <button type="submit" class="btn btn-success w-100 py-2">
                    <i class="bi bi-calendar-check me-1"></i>
                    Ajukan Sewa
                </button>

            </div>

        </div>

    </form>

</div>

{{-- GoodUI #13/#28/#33: client-side convenience untuk form sewa (validasi server tetap sumber kebenaran).
     Delegated agar jalan di konten dinamis (inject SweetAlert via $template.html());
     tidak bind saat load ke elemen di dalam #sewaFormTemplate. --}}
<script>
(function () {
    if (window.__sewaGoodUIInit) return;
    window.__sewaGoodUIInit = true;

    function sewaFormOf(el) {
        return el && el.closest ? el.closest('form') : null;
    }

    // Delegated change: pakai $(document).on bila jQuery ada, fallback native.
    function onDocChange(selector, fn) {
        if (window.jQuery) {
            window.jQuery(document).on('change', selector, function (e) { fn(e, this); });
        } else {
            document.addEventListener('change', function (e) {
                if (e.target && e.target.matches && e.target.matches(selector)) fn(e, e.target);
            });
        }
    }

    function clearDateError(form) {
        form.querySelectorAll('.sewa-date-error').forEach(function (n) { n.remove(); });
    }

    // #13: cabang-kembali mengikuti cabang-ambil selama masih placeholder/kosong.
    onDocChange('select[name="cabang_ambil_id"]', function (e, el) {
        var form = sewaFormOf(el);
        if (!form) return;
        var kembali = form.querySelector('select[name="cabang_kembali_id"]');
        if (kembali && !kembali.value) kembali.value = el.value;
    });

    // #33: hapus catatan inline saat tanggal diubah / submit diulang.
    onDocChange('input[name="tanggal_mulai"], input[name="tanggal_selesai"]', function (e, el) {
        var form = sewaFormOf(el);
        if (form) clearDateError(form);
    });

    // #33: cegah submit bila rentang salah — capture agar jalan SEBELUM handler AJAX existing.
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!form || !form.querySelector) return;
        var mulai = form.querySelector('input[name="tanggal_mulai"]');
        var selesai = form.querySelector('input[name="tanggal_selesai"]');
        if (!mulai || !selesai) return;
        clearDateError(form);
        if (mulai.value && selesai.value && selesai.value <= mulai.value) {
            e.preventDefault();
            e.stopPropagation();
            var note = document.createElement('div');
            note.className = 'sewa-date-error text-danger small mt-1';
            note.textContent = 'Tanggal selesai harus setelah tanggal mulai.';
            selesai.after(note);
        }
    }, true);
})();
</script>