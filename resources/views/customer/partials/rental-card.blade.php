{{-- =========================================================
     KARTU RENTAL RENTALKU
========================================================= --}}

<div class="rental-card">
    <div class="stat-card d-flex flex-column h-100">

        {{-- HEADER --}}
        <div class="d-flex gap-3 mb-3 pb-3 border-bottom">

            <div class="rental-image-thumb">
                @if($rental->mobil && $rental->mobil->image)
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

            <div class="flex-grow-1">
                <h6 class="fw-bold mb-1">
                    {{ $rental->mobil->name ?? 'Mobil' }}
                </h6>

                <small class="text-muted d-block">
                    Rental #{{ $rental->id }}
                </small>

                <div class="mt-2">
                    <span class="badge
                        {{ $rental->status === 'Selesai' ? 'bg-success' :
                           ($rental->status === 'Disetujui' ? 'bg-primary' :
                           ($rental->status === 'Menunggu' ? 'bg-warning text-dark' :
                           ($rental->status === 'Ditolak' ? 'bg-danger' : 'bg-secondary'))) }}">
                        {{ $rental->status }}
                    </span>
                </div>
            </div>

        </div>

        {{-- DATA RENTAL --}}
        <div class="rental-data mb-3">

            <div class="rental-data-item">
                <i class="bi bi-calendar-event"></i>
                <span>
                    {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y') }}
                    -
                    {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y') }}
                </span>
            </div>

            <div class="rental-data-item">
                <i class="bi bi-clock"></i>
                <span>{{ $rental->jumlah_hari }} Hari</span>
            </div>

            <div class="rental-data-item">
                <i class="bi bi-wallet2"></i>
                <span class="text-success fw-bold">
                    Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                </span>
            </div>

        </div>

        {{-- ACTION --}}
        <div class="mt-auto">

            {{-- STATUS DISETUJUI --}}
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
                        <small>Bukti pembayaran sedang diverifikasi.</small>
                    </div>

                @elseif($rental->pembayaran->status === 'Disetujui')

                    <div class="alert alert-success mb-0 py-2 px-3">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        <small>Pembayaran terverifikasi.</small>
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

            {{-- STATUS MENUNGGU --}}
            @elseif($rental->status === 'Menunggu')

                <div class="alert alert-warning mb-0 py-2 px-3">
                    <i class="bi bi-hourglass-split me-1"></i>
                    <small>Menunggu persetujuan.</small>
                </div>

            {{-- STATUS DITOLAK --}}
            @elseif($rental->status === 'Ditolak')

                <div class="alert alert-danger mb-0 py-2 px-3">
                    <i class="bi bi-x-circle me-1"></i>
                    <small>Pengajuan ditolak.</small>
                </div>

            {{-- STATUS SELESAI --}}
            @elseif($rental->status === 'Selesai')

                <div class="d-flex gap-2 flex-wrap align-items-center">

                    {{-- RATING --}}
                    @if(!$rental->rating)

                        <button
                            type="button"
                            class="rental-action-btn btn-rating"
                            data-rating-modal="ratingModal{{ $rental->id }}"
                        >
                            <i class="bi bi-star-fill me-1"></i>
                            Rating
                        </button>

                        {{-- MODAL RATING
                             Disimpan dalam container terlebih dahulu.
                             JavaScript akan memindahkannya ke BODY. --}}
                        <div
                            class="rating-modal-custom"
                            id="ratingModal{{ $rental->id }}"
                            aria-hidden="true"
                        >

                            <div
                                class="rating-modal-backdrop"
                                data-rating-close="ratingModal{{ $rental->id }}"
                            ></div>

                            <div
                                class="rating-modal-box"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="ratingTitle{{ $rental->id }}"
                                tabindex="-1"
                            >

                                <form
                                    action="{{ route('customer.ratings.store', $rental->id) }}"
                                    method="POST"
                                    class="rating-form"
                                >
                                    @csrf

                                    {{-- HEADER MODAL --}}
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
                                            data-rating-close="ratingModal{{ $rental->id }}"
                                            aria-label="Tutup"
                                        ></button>

                                    </div>

                                    {{-- BODY MODAL --}}
                                    <div class="modal-body text-start">

                                        <div class="mb-4">
                                            <label
                                                for="ratingSelect{{ $rental->id }}"
                                                class="form-label fw-semibold"
                                            >
                                                Rating
                                            </label>

                                            <select
                                                id="ratingSelect{{ $rental->id }}"
                                                name="rating"
                                                class="form-select"
                                                required
                                            >
                                                <option value="">Pilih Rating</option>
                                                <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                                <option value="4">⭐⭐⭐⭐ Baik</option>
                                                <option value="3">⭐⭐⭐ Cukup</option>
                                                <option value="2">⭐⭐ Kurang</option>
                                                <option value="1">⭐ Sangat Kurang</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label
                                                for="komentarRating{{ $rental->id }}"
                                                class="form-label fw-semibold"
                                            >
                                                Komentar
                                            </label>

                                            <textarea
                                                id="komentarRating{{ $rental->id }}"
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

                                    {{-- FOOTER MODAL --}}
                                    <div class="modal-footer">

                                        <button
                                            type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-rating-close="ratingModal{{ $rental->id }}"
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

                        {{-- RATING SUDAH DIBERIKAN --}}
                        <div class="rating-result">

                            <div
                                class="rating-result-stars"
                                aria-label="Rating {{ $rental->rating->rating }} dari 5"
                            >
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

                    {{-- KOMPENSASI --}}
                    <a
                        href="{{ route('customer.kompensasi.index', [
                            'baru' => 1,
                            'rental' => $rental->id
                        ]) }}"
                        class="rental-action-btn btn-kompensasi"
                    >
                        <i class="bi bi-megaphone me-1"></i>
                        Kompensasi
                    </a>

                </div>

            @endif

            {{-- DENDA --}}
            @if($rental->dendas && $rental->dendas->count())

                <div class="mt-3 pt-3 border-top">

                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Denda ({{ $rental->dendas->count() }})
                    </h6>

                    @foreach($rental->dendas as $d)

                        <div class="border rounded p-2 mb-2 small">

                            <div class="d-flex justify-content-between align-items-start gap-2 mb-1">

                                <strong>{{ $d->jenis ?? 'Denda' }}</strong>

                                @if($d->status === 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($d->status === 'menunggu verifikasi')
                                    <span class="badge bg-info text-dark">Verifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum</span>
                                @endif

                            </div>

                            <div class="text-success fw-bold">
                                Rp {{ number_format($d->nominal ?? 0, 0, ',', '.') }}
                            </div>

                            {{-- FOTO BUKTI --}}
                            @if($d->foto_bukti)

                                <img
                                    src="{{ asset($d->foto_bukti) }}"
                                    alt="Bukti pembayaran denda"
                                    class="img-fluid rounded mt-1"
                                    style="max-height: 80px; cursor: zoom-in;"
                                    onclick="openBuktiModal(this)"
                                    data-src="{{ asset($d->foto_bukti) }}"
                                >

                            @endif

                            {{-- FORM PEMBAYARAN DENDA --}}
                            @if(($d->status ?? 'belum bayar') === 'belum bayar')

                                <form
                                    method="POST"
                                    action="{{ route('customer.dendas.bayar', $d->id) }}"
                                    enctype="multipart/form-data"
                                    class="mt-2 denda-bayar-form"
                                >
                                    @csrf

                                    <div class="row g-1">

                                        <div class="col-12">

                                            <input
                                                type="file"
                                                name="bukti_bayar"
                                                class="form-control form-control-sm @error('bukti_bayar') is-invalid @enderror"
                                                accept=".jpg,.jpeg,.png"
                                                required
                                            >

                                            <div class="form-text small">
                                                Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                                            </div>

                                            @error('bukti_bayar')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                        <div class="col-12">

                                            <input
                                                type="date"
                                                name="tanggal_bayar"
                                                class="form-control form-control-sm @error('tanggal_bayar') is-invalid @enderror"
                                                value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                                                max="{{ date('Y-m-d') }}"
                                                required
                                            >

                                            @error('tanggal_bayar')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror

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


{{-- =========================================================
     CSS MODAL RATING
========================================================= --}}

<style>
.rating-modal-custom {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 20000;
    align-items: center;
    justify-content: center;
    padding: 20px;
    isolation: isolate;
}

.rating-modal-custom.show {
    display: flex;
}

.rating-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.60);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
}

.rating-modal-box {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 500px;
    max-height: calc(100vh - 40px);
    max-height: calc(100dvh - 40px);
    overflow-y: auto;
    overscroll-behavior: contain;
    background: #fff;
    border: none;
    border-radius: 18px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);

    /* Tidak menggunakan transform */
    animation: ratingModalFadeIn 0.18s ease-out both;
}

@keyframes ratingModalFadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

.rating-modal-custom .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 20px 22px 12px;
    border-bottom: 1px solid #eee;
}

.rating-modal-custom .modal-body {
    padding: 22px;
}

.rating-modal-custom .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    padding: 12px 22px 20px;
    border-top: 1px solid #eee;
}

.rating-modal-custom .form-select,
.rating-modal-custom .form-control {
    border-radius: 10px;
}

.rating-modal-custom .form-select:focus,
.rating-modal-custom .form-control:focus {
    border-color: #2C666E;
    box-shadow: 0 0 0 0.2rem rgba(44, 102, 110, 0.12);
}

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
    display: flex;
    gap: 2px;
    color: #f59e0b;
}

.rating-result-value {
    font-size: 13px;
    font-weight: 700;
    color: #374151;
}

.btn-rating {
    cursor: pointer;
    border: none;
}

body.rating-modal-open {
    overflow: hidden;
}

@media (max-width: 576px) {
    .rating-modal-custom {
        padding: 12px;
    }

    .rating-modal-box {
        max-height: calc(100vh - 24px);
        max-height: calc(100dvh - 24px);
        border-radius: 14px;
    }

    .rating-modal-custom .modal-header {
        padding: 16px 18px 12px;
    }

    .rating-modal-custom .modal-body {
        padding: 18px;
    }

    .rating-modal-custom .modal-footer {
        padding: 12px 18px 16px;
    }
}
</style>


{{-- =========================================================
     JAVASCRIPT MODAL RATING DAN VALIDASI DENDA
========================================================= --}}

<script>
(function () {
    /*
     * Mencegah event handler terpasang berkali-kali
     * apabila file Blade ini dimuat ulang secara dinamis.
     */
    if (window.rentalRatingHandlersInitialized) {
        return;
    }

    window.rentalRatingHandlersInitialized = true;

    const modalOriginalParents = new Map();
    let activeRatingModal = null;
    let previousBodyOverflow = '';

    function openRatingModal(id) {
        const modal = document.getElementById(id);

        if (!modal || modal.classList.contains('show')) {
            return;
        }

        /*
         * Simpan posisi asli modal agar bisa dikembalikan
         * setelah ditutup.
         */
        if (!modalOriginalParents.has(modal)) {
            modalOriginalParents.set(modal, {
                parent: modal.parentNode,
                nextSibling: modal.nextSibling
            });
        }

        /*
         * Pindahkan modal ke BODY untuk menghindari
         * pengaruh transform/filter pada kartu rental.
         */
        if (modal.parentNode !== document.body) {
            document.body.appendChild(modal);
        }

        previousBodyOverflow = document.body.style.overflow;

        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');

        document.body.classList.add('rating-modal-open');
        document.body.style.overflow = 'hidden';

        activeRatingModal = modal;

        const dialog = modal.querySelector('.rating-modal-box');

        if (dialog) {
            requestAnimationFrame(function () {
                if (modal.classList.contains('show')) {
                    dialog.focus({ preventScroll: true });
                }
            });
        }
    }

    function closeRatingModal(id) {
        const modal = document.getElementById(id);

        if (!modal || !modal.classList.contains('show')) {
            return;
        }

        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');

        if (activeRatingModal === modal) {
            activeRatingModal = null;
        }

        /*
         * Pulihkan posisi modal di dalam kartu rental.
         */
        const original = modalOriginalParents.get(modal);

        if (original && original.parent) {
            if (
                original.nextSibling &&
                original.nextSibling.parentNode === original.parent
            ) {
                original.parent.insertBefore(modal, original.nextSibling);
            } else {
                original.parent.appendChild(modal);
            }
        }

        if (!document.querySelector('.rating-modal-custom.show')) {
            document.body.classList.remove('rating-modal-open');
            document.body.style.overflow = previousBodyOverflow;
        }
    }

    /*
     * Tombol buka modal.
     */
    document.addEventListener('click', function (event) {
        const openButton = event.target.closest('[data-rating-modal]');

        if (openButton) {
            event.preventDefault();

            openRatingModal(
                openButton.getAttribute('data-rating-modal')
            );

            return;
        }

        /*
         * Tombol tutup dan backdrop.
         */
        const closeButton = event.target.closest('[data-rating-close]');

        if (closeButton) {
            event.preventDefault();

            closeRatingModal(
                closeButton.getAttribute('data-rating-close')
            );
        }
    });

    /*
     * Tutup modal menggunakan Escape.
     */
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && activeRatingModal) {
            closeRatingModal(activeRatingModal.id);
        }
    });

    /*
     * Validasi ukuran file bukti denda: maksimal 2 MB.
     */
    document.addEventListener('change', function (event) {
        const input = event.target;

        if (!input || input.name !== 'bukti_bayar') {
            return;
        }

        const file = input.files && input.files[0];

        if (file && file.size > 2 * 1024 * 1024) {
            input.value = '';

            if (window.Swal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Ukuran bukti maksimal 2 MB.'
                });
            } else {
                alert('Ukuran bukti maksimal 2 MB.');
            }
        }
    });

    /*
     * Cegah submit denda jika file melebihi 2 MB.
     * Server tetap wajib melakukan validasi.
     */
    document.addEventListener('submit', function (event) {
        const form = event.target;

        if (
            !form ||
            !form.classList ||
            !form.classList.contains('denda-bayar-form')
        ) {
            return;
        }

        const input = form.querySelector('input[name="bukti_bayar"]');
        const file = input && input.files && input.files[0];

        if (file && file.size > 2 * 1024 * 1024) {
            event.preventDefault();

            const button = form.querySelector('button[type="submit"]');

            if (button) {
                button.disabled = false;
                button.innerHTML =
                    '<i class="bi bi-cash-coin me-1"></i> Bayar';
            }

            if (window.Swal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Ukuran bukti maksimal 2 MB.'
                });
            } else {
                alert('Ukuran bukti maksimal 2 MB.');
            }
        }
    });

    /*
     * Cegah tombol rating diklik berulang saat form dikirim.
     */
    document.addEventListener('submit', function (event) {
        const form = event.target;

        if (!form || !form.classList.contains('rating-form')) {
            return;
        }

        if (form.dataset.submitting === 'true') {
            event.preventDefault();
            return;
        }

        form.dataset.submitting = 'true';

        const button = form.querySelector('button[type="submit"]');

        if (button) {
            button.disabled = true;
            button.innerHTML =
                '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengirim...';
        }
    });

    /*
     * Pertahankan nama fungsi global jika dibutuhkan
     * oleh kode lain pada halaman.
     */
    window.openRatingModal = openRatingModal;
    window.closeRatingModal = closeRatingModal;
})();
</script>
