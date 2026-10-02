{{-- Dipakai semua halaman via @include('layouts.partials.modal-head-style') di dalam <head>. --}}
{{-- Pasangan markup: @include('layouts.partials.modal-head', ['title' => ..., 'icon' => ..., 'subtitle' => ..., 'titleId' => ...]). --}}
<style>
    /* Samakan semua modal ber-header gradien: tanpa ring border 1px Bootstrap
       (itu garis abu yang terlihat seperti gap di pojok), gradien diklip
       tepat mengikuti lengkungan .modal-content. Box-shadow Bootstrap tetap
       memberi definisi tepi modal. Berlaku juga di halaman tanpa aturan
       .modal-content sendiri (default Bootstrap: radius .5rem + border 1px
       + overflow visible). */
    .modal-content:has(.mhead) {
        overflow: hidden;
        border: 0;
    }

    .mhead {
        background: linear-gradient(110deg, #08462a, #198754);
        color: #fff;
        padding: 20px 22px;
        border: 0;
        /* Ikuti lengkungan sudut .modal-content agar tidak ada gap di pojok atas. */
        border-top-left-radius: inherit;
        border-top-right-radius: inherit;
        /* Tarik 1px keluar lalu diklip aturan di atas: menutup hairline
           antialias/backdrop di pojok tanpa menggeser isi. */
        margin: -1px -1px 0;
    }

    .mhead .modal-title {
        font-weight: 800;
    }

    .mhead small {
        color: #dff5e8;
    }

    .mhead .btn-close {
        filter: invert(1);
    }
</style>
