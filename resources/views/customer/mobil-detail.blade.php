<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
       {{ $mobil->name ?? 'Detail Mobil' }} - RentalKu
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #f6f8f7;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            color: #1f2937;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #eee;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        /* Samakan gaya tombol auth navbar dengan landing (layouts/partials/navbar) */
        .btn-rent {
            background: #198754;
            color: white;
            border-radius: 10px;
            padding: 11px 21px;
            font-weight: 700;
            border: none;
        }

        .btn-rent:hover {
            background: #146c43;
            color: white;
        }

        .detail-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0,0,0,.06);
        }

        .car-photo {
            width: 100%;
            height: 470px;
            object-fit: contain;
            object-position: center;
            border-radius: 18px;
            background: #f6f8f7;
            display: block;
        }

        .detail-content {
            padding: 40px;
        }

        .badge-available {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e8f7ef;
            color: #198754;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }

        .badge-unavailable {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fde8e8;
            color: #dc3545;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }

        .car-title {
            font-size: 34px;
            font-weight: 800;
            margin-top: 18px;
            margin-bottom: 10px;
        }

        .car-subtitle {
            color: #6b7280;
            font-size: 15px;
        }

        .price-box {
            background: #f1faf5;
            border-radius: 18px;
            padding: 20px;
            margin-top: 25px;
        }

        .price-label {
            color: #6b7280;
            font-size: 14px;
        }

        .price {
            color: #198754;
            font-size: 28px;
            font-weight: 800;
        }

        .price span {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
        }

        .spec-card {
            background: #f8faf9;
            border: 1px solid #edf0ee;
            border-radius: 16px;
            padding: 17px;
            height: 100%;
        }

        .spec-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #e8f7ef;
            color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            margin-bottom: 10px;
        }

        .spec-title {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .spec-value {
            font-weight: 700;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: #4b5563;
        }

        .feature i {
            color: #198754;
        }

        .btn-rental {
            background: #198754;
            color: white;
            border: none;
            border-radius: 13px;
            padding: 14px 25px;
            font-weight: 700;
            width: 100%;
        }

        .btn-rental:hover {
            background: #146c43;
            color: white;
        }

        .btn-back {
            border: 1px solid #dfe5e1;
            background: white;
            color: #374151;
            border-radius: 13px;
            padding: 13px 20px;
            font-weight: 600;
        }

        .btn-back:hover {
            background: #f5f7f6;
        }

        .section-title {
            font-weight: 800;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {

            .car-photo {
                height: 280px;
            }

            .detail-content {
                padding: 25px;
            }

            .car-title {
                font-size: 27px;
            }

        }

    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

<nav class="navbar">
    <div class="container py-3">

        <a href="{{ url('/') }}" class="text-decoration-none brand">
            Rental<span>ku</span>.
        </a>

        <div class="d-flex align-items-center gap-3">

                @auth

                    <span class="d-none d-md-block">
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button class="btn btn-outline-danger fw-semibold rounded-3">
                            <i class="bi bi-box-arrow-right"></i>
                            Keluar
                        </button>
                    </form>

                @else

                    <a href="{{ route('login') }}" class="btn btn-light border rounded-3 px-3 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Masuk
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-rent">
                        Daftar
                    </a>

                @endauth

            </div>

    </div>
</nav>

<div class="container py-4">

    {{-- KEMBALI: customer → dashboard, guest → beranda (dashboard dilindungi auth) --}}
    <div class="mb-4">

        @auth
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-2"></i>

                Kembali ke Dashboard

            </a>
        @else
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-2"></i>

                Kembali ke Beranda

            </a>
        @endauth

    </div>

    <div class="detail-card">

        <div class="row g-0">

            <div class="col-lg-6 p-3 p-md-4">

               @if($mobil->image)
    <img
        src="{{ asset($mobil->image) }}"
        class="car-photo"
        alt="{{ $mobil->name }}"
    >
@else
    <img
        src="https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg"
        class="car-photo"
        alt="Mobil Rental"
    >
@endif

            </div>

            <div class="col-lg-6">

                <div class="detail-content">

                    @if($mobil->status === 'Tersedia')

    <span class="badge-available">

        <i class="bi bi-check-circle-fill"></i>

        Tersedia untuk disewa

    </span>

@else

    <span class="badge-unavailable">

        <i class="bi bi-x-circle-fill"></i>

        Tidak Tersedia untuk disewa

    </span>

@endif

                    <h1 class="car-title">

                    {{ $mobil->name }}

                    </h1>

                   <p class="car-subtitle">
    <i class="bi bi-car-front me-1"></i>

    {{ $mobil->tipeMobil->name ?? '-' }}
</p>

                    <div class="price-box">

                        <div class="price-label">
                            Harga sewa mulai dari
                        </div>

                        <div class="price">

                            Rp
{{ number_format($mobil->harga_perhari, 0, ',', '.') }}

                            <span>/ hari</span>

                        </div>

                    </div>

<div class="row g-3 mt-2">

    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-award"></i>
            </div>

            <div class="spec-title">
                Brand
            </div>

            <div class="spec-value">
                {{ $mobil->brand->name ?? '-' }}
            </div>

        </div>

    </div>

    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-car-front"></i>
            </div>

            <div class="spec-title">
                Tipe Mobil
            </div>

            <div class="spec-value">
                {{ $mobil->tipeMobil->name ?? '-' }}
            </div>

        </div>

    </div>

    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-people"></i>
            </div>

            <div class="spec-title">
                Kapasitas
            </div>

            <div class="spec-value">
                {{ $mobil->kapasitas }} Orang
            </div>

        </div>

    </div>

    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-gear"></i>
            </div>

            <div class="spec-title">
                Transmisi
            </div>

            <div class="spec-value">
                {{ $mobil->transmisi }}
            </div>

        </div>

    </div>

    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-palette"></i>
            </div>

            <div class="spec-title">
                Warna
            </div>

            <div class="spec-value">
                {{ $mobil->warna }}
            </div>

        </div>

    </div>

    <div class="col-6">

        <div class="spec-card">

            <div class="spec-icon">
                <i class="bi bi-calendar3"></i>
            </div>

            <div class="spec-title">
                Tahun
            </div>

            <div class="spec-value">
                {{ $mobil->tahun }}
            </div>

        </div>

    </div>

<div class="col-6">

    <div class="spec-card">

        <div class="spec-icon">
            <i class="bi bi-wallet2"></i>
        </div>

        <div class="spec-title">
            Deposit
        </div>

        <div class="spec-value">
            Rp {{ number_format($mobil->deposit, 0, ',', '.') }}
        </div>

    </div>

</div>

<div class="col-6">

    <div class="spec-card">

        <div class="spec-icon">
            <i class="bi bi-geo-alt"></i>
        </div>

        <div class="spec-title">
            Cabang
        </div>

        <div class="spec-value">
            {{ $mobil->cabang->name ?? '-' }}
        </div>

    </div>

</div>

</div>

                   <div class="mt-4">

    @if($mobil->status === 'Tersedia')

        @auth

            <button
                type="button"
                class="btn btn-rental d-flex align-items-center justify-content-center"
                onclick="openSewaPopup()">

                <i class="bi bi-calendar-check me-2"></i>

                Sewa Sekarang

            </button>

        @else

            <a
                href="{{ route('login') }}"
                class="btn btn-rental d-flex align-items-center justify-content-center text-decoration-none">

                <i class="bi bi-box-arrow-in-right me-2"></i>

                Masuk untuk Sewa

            </a>

        @endauth

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

                    <div class="text-center mt-3">

                        <small class="text-muted">

                            <i class="bi bi-shield-check me-1"></i>

                            Rental aman dan terpercaya bersama RentalKu

                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-5 g-4">

        <div class="col-lg-7">

            <div class="bg-white rounded-4 p-4">

                <h4 class="section-title">
                    Tentang Mobil
                </h4>

               <p class="text-muted mb-0">

    {{ $mobil->description ?? 'Belum ada deskripsi mobil.' }}

</p>

            </div>

        </div>

        <div class="col-lg-5">

    <div class="bg-white rounded-4 p-4">

        <h4 class="section-title">
            Fasilitas
        </h4>

        @forelse($mobil->fasilitas as $fasilitas)

            <div class="feature">

                <i class="bi bi-check-circle-fill"></i>

                {{ $fasilitas->name }}

            </div>

        @empty

            <p class="text-muted mb-0">
                Belum ada fasilitas.
            </p>

        @endforelse

    </div>

</div>

{{-- FORM SEWA (server-rendered, di-inject ke SweetAlert) --}}
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
                    <select name="supir_id" class="form-select" id="supirSelect" onchange="updateSupirProfile(this)">
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

                <!-- Profile Supir Card (Hidden by default) -->
                <div id="supirProfileCard" class="card mb-3 shadow-sm border-primary animate__animated animate__fadeIn" style="display: none;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <img id="supirImg" src="" class="rounded-circle me-3" style="width: 70px; height: 70px; object-fit: cover; border: 2px solid var(--bs-primary);">
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold text-primary" id="supirName"></h6>
                                <div class="small text-muted mb-2">
                                    <i class="bi bi-telephone me-1"></i> <span id="supirPhone"></span>
                                </div>
                                <div class="badge bg-light text-primary border border-primary">
                                    Tarif: Rp <span id="supirTarif"></span> /hari
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function updateSupirProfile(select) {
                        const card = document.getElementById('supirProfileCard');
                        const opt = select.options[select.selectedIndex];
                        
                        if (select.value === "") {
                            card.style.display = 'none';
                        } else {
                            document.getElementById('supirName').innerText = opt.dataset.name;
                            document.getElementById('supirPhone').innerText = opt.dataset.phone;
                            document.getElementById('supirTarif').innerText = opt.dataset.tarif;
                            document.getElementById('supirImg').src = opt.dataset.image;
                            card.style.display = 'block';
                        }
                        updateSewaButton();
                    }

                    function updateSewaButton() {
                        const tglMulai = document.querySelector('input[name="tanggal_mulai"]').value;
                        const tglSelesai = document.querySelector('input[name="tanggal_selesai"]').value;
                        const btn = document.querySelector('button[type="submit"]');
                        
                        // Disable if dates empty
                        btn.disabled = !(tglMulai && tglSelesai);
                    }

                    document.addEventListener('DOMContentLoaded', () => {
                        const dateInputs = document.querySelectorAll('input[name="tanggal_mulai"], input[name="tanggal_selesai"]');
                        dateInputs.forEach(i => i.addEventListener('change', updateSewaButton));
                        updateSewaButton();
                    });
                </script>

                <div class="form-text mt-2">
                   <i class="bi bi-info-circle me-1"></i>
                   Pilih supir jika Anda membutuhkan bantuan pengemudi.
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

<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function openSewaPopup() {
        var $template = $('#sewaFormTemplate');
        if (!$template.length) return;

        if ($('.badge-available').length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Mobil sedang tidak tersedia.',
            });
            return;
        }

        Swal.fire({
            title: 'Sewa {{ $mobil->name }}',
            html: $template.html(),
            width: 600,
            showConfirmButton: false,
            didOpen: function() {
                var $form = $('#swal2-html-container form');

                $form.on('submit', function(event) {
                    event.preventDefault();

                    var formData = new FormData($form[0]);

                    Swal.showLoading();

                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        data: formData,
                        processData: false,
                        contentType: false
                    })
                    .done(function(data, textStatus, xhr) {
                        Swal.hideLoading();

                        if (xhr.status !== 200) {
                            var firstError = data.errors
                                ? Object.values(data.errors).flat()[0]
                                : (data.message || 'Terjadi kesalahan.');

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: firstError,
                            });
                            return;
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Pengajuan sewa mobil berhasil dibuat.',
                            confirmButtonText: 'OK',
                        }).then(function() {
                            window.location.href = '{{ route('customer.dashboard') }}';
                        });
                    })
                    .fail(function() {
                        Swal.hideLoading();
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Koneksi bermasalah. Silakan coba lagi.',
                        });
                    });
                });
            }
        });
    }

</script>

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

        // Filter supir berdasarkan cabang ambil yang dipilih
        var cabangId = el.value;
        var supirSelect = form.querySelector('select[name="supir_id"]');
        if (supirSelect) {
            Array.from(supirSelect.options).forEach(function(opt) {
                if (opt.value === "") return;
                opt.hidden = (opt.dataset.cabangId !== cabangId);
            });

            // Reset pilihan supir jika tidak sesuai cabang
            if (supirSelect.value !== "" && supirSelect.options[supirSelect.selectedIndex].dataset.cabangId !== cabangId) {
                supirSelect.value = "";
                var card = document.getElementById('supirProfileCard');
                if (card) card.style.display = 'none';
                updateSewaButton();
            }
        }
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

</body>
</html>