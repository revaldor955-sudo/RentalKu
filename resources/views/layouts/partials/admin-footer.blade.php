{{-- FOOTER ADMIN/STAFF --}}
{{-- Dipakai via @include('layouts.partials.admin-footer', ['pageTitle' => 'Management Mobil']) --}}
<footer class="bg-white border-top py-4">

    <div class="container text-center">

        <div class="fw-bold">
            Rental<span class="text-success">ku</span>.
        </div>

        <small class="text-muted">
            {{ $pageTitle ?? 'RentalKu' }} - RentalKu
        </small>

    </div>

</footer>
