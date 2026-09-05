<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ajukan Klaim Kompensasi - RentalKu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f5f7f6;
            font-family: 'Montserrat', 'Plus Jakarta Sans', sans-serif;
            color: #1f2937;
        }

        .navbar {
            background: rgba(255,255,255,.95);
            border-bottom: 1px solid #e9ecef;
        }

        .brand {
            font-size: 27px;
            font-weight: 800;
            color: #1f2937;
        }

        .brand span {
            color: #198754;
        }

        .user-box {
            background: #f5f8f6;
            border-radius: 50px;
            padding: 6px 12px 6px 7px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        .user-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #198754;
            color: white;
            font-size: 16px;
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

    @include('layouts.partials.navbar')

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="page-title mb-1">
                    Ajukan Klaim Kompensasi
                </h2>

                <p class="text-muted mb-0">
                    Isi formulir di bawah untuk mengajukan klaim kompensasi.
                </p>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('customer.kompensasi.index') }}" class="btn btn-outline-secondary">
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

            <form action="{{ route('kompensasis.store') }}" method="POST" id="formAjukanKompensasi">

                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Rental (Status Selesai)
                        </label>

                        <select name="rental_id" id="ajuanRentalId" class="form-select" required>
                            <option value="">-- Pilih Rental --</option>
                            @foreach($rentals as $rental)
                                <option value="{{ $rental->id }}" data-mobil="{{ $rental->mobil_id }}" data-mobil-name="{{ $rental->mobil->name }}" data-plate="{{ $rental->mobil->plate_number }}">
                                    {{ $rental->mobil->name ?? '-' }} ({{ $rental->mobil->plate_number ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Mobil
                        </label>

                        <input type="text" id="ajuanMobilDisplay" class="form-control" readonly>

                        <input type="hidden" name="mobil_id" id="ajuanMobilId">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Jenis Kompensasi
                        </label>

                        <select name="jenis" id="ajuanJenis" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="pengembalian_dana">Pengembalian Dana</option>
                            <option value="diskon">Diskon Sewa Berikutnya</option>
                            <option value="gratis_sewa">Gratis Sewa Berikutnya</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Nominal (Rp)
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input
                                type="number"
                                name="nominal"
                                id="ajuanNominal"
                                class="form-control"
                                placeholder="Contoh: 50000"
                                min="0"
                                step="0.01">
                        </div>

                        <small class="text-muted" id="nominalHint">Wajib diisi untuk jenis "Pengembalian Dana"</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Alasan
                        </label>

                        <textarea
                            name="alasan"
                            class="form-control"
                            rows="3"
                            placeholder="Jelaskan alasan klaim kompensasi..."
                            required></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Tanggal Kejadian
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="{{ now()->format('Y-m-d') }}"
                            max="{{ now()->format('Y-m-d') }}"
                            required>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('customer.kompensasi.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-1"></i>
                        Batal
                    </a>

                    <button type="submit" class="btn btn-green">
                        <i class="bi bi-send me-1"></i>
                        Kirim Klaim
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

        const rentalMobilMap = {
            @foreach($rentals as $rental)
                {{ $rental->id }}: {
                    mobil_id: {{ $rental->mobil_id }},
                    mobil_name: '{{ $rental->mobil->name }}',
                    plate: '{{ $rental->mobil->plate_number }}',
                },
            @endforeach
        };

        $(document).ready(function() {

            $('#ajuanRentalId').on('change', function() {
                const rentalId = $(this).val();
                if (rentalMobilMap[rentalId]) {
                    $('#ajuanMobilId').val(rentalMobilMap[rentalId].mobil_id);
                    $('#ajuanMobilDisplay').val(rentalMobilMap[rentalId].mobil_name + ' (' + rentalMobilMap[rentalId].plate + ')');
                } else {
                    $('#ajuanMobilId').val('');
                    $('#ajuanMobilDisplay').val('');
                }
            });

            $('#ajuanJenis').on('change', function() {
                const jenis = $(this).val();
                if (jenis === 'pengembalian_dana') {
                    $('#ajuanNominal').prop('required', true);
                    $('#nominalHint').text('Wajib diisi untuk jenis "Pengembalian Dana"');
                } else {
                    $('#ajuanNominal').prop('required', false).val('');
                    $('#nominalHint').text('Tidak diisi untuk Diskon/Gratis Sewa (nominal = 0)');
                }
            });

            $('#formAjukanKompensasi').on('submit', function(e) {
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
                            text: result.message || 'Klaim kompensasi berhasil diajukan.',
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(function() {
                            window.location.href = '{{ route('customer.kompensasi.index') }}';
                        });
                    },
                    error: function(xhr) {
                        const r = xhr.responseJSON || {};
                        const msg = r.errors ? Object.values(r.errors)[0][0] :
                            (r.message || 'Terjadi kesalahan saat mengajukan klaim.');

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: msg,
                        });
                    }
                });
            });

        });

    </script>

</body>

</html>