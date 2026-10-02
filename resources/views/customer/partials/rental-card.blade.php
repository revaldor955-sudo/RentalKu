<div class="rental-card">
    <div class="stat-card d-flex flex-column h-100">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <div class="d-flex gap-3 mb-3 pb-3 border-bottom">

            {{-- Car Image --}}
            <div class="rental-image-thumb">
                @if($rental->mobil->image)
                    <img
                        src="{{ asset($rental->mobil->image) }}"
                        alt="{{ $rental->mobil->name }}"
                        class="img-fluid rounded"
                    >
                @else
                    <div class="placeholder-image rounded d-flex align-items-center justify-content-center">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                @endif
            </div>

            {{-- Title + ID + Status --}}
            <div class="flex-grow-1">
                <h6 class="fw-bold mb-1">
                    {{ $rental->mobil->name }}
                </h6>

                <small class="text-muted d-block">
                    Rental #{{ $rental->id }}
                </small>

                <div class="mt-2">
                    <span class="badge {{ $rental->status === 'Selesai' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $rental->status }}
                    </span>
                </div>
            </div>

        </div>


        {{-- =========================================================
             DATA RENTAL
        ========================================================== --}}
        <div class="rental-data mb-3">

            <div class="rental-data-item">
                <i class="bi bi-calendar-event"></i>
                <span>
                    {{ $rental->tanggal_mulai->format('d/m/Y') }}
                    -
                    {{ $rental->tanggal_selesai->format('d/m/Y') }}
                </span>
            </div>

            <div class="rental-data-item">
                <i class="bi bi-clock"></i>
                <span>
                    {{ $rental->jumlah_hari }} Hari
                </span>
            </div>

            <div class="rental-data-item">
                <i class="bi bi-wallet2"></i>
                <span class="text-success fw-bold">
                    Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                </span>
            </div>

        </div>


        {{-- =========================================================
             ACTION
        ========================================================== --}}
        <div class="mt-auto">

            {{-- =====================================================
                 STATUS DISETUJUI
            ====================================================== --}}
            @if($rental->status === 'Disetujui')

                @if(!$rental->pembayaran)

                    <button
                        type="button"
                        class="btn btn-success w-100 btn-bayar"
                        data-action="{{ route('pembayaran.store', $rental->id) }}"
                        data-title="Bayar Sekarang"
                        data-mobil="{{ $rental->mobil->name ?? 'Mobil' }}"
                        data-rental="{{ $rental->id }}"
                        data-cabang="{{ $rental->cabang_ambil_id }}"
                        data-total="{{ $rental->total_harga }}"
                    >
                        <i class="bi bi-credit-card me-1"></i>
                        Bayar Sekarang
                    </button>

                @elseif($rental->pembayaran->status === 'Menunggu')

                    <div class="alert alert-info mb-0 py-2 px-3">
                        <i class="bi bi-clock-history me-1"></i>
                        <small>
                            Bukti pembayaran sedang diverifikasi
                        </small>
                    </div>

                @elseif($rental->pembayaran->status === 'Disetujui')

                    <div class="alert alert-success mb-0 py-2 px-3">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        <small>
                            Pembayaran terverifikasi
                        </small>
                    </div>

                @elseif($rental->pembayaran->status === 'Ditolak')

                    <button
                        type="button"
                        class="btn btn-danger w-100 btn-bayar"
                        data-action="{{ route('pembayaran.store', $rental->id) }}"
                        data-title="Upload Ulang Pembayaran"
                        data-mobil="{{ $rental->mobil->name ?? 'Mobil' }}"
                        data-rental="{{ $rental->id }}"
                        data-cabang="{{ $rental->cabang_ambil_id }}"
                        data-total="{{ $rental->total_harga }}"
                    >
                        <i class="bi bi-arrow-repeat me-1"></i>
                        Upload Ulang
                    </button>

                @endif


            {{-- =====================================================
                 STATUS MENUNGGU
            ====================================================== --}}
            @elseif($rental->status === 'Menunggu')

                <div class="alert alert-warning mb-0 py-2 px-3">
                    <i class="bi bi-hourglass-split me-1"></i>
                    <small>
                        Menunggu persetujuan
                    </small>
                </div>


            {{-- =====================================================
                 STATUS DITOLAK
            ====================================================== --}}
            @elseif($rental->status === 'Ditolak')

                <div class="alert alert-danger mb-0 py-2 px-3">
                    <i class="bi bi-x-circle me-1"></i>
                    <small>
                        Pengajuan ditolak
                    </small>
                </div>


            {{-- =====================================================
                 STATUS SELESAI
            ====================================================== --}}
            @elseif($rental->status === 'Selesai')

                <div class="d-flex gap-2 flex-wrap">

                    {{-- =================================================
                         RATING
                    ================================================== --}}
                    @if(!$rental->rating)

                        {{-- Tombol Rating --}}
                        <button
                            type="button"
                            class="rental-action-btn btn-rating"
                            onclick="openRatingModal({{ $rental->id }})"
                        >
                            <i class="bi bi-star-fill me-1"></i>
                            Rating
                        </button>


                        {{-- =================================================
                             CUSTOM RATING MODAL
                        ================================================== --}}
                        <div
                            class="rating-modal-custom"
                            id="ratingModal{{ $rental->id }}"
                            aria-hidden="true"
                        >

                            {{-- Backdrop --}}
                            <div
                                class="rating-modal-backdrop"
                                onclick="closeRatingModal({{ $rental->id }})"
                            ></div>


                            {{-- Modal Box --}}
                            <div
                                class="rating-modal-box"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="ratingTitle{{ $rental->id }}"
                            >

                                <form
                                    action="{{ route('customer.ratings.store', $rental->id) }}"
                                    method="POST"
                                >

                                    @csrf


                                    {{-- HEADER --}}
                                    <div class="modal-header">

                                        <div>
                                            <h5
                                                class="modal-title fw-bold mb-1"
                                                id="ratingTitle{{ $rental->id }}"
                                            >
                                                <i class="bi bi-star-fill text-warning me-1"></i>
                                                Beri Rating
                                            </h5>

                                            <small class="text-muted">
                                                {{ $rental->mobil->name ?? 'Mobil' }}
                                            </small>
                                        </div>

                                        <button
                                            type="button"
                                            class="btn-close"
                                            onclick="closeRatingModal({{ $rental->id }})"
                                            aria-label="Tutup"
                                        ></button>

                                    </div>


                                    {{-- BODY --}}
                                    <div class="modal-body text-start">

                                        {{-- Rating --}}
                                        <div class="mb-4">

                                            <label class="form-label fw-semibold">
                                                Rating
                                            </label>

                                            <select
                                                name="rating"
                                                class="form-select"
                                                required
                                            >
                                                <option value="">
                                                    Pilih Rating
                                                </option>

                                                <option value="5">
                                                    ⭐⭐⭐⭐⭐ Sangat Baik
                                                </option>

                                                <option value="4">
                                                    ⭐⭐⭐⭐ Baik
                                                </option>

                                                <option value="3">
                                                    ⭐⭐⭐ Cukup
                                                </option>

                                                <option value="2">
                                                    ⭐⭐ Kurang
                                                </option>

                                                <option value="1">
                                                    ⭐ Sangat Kurang
                                                </option>
                                            </select>

                                        </div>


                                        {{-- Komentar --}}
                                        <div class="mb-2">

                                            <label class="form-label fw-semibold">
                                                Komentar
                                            </label>

                                            <textarea
                                                name="komentar"
                                                class="form-control"
                                                rows="4"
                                                maxlength="1000"
                                                placeholder="Tulis pengalaman kamu menggunakan layanan RentalKu..."
                                                required
                                            ></textarea>

                                            <div class="form-text">
                                                Maksimal 1000 karakter.
                                            </div>

                                        </div>

                                    </div>


                                    {{-- FOOTER --}}
                                    <div class="modal-footer">

                                        <button
                                            type="button"
                                            class="btn btn-secondary btn-sm"
                                            onclick="closeRatingModal({{ $rental->id }})"
                                        >
                                            Batal
                                        </button>

                                        <button
                                            type="submit"
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="bi bi-send me-1"></i>
                                            Kirim
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>


                    @else

                        {{-- =================================================
                             RATING SUDAH DIBERIKAN
                        ================================================== --}}
                        <div class="rating-result">

                            <div class="rating-result-stars">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <= (int) $rental->rating->rating)
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif

                                @endfor

                            </div>

                            <span class="rating-result-value">
                                {{ $rental->rating->rating }}/5
                            </span>

                        </div>

                    @endif


                    {{-- =================================================
                         KOMPENSASI
                    ================================================== --}}
                    <a
                        href="{{ route('customer.kompensasi.index', ['baru' => 1, 'rental' => $rental->id]) }}"
                        class="rental-action-btn btn-kompensasi"
                    >
                        <i class="bi bi-megaphone me-1"></i>
                        Kompensasi
                    </a>

                </div>

            @endif


            {{-- =========================================================
                 DENDA
            ========================================================== --}}
            @if($rental->dendas && $rental->dendas->count())

                <div class="mt-3 pt-3 border-top">

                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Denda ({{ $rental->dendas->count() }})
                    </h6>


                    @foreach($rental->dendas as $d)

                        <div class="border rounded p-2 mb-2 small">

                            <div class="d-flex justify-content-between align-items-start gap-2 mb-1">

                                <strong>
                                    {{ $d->jenis ?? 'Denda' }}
                                </strong>


                                @if($d->status === 'lunas')

                                    <span class="badge bg-success">
                                        Lunas
                                    </span>

                                @elseif($d->status === 'menunggu verifikasi')

                                    <span class="badge bg-info text-dark">
                                        Verifikasi
                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark">
                                        Belum
                                    </span>

                                @endif

                            </div>


                            <div class="text-success fw-bold">
                                Rp {{ number_format($d->nominal ?? 0, 0, ',', '.') }}
                            </div>


                            {{-- Bukti --}}
                            @if($d->foto_bukti)

                                <img
                                    src="{{ asset($d->foto_bukti) }}"
                                    alt="Bukti"
                                    class="img-fluid rounded mt-1"
                                    style="max-height: 80px; cursor: zoom-in;"
                                    onclick="openBuktiModal(this)"
                                    data-src="{{ asset($d->foto_bukti) }}"
                                >

                            @endif


                            {{-- Pembayaran Denda --}}
                            @if(($d->status ?? 'belum bayar') === 'belum bayar')

                                <form
                                    method="POST"
                                    action="{{ route('customer.dendas.bayar', $d->id) }}"
                                    enctype="multipart/form-data"
                                    class="mt-2"
                                >

                                    @csrf

                                    <div class="row g-1">

                                        <div class="col-12">

                                            <input
                                                type="file"
                                                name="bukti_bayar"
                                                class="form-control form-control-sm"
                                                accept="image/*"
                                                required
                                            >

                                        </div>


                                        <div class="col-12">

                                            <input
                                                type="date"
                                                name="tanggal_bayar"
                                                class="form-control form-control-sm"
                                                required
                                            >

                                        </div>


                                        <div class="col-12">

                                            <button
                                                type="submit"
                                                class="btn btn-warning btn-sm w-100"
                                            >
                                                <i class="bi bi-cash-coin me-1"></i>
                                                Bayar
                                            </button>

                                        </div>

                                    </div>

                                </form>

                            @endif

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>
</div>


{{-- =============================================================
     CSS MODAL RATING
============================================================== --}}
<style>

.rating-modal-custom {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 99999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.rating-modal-custom.show {
    display: flex;
}

.rating-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, .55);
    backdrop-filter: blur(3px);
}

.rating-modal-box {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, .28);
    animation: ratingModalIn .22s ease-out;
}

.rating-modal-box .modal-header {
    padding: 20px 22px 12px;
    border-bottom: 1px solid #eee;
}

.rating-modal-box .modal-body {
    padding: 22px;
}

.rating-modal-box .modal-footer {
    padding: 12px 22px 20px;
    border-top: 1px solid #eee;
}

.rating-modal-box .form-select,
.rating-modal-box .form-control {
    border-radius: 10px;
}

.rating-modal-box .form-select:focus,
.rating-modal-box .form-control:focus {
    border-color: #2C666E;
    box-shadow: 0 0 0 .2rem rgba(44, 102, 110, .12);
}

@keyframes ratingModalIn {

    from {
        opacity: 0;
        transform: translateY(-20px) scale(.97);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

}


/* Rating yang sudah diberikan */

.rating-result {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 14px;
    border-radius: 10px;
    background: #f8f9fa;
    border: 1px solid #e5e7eb;
}

.rating-result-stars {
    color: #f59e0b;
    display: flex;
    gap: 2px;
}

.rating-result-value {
    font-size: 13px;
    font-weight: 700;
    color: #374151;
}


/* Tombol rating */

.btn-rating {
    cursor: pointer;
    border: none;
}

body.rating-modal-open {
    overflow: hidden;
}

</style>


{{-- =============================================================
     JAVASCRIPT MODAL RATING
============================================================== --}}
<script>

function openRatingModal(id) {

    const modal = document.getElementById('ratingModal' + id);

    if (!modal) {
        return;
    }

    modal.classList.add('show');

    modal.setAttribute('aria-hidden', 'false');

    document.body.classList.add('rating-modal-open');
}


function closeRatingModal(id) {

    const modal = document.getElementById('ratingModal' + id);

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    modal.setAttribute('aria-hidden', 'true');

    document.body.classList.remove('rating-modal-open');
}


/* Tutup menggunakan tombol ESC */

document.addEventListener('keydown', function(event) {

    if (event.key !== 'Escape') {
        return;
    }

    document
        .querySelectorAll('.rating-modal-custom.show')
        .forEach(function(modal) {

            modal.classList.remove('show');

            modal.setAttribute('aria-hidden', 'true');

        });

    document.body.classList.remove('rating-modal-open');

});

</script>
