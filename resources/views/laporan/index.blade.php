<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan - RentalKu</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #f5f7f6;
            font-family: Arial, sans-serif;
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
            box-shadow: 0 8px 25px rgba(0,0,0,.04);
        }

        .report-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: #e9f7ef;
            color: #198754;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 35px;
            margin: auto;
        }

    </style>

</head>

<body>

<nav class="navbar">

    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center w-100">

            <a
                href="{{ route('admin.dashboard') }}"
                class="text-decoration-none brand"
            >
                Rental<span>ku</span>.
            </a>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="btn btn-outline-secondary btn-sm"
                >
                    <i class="bi bi-speedometer2 me-1"></i>
                    Dashboard
                </a>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-outline-danger btn-sm"
                    >
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Keluar
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>


<div class="container py-5">

    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            Laporan
        </h2>

        <p class="text-muted mb-0">
            Kelola dan lihat laporan aktivitas RentalKu.
        </p>

    </div>


    <div class="page-card">

        <div class="text-center py-5">

            <div class="report-icon mb-4">

                <i class="bi bi-file-earmark-bar-graph"></i>

            </div>

            <h4 class="fw-bold">
                Laporan Belum Tersedia
            </h4>

            <p class="text-muted mb-0">
                Fitur laporan akan tersedia setelah data laporan
                RentalKu selesai dibuat.
            </p>

        </div>

    </div>

</div>

</body>

</html>