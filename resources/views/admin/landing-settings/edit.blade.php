@extends('layouts.admin')

@section('title', 'Pengaturan Landing Page')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-window-stack me-2"></i>
                Pengaturan Landing Page
            </h3>

            <p class="text-muted mb-0">
                Kelola konten Landing Page RentalKu melalui dashboard Admin.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.landing-settings.update') }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-success text-white rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-stars me-2"></i>
                    Hero Section
                </h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Hero Badge
                    </label>

                    <input type="text"
                           name="hero_badge"
                           class="form-control"
                           value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}"
                           placeholder="Rental Mobil Mudah & Terpercaya">
                    <small class="text-muted">
                        Teks kecil yang tampil di atas judul utama.
                    </small>
                </div>


                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Hero Title
                    </label>

                    <input type="text"
                           name="hero_title"
                           class="form-control"
                           value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                           placeholder="Perjalanan lebih mudah bersama RentalKu.">
                </div>


                <div class="mb-0">
                    <label class="form-label fw-semibold">
                        Hero Description
                    </label>

                    <textarea name="hero_description"
                              class="form-control"
                              rows="4"
                              placeholder="Deskripsi singkat mengenai RentalKu.">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-success text-white rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle me-2"></i>
                    About Section
                </h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        About Title
                    </label>

                    <input type="text"
                           name="about_title"
                           class="form-control"
                           value="{{ old('about_title', $settings['about_title'] ?? '') }}"
                           placeholder="Solusi Rental Mobil untuk Setiap Perjalanan">
                </div>

                <div>
                    <label class="form-label fw-semibold">
                        About Description
                    </label>

                    <textarea name="about_description"
                              class="form-control"
                              rows="4"
                              placeholder="Deskripsi mengenai RentalKu.">{{ old('about_description', $settings['about_description'] ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-success text-white rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-tags me-2"></i>
                    Brand Section
                </h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Brand Title
                    </label>

                    <input type="text"
                           name="brand_title"
                           class="form-control"
                           value="{{ old('brand_title', $settings['brand_title'] ?? '') }}"
                           placeholder="Pilihan Brand Mobil">
                </div>

                <div>
                    <label class="form-label fw-semibold">
                        Brand Description
                    </label>

                    <textarea name="brand_description"
                              class="form-control"
                              rows="4"
                              placeholder="Deskripsi bagian brand mobil.">{{ old('brand_description', $settings['brand_description'] ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-success text-white rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-ticket-perforated me-2"></i>
                    Promo Section
                </h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Promo Title
                    </label>

                    <input type="text"
                           name="promo_title"
                           class="form-control"
                           value="{{ old('promo_title', $settings['promo_title'] ?? '') }}"
                           placeholder="Promo RentalKu">
                </div>

                <div>
                    <label class="form-label fw-semibold">
                        Promo Description
                    </label>

                    <textarea name="promo_description"
                              class="form-control"
                              rows="4"
                              placeholder="Deskripsi mengenai promo RentalKu.">{{ old('promo_description', $settings['promo_description'] ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-success text-white rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-grid me-2"></i>
                    Feature Section
                </h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Feature Title
                    </label>

                    <input type="text"
                           name="feature_title"
                           class="form-control"
                           value="{{ old('feature_title', $settings['feature_title'] ?? '') }}"
                           placeholder="Kenapa Memilih RentalKu?">
                </div>

                <div>
                    <label class="form-label fw-semibold">
                        Feature Description
                    </label>

                    <textarea name="feature_description"
                              class="form-control"
                              rows="4"
                              placeholder="Deskripsi keunggulan RentalKu.">{{ old('feature_description', $settings['feature_description'] ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-success text-white rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-ol me-2"></i>
                    Steps Section
                </h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Steps Title
                    </label>

                    <input type="text"
                           name="steps_title"
                           class="form-control"
                           value="{{ old('steps_title', $settings['steps_title'] ?? '') }}"
                           placeholder="Cara Mudah Rental Mobil">
                </div>

                <div>
                    <label class="form-label fw-semibold">
                        Steps Description
                    </label>

                    <textarea name="steps_description"
                              class="form-control"
                              rows="4"
                              placeholder="Deskripsi mengenai langkah rental mobil.">{{ old('steps_description', $settings['steps_description'] ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-success text-white rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-chat-quote me-2"></i>
                    Testimonial Section
                </h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Testimonial Title
                    </label>

                    <input type="text"
                           name="testimonial_title"
                           class="form-control"
                           value="{{ old('testimonial_title', $settings['testimonial_title'] ?? '') }}"
                           placeholder="Apa Kata Pelanggan Kami?">
                </div>

                <div>
                    <label class="form-label fw-semibold">
                        Testimonial Description
                    </label>

                    <textarea name="testimonial_description"
                              class="form-control"
                              rows="4"
                              placeholder="Deskripsi bagian testimonial.">{{ old('testimonial_description', $settings['testimonial_description'] ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-success text-white rounded-top-4 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-question-circle me-2"></i>
                    FAQ Section
                </h5>
            </div>

            <div class="card-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        FAQ Title
                    </label>

                    <input type="text"
                           name="faq_title"
                           class="form-control"
                           value="{{ old('faq_title', $settings['faq_title'] ?? '') }}"
                           placeholder="Pertanyaan yang Sering Diajukan">
                </div>

                <div>
                    <label class="form-label fw-semibold">
                        FAQ Description
                    </label>

                    <textarea name="faq_description"
                              class="form-control"
                              rows="4"
                              placeholder="Deskripsi bagian FAQ.">{{ old('faq_description', $settings['faq_description'] ?? '') }}</textarea>
                </div>

            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mb-4">

            <a href="{{ url('/') }}"
               target="_blank"
               class="btn btn-outline-secondary rounded-pill px-4">

                <i class="bi bi-eye me-2"></i>
                Lihat Landing Page

            </a>

            <button type="submit"
                    class="btn btn-success rounded-pill px-4">

                <i class="bi bi-save me-2"></i>
                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

@endsection