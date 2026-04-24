@extends('landing.layouts.app')

@section('title', 'Profil Desa ' . ($profile->village_name ?? 'Sukorejo') . ' - Portal Desa Digital')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/profil-desa.css') }}">
@endpush

@section('content')
    <!-- Sub-page Hero -->
    <header class="sub-hero">
        <div class="container sub-hero-content">
            <h1>Profil Desa</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil Desa</li>
                </ol>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="section py-5">
        <div class="container">
            <!-- Visi Misi Section -->
            <div class="row mb-5 pb-4">
                <div class="col-12 section-title">
                    <h2>Visi & Misi</h2>
                    <p>Arah dan tujuan pembangunan desa untuk masa depan yang lebih baik</p>
                </div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="card h-100 shadow-sm border-0"
                        style="border-radius: 15px; transition: transform 0.3s; cursor: default;"
                        onmouseover="this.style.transform='translateY(-5px)'"
                        onmouseout="this.style.transform='translateY(0)'">
                        <div class="card-body p-5 text-center d-flex flex-column justify-content-center">
                            <div class="icon-wrapper mb-4"
                                style="width: 80px; height: 80px; background: var(--light-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fas fa-eye" style="font-size: 2.5rem; color: var(--primary-color);"></i>
                            </div>
                            <h3 class="font-weight-bold mb-4" style="color: var(--dark-color); font-weight: 700;">Visi
                            </h3>
                            <p class="lead"
                                style="font-weight: 500; font-style: italic; color: var(--text-dark); line-height: 1.8;">
                                "{{ $profile->vision ?? 'Terwujudnya Desa Sukorejo yang Maju, Sejahtera, Transparan, dan Berbudaya melalui Pemberdayaan Masyarakat dan Tata Kelola yang Baik.' }}"</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card h-100 shadow-sm border-0"
                        style="border-radius: 15px; transition: transform 0.3s; cursor: default;"
                        onmouseover="this.style.transform='translateY(-5px)'"
                        onmouseout="this.style.transform='translateY(0)'">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <div class="icon-wrapper mb-4"
                                    style="width: 80px; height: 80px; background: var(--light-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                    <i class="fas fa-bullseye"
                                        style="font-size: 2.5rem; color: var(--primary-color);"></i>
                                </div>
                                <h3 class="font-weight-bold" style="color: var(--dark-color); font-weight: 700;">Misi
                                </h3>
                            </div>
                            <div class="misi-content" style="color: var(--text-dark); line-height: 1.8;">
                                @if($profile && $profile->mission)
                                    {!! nl2br(e($profile->mission)) !!}
                                @else
                                    <ul class="list-group list-group-flush mt-3" style="border-top: none;">
                                        <li class="list-group-item d-flex align-items-start" style="border: none; padding: 0.75rem 0;">
                                            <i class="fas fa-check-circle mt-1 me-3" style="color: var(--primary-color); font-size: 1.25rem;"></i>
                                            <span>Meningkatkan tata kelola pemerintahan desa yang profesional, transparan, dan akuntabel.</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-start" style="border: none; padding: 0.75rem 0;">
                                            <i class="fas fa-check-circle mt-1 me-3" style="color: var(--primary-color); font-size: 1.25rem;"></i>
                                            <span>Mengembangkan potensi ekonomi desa melalui pemberdayaan UMKM, pertanian, dan pariwisata.</span>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(0,0,0,0.1); margin: 3rem 0;">

            <!-- Sejarah Section -->
            <div class="row align-items-center mb-5 pb-4">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="position-relative">
                        <img src="{{ !empty($profile->village_image) ? asset('storage/' . $profile->village_image) : "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 600 450'%3E%3Crect fill='%23d8f3dc' width='600' height='450' rx='20'/%3E%3Cpath fill='%2352b788' d='M0,450 L0,250 C100,200 200,350 300,250 C400,150 500,280 600,200 L600,450 Z'/%3E%3Cpath fill='%232d8659' opacity='0.5' d='M0,450 L0,300 C150,250 250,400 400,300 C500,250 550,300 600,280 L600,450 Z'/%3E%3Ccircle cx='120' cy='150' r='50' fill='%232d8659' opacity='0.3'/%3E%3C/svg%3E" }}"
                            alt="Sejarah Desa" class="img-fluid rounded shadow-lg" style="border-radius: 20px;">
                        <div class="position-absolute bg-white px-4 py-3 shadow"
                            style="bottom: -20px; right: 20px; border-radius: 15px; border-left: 5px solid var(--primary-color);">
                            <h4 class="mb-0 text-dark" style="font-weight: 700;">Sejak 1945</h4>
                            <small class="text-muted">Berdiri dan Melayani</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h2 style="color: var(--dark-color); font-weight: 700; margin-bottom: 1.5rem; font-size: 2.5rem;">
                        Sejarah Singkat Desa {{ $profile->village_name ?? 'Sukorejo' }}</h2>
                    <div style="color: var(--text-dark); line-height: 1.8;">
                        @if($profile && $profile->history)
                            {!! nl2br(e($profile->history)) !!}
                        @else
                            <p>Desa kami telah berdiri sejak masa kemerdekaan, berawal dari sebuah perkampungan kecil yang mayoritas penduduknya berprofesi sebagai petani. Seiring berjalannya waktu, desa ini mengalami berbagai perkembangan signifikan.</p>
                        @endif
                    </div>
                </div>
            </div>

            <hr style="border-color: rgba(0,0,0,0.1); margin: 3rem 0;">

            <!-- Struktur Organisasi Section -->
            <div class="row pt-4">
                <div class="col-12 section-title">
                    <h2>Struktur Organisasi</h2>
                    <p>Bagan susunan pemerintahan desa yang bertugas melayani masyarakat</p>
                </div>
                <div class="col-12 text-center">
                    <div class="card shadow border-0" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-body p-5 bg-light">
                            @if($profile && $profile->org_chart_image)
                                <img src="{{ asset('storage/' . $profile->org_chart_image) }}" alt="Struktur Organisasi" class="img-fluid w-100 rounded">
                            @else
                                <img src="https://placehold.co/1000x500?text=Struktur+Organisasi"
                                    alt="Struktur Organisasi" class="img-fluid w-100 rounded">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
