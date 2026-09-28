<div class="rental-card">
    <div class="stat-card d-flex flex-column h-100">

        <!-- Header: Image + Title + Status -->
        <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
            <!-- Car Image -->
            <div class="rental-image-thumb">
                @if($rental->mobil->image)
                    <img src="{{ asset($rental->mobil->image) }}" alt="{{ $rental->mobil->name }}" class="img-fluid rounded">
                @else
                    <div class="placeholder-image rounded d-flex align-items-center justify-content-center">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                @endif
            </div>

            <!-- Title + ID + Status -->
            <div class="flex-grow-1">
                <h6 class="fw-bold mb-1">{{ $rental->mobil->name }}</h6>
                <small class="text-muted d-block">Rental #{{ $rental->id }}</small>
                <div class="mt-2">
                    <span class="badge {{ $rental->status === 'Selesai' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $rental->status }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Data Section: Flat List -->
        <div class="rental-data mb-3">
            <div class="rental-data-item">
                <i class="bi bi-calendar-event"></i>
                <span>{{ $rental->tanggal_mulai->format('d/m/Y') }} - {{ $rental->tanggal_selesai->format('d/m/Y') }}</span>
            </div>
            <div class="rental-data-item">
                <i class="bi bi-clock"></i>
                <span>{{ $rental->jumlah_hari }} Hari</span>
            </div>
            <div class="rental-data-item">
                <i class="bi bi-wallet2"></i>
                <span class="text-success fw-bold">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Action Section -->
        <div class="mt-auto">

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
            <small>Bukti pembayaran sedang diverifikasi</small>
        </div>
    @elseif($rental->pembayaran->status === 'Disetujui')
        <div class="alert alert-success mb-0 py-2 px-3">
            <i class="bi bi-check-circle-fill me-1"></i>
            <small>Pembayaran terverifikasi</small>
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

@elseif($rental->status === 'Menunggu')
    <div class="alert alert-warning mb-0 py-2 px-3">
        <i class="bi bi-hourglass-split me-1"></i>
        <small>Menunggu persetujuan</small>
    </div>

@elseif($rental->status === 'Ditolak')
    <div class="alert alert-danger mb-0 py-2 px-3">
        <i class="bi bi-x-circle me-1"></i>
        <small>Pengajuan ditolak</small>
    </div>

@elseif($rental->status === 'Selesai')
    <div class="d-flex gap-2 flex-wrap">
        @if(!$rental->rating)
        <button type="button" class="rental-action-btn btn-rating" data-bs-toggle="modal" data-bs-target="#ratingModal{{ $rental->id }}">
            <i class="bi bi-star-fill me-1"></i>
            Rating
        </button>

        <!-- Modal Rating -->
        <div class="modal fade text-dark" id="ratingModal{{ $rental->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('customer.ratings.store', $rental->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">
                                <i class="bi bi-star-fill text-warning me-1"></i>
                                Beri Rating
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rating</label>
                                <select name="rating" class="form-select" required>
                                    <option value="">Pilih Rating</option>
                                    <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                    <option value="4">⭐⭐⭐⭐ Baik</option>
                                    <option value="3">⭐⭐⭐ Cukup</option>
                                    <option value="2">⭐⭐ Kurang</option>
                                    <option value="1">⭐ Sangat Kurang</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Komentar</label>
                                <textarea name="komentar" class="form-control" rows="4" placeholder="Tulis pengalaman kamu..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="bi bi-send me-1"></i> Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else
        <span class="badge bg-success flex-grow-1 d-flex align-items-center justify-content-center">
            <i class="bi bi-star-fill me-1"></i>
            {{ $rental->rating->rating }}/5
        </span>
        @endif
        <a href="{{ route('customer.kompensasi.index', ['baru' => 1, 'rental' => $rental->id]) }}" class="rental-action-btn btn-kompensasi">
            <i class="bi bi-megaphone me-1"></i>
            Kompensasi
        </a>
    </div>
@endif

            <!-- Denda Section -->
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
                            <div class="text-success fw-bold">Rp {{ number_format($d->nominal ?? 0, 0, ',', '.') }}</div>
                            @if($d->foto_bukti)
                                <img src="{{ asset($d->foto_bukti) }}" alt="Bukti" class="img-fluid rounded mt-1" style="max-height: 80px; cursor: zoom-in;" onclick="openBuktiModal(this)" data-src="{{ asset($d->foto_bukti) }}">
                            @endif
                            @if(($d->status ?? 'belum bayar') === 'belum bayar')
                                <form method="POST" action="{{ route('customer.dendas.bayar', $d->id) }}" enctype="multipart/form-data" class="mt-2">
                                    @csrf
                                    <div class="row g-1">
                                        <div class="col-12">
                                            <input type="file" name="bukti_bayar" class="form-control form-control-sm" accept="image/*" required>
                                        </div>
                                        <div class="col-12">
                                            <input type="date" name="tanggal_bayar" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-warning btn-sm w-100">
                                                <i class="bi bi-cash-coin me-1"></i> Bayar
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
