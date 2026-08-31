{{-- Dipakai oleh home.blade.php via @include dan HomeController::index() saat AJAX --}}
@php
    $bulanIndo = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
@endphp

<div class="d-flex justify-content-between align-items-end mb-5">

    <div>

        <div class="text-success fw-bold mb-2">
            {{ $punyaFilter ? 'HASIL PENCARIAN' : 'PILIH KENDARAAN' }}
        </div>

        <h2 class="section-title">
            {{ $punyaFilter ? 'Mobil yang cocok dengan pencarianmu' : 'Mobil pilihan untuk perjalananmu' }}
        </h2>

        @if ($punyaFilter)

            <div class="d-flex flex-wrap align-items-center gap-2 mt-3">

                <span class="badge rounded-pill text-bg-success">
                    {{ $mobils->count() }} mobil ditemukan
                </span>

                @if ($cabangAktif)

                    <span class="badge rounded-pill text-bg-light border">
                        <i class="bi bi-geo-alt me-1"></i>
                        {{ $cabangAktif->name }}
                    </span>

                @endif

                @if ($mulai && $selesai)

                    <span class="badge rounded-pill text-bg-light border">
                        <i class="bi bi-calendar-event me-1"></i>
                        {{ $mulai->day.' '.$bulanIndo[(int) $mulai->month].' '.$mulai->year }}
                        &ndash;
                        {{ $selesai->day.' '.$bulanIndo[(int) $selesai->month].' '.$selesai->year }}
                    </span>

                @endif

                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill" data-search-link data-search-top>
                    <i class="bi bi-x-lg me-1"></i>
                    Reset
                </a>

            </div>

        @else

            <p class="section-subtitle">
                Pilih kendaraan yang sesuai dengan kebutuhan
                dan budget perjalananmu.
            </p>

        @endif

    </div>

</div>


<div class="row g-4">

    @forelse($mobils as $mobil)
        <div class="col-md-6 col-lg-4">

            <div class="car-card">

                @if ($mobil->fotoMobils->isNotEmpty())
                    <img src="{{ $mobil->fotoMobils->first()->url }}" class="car-image"
                        alt="{{ $mobil->name }}">
                @elseif($mobil->image)
                    <img src="{{ asset($mobil->image) }}" class="car-image" alt="{{ $mobil->name }}">
                @else
                    <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=900&q=80"
                        class="car-image" alt="{{ $mobil->name }}">
                @endif


                <div class="car-content">

                    <div class="car-brand">
                        {{ $mobil->brand->name ?? '-' }}
                    </div>

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

                        <a href="{{ route('mobils.show', $mobil->id) }}" class="btn btn-rent">
                            Detail
                        </a>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12">

            <div class="text-center py-5">

                <div class="mb-3">
                    <i class="bi {{ $punyaFilter ? 'bi-search' : 'bi-car-front' }} fs-1 text-secondary"></i>
                </div>

                <h5>
                    {{ $punyaFilter ? 'Tidak ada mobil yang cocok dengan pencarianmu' : 'Belum ada mobil tersedia' }}
                </h5>

                <p class="text-secondary">
                    @if ($punyaFilter)
                        Coba ubah lokasi pengambilan atau rentang tanggal, lalu cari kembali.
                    @else
                        Data mobil akan muncul di sini setelah
                        ditambahkan melalui dashboard admin.
                    @endif
                </p>

                @if ($punyaFilter)

                    <a href="{{ route('home') }}" class="btn btn-rent mt-2" data-search-link data-search-top>
                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                        Reset Pencarian
                    </a>

                @endif

            </div>

        </div>

    @endforelse

</div>

@if (! $punyaFilter && ($mobils->count() < $totalTersedia || $jumlah > 6))

    <div class="text-center mt-5 d-flex flex-wrap gap-2 justify-content-center">

        @if ($mobils->count() < $totalTersedia)

            <a href="{{ route('home', ['jumlah' => $jumlah + 6]) }}" class="btn btn-outline-dark px-4 py-2" data-search-link>
                Tampilkan Lebih Banyak
                <small class="text-secondary ms-1">({{ $totalTersedia - $mobils->count() }} lainnya)</small>
                <i class="bi bi-chevron-down ms-1"></i>
            </a>

        @endif

        @if ($jumlah > 6)

            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2" data-search-link data-search-top>
                Tampilkan Lebih Sedikit
                <i class="bi bi-chevron-up ms-1"></i>
            </a>

        @endif

    </div>

@endif
