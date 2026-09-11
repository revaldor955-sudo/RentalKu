{{-- HEADER MODAL BERSAMA (gradien hijau) --}}
{{-- Dipakai semua modal via @include('layouts.partials.modal-head', [...]). --}}
{{-- Parameter: 'title' (teks, wajib), 'icon' (kelas bi tanpa prefix, opsional), --}}
{{-- 'subtitle' (teks kecil, opsional), 'titleId' (id h5, opsional). --}}
{{-- Syarat: halaman sudah @include('layouts.partials.modal-head-style') di <head>. --}}
<div class="modal-header mhead">

    <div>

        <h5 class="modal-title" @isset($titleId)id="{{ $titleId }}"@endisset>
            @isset($icon)<i class="bi {{ $icon }} me-2"></i>@endisset{{ $title ?? '' }}
        </h5>

        @isset($subtitle)
            <small>{{ $subtitle }}</small>
        @endisset

    </div>

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="modal"
        aria-label="Tutup"></button>

</div>
