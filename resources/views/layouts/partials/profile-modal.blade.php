{{-- Dipakai admin, staff, dan customer via @include('layouts.partials.profile-modal'). --}}
{{-- Modal Profile & Edit Profile dengan UX Impeccable --}}

@include('layouts.partials.modal-head-style')

<style>
    .pm-card {
        border-radius: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    .pm-avatar-wrapper {
        position: relative;
        width: 88px;
        height: 88px;
        margin: 0 auto;
    }
    .pm-avatar-img {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 3px solid #fff;
    }
    .pm-avatar-fallback {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #198754, #0d5232);
        color: #fff;
        font-size: 34px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.25);
        border: 3px solid #fff;
    }
    .pm-badge-role {
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 3px 10px;
        border-radius: 20px;
        background: rgba(25, 135, 84, 0.12);
        color: #198754;
    }
    .pm-info-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        margin-bottom: 2px;
    }
    .pm-info-val {
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
        word-break: break-word;
    }
    .pm-upload-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #198754;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        border: 2px solid #fff;
        transition: transform 0.15s ease, background-color 0.15s ease;
    }
    .pm-upload-btn:hover {
        background: #146c43;
        transform: scale(1.08);
    }
</style>

<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">

            @include('layouts.partials.modal-head', [
                            'title' => 'Profil Saya',
                            'titleId' => 'profileModalLabel',
                            'icon' => 'bi-person-circle'
                        ])

                        <div class="modal-body p-4">

                {{-- VIEW MODE --}}
                <div id="pmViewMode">
                    <div class="text-center mb-4">
                        <div class="pm-avatar-wrapper mb-3">
                            @if(Auth::user()->photo)
                                <img src="{{ asset(Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" class="pm-avatar-img" id="pmViewAvatarImg">
                            @else
                                <div class="pm-avatar-fallback" id="pmViewAvatarFallback">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <h5 class="fw-bold mb-1" id="pmViewName">{{ Auth::user()->name }}</h5>
                        <span class="pm-badge-role">{{ Auth::user()->role->name ?? 'User' }}</span>
                    </div>

                    <div class="pm-card p-3 mb-3">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="pm-info-label"><i class="bi bi-envelope me-1"></i> Email</div>
                                <div class="pm-info-val" id="pmViewEmail">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="col-12">
                                <div class="pm-info-label"><i class="bi bi-telephone me-1"></i> Nomor HP</div>
                                <div class="pm-info-val" id="pmViewPhone">{{ Auth::user()->phone ?? '-' }}</div>
                            </div>
                            <div class="col-12">
                                <div class="pm-info-label"><i class="bi bi-geo-alt me-1"></i> Alamat</div>
                                <div class="pm-info-val" id="pmViewAddress">{{ Auth::user()->address ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- EDIT MODE FORM --}}
                <form id="pmEditForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="d-none">
                    @csrf
                    @method('PATCH')

                    {{-- Avatar Edit --}}
                    <div class="text-center mb-3">
                        <div class="pm-avatar-wrapper mb-2">
                            <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo) : '' }}" 
                                 alt="Avatar Preview" 
                                 class="pm-avatar-img {{ Auth::user()->photo ? '' : 'd-none' }}" 
                                 id="pmEditPreviewImg">
                            
                            <div class="pm-avatar-fallback {{ Auth::user()->photo ? 'd-none' : '' }}" id="pmEditPreviewFallback">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <label for="pmPhotoInput" class="pm-upload-btn" title="Ubah Foto">
                                <i class="bi bi-camera-fill"></i>
                            </label>
                            <input type="file" id="pmPhotoInput" name="photo" accept="image/*" class="d-none">
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <label for="pmPhotoInput" class="btn btn-sm btn-light border text-secondary cursor-pointer">
                                Choose Photo
                            </label>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none {{ Auth::user()->photo ? '' : 'd-none' }}" id="pmRemovePhotoBtn">
                                Remove
                            </button>
                        </div>
                        <input type="hidden" name="remove_photo" id="pmRemovePhotoVal" value="0">
                        <div class="invalid-feedback d-block small" id="err-photo"></div>
                    </div>

                    <div class="mb-3">
                        <label for="pmInputName" class="form-label small fw-semibold text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="pmInputName" name="name" value="{{ Auth::user()->name }}" required>
                        <div class="invalid-feedback small" id="err-name"></div>
                    </div>

                    <div class="mb-3">
                        <label for="pmInputEmail" class="form-label small fw-semibold text-secondary">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="pmInputEmail" name="email" value="{{ Auth::user()->email }}" required>
                        <div class="invalid-feedback small" id="err-email"></div>
                    </div>

                    <div class="mb-3">
                        <label for="pmInputPhone" class="form-label small fw-semibold text-secondary">Nomor HP / WhatsApp</label>
                        <input type="text" class="form-control" id="pmInputPhone" name="phone" value="{{ Auth::user()->phone }}" placeholder="Contoh: 08123456789">
                        <div class="invalid-feedback small" id="err-phone"></div>
                    </div>

                    <div class="mb-3">
                        <label for="pmInputAddress" class="form-label small fw-semibold text-secondary">Alamat Lengkap</label>
                        <textarea class="form-control" id="pmInputAddress" name="address" rows="2" placeholder="Alamat rumah / domisili">{{ Auth::user()->address }}</textarea>
                        <div class="invalid-feedback small" id="err-address"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light border-top-0 rounded-bottom-4 px-4 py-3 d-flex justify-content-end">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" id="pmToggleBtn">
                        <i class="bi bi-pencil me-1"></i> Edit Profile
                    </button>

                    <button type="button" class="btn btn-success btn-sm rounded-pill px-4 d-none" id="pmSaveBtn">
                        <i class="bi bi-check-lg me-1"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-light btn-sm rounded-pill px-3 d-none text-secondary" id="pmCancelBtn">
                        Batal
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('profileModal');
    if (!modalEl) return;

    const viewMode = document.getElementById('pmViewMode');
    const editForm = document.getElementById('pmEditForm');
    const toggleBtn = document.getElementById('pmToggleBtn');
    const saveBtn = document.getElementById('pmSaveBtn');
    const cancelBtn = document.getElementById('pmCancelBtn');

    const photoInput = document.getElementById('pmPhotoInput');
    const previewImg = document.getElementById('pmEditPreviewImg');
    const previewFallback = document.getElementById('pmEditPreviewFallback');
    const removeBtn = document.getElementById('pmRemovePhotoBtn');
    const removeVal = document.getElementById('pmRemovePhotoVal');

    function clearErrors() {
        document.querySelectorAll('#pmEditForm .is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('#pmEditForm .invalid-feedback').forEach(el => el.textContent = '');
    }

    function setMode(edit) {
        if (edit) {
            viewMode.classList.add('d-none');
            editForm.classList.remove('d-none');
            toggleBtn.classList.add('d-none');
            saveBtn.classList.remove('d-none');
            cancelBtn.classList.remove('d-none');
            clearErrors();
        } else {
            viewMode.classList.remove('d-none');
            editForm.classList.add('d-none');
            toggleBtn.classList.remove('d-none');
            saveBtn.classList.add('d-none');
            cancelBtn.classList.add('d-none');
        }
    }

    toggleBtn.addEventListener('click', function() {
        setMode(true);
    });

    cancelBtn.addEventListener('click', function() {
        setMode(false);
    });

    // Reset when modal opens/closes
    modalEl.addEventListener('show.bs.modal', function(e) {
        // If trigger button had data-mode="edit", open directly in edit mode
        const trigger = e.relatedTarget;
        if (trigger && (trigger.getAttribute('data-mode') === 'edit' || trigger.textContent.trim().includes('Edit Profile'))) {
            setMode(true);
        } else {
            setMode(false);
        }
    });

    // Photo preview
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            removeVal.value = "0";
            const reader = new FileReader();
            reader.onload = function(evt) {
                previewImg.src = evt.target.result;
                previewImg.classList.remove('d-none');
                previewFallback.classList.add('d-none');
                removeBtn.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    removeBtn.addEventListener('click', function() {
        photoInput.value = '';
        removeVal.value = "1";
        previewImg.src = '';
        previewImg.classList.add('d-none');
        previewFallback.classList.remove('d-none');
        removeBtn.classList.add('d-none');
    });

    // Save AJAX
    saveBtn.addEventListener('click', function() {
        clearErrors();
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...';

        const formData = new FormData(editForm);

        fetch(editForm.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || formData.get('_token')
            },
            body: formData
        })
        .then(res => res.json().then(data => ({ status: res.status, body: data })))
        .then(({ status, body }) => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan';

            if (status === 200 && body.success) {
                const u = body.user;

                // Update View UI
                document.getElementById('pmViewName').textContent = u.name;
                document.getElementById('pmViewEmail').textContent = u.email;
                document.getElementById('pmViewPhone').textContent = u.phone || '-';
                document.getElementById('pmViewAddress').textContent = u.address || '-';

                // Update Avatar UI in View & Header/Nav
                if (u.photo_url) {
                    let vImg = document.getElementById('pmViewAvatarImg');
                    let vFallback = document.getElementById('pmViewAvatarFallback');
                    if (vImg) {
                        vImg.src = u.photo_url;
                    } else if (vFallback) {
                        vFallback.outerHTML = `<img src="${u.photo_url}" alt="${u.name}" class="pm-avatar-img" id="pmViewAvatarImg">`;
                    }
                } else {
                    const vImg = document.getElementById('pmViewAvatarImg');
                    if (vImg) {
                        vImg.outerHTML = `<div class="pm-avatar-fallback" id="pmViewAvatarFallback">${u.name.charAt(0).toUpperCase()}</div>`;
                    }
                }

                // Update navbar display names across page if present
                document.querySelectorAll('.user-name').forEach(el => el.textContent = u.name);

                // Update navbar avatars across page if present
                if (u.photo_url) {
                    document.querySelectorAll('.user-avatar').forEach(el => {
                        const img = el.querySelector('img');
                        if (img) {
                            img.src = u.photo_url;
                        } else {
                            el.innerHTML = `<img src="${u.photo_url}" alt="Avatar" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">`;
                        }
                    });
                } else {
                     document.querySelectorAll('.user-avatar').forEach(el => {
                        el.innerHTML = `<i class="bi bi-person-fill"></i>`;
                        // Custom nav has different icon class
                        if(el.classList.contains('user-icon')) el.innerHTML = `<i class="bi bi-person fs-5"></i>`;
                    });
                }

                // SweetAlert Success
                if (window.Swal) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: body.message,
                        timer: 2000,
                        showConfirmButton: false,
                        borderRadius: '15px'
                    });
                }

                // Switch back to view mode after short delay
                setTimeout(() => {
                    setMode(false);
                }, 800);
            } else if (status === 422 && body.errors) {
                // SweetAlert Error Validation
                if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Cek kembali inputan Anda.',
                        borderRadius: '15px'
                    });
                }
                Object.keys(body.errors).forEach(key => {
                    const input = document.getElementById('pmInput' + key.charAt(0).toUpperCase() + key.slice(1)) || document.getElementById('pmPhotoInput');
                    const errBox = document.getElementById('err-' + key);
                    if (input) input.classList.add('is-invalid');
                    if (errBox) errBox.textContent = body.errors[key][0];
                });
            } else {
                if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: body.message || 'Gagal memperbarui profil.',
                        borderRadius: '15px'
                    });
                }
            }
        })
        .catch(err => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Simpan';
            if (window.Swal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan koneksi server.',
                    borderRadius: '15px'
                });
            }
        });
    });
});
</script>
