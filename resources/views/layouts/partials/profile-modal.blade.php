{{-- MODAL PROFIL BERSAMA --}}
{{-- Dipakai admin, staff, dan customer via @include('layouts.partials.profile-modal'). --}}
{{-- Syarat: Bootstrap CSS + JS bundle sudah dimuat halaman masing-masing. --}}
{{-- Style header dibawa sendiri agar rapi di halaman mana pun (termasuk via admin/staff-navbar). --}}
{{-- Trigger: elemen apa pun dengan data-bs-toggle="modal" data-bs-target="#profileModal". --}}

@include('layouts.partials.modal-head-style')

<style>
    .pm-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #198754;
        color: white;
        font-size: 22px;
        flex-shrink: 0;
    }
</style>

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            @include('layouts.partials.modal-head', ['title' => 'Profil Saya', 'titleId' => 'profileModalLabel'])

            <div class="modal-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="pm-avatar">
                        <i class="bi bi-person"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ Auth::user()->name }}</div>
                        <div class="text-muted small">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf

                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
