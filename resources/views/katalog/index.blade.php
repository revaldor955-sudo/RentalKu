@extends('layouts.landing')

@section('title', 'Katalog Mobil - Rentalku')

@push('styles')
<style>
    .car-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease, color 0.2s ease, background 0.2s ease, border-color 0.2s ease;
        border: 1px solid #edf0ee;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        position: relative;
    }
    .car-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }
    .car-card:hover .car-title {
        color: var(--primary, #2c666e);
    }
    .car-card:hover .btn-rent {
        background: var(--primary, #2c666e) !important;
        color: #fff !important;
    }
    .car-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.25s ease;
    }
    .car-card:hover .car-image {
        transform: scale(1.04);
    }
    .car-populer {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #dc3545;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 20px;
        z-index: 2;
    }
    .filter-card {
        background: #fff;
        border: 1px solid #edf0ee;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }
    .pager-bar {
        background: #fff;
        border: 1px solid #edf0ee;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        padding: 12px 16px;
    }
    .pager-select {
        width: auto;
        border-radius: 10px;
    }
    .pager-jump {
        width: 72px;
        border-radius: 10px;
        text-align: center;
    }
    .pager-btn {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        color: #1f2937;
        font-weight: 600;
        background: #fff;
    }
    .pager-btn:hover {
        border-color: #198754;
        color: #198754;
        background: #f5f7f6;
    }
    .pager-btn.disabled {
        opacity: 0.4;
        pointer-events: none;
    }
    .pager-next {
        background: #198754;
        border-color: #198754;
        color: #fff;
    }
    .pager-next:hover {
        background: #146c43;
        border-color: #146c43;
        color: #fff;
    }
</style>
@endpush

@section('content')

    <section class="section" id="katalog">

        <div class="container">

            <div class="text-center mb-4">

                <div class="text-success fw-bold mb-2">
                    KATALOG
                </div>

                <h2 class="section-title">
                    Semua Mobil
                </h2>

                <p class="section-subtitle mx-auto">
                    Jelajahi seluruh armada Rentalku dan saring sesuai kebutuhan perjalananmu.
                </p>

            </div>

            <div class="filter-card p-3 p-md-4 mb-5">

                <form action="{{ route('katalog.index') }}" method="GET">

                    <div class="row g-3 align-items-end">

                        <div class="col-md-6 col-lg-3">

                            <label class="form-label fw-semibold" for="q">
                                Kata Kunci
                            </label>

                            <input type="text" name="q" id="q" class="form-control" placeholder="Nama atau plat nomor..." value="{{ $kataKunci }}">

                        </div>

                        <div class="col-md-6 col-lg-3">

                            <label class="form-label fw-semibold" for="cabang">
                                Cabang
                            </label>

                            <select name="cabang" id="cabang" class="form-select">

                                <option value="">
                                    Semua cabang
                                </option>

                                @foreach ($cabangs as $item)
                                    <option value="{{ $item->id }}" @selected($cabangAktif?->id == $item->id)>
                                        {{ $item->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 col-lg-2">

                            <label class="form-label fw-semibold" for="transmisi">
                                Transmisi
                            </label>

                            <select name="transmisi" id="transmisi" class="form-select">

                                <option value="">
                                    Semua
                                </option>

                                <option value="manual" @selected($transmisi === 'manual')>
                                    Manual
                                </option>

                                <option value="matic" @selected($transmisi === 'matic')>
                                    Matic
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 col-lg-2">

                            <label class="form-label fw-semibold" for="status">
                                Status
                            </label>

                            <select name="status" id="status" class="form-select">

                                <option value="tersedia" @selected($statusInput !== 'tidak_tersedia')>
                                    Tersedia
                                </option>

                                <option value="tidak_tersedia" @selected($statusInput === 'tidak_tersedia')>
                                    Tidak Tersedia
                                </option>

                            </select>

                        </div>

                        <div class="col-lg-2 d-grid gap-2 d-md-flex">

                            <button type="submit" class="btn btn-rent flex-fill">
                                <i class="bi bi-search me-1"></i>
                                Cari
                            </button>

                            <a href="{{ route('katalog.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center px-3" title="Reset filter" aria-label="Reset filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>

                        </div>

                    </div>

                </form>

            </div>

            <div class="row g-4">

                @forelse($mobils as $mobil)
                    <div class="col-md-6 col-lg-4">

                        <div class="car-card"
                             data-mobil-id="{{ $mobil->slug }}"
                             role="button"
                             style="cursor: pointer;">

                            @if(in_array($mobil->id, ($populerIds ?? [])))
                                <div class="car-populer"><i class="bi bi-fire me-1"></i>Populer</div>
                            @endif

                            @if ($mobil->fotoMobils->isNotEmpty())
                                <img src="{{ $mobil->fotoMobils->first()->url }}" class="car-image"
                                    alt="{{ $mobil->name }}" loading="lazy">
                            @elseif($mobil->image)
                                <img src="{{ asset($mobil->image) }}" class="car-image" alt="{{ $mobil->name }}" loading="lazy">
                            @else
                                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=900&q=80"
                                    class="car-image" alt="{{ $mobil->name }}" loading="lazy">
                            @endif

                            <div class="car-content">

                                <div class="car-title">
                                    {{ $mobil->name }}
                                </div>

                                <div class="car-info mb-4">

                                    <span>
                                        <i class="bi bi-people me-1"></i>
                                        {{ $mobil->kapasitas }}
                                    </span>

                                    <span>
                                        <i class="bi bi-gear me-1"></i>
                                        {{ ucfirst($mobil->transmisi) }}
                                    </span>

                                    <span>
                                        <i class="bi bi-geo-alt me-1"></i>
                                        {{ $mobil->cabang->name ?? '-' }}
                                    </span>

                                </div>

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <div class="car-price">

                                            Rp {{ number_format($mobil->harga_perhari, 0, ',', '.') }}

                                            <small>
                                                /hari
                                            </small>

                                        </div>

                                    </div>

                                    @if ($statusMobil === 'Disewa')
                                        <span class="btn btn-secondary disabled">
                                            Tidak Tersedia
                                        </span>
                                    @else
                                        <button
                                            type="button"
                                            class="btn btn-rent"
                                            data-mobil-id="{{ $mobil->slug }}"
                                            style="pointer-events: none;">
                                            Detail
                                        </button>
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="text-center py-5">

                            <div class="mb-3">
                                <i class="bi bi-search fs-1 text-secondary"></i>
                            </div>

                            <h5>
                                Tidak ada mobil yang cocok dengan pencarianmu
                            </h5>

                            <p class="text-secondary">
                                Coba ubah filter, lalu cari kembali.
                            </p>

                            <a href="{{ route('katalog.index') }}" class="btn btn-rent mt-2">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>
                                Reset Filter
                            </a>

                        </div>

                    </div>

                @endforelse

            </div>

            @if ($mobils->total() > 0)
                <div class="pager-bar mt-5 d-flex flex-wrap align-items-center justify-content-between gap-3">

                    <div class="text-secondary small">
                        Menampilkan {{ $mobils->firstItem() }}&ndash;{{ $mobils->lastItem() }} dari {{ $mobils->total() }} mobil
                    </div>

                    <form action="{{ route('katalog.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">

                        <input type="hidden" name="q" value="{{ $kataKunci }}">
                        <input type="hidden" name="cabang" value="{{ $cabangAktif?->id }}">
                        <input type="hidden" name="transmisi" value="{{ $transmisi }}">
                        <input type="hidden" name="status" value="{{ $statusInput }}">

                        <select name="per_page" class="form-select form-select-sm pager-select" onchange="this.form.page.value=1;this.form.submit()" aria-label="Jumlah per halaman">
                            @foreach ([10, 20, 50] as $opsi)
                                <option value="{{ $opsi }}" @selected($perPage == $opsi)>
                                    {{ $opsi }} / halaman
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="page" class="form-control form-control-sm pager-jump" min="1" max="{{ $mobils->lastPage() }}" value="{{ $mobils->currentPage() }}" aria-label="Lompat ke halaman" onchange="this.form.submit()">

                        <span class="text-secondary small">
                            Halaman {{ $mobils->currentPage() }} / {{ $mobils->lastPage() }}
                        </span>

                    </form>

                    <div class="d-flex align-items-center gap-2">

                        @if ($mobils->onFirstPage())
                            <span class="btn btn-sm pager-btn disabled" aria-disabled="true">
                                First Page
                            </span>
                        @else
                            <a href="{{ $mobils->url(1) }}" class="btn btn-sm pager-btn">
                                First Page
                            </a>
                        @endif

                        @if ($mobils->onFirstPage())
                            <span class="btn btn-sm pager-btn disabled" aria-disabled="true">
                                <i class="bi bi-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $mobils->previousPageUrl() }}" class="btn btn-sm pager-btn{{ $mobils->hasMorePages() ? '' : ' pager-next' }}" rel="prev" aria-label="Halaman sebelumnya">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        @endif

                        @if ($mobils->hasMorePages())
                            <a href="{{ $mobils->nextPageUrl() }}" class="btn btn-sm pager-btn pager-next" rel="next" aria-label="Halaman berikutnya">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @else
                            <span class="btn btn-sm pager-btn disabled" aria-disabled="true">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        @endif

                        @if ($mobils->hasMorePages())
                            <a href="{{ $mobils->url($mobils->lastPage()) }}" class="btn btn-sm pager-btn">
                                Last Page
                            </a>
                        @else
                            <span class="btn btn-sm pager-btn disabled" aria-disabled="true">
                                Last Page
                            </span>
                        @endif

                    </div>

                </div>
            @endif

        </div>

    </section>

@endsection

@push('scripts')
<script>
    $(document).on('click', '.car-card[data-mobil-id], button[data-mobil-id]', function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.href = '/mobils/' + $(this).data('mobil-id') + '?from=katalog';
    });
</script>
@endpush
