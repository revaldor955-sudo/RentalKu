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
    .pager-bar .text-secondary { font-size: 14px; font-weight: 500; }
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
    @media (prefers-reduced-motion: no-preference) {
        .car-card-ajax {
            animation: carFadeUp 0.35s ease both;
        }
        #katalog-grid > div:nth-child(2) .car-card-ajax { animation-delay: 0.05s; }
        #katalog-grid > div:nth-child(3) .car-card-ajax { animation-delay: 0.1s; }
        #katalog-grid > div:nth-child(n+4) .car-card-ajax { animation-delay: 0.15s; }
    }
    @keyframes carFadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: none; }
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

                <form action="{{ route('katalog.index') }}" method="GET" id="katalog-filter">

                    <div class="row g-3 align-items-end">

                        <div class="col-md-6 col-lg-2">

                            <label class="form-label fw-semibold" for="q">
                                Kata Kunci
                            </label>

                            <input type="text" name="q" id="q" class="form-control" placeholder="Nama atau plat nomor..." value="{{ $kataKunci }}" autocomplete="off">

                        </div>

                        <div class="col-md-6 col-lg-2">

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

                        <div class="col-md-6 col-lg-2">

                            <label class="form-label fw-semibold" for="sort">
                                Urutkan
                            </label>

                            <select name="sort" id="sort" class="form-select">

                                <option value="populer" @selected(($sort ?? 'populer') === 'populer')>
                                    Populer
                                </option>

                                <option value="harga_asc" @selected(($sort ?? '') === 'harga_asc')>
                                    Harga termurah
                                </option>

                                <option value="harga_desc" @selected(($sort ?? '') === 'harga_desc')>
                                    Harga termahal
                                </option>

                                <option value="terbaru" @selected(($sort ?? '') === 'terbaru')>
                                    Terbaru
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

            <div class="row g-4" id="katalog-grid">

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
                <div class="pager-bar mt-5 d-flex flex-wrap align-items-center justify-content-between gap-3" id="katalog-pager">

                    <div class="text-secondary" id="katalog-info">
                        Menampilkan {{ $mobils->firstItem() }}&ndash;{{ $mobils->lastItem() }} dari {{ $mobils->total() }} mobil
                    </div>

                    <form action="{{ route('katalog.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2" id="katalog-pager-form">

                        <input type="hidden" name="q" value="{{ $kataKunci }}">
                        <input type="hidden" name="cabang" value="{{ $cabangAktif?->id }}">
                        <input type="hidden" name="transmisi" value="{{ $transmisi }}">
                        <input type="hidden" name="status" value="{{ $statusInput }}">
                        <input type="hidden" name="sort" value="{{ $sort ?? 'populer' }}">

                        <select name="per_page" id="katalog-perpage" class="form-select form-select-sm pager-select" onchange="this.form.page.value=1;this.form.submit()" aria-label="Jumlah per halaman">
                            @foreach ([10, 20, 50, 100] as $opsi)
                                <option value="{{ $opsi }}" @selected($perPage == $opsi)>
                                    {{ $opsi }} / halaman
                                </option>
                            @endforeach
                            <option value="custom">
                                Custom
                            </option>
                        </select>

                        <input type="number" id="katalog-custom" class="form-control form-control-sm pager-jump" min="1" max="100" value="{{ $perPage }}" aria-label="Jumlah custom per halaman">

                        <input type="number" name="page" id="katalog-jump" class="form-control form-control-sm pager-jump d-none" min="1" max="{{ $mobils->lastPage() }}" value="{{ $mobils->currentPage() }}" aria-label="Lompat ke halaman" onchange="this.form.submit()">

                        <span class="text-secondary" id="katalog-page">
                            Halaman {{ $mobils->currentPage() }} / {{ $mobils->lastPage() }}
                        </span>

                    </form>

                    <div class="d-flex align-items-center gap-2" id="katalog-nav">

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

    function formatRupiah(v){ return 'Rp ' + Number(v).toLocaleString('id-ID'); }

    function escapeHtml(s){
        return String(s ?? '').replace(/[&<>"']/g, function(c){
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];
        });
    }

    var katalogPresets = ['10', '20', '50', '100'];
    var katalogQTimer = null;

    function katalogParams(page) {
        var perPage = $('#katalog-perpage').val();
        if (perPage === 'custom') {
            perPage = $('#katalog-custom').val();
        }
        return {
            q: $('#q').val(),
            cabang: $('#cabang').val(),
            transmisi: $('#transmisi').val(),
            status: $('#status').val(),
            sort: $('#sort').val(),
            per_page: perPage,
            page: page || 1
        };
    }

    function katalogSkeleton() {
        var html = '';
        for (var i = 0; i < 6; i++) {
            html += '<div class="col-md-6 col-lg-4"><div class="car-card p-3" aria-hidden="true">'
                + '<div class="placeholder-glow"><span class="placeholder col-12" style="height:200px;border-radius:12px;"></span></div>'
                + '<div class="car-content"><p class="placeholder-glow mb-0"><span class="placeholder col-7"></span> '
                + '<span class="placeholder col-4"></span> <span class="placeholder col-6"></span></p></div>'
                + '</div></div>';
        }
        $('#katalog-grid').html(html);
    }

    function katalogCard(m, tersedia) {
        var btn = tersedia
            ? '<button type="button" class="btn btn-rent" data-mobil-id="' + m.slug + '" style="pointer-events: none;">Detail</button>'
            : '<span class="btn btn-secondary disabled">Tidak Tersedia</span>';
        return '<div class="col-md-6 col-lg-4"><div class="car-card car-card-ajax" data-mobil-id="' + m.slug + '" role="button" style="cursor: pointer;">'
            + (m.populer ? '<div class="car-populer"><i class="bi bi-fire me-1"></i>Populer</div>' : '')
            + '<img src="' + m.foto_url + '" class="car-image" alt="' + escapeHtml(m.name) + '" loading="lazy">'
            + '<div class="car-content"><div class="car-title">' + escapeHtml(m.name) + '</div>'
            + '<div class="car-info mb-4"><span><i class="bi bi-people me-1"></i>' + escapeHtml(m.kapasitas) + '</span> '
            + '<span><i class="bi bi-gear me-1"></i>' + escapeHtml(String(m.transmisi).charAt(0).toUpperCase() + String(m.transmisi).slice(1)) + '</span> '
            + '<span><i class="bi bi-geo-alt me-1"></i>' + escapeHtml(m.cabang) + '</span></div>'
            + '<div class="d-flex justify-content-between align-items-center"><div><div class="car-price">'
            + formatRupiah(m.harga_perhari) + ' <small>/hari</small></div></div>' + btn + '</div></div></div></div>';
    }

    function katalogEmpty() {
        return '<div class="col-12"><div class="text-center py-5"><div class="mb-3">'
            + '<i class="bi bi-search fs-1 text-secondary"></i></div>'
            + '<h5>Tidak ada mobil yang cocok dengan pencarianmu</h5>'
            + '<p class="text-secondary">Coba ubah filter, lalu cari kembali.</p>'
            + '<a href="{{ route('katalog.index') }}" class="btn btn-rent mt-2">'
            + '<i class="bi bi-arrow-counterclockwise me-2"></i>Reset Filter</a></div></div>';
    }

    function katalogNav(meta) {
        var cur = meta.current_page, last = meta.last_page;
        function btn(page, label, next) {
            var dis = (page === null);
            var cls = 'btn btn-sm pager-btn' + (dis ? ' disabled' : '') + (!dis && next ? ' pager-next' : '');
            return dis
                ? '<span class="' + cls + '" aria-disabled="true">' + label + '</span>'
                : '<button type="button" class="' + cls + '" data-page="' + page + '">' + label + '</button>';
        }
        return btn(cur > 1 ? 1 : null, 'First Page', false)
            + btn(cur > 1 ? cur - 1 : null, '<i class="bi bi-chevron-left"></i>', !(cur < last))
            + btn(cur < last ? cur + 1 : null, '<i class="bi bi-chevron-right"></i>', true)
            + btn(cur < last ? last : null, 'Last Page', false);
    }

    function katalogFetch(page, scroll) {
        var params = katalogParams(page);
        katalogSkeleton();
        $.ajax({
            url: '{{ route('katalog.data') }}',
            type: 'GET',
            data: params,
            dataType: 'json',
            success: function(res) {
                var meta = res.meta;
                var html = '';
                if (res.data.length) {
                    res.data.forEach(function(m){ html += katalogCard(m, meta.tersedia); });
                } else {
                    html = katalogEmpty();
                }
                $('#katalog-grid').html(html);
                var from = meta.from || 0, to = meta.to || 0;
                $('#katalog-info').text('Menampilkan ' + from + '–' + to + ' dari ' + meta.total + ' mobil');
                $('#katalog-page').text('Halaman ' + (meta.last_page ? meta.current_page : 0) + ' / ' + meta.last_page);
                $('#katalog-nav').html(katalogNav(meta));
                $('#katalog-pager').toggleClass('d-none', res.data.length === 0);
                $('#katalog-pager-form input[name="sort"]').val($('#sort').val());
                var url = '{{ route('katalog.index') }}?' + $.param(params);
                window.history.replaceState(null, '', url);
                if (scroll) {
                    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                    document.getElementById('katalog').scrollIntoView({ behavior: reduce ? 'auto' : 'smooth' });
                }
            },
            error: function() {
                $('#katalog-grid').html('<div class="col-12"><div class="text-center py-5">'
                    + '<p class="text-secondary">Gagal memuat katalog. Periksa koneksi lalu coba lagi.</p>'
                    + '<button type="button" class="btn btn-rent mt-2" id="katalog-retry">'
                    + '<i class="bi bi-arrow-counterclockwise me-2"></i>Coba Lagi</button></div></div>');
            }
        });
    }

    $(document).on('click', '#katalog-nav [data-page]', function() {
        katalogFetch(Number($(this).data('page')), true);
    });

    $(document).on('click', '#katalog-retry', function() {
        katalogFetch(1, false);
    });

    $('#katalog-filter').on('submit', function(e) {
        e.preventDefault();
        katalogFetch(1, false);
    });

    $('#katalog-filter').on('change', '#cabang, #transmisi, #status, #sort', function() {
        katalogFetch(1, false);
    });

    $('#q').on('input', function() {
        clearTimeout(katalogQTimer);
        katalogQTimer = setTimeout(function(){ katalogFetch(1, false); }, 400);
    });

    $('#katalog-pager-form').on('submit', function(e) {
        e.preventDefault();
        katalogFetch(1, false);
    });

    $('#katalog-perpage').on('change', function() {
        if ($(this).val() === 'custom') {
            $('#katalog-custom').focus().select();
            return;
        }
        $('#katalog-custom').val($(this).val());
        katalogFetch(1, false);
    });

    $('#katalog-custom').on('change', function() {
        var n = parseInt($(this).val(), 10) || 10;
        n = Math.min(Math.max(n, 1), 100);
        $(this).val(n);
        $('#katalog-perpage').val(katalogPresets.indexOf(String(n)) !== -1 ? String(n) : 'custom');
        katalogFetch(1, false);
    });
</script>
@endpush
