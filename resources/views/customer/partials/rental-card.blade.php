<div class="rental-card" id="rental-{{ $rental->id }}" tabindex="-1">
    <div class="stat-card d-flex flex-column">

        <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
            <div class="rental-image-thumb">
                @if($rental->mobil && $rental->mobil->image)
                    <img src="{{ asset($rental->mobil->image) }}" alt="{{ $rental->mobil->name }}" class="img-fluid rounded">
                @else
                    <div class="placeholder-image rounded d-flex align-items-center justify-content-center">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                @endif
            </div>

            <div class="flex-grow-1">
                <h6 class="fw-bold mb-1">{{ $rental->mobil->name ?? 'Mobil' }}</h6>
                <small class="text-muted d-block">Rental #{{ $rental->id }}</small>

                <div class="mt-2">
                    <span class="badge {{ $rental->status === 'Selesai' ? 'bg-success' : ($rental->status === 'Disetujui' ? 'bg-primary' : ($rental->status === 'Menunggu' ? 'bg-warning text-dark' : ($rental->status === 'Ditolak' ? 'bg-danger' : 'bg-secondary'))) }}">
                        {{ $rental->status }}
                    </span>
                </div>
            </div>
        </div>

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

            <div class="rental-data-item align-items-start">
                <i class="bi bi-wallet2 mt-1"></i>

                <div class="w-100">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Subtotal Rental</span>
                        <span>Rp {{ number_format($rental->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if(($rental->diskon ?? 0) > 0)
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-success">Diskon ({{ $rental->kode_promo }})</span>
                            <span class="text-success fw-bold">− Rp {{ number_format($rental->diskon, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Deposit</span>
                        <span>Rp {{ number_format($rental->deposit, 0, ',', '.') }}</span>
                    </div>

                    <hr class="my-2">

                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Pembayaran</span>
                        <span class="text-success fw-bold">Rp {{ number_format($rental->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @php
            $pembayaranSewa = $rental->pembayaran;
            $statusSewa = $pembayaranSewa ? $pembayaranSewa->status : 'Belum Bayar';
            $sewaLunas = $statusSewa === 'Disetujui';
            $sewaDibayar = in_array($statusSewa, ['Menunggu', 'Disetujui'], true);
            $labelSewa = match ($statusSewa) {
                'Disetujui' => 'Lunas',
                'Menunggu' => 'Menunggu Verifikasi',
                'Ditolak' => 'Ditolak',
                default => 'Belum Bayar',
            };
            $classSewa = match ($statusSewa) {
                'Disetujui' => 'bg-success',
                'Menunggu' => 'bg-info text-dark',
                'Ditolak' => 'bg-danger',
                default => 'bg-warning text-dark',
            };

            $dendaBelumBayar = $rental->dendas->filter(function ($d) {
                return strtolower(trim($d->status ?? 'belum bayar')) === 'belum bayar';
            });
            $dendaMenunggu = $rental->dendas->contains(function ($d) {
                return strtolower(trim($d->status ?? '')) === 'menunggu verifikasi';
            });
            $semuaDendaLunas = $rental->dendas->count() > 0
                && $dendaBelumBayar->isEmpty()
                && !$dendaMenunggu;
            $labelDenda = $rental->dendas->count() === 0
                ? 'Tidak Ada'
                : ($semuaDendaLunas ? 'Lunas' : ($dendaBelumBayar->isNotEmpty() ? 'Belum Bayar' : 'Menunggu Verifikasi'));
            $classDenda = $semuaDendaLunas ? 'bg-success' : ($dendaBelumBayar->isNotEmpty() ? 'bg-warning text-dark' : 'bg-info text-dark');
            $totalBelumDibayar = ($sewaDibayar ? 0 : (float) $rental->total_harga) + (float) $dendaBelumBayar->sum('nominal');
        @endphp

        <div class="tagihan-ringkasan mb-3">
            <div class="tagihan-ringkasan-title">
                <i class="bi bi-receipt me-1"></i>
                Ringkasan Tagihan
            </div>

            <div class="d-flex justify-content-between align-items-center gap-2">
                <span class="small text-muted">Biaya rental</span>
                <span class="badge {{ $classSewa }}">{{ $labelSewa }}</span>
            </div>

            <div class="d-flex justify-content-between align-items-center gap-2">
                <span class="small text-muted">Denda ({{ $rental->dendas->count() }})</span>
                <span class="badge {{ $classDenda }}">{{ $labelDenda }}</span>
            </div>

            <div class="tagihan-ringkasan-total d-flex justify-content-between align-items-center">
                <span class="small fw-semibold">Total belum dibayar</span>
                <span class="fw-bold">Rp {{ number_format($totalBelumDibayar, 0, ',', '.') }}</span>
            </div>

            @if (!$sewaDibayar && $dendaBelumBayar->isNotEmpty())
                <button type="button" class="btn btn-success w-100 mt-2 btn-bayar"
                    data-action="{{ route('payment.all', $rental->id) }}"
                    data-title="Bayar Semua"
                    data-mode="all"
                    data-mobil="{{ $rental->mobil->name ?? 'Mobil' }}"
                    data-rental="{{ $rental->id }}"
                    data-cabang="{{ $rental->mobil->cabang_id }}"
                    data-total="{{ (float) $rental->total_harga + (float) $dendaBelumBayar->sum('nominal') }}"
                    data-denda="{{ (float) $dendaBelumBayar->sum('nominal') }}">
                    <i class="bi bi-cash-stack me-1"></i>
                    Bayar Semua
                </button>
            @endif
        </div>

        <div class="rental-actions">

            @if($rental->status === 'Disetujui')

                @if(!$rental->pembayaran)
                    <button type="button" class="btn btn-success w-100 btn-bayar"
                        data-action="{{ route('payment.rental', $rental->id) }}"
                        data-title="Bayar Sewa"
                        data-mobil="{{ $rental->mobil->name ?? 'Mobil' }}"
                        data-rental="{{ $rental->id }}"
                        data-cabang="{{ $rental->mobil->cabang_id }}"
                        data-total="{{ $rental->total_harga }}">
                        <i class="bi bi-credit-card me-1"></i>
                        Bayar Sewa
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
                    <button type="button" class="btn btn-danger w-100 btn-bayar"
                        data-action="{{ route('payment.rental', $rental->id) }}"
                        data-title="Upload Ulang Pembayaran"
                        data-mobil="{{ $rental->mobil->name ?? 'Mobil' }}"
                        data-rental="{{ $rental->id }}"
                        data-cabang="{{ $rental->mobil->cabang_id }}"
                        data-total="{{ $rental->total_harga }}">
                        <i class="bi bi-arrow-repeat me-1"></i>
                        Upload Ulang
                    </button>
                @endif

            @elseif($rental->status === 'Menunggu')
                <div class="alert alert-warning mb-0 py-2 px-3">
                    <i class="bi bi-hourglass-split me-1"></i>
                    <small>Menunggu persetujuan.</small>
                </div>

            @elseif($rental->status === 'Ditolak')
                <div class="alert alert-danger mb-0 py-2 px-3">
                    <i class="bi bi-x-circle me-1"></i>
                    <small>Pengajuan ditolak.</small>
                </div>

            @elseif($rental->status === 'Berjalan')

                <div class="d-flex flex-column gap-2">

                    @if(!$rental->pembayaran)
                        <button type="button" class="btn btn-success w-100 btn-bayar"
                            data-action="{{ route('payment.rental', $rental->id) }}"
                            data-title="Bayar Sewa"
                            data-mobil="{{ $rental->mobil->name ?? 'Mobil' }}"
                            data-rental="{{ $rental->id }}"
                            data-cabang="{{ $rental->mobil->cabang_id }}"
                            data-total="{{ $rental->total_harga }}">
                            <i class="bi bi-credit-card me-1"></i>
                            Bayar Sewa
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
                        <button type="button" class="btn btn-danger w-100 btn-bayar"
                            data-action="{{ route('payment.rental', $rental->id) }}"
                            data-title="Upload Ulang Pembayaran"
                            data-mobil="{{ $rental->mobil->name ?? 'Mobil' }}"
                            data-rental="{{ $rental->id }}"
                            data-cabang="{{ $rental->mobil->cabang_id }}"
                            data-total="{{ $rental->total_harga }}">
                            <i class="bi bi-arrow-repeat me-1"></i>
                            Upload Ulang
                        </button>
                    @endif

                    <a href="{{ route('customer.gps.pengirim', $rental->id) }}" class="btn btn-success w-100">
                        <i class="bi bi-geo-alt-fill me-1"></i>
                        Bagikan Lokasi GPS
                    </a>
                </div>

            @elseif($rental->status === 'Selesai')

                <div class="d-flex gap-2 flex-wrap align-items-center">

                    @if(!$rental->rating)

                        <button type="button" class="rental-action-btn btn-rating"
                            data-rating-modal="ratingModal{{ $rental->id }}">
                            <i class="bi bi-star-fill me-1"></i>
                            Rating
                        </button>

                        <div class="rating-modal-custom" id="ratingModal{{ $rental->id }}" aria-hidden="true">

                            <div class="rating-modal-backdrop" data-rating-close="ratingModal{{ $rental->id }}"></div>

                            <div class="rating-modal-box" role="dialog" aria-modal="true"
                                aria-labelledby="ratingTitle{{ $rental->id }}" tabindex="-1">

                                <form action="{{ route('customer.ratings.store', $rental->id) }}" method="POST" class="rating-form">
                                    @csrf

                                    <div class="modal-header">
                                        <div>
                                            <h5 class="modal-title fw-bold mb-1" id="ratingTitle{{ $rental->id }}">
                                                <i class="bi bi-star-fill text-warning me-1"></i>
                                                Beri Rating
                                            </h5>
                                            <small class="text-muted">{{ $rental->mobil->name ?? 'Mobil' }}</small>
                                        </div>

                                        <button type="button" class="btn-close"
                                            data-rating-close="ratingModal{{ $rental->id }}"
                                            aria-label="Tutup"></button>
                                    </div>

                                    <div class="modal-body text-start">
                                        <div class="mb-4">
                                            <label for="ratingSelect{{ $rental->id }}" class="form-label fw-semibold">
                                                Rating
                                            </label>

                                            <select id="ratingSelect{{ $rental->id }}" name="rating" class="form-select" required>
                                                <option value="">Pilih Rating</option>
                                                <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                                <option value="4">⭐⭐⭐⭐ Baik</option>
                                                <option value="3">⭐⭐⭐ Cukup</option>
                                                <option value="2">⭐⭐ Kurang</option>
                                                <option value="1">⭐ Sangat Kurang</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label for="komentarRating{{ $rental->id }}" class="form-label fw-semibold">
                                                Komentar
                                            </label>

                                            <textarea id="komentarRating{{ $rental->id }}" name="komentar"
                                                class="form-control" rows="4" maxlength="1000"
                                                placeholder="Tulis pengalaman kamu menggunakan layanan RentalKu..."
                                                required></textarea>

                                            <div class="form-text">Maksimal 1000 karakter.</div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-rating-close="ratingModal{{ $rental->id }}">
                                            Batal
                                        </button>

                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="bi bi-send me-1"></i>
                                            Kirim
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @else

                        <div class="rating-result">
                            <div class="rating-result-stars" aria-label="Rating {{ $rental->rating->rating }} dari 5">
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

                    <a href="{{ route('customer.kompensasi.index', ['baru' => 1, 'rental' => $rental->id]) }}"
                        class="rental-action-btn btn-kompensasi">
                        <i class="bi bi-megaphone me-1"></i>
                        Kompensasi
                    </a>
                </div>
            @endif
        </div>

        @if($rental->dendas && $rental->dendas->count())

            <div class="rental-denda-section mt-3 pt-3 border-top">

                <div class="rental-denda-heading mb-3">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-exclamation-triangle me-1 text-warning"></i>
                        Detail Denda
                    </h6>

                    <span class="badge bg-warning text-dark">
                        {{ $rental->dendas->count() }} Denda
                    </span>
                </div>

                <div class="rental-denda-list">

                    @foreach($rental->dendas as $d)

                        @php
                            $statusDenda = strtolower(trim($d->status ?? 'belum bayar'));

                            $statusLabel = match($statusDenda) {
                                'lunas' => 'Lunas',
                                'menunggu verifikasi' => 'Menunggu Verifikasi',
                                'ditolak' => 'Ditolak',
                                default => 'Belum Bayar',
                            };

                            $statusClass = match($statusDenda) {
                                'lunas' => 'bg-success',
                                'menunggu verifikasi' => 'bg-info text-dark',
                                'ditolak' => 'bg-danger',
                                default => 'bg-warning text-dark',
                            };

                            $jenisDenda = ucfirst(str_replace('_', ' ', $d->jenis ?? 'Denda'));

                            $modalFotoId = 'dendaFotoModal' . $d->id;
                            $modalBayarId = 'dendaBayarModal' . $d->id;
                        @endphp

                        <div class="denda-customer-card">

                            <div class="denda-card-header">

                                <div class="denda-card-title">
                                    <div class="denda-icon">
                                        <i class="bi bi-exclamation-circle"></i>
                                    </div>

                                    <div class="denda-title-text">
                                        <div class="fw-bold">{{ $jenisDenda }}</div>
                                        <small class="text-muted">Denda #{{ $d->id }}</small>
                                    </div>
                                </div>

                                <span class="badge {{ $statusClass }} denda-status-badge">
                                    {{ $statusLabel }}
                                </span>

                            </div>

                            <div class="denda-detail-list">

                                <div class="denda-detail-row">
                                    <span class="denda-label">Nominal Denda</span>

                                    <span class="denda-value text-success fw-bold">
                                        Rp {{ number_format($d->nominal ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="denda-detail-row">
                                    <span class="denda-label">Tanggal Denda</span>

                                    <span class="denda-value">
                                        {{ $d->created_at ? $d->created_at->format('d/m/Y H:i') : '-' }}
                                    </span>
                                </div>

                                <div class="denda-detail-row">
                                    <span class="denda-label">Nomor Rental</span>

                                    <span class="denda-value">
                                        #{{ $rental->id }}
                                    </span>
                                </div>

                                <div class="denda-detail-row">
                                    <span class="denda-label">Mobil</span>

                                    <span class="denda-value">
                                        {{ $rental->mobil->name ?? '-' }}
                                    </span>
                                </div>

                                <div class="denda-detail-row">
                                    <span class="denda-label">Tanggal Rental</span>

                                    <span class="denda-value">
                                        {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y') }}
                                    </span>
                                </div>

                            </div>

                            <div class="denda-description-section">

                                <div class="fw-semibold small mb-2">
                                    <i class="bi bi-card-text me-1"></i>
                                    Deskripsi Denda
                                </div>

                                <div class="denda-description">
                                    {{ $d->deskripsi ?: 'Tidak ada deskripsi denda.' }}
                                </div>

                            </div>

                            @if($d->foto_bukti && file_exists(public_path($d->foto_bukti)))

                                <div class="denda-action-section">

                                    <button type="button"
                                        class="btn btn-outline-success btn-sm w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#{{ $modalFotoId }}">

                                        <i class="bi bi-images me-1"></i>
                                        Lihat Foto Bukti

                                    </button>

                                </div>

                                <div class="modal fade denda-foto-modal"
                                    id="{{ $modalFotoId }}"
                                    tabindex="-1"
                                    aria-labelledby="{{ $modalFotoId }}Label"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered modal-lg">

                                        <div class="modal-content border-0 rounded-4 overflow-hidden">

                                            <div class="modal-header bg-success text-white">

                                                <div>
                                                    <h5 class="modal-title fw-bold"
                                                        id="{{ $modalFotoId }}Label">

                                                        <i class="bi bi-images me-2"></i>
                                                        Foto Bukti Denda

                                                    </h5>

                                                    <small>
                                                        {{ $jenisDenda }} - Rental #{{ $rental->id }}
                                                    </small>
                                                </div>

                                                <button type="button"
                                                    class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Tutup">
                                                </button>

                                            </div>

                                            <div class="modal-body p-3">

                                                <div class="denda-foto-container">

                                                    <img src="{{ asset($d->foto_bukti) }}"
                                                        alt="Foto bukti {{ $jenisDenda }}"
                                                        class="denda-foto-preview">

                                                </div>

                                                <div class="text-center text-muted small mt-3">
                                                    Foto bukti denda Rental #{{ $rental->id }}
                                                </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                    Tutup
                                                </button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @else

                                <div class="denda-action-section">

                                    <div class="alert alert-light border py-2 mb-0 small">
                                        <i class="bi bi-image me-1 text-muted"></i>
                                        Foto bukti denda belum tersedia.
                                    </div>

                                </div>

                            @endif

                            @if($statusDenda === 'belum bayar')

                                <div class="denda-action-section">

                                    <button type="button"
                                        class="btn btn-warning w-100"
                                        {{ $sewaLunas ? '' : 'disabled' }}
                                        data-bs-toggle="modal"
                                        data-bs-target="#{{ $modalBayarId }}">

                                        <i class="bi bi-credit-card me-1"></i>
                                        Pembayaran Denda

                                    </button>

                                    @if (!$sewaLunas)
                                        <div class="small text-muted mt-1">
                                            Lunasi biaya rental terlebih dahulu
                                        </div>
                                    @endif

                                </div>

                                <div class="modal fade"
                                    id="{{ $modalBayarId }}"
                                    tabindex="-1"
                                    aria-labelledby="{{ $modalBayarId }}Label"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content border-0 shadow">

                                            @include('layouts.partials.modal-head', [
                                                'title' => 'Pembayaran Denda',
                                                'icon' => 'bi-wallet2',
                                                'titleId' => $modalBayarId.'Label',
                                                'subtitle' => 'Unggah bukti pembayaran denda.',
                                            ])

                                            <form method="POST"
                                                action="{{ route('payment.denda', $d->id) }}"
                                                enctype="multipart/form-data"
                                                class="denda-bayar-form">

                                                @csrf

                                                <div class="modal-body">

                                                    <div class="alert alert-warning">

                                                        <div class="small text-muted">
                                                            Jenis Denda
                                                        </div>

                                                        <div class="fw-bold mb-2">
                                                            {{ $jenisDenda }}
                                                        </div>

                                                        <div class="small text-muted">
                                                            Nominal Denda
                                                        </div>

                                                        <h4 class="fw-bold mb-0">
                                                            Rp {{ number_format($d->nominal ?? 0, 0, ',', '.') }}
                                                        </h4>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label class="form-label fw-semibold">
                                                            Bukti Pembayaran
                                                        </label>

                                                        <input type="file"
                                                            name="bukti_bayar"
                                                            class="form-control"
                                                            accept=".jpg,.jpeg,.png"
                                                            required>

                                                        <small class="text-muted">
                                                            Format JPG, JPEG, PNG. Maksimal 2 MB.
                                                        </small>

                                                        @error('bukti_bayar')
                                                            <div class="text-danger small mt-1">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror

                                                    </div>

                                                    <div class="mb-2">

                                                        <label class="form-label fw-semibold">
                                                            Tanggal Pembayaran
                                                        </label>

                                                        <input type="date"
                                                            name="tanggal_bayar"
                                                            class="form-control"
                                                            value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                                                            max="{{ date('Y-m-d') }}"
                                                            required>

                                                        @error('tanggal_bayar')
                                                            <div class="text-danger small mt-1">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror

                                                    </div>

                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Batal
                                                    </button>

                                                    <button type="submit"
                                                        class="btn btn-warning">

                                                        <i class="bi bi-send me-1"></i>
                                                        Kirim Pembayaran

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            @elseif($statusDenda === 'menunggu verifikasi')

                                <div class="denda-action-section">

                                    <div class="alert alert-info py-2 mb-0 small">
                                        <i class="bi bi-clock-history me-1"></i>
                                        Bukti pembayaran denda sedang diperiksa Admin/Staff.
                                    </div>

                                </div>

                            @elseif($statusDenda === 'lunas')

                                <div class="denda-action-section">

                                    <div class="alert alert-success py-2 mb-0 small">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Denda telah lunas.
                                    </div>

                                </div>

                            @elseif($statusDenda === 'ditolak')

                                <div class="denda-action-section">

                                    <div class="alert alert-danger py-2 mb-0 small">
                                        <i class="bi bi-x-circle-fill me-1"></i>
                                        Pembayaran denda ditolak. Silakan hubungi Admin/Staff.
                                    </div>

                                </div>

                            @endif

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

    </div>
</div>

<style>
.rental-card {
    height: auto !important;
    align-self: flex-start !important;
}

.rental-card .stat-card {
    height: auto !important;
    min-height: 0 !important;
    align-self: flex-start !important;
    display: flex;
    flex-direction: column;
}

.rental-actions {
    width: 100%;
    margin-top: 0;
}

.tagihan-ringkasan {
    background: #f8f9fa;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.tagihan-ringkasan-title {
    font-size: 12px;
    font-weight: 700;
    color: #2C666E;
    margin-bottom: 2px;
}

.tagihan-ringkasan-total {
    border-top: 1px solid #e5e7eb;
    padding-top: 8px;
    margin-top: 2px;
    color: #198754;
}

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

.rental-denda-section {
    width: 100%;
    min-width: 0;
    max-width: 100%;
    overflow: hidden;
}

.rental-denda-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.rental-denda-list {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-width: 0;
    gap: 14px;
}

.denda-customer-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-width: 0;
    max-width: 100%;
    box-sizing: border-box;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 15px;
    gap: 14px;
    overflow: hidden;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.denda-customer-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.denda-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
    width: 100%;
    min-width: 0;
}

.denda-card-title {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    flex: 1;
}

.denda-icon {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fff7ed;
    color: #ea580c;
    font-size: 17px;
}

.denda-title-text {
    min-width: 0;
    overflow-wrap: anywhere;
}

.denda-status-badge {
    flex-shrink: 0;
    white-space: normal;
    text-align: center;
    max-width: 45%;
}

.denda-detail-list {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-width: 0;
    gap: 10px;
}

.denda-detail-row {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1.2fr);
    align-items: start;
    gap: 12px;
    width: 100%;
    min-width: 0;
    font-size: 13px;
}

.denda-label {
    color: #64748b;
    min-width: 0;
}

.denda-value {
    min-width: 0;
    text-align: right;
    overflow-wrap: anywhere;
    word-break: break-word;
}

.denda-description-section {
    width: 100%;
    min-width: 0;
}

.denda-description {
    width: 100%;
    min-width: 0;
    box-sizing: border-box;
    font-size: 13px;
    line-height: 1.7;
    color: #475569;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 11px 12px;
    white-space: pre-line;
    overflow-wrap: anywhere;
    word-break: break-word;
}

.denda-action-section {
    width: 100%;
    min-width: 0;
}

.denda-action-section .btn,
.denda-action-section .alert {
    width: 100%;
    box-sizing: border-box;
}

.denda-customer-card .alert {
    overflow-wrap: anywhere;
}

.denda-foto-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border-radius: 12px;
    overflow: hidden;
    min-height: 200px;
    position: relative;
}

.denda-foto-preview {
    display: block;
    width: auto;
    max-width: 100%;
    max-height: 75vh;
    object-fit: contain;
    border-radius: 10px;
    transition: none !important;
    animation: none !important;
    transform: none !important;
    filter: none !important;
    opacity: 1 !important;
}

.denda-foto-preview:hover {
    transform: none !important;
    filter: none !important;
    opacity: 1 !important;
}

.denda-foto-modal .modal-content {
    border-radius: 16px;
}

.denda-foto-modal .modal-header {
    background: #198754;
}

.denda-foto-modal .modal-body {
    background: #ffffff;
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

    .denda-customer-card {
        padding: 12px;
        gap: 12px;
        border-radius: 12px;
    }

    .denda-card-header {
        gap: 8px;
    }

    .denda-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
        font-size: 15px;
    }

    .denda-detail-row {
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 8px;
        font-size: 12px;
    }

    .denda-value {
        text-align: right;
    }

    .denda-status-badge {
        max-width: 48%;
        font-size: 10px;
    }

    .denda-description {
        font-size: 12px;
        padding: 10px;
    }

    .denda-foto-preview {
        max-height: 60vh;
    }
}
</style>

<script>
(function () {
    if (!window.dendaModalRelocatorBound) {
        window.dendaModalRelocatorBound = true;

        document.addEventListener('show.bs.modal', function (event) {
            const modal = event.target;

            if (
                modal &&
                modal.id &&
                (
                    modal.id.startsWith('dendaBayarModal') ||
                    modal.id.startsWith('dendaFotoModal')
                )
            ) {
                document.body.appendChild(modal);
            }
        });
    }

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

        if (!modalOriginalParents.has(modal)) {
            modalOriginalParents.set(modal, {
                parent: modal.parentNode,
                nextSibling: modal.nextSibling
            });
        }

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

        const original = modalOriginalParents.get(modal);

        if (original && original.parent) {
            if (original.nextSibling && original.nextSibling.parentNode === original.parent) {
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

    document.addEventListener('click', function (event) {
        const openButton = event.target.closest('[data-rating-modal]');

        if (openButton) {
            event.preventDefault();
            openRatingModal(openButton.getAttribute('data-rating-modal'));
            return;
        }

        const closeButton = event.target.closest('[data-rating-close]');

        if (closeButton) {
            event.preventDefault();
            closeRatingModal(closeButton.getAttribute('data-rating-close'));
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && activeRatingModal) {
            closeRatingModal(activeRatingModal.id);
        }
    });

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

    document.addEventListener('submit', function (event) {
        const form = event.target;

        if (!form || !form.classList || !form.classList.contains('denda-bayar-form')) {
            return;
        }

        const input = form.querySelector('input[name="bukti_bayar"]');
        const file = input && input.files && input.files[0];

        if (file && file.size > 2 * 1024 * 1024) {
            event.preventDefault();

            const button = form.querySelector('button[type="submit"]');

            if (button) {
                button.disabled = false;
                button.innerHTML = '<i class="bi bi-cash-coin me-1"></i> Bayar';
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
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengirim...';
        }
    });

    window.openRatingModal = openRatingModal;
    window.closeRatingModal = closeRatingModal;
})();
</script>