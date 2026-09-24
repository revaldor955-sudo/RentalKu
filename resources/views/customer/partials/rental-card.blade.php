<div class="rental-masonry-item">

    <div class="stat-card d-flex flex-column h-100">

        <div class="d-flex justify-content-between align-items-start mb-3">

            <div>

                <h5 class="fw-bold mb-1">
                    {{ $rental->mobil->name ?? 'Mobil' }}
                </h5>

                <small class="text-muted">
                    Rental #{{ $rental->id }}
                </small>

            </div>
@if($rental->status === 'Menunggu')

                <span class="badge bg-warning text-dark">
                    Menunggu

                </span>

            @elseif($rental->status === 'Disetujui')

                <span class="badge bg-success">
                    Disetujui

                </span>

            @elseif($rental->status === 'Selesai')

                <span class="badge bg-secondary">
                    Selesai

                </span>

            @elseif($rental->status === 'Ditolak')

                <span class="badge bg-danger">
                    Ditolak

                </span>

            @else

                <span class="badge bg-dark">
                    {{ $rental->status }}
                </span>

            @endif

        </div>


        <div class="row g-3 mb-3">

            <div class="col-6">

                <small class="text-muted d-block">
                    Tanggal Mulai
                </small>

                <strong>
                    {{ $rental->tanggal_mulai->format('d/m/Y') }}
                </strong>

            </div>

            <div class="col-6">

                <small class="text-muted d-block">
                    Tanggal Selesai
                </small>

                <strong>
                    {{ $rental->tanggal_selesai->format('d/m/Y') }}
                </strong>

            </div>

            <div class="col-6">

                <small class="text-muted d-block">
                    Jumlah Hari
                </small>

                <strong>
                    {{ $rental->jumlah_hari }} Hari
                </strong>

            </div>

            <div class="col-6">

                <small class="text-muted d-block">
                    Total Harga
                </small>

                <strong class="text-success">
                    Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                </strong>

            </div>

        </div>


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

        <div class="alert alert-info mb-0">
            <i class="bi bi-clock-history me-1"></i>
            Bukti pembayaran sudah dikirim dan sedang
            menunggu verifikasi tim kami.
        </div>

   @elseif($rental->pembayaran->status === 'Disetujui')

    <div class="alert alert-success mb-0">
        <i class="bi bi-check-circle-fill me-1"></i>
        Pembayaran sudah diverifikasi tim kami.
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
            Upload Ulang Pembayaran
        </button>

    @endif

@elseif($rental->status === 'Menunggu')

    <div class="alert alert-warning mb-0">
        <i class="bi bi-hourglass-split me-1"></i>
        Menunggu persetujuan tim kami sebelum melakukan pembayaran.
    </div>

@elseif($rental->status === 'Ditolak')

    <div class="alert alert-danger mb-0">
        <i class="bi bi-x-circle me-1"></i>
        Pengajuan rental ditolak.
    </div>

@elseif($rental->status === 'Selesai')

    <div class="alert alert-secondary mb-0">
        <i class="bi bi-check2-circle me-1"></i>
        Rental telah selesai.
        <div class="d-flex gap-2 mt-2 flex-wrap">
            @if(!$rental->rating)
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ratingModal{{ $rental->id }}">
                <i class="bi bi-star-fill me-1"></i>
                Beri Rating
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
                                    Beri Rating Rental #{{ $rental->id }}
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
                                    <i class="bi bi-send me-1"></i> Kirim Rating
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <span class="badge bg-warning text-dark">
                <i class="bi bi-star-fill me-1"></i>
                Sudah Rating: {{ $rental->rating->rating }}/5
            </span>
            @endif
            <a href="{{ route('customer.kompensasi.index', ['baru' => 1, 'rental' => $rental->id]) }}" class="btn btn-outline-success btn-sm">
                <i class="bi bi-megaphone me-1"></i>
                Ajukan Kompensasi
            </a>
        </div>
    </div>

@endif

            @if($rental->dendas && $rental->dendas->count())
                    <div class="mt-3">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Denda Rental Ini
                        </h6>
                        @foreach($rental->dendas as $d)
                            <div class="border rounded p-3 mb-2">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                    <strong>{{ $d->jenis ?? 'Denda' }}</strong>
                                    @if($d->status === 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif($d->status === 'menunggu verifikasi')
                                        <span class="badge bg-info text-dark">Menunggu Verifikasi</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Bayar</span>
                                    @endif
                                </div>
                                <div class="text-success fw-bold mb-1">
                                    Rp {{ number_format($d->nominal ?? 0, 0, ',', '.') }}
                                </div>
                                @isset($d->syarat_dan_ketentuan)
                                    @if($d->syarat_dan_ketentuan)
                                        <small class="text-muted d-block mb-1">{{ $d->syarat_dan_ketentuan }}</small>
                                    @endif
                                @endisset
                                @isset($d->foto_bukti)
                                    @if($d->foto_bukti)
                                        <small class="text-muted d-block">Bukti staff:</small>
                                        <img src="{{ asset($d->foto_bukti) }}" alt="Bukti denda (klik untuk memperbesar)" title="Klik untuk memperbesar" data-src="{{ asset($d->foto_bukti) }}" onclick="openBuktiModal(this)" class="img-fluid rounded mb-1" style="max-height: 120px; cursor: zoom-in;">
                                    @endif
                                @endisset
                                @isset($d->bukti_bayar)
                                    @if($d->bukti_bayar)
                                        <small class="text-muted d-block">Bukti bayar kamu:</small>
                                        <img src="{{ asset($d->bukti_bayar) }}" alt="Bukti bayar denda (klik untuk memperbesar)" title="Klik untuk memperbesar" data-src="{{ asset($d->bukti_bayar) }}" onclick="openBuktiModal(this)" class="img-fluid rounded mb-1" style="max-height: 120px; cursor: zoom-in;">
                                    @endif
                                @endisset
                                @isset($d->tanggal_bayar)
                                    @if($d->tanggal_bayar)
                                        <small class="text-muted d-block mb-1">Tanggal bayar: {{ \Carbon\Carbon::parse($d->tanggal_bayar)->format('d/m/Y') }}</small>
                                    @endif
                                @endisset
                                @if(($d->status ?? 'belum bayar') === 'belum bayar')
                                    <form method="POST" action="{{ route('customer.dendas.bayar', $d->id) }}" enctype="multipart/form-data" class="mt-2">
                                        @csrf
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label small mb-1">Bukti Bayar</label>
                                                <input type="file" name="bukti_bayar" class="form-control form-control-sm" accept="image/*" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small mb-1">Tanggal Bayar</label>
                                                <input type="date" name="tanggal_bayar" class="form-control form-control-sm" required>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                                    <i class="bi bi-cash-coin me-1"></i>
                                                    Bayar Denda
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
