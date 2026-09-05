<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Servis Mobil - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f5f7f6;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1f2937;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 25px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .page-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #edf0ee;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .12);
        }

        .btn-green {
            background: #198754;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 18px;
        }

        .btn-green:hover {
            background: #146c43;
            color: white;
        }
    </style>
</head>

<body>

    @include('layouts.partials.admin-navbar')

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="page-title mb-1">
                    Tambah Servis Mobil
                </h2>

                <p class="text-muted mb-0">
                    Catat servis kendaraan baru.
                </p>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('servis_mobils.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali
                </a>

            </div>

        </div>

        @if(session('success'))
            <span id="flashSuccess" class="d-none">{{ session('success') }}</span>
        @endif


        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Terdapat kesalahan:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <div class="page-card p-4">

            <form action="{{ route('servis_mobils.store') }}" method="POST" id="formTambahServisMobil">

                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Mobil
                        </label>

                        <select name="mobil_id" class="form-select" required>
                            <option value="">-- Pilih Mobil --</option>
                            @foreach($mobils as $mobil)
                                <option value="{{ $mobil->id }}">
                                    {{ $mobil->name }} ({{ $mobil->plate_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Tanggal Servis
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="{{ now()->format('Y-m-d') }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Jenis Servis
                        </label>

                        <select name="jenis" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="rutin">Rutin</option>
                            <option value="perbaikan">Perbaikan</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Biaya
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input
                                type="number"
                                name="biaya"
                                class="form-control"
                                placeholder="Contoh: 500000"
                                min="0"
                                step="0.01"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Bengkel
                        </label>

                        <input
                            type="text"
                            name="bengkel"
                            class="form-control"
                            placeholder="Nama bengkel"
                            maxlength="100">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="3"
                            placeholder="Keterangan servis..."></textarea>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('servis_mobils.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>
                        Batal
                    </a>

                    <button type="submit" class="btn btn-green">
                        <i class="bi bi-save me-1"></i>
                        Simpan Servis
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        var CSRF_TOKEN = '{{ csrf_token() }}';

        var $flashSuccess = $('#flashSuccess');

        if ($flashSuccess.length) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: $flashSuccess.text(),
                timer: 1800,
                showConfirmButton: false,
            });
        }

        $('#formTambahServisMobil').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                success: function(result) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: result.message || 'Servis mobil berhasil ditambahkan.',
                        timer: 1500,
                        showConfirmButton: false,
                    }).then(function() {
                        window.location.href = '{{ route('servis_mobils.index') }}';
                    });
                },
                error: function(xhr) {
                    const r = xhr.responseJSON || {};
                    const msg = r.errors ? Object.values(r.errors)[0][0] :
                        (r.message || 'Terjadi kesalahan saat menambahkan servis mobil.');

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: msg,
                    });
                }
            });
        });

    </script>

</body>

</html>