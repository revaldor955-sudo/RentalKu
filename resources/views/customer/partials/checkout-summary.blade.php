{{-- Partial: Checkout Summary (tampil di modal dashboard customer).
     Di-render server-side dan di-inject via AJAX setelah form sewa valid. --}}

<style>
    .checkout-summary .cs-mobil-img {
        width: 100px;
        height: 75px;
        object-fit: cover;
        border-radius: 12px;
    }
    .checkout-summary .cs-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .checkout-summary .cs-row:last-child {
        border-bottom: none;
    }
    .checkout-summary .cs-label {
        color: #6b7280;
        font-size: 14px;
    }
    .checkout-summary .cs-value {
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }
    .checkout-summary .cs-total-box {
        background: #f1faf5;
        border-radius: 16px;
        padding: 20px;
        margin-top: 16px;
    }
    .checkout-summary .cs-total-label {
        font-size: 14px;
        color: #6b7280;
    }
    .checkout-summary .cs-total-price {
        font-size: 28px;
        font-weight: 800;
        color: #198754;
    }
    .checkout-summary .cs-promo-box {
        background: #f0fff6;
        border: 1px solid #d5f5e3;
        border-radius: 12px;
        padding: 16px;
        margin: 16px 0;
    }
    .checkout-summary .cs-btn-confirm {
        background: #198754;
        color: white;
        border: none;
        border-radius: 13px;
        padding: 14px 25px;
        font-weight: 700;
        font-size: 16px;
        width: 100%;
        transition: all .2s ease;
    }
    .checkout-summary .cs-btn-confirm:hover {
        background: #146c43;
        transform: translateY(-1px);
    }
    .checkout-summary .cs-btn-back {
        background: transparent;
        color: #6b7280;
        border: 1px solid #e5e7eb;
        border-radius: 13px;
        padding: 12px 25px;
        font-weight: 600;
        font-size: 14px;
        width: 100%;
        margin-top: 8px;
        transition: all .2s ease;
    }
    .checkout-summary .cs-btn-back:hover {
        background: #f9fafb;
        color: #374151;
    }
    @media (prefers-reduced-motion: reduce) {
        .checkout-summary .cs-btn-confirm,
        .checkout-summary .cs-btn-back {
            transition: none;
            transform: none;
        }
    }
</style>

<div class="checkout-summary text-start">
    {{-- Header mobil --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        @if($mobil->image)
            <img src="{{ asset($mobil->image) }}" class="cs-mobil-img" alt="{{ $mobil->name }}">
        @else
            <div class="cs-mobil-img bg-light d-flex align-items-center justify-content-center">
                <i class="bi bi-car-front text-muted fs-3"></i>
            </div>
        @endif
        <div>
            <h5 class="fw-bold mb-1">{{ $mobil->name }}</h5>
            <small class="text-muted">{{ $mobil->brand->name ?? '-' }}</small>
        </div>
    </div>

    {{-- Rincian --}}
    <div class="cs-row">
        <span class="cs-label">Tanggal Mulai</span>
        <span class="cs-value">{{ \Carbon\Carbon::parse($checkout['tanggal_mulai'] ?? now())->format('d/m/Y') }}</span>
    </div>
    <div class="cs-row">
        <span class="cs-label">Tanggal Selesai</span>
        <span class="cs-value">{{ \Carbon\Carbon::parse($checkout['tanggal_selesai'] ?? now())->format('d/m/Y') }}</span>
    </div>
    <div class="cs-row">
        <span class="cs-label">Jumlah Hari</span>
        <span class="cs-value">{{ $jumlahHari }} hari</span>
    </div>
    <div class="cs-row">
        <span class="cs-label">Harga Mobil</span>
        <span class="cs-value">Rp {{ number_format($subtotalMobil, 0, ',', '.') }}</span>
    </div>
    @if($subtotalSupir > 0)
    <div class="cs-row">
        <span class="cs-label">Biaya Supir</span>
        <span class="cs-value">Rp {{ number_format($subtotalSupir, 0, ',', '.') }}</span>
    </div>
    @endif
    <div class="cs-row">
        <span class="cs-label">Deposit</span>
        <span class="cs-value">Rp {{ number_format($deposit, 0, ',', '.') }}</span>
    </div>

    {{-- Promo input --}}
    <div class="cs-promo-box">
        <label for="cs-kode-promo" class="form-label fw-bold mb-2">
            <i class="bi bi-ticket-perforated text-success me-1"></i>
            Gunakan Kode Promo
        </label>
        <div class="input-group">
            <input type="text" id="cs-kode-promo" class="form-control" placeholder="Contoh: HEMAT30" maxlength="50" autocomplete="off" value="{{ old('kode_promo', $checkout['kode_promo'] ?? '') }}">
            <button type="button" class="btn btn-outline-success" onclick="applyPromo()">Terapkan</button>
        </div>
        <small class="text-muted d-block mt-2">Masukkan kode promo yang diberikan admin.</small>
        <div id="cs-promo-message" class="mt-2 small"></div>
    </div>

    @if($diskon > 0)
    <div class="cs-row text-success">
        <span class="cs-label">Diskon Promo</span>
        <strong>- Rp {{ number_format($diskon, 0, ',', '.') }}</strong>
    </div>
    @endif

    {{-- Total --}}
    <div class="cs-total-box">
        <div class="d-flex justify-content-between align-items-center">
            <span class="cs-total-label">Total Harga</span>
            <span class="cs-total-price">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Actions --}}
    <form id="checkoutConfirmForm" action="{{ route('rentals.checkout.confirm', $mobil->id) }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="kode_promo" id="cs-hidden-promo" value="{{ $checkout['kode_promo'] ?? '' }}">
        <button type="submit" class="cs-btn-confirm">
            <i class="bi bi-check-circle me-2"></i>
            Konfirmasi Rental
        </button>
    </form>
    <button type="button" class="cs-btn-back" onclick="backToSewaForm()">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </button>
</div>

<script>
    function applyPromo() {
        var kode = $('#cs-kode-promo').val().trim();
        if (!kode) return;
        $('#cs-promo-message').html('<span class="text-muted">Memeriksa promo...</span>');
        $.ajax({
            url: '{{ route('rentals.checkout', $mobil->id) }}',
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                tanggal_mulai: '{{ $checkout['tanggal_mulai'] ?? '' }}',
                tanggal_selesai: '{{ $checkout['tanggal_selesai'] ?? '' }}',
                supir_id: '{{ $checkout['supir_id'] ?? '' }}',
                kode_promo: kode,
                catatan: '{{ $checkout['catatan'] ?? '' }}'
            },
            success: function(res) {
                if (res.success && res.html) {
                    $('#swal2-html-container').html(res.html);
                    $('#cs-promo-message').html('<span class="text-success"><i class="bi bi-check-circle me-1"></i>Promo berhasil diterapkan.</span>');
                } else {
                    $('#cs-promo-message').html('<span class="text-danger">' + (res.message || 'Promo tidak valid.') + '</span>');
                }
            },
            error: function(xhr) {
                var msg = 'Gagal memeriksa promo.';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                $('#cs-promo-message').html('<span class="text-danger">' + msg + '</span>');
            }
        });
    }

    function backToSewaForm() {
        var $template = $('#sewaFormTemplate');
        if ($template.length) {
            $('#swal2-html-container').html($template.html());
            initSewaForm();
        }
    }

    // Bind submit konfirmasi checkout
    $(document).off('submit', '#checkoutConfirmForm').on('submit', '#checkoutConfirmForm', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $submit = $form.find('button[type="submit"]');
        var submitHtml = $submit.html();
        $submit.prop('disabled', true);
        $submit.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengirim...');
        Swal.showLoading();
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: $form.serialize(),
            success: function(res) {
                Swal.hideLoading();
                if (res.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        html: '<div class="swal-check"><svg width="72" height="72" viewBox="0 0 52 52"><circle cx="26" cy="26" r="24" fill="none" stroke="#198754" stroke-width="2.5"/><path fill="none" stroke="#198754" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" d="M14 27l8 8 16-16"/></svg><p>' + (res.message || 'Pengajuan sewa mobil berhasil dibuat.') + '</p></div>',
                        confirmButtonText: 'OK',
                    }).then(function() {
                        window.location.reload();
                    });
                } else {
                    $submit.prop('disabled', false);
                    $submit.html(submitHtml);
                    var errs = res.errors || {};
                    if (errs.kode_promo) $('#cs-promo-message').html('<span class="text-danger">' + errs.kode_promo[0] + '</span>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.errors ? Object.values(res.errors).flat()[0] : (res.message || 'Terjadi kesalahan.'),
                    });
                }
            },
            error: function(xhr) {
                Swal.hideLoading();
                $submit.prop('disabled', false);
                $submit.html(submitHtml);
                var r = (xhr && xhr.responseJSON) || {};
                var msg = 'Terjadi kesalahan. Silakan coba lagi.';
                if (r.errors) {
                    msg = Object.values(r.errors).flat()[0] || msg;
                    if (r.errors.kode_promo) $('#cs-promo-message').html('<span class="text-danger">' + r.errors.kode_promo[0] + '</span>');
                } else if (r.message) msg = r.message;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                });
            }
        });
    });
</script>
