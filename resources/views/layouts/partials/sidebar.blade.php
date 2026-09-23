{{-- SIDEBAR DISPATCHER --}}
{{-- Dipakai oleh semua halaman admin/staff via @include('layouts.partials.sidebar') --}}
{{-- Memilih sidebar sesuai role agar sidebar stabil saat pindah halaman:
     Staff -> staff-sidebar, selain itu -> admin-sidebar. --}}
@if((auth()->user()->role->name ?? '') === 'Staff')
    @include('layouts.partials.staff-sidebar')
@else
    @include('layouts.partials.admin-sidebar')
@endif
