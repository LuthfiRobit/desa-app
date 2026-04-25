@extends('landing.layouts.app')

@section('title', 'Desa Sukorejo - Portal Desa Digital')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/index.css') }}">
@endpush

@section('content')
    <!-- Hero Section -->
    <section id="beranda" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 hero-content">
                    <h1>Selamat Datang di Portal Digital Desa {{ $profile->village_name ?? 'Sukorejo' }}</h1>
                    <p>Pusat informasi dan layanan digital resmi Desa {{ $profile->village_name ?? 'Sukorejo' }}, Kecamatan
                        Kotaanyar, Kabupaten Probolinggo.
                        Wujudkan tata kelola desa yang transparan dan akuntabel!</p>
                    <div>
                        <a href="#layanan" class="btn btn-hero btn-hero-primary">
                            <i class="fas fa-rocket me-2"></i>Jelajahi Layanan
                        </a>
                        <a href="#berita" class="btn btn-hero btn-hero-outline">
                            <i class="fas fa-newspaper me-2"></i>Berita Terbaru
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 hero-illustration d-none d-lg-block">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
    </section>
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                @if(isset($profile))
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="fas fa-users"></i>
                            <h3>{{ number_format($profile->population, 0, ',', '.') }}</h3>
                            <p>Total Penduduk</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="fas fa-map-marked-alt"></i>
                            <h3>{{ $profile->area_size }}</h3>
                            <p>Luas Wilayah</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="fas fa-home"></i>
                            <h3>{{ $profile->hamlet_count }} Dusun</h3>
                            <p>Jumlah Dusun</p>
                        </div>
                    </div>
                @else
                    <div class="col-12 text-center">
                        <p>Data statistik belum tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Welcome Section (Sambutan Kepala Desa) -->
    <section id="profil" class="section pb-0">
        <div class="container">
            <div class="welcome-section"
                style="box-shadow: 0 15px 40px rgba(45, 134, 89, 0.1); margin-top: -30px; border: 1px solid rgba(45, 134, 89, 0.1);">
                <div class="row align-items-center">
                    <div class="col-lg-4 mb-4 mb-lg-0 text-center">
                        <div class="welcome-image d-inline-block"
                            style="border: 5px solid white; box-shadow: 0 10px 20px rgba(0,0,0,0.15);">
                            <img src="{{ (!empty($profile->head_of_village_img) && Storage::disk('public')->exists($profile->head_of_village_img)) ? asset('storage/' . $profile->head_of_village_img) : 'https://placehold.co/300x400?text=' . urlencode($profile->head_of_village_name ?? 'Kepala Desa') }}"
                                alt="Kepala Desa">
                        </div>
                    </div>
                    <div class="col-lg-8 ps-lg-4">
                        <div class="welcome-content">
                            <h3 style="font-size: 2.2rem; color: var(--dark-color);">Sambutan Kepala Desa</h3>
                            <span class="author"
                                style="color: var(--primary-color); font-size: 1.2rem; display: inline-block; margin-bottom: 1.5rem; font-weight: 600; border-bottom: 2px solid var(--accent-color); padding-bottom: 5px;">{{ $profile->head_of_village_name ?? 'H. Ahmad Santoso, S.Sos' }}</span>
                            @if(isset($profile) && $profile->head_of_village_msg)
                                <div style="font-size: 1.05rem; line-height: 1.8; color: var(--text-dark);">
                                    {!! $profile->head_of_village_msg !!}
                                </div>
                            @else
                                <p style="font-size: 1.05rem; line-height: 1.8; color: var(--text-dark);">Assalamu'alaikum
                                    Warahmatullahi Wabarakatuh.<br>Selamat datang di website resmi Desa Sukorejo. Kami hadirkan
                                    portal ini sebagai sarana informasi dan pelayanan publik yang lebih modern dan transparan
                                    bagi seluruh warga.</p>
                                <p style="font-size: 1.05rem; line-height: 1.8; color: var(--text-dark);">Melalui platform ini,
                                    kami berharap transparansi dan akuntabilitas pemerintahan desa semakin meningkat. Setiap
                                    warga dapat dengan mudah mengakses informasi, mengunduh dokumen, dan memantau kinerja secara
                                    <em>real-time</em>.
                                </p>
                            @endif
                            <a href="{{ url('profil-desa') }}" class="btn mt-3"
                                style="background-color: var(--primary-color); color: white; border-radius: 25px; padding: 0.6rem 1.5rem; font-weight: 500; transition: all 0.3s;"
                                onmouseover="this.style.backgroundColor='var(--dark-color)'"
                                onmouseout="this.style.backgroundColor='var(--primary-color)'">Profil Lengkap Desa <i
                                    class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Kami</h2>
                <p>Berbagai layanan digital yang memudahkan warga dalam mengakses informasi dan dokumen penting</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('unduhan') }}" class="service-card text-decoration-none d-block">
                        <div class="service-icon">
                            <i class="fas fa-file-download"></i>
                        </div>
                        <h4>Pusat Unduhan</h4>
                        <p>Download formulir dan dokumen penting seperti permohonan KTP, surat pengantar, dan berbagai
                            form administrasi lainnya</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('berita') }}" class="service-card text-decoration-none d-block">
                        <div class="service-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h4>Informasi & Berita</h4>
                        <p>Dapatkan update terbaru tentang kegiatan, agenda, dan perkembangan desa secara real-time dan
                            transparan</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('transparansi') }}" class="service-card text-decoration-none d-block">
                        <div class="service-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h4>Transparansi Keuangan</h4>
                        <p>Pantau realisasi APBDes melalui grafik dan laporan yang mudah dipahami untuk akuntabilitas
                            pengelolaan keuangan</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('galeri') }}" class="service-card text-decoration-none d-block">
                        <div class="service-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <h4>Galeri Kegiatan</h4>
                        <p>Lihat dokumentasi foto-foto kegiatan dan acara desa untuk tetap terhubung dengan perkembangan
                            masyarakat</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('agenda') }}" class="service-card text-decoration-none d-block">
                        <div class="service-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h4>Agenda Desa</h4>
                        <p>Informasi lengkap tentang jadwal kegiatan dan acara desa yang akan datang agar tidak
                            terlewatkan</p>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('profil-desa') }}" class="service-card text-decoration-none d-block">
                        <div class="service-icon">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <h4>Profil Desa</h4>
                        <p>Pelajari visi-misi, sejarah, dan struktur organisasi pemerintahan desa secara lengkap dan
                            detail</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="berita" class="section" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="section-title">
                <h2>Berita Terbaru</h2>
                <p>Ikuti perkembangan dan informasi terkini dari desa kami</p>
            </div>
            <div class="row g-4">
                @forelse($articles ?? [] as $article)
                    <div class="col-lg-4 col-md-6">
                        <div class="news-card">
                            <div class="news-image">
                                <img src="{{ (!empty($article->image_path) && Storage::disk('public')->exists($article->image_path)) ? asset('storage/' . $article->image_path) : 'https://placehold.co/600x400?text=' . urlencode($article->title) }}"
                                    alt="{{ $article->title }}">
                                <span class="news-badge">{{ $article->category->name ?? 'Umum' }}</span>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <span><i
                                            class="far fa-calendar"></i>{{ isset($article->published_at) ? $article->published_at->format('d M Y') : '-' }}</span>
                                    <span><i class="far fa-user"></i>{{ $article->user->name ?? 'Admin Desa' }}</span>
                                </div>
                                <h5>{{ $article->title }}</h5>
                                <p>{{ Str::limit(strip_tags($article->content), 100) }}</p>
                                <a href="{{ url('artikel/' . $article->slug) }}" class="btn-read-more">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper fa-4x text-muted mb-3 opacity-50"></i>
                        <p class="text-muted mb-0">Belum ada berita yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-5">
                <a href="{{ url('berita') }}" class="btn btn-hero-primary"
                    style="background-color: var(--primary-color); color: white; border: 2px solid var(--primary-color);">
                    <i class="fas fa-th-list me-2"></i>Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>

    <!-- Lokasi Desa / Maps Section -->
    <section id="lokasi" class="section pt-0 pb-5">
        <div class="container">
            <div class="section-title mb-5">
                <h2>Lokasi Desa</h2>
                <p>Kunjungi kantor desa kami untuk layanan administrasi tatap muka</p>
            </div>
            <div class="map-container"
                style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); height: 450px; border: 5px solid white;">
                <!-- Menggunakan dummy map embed Bandung sebagai placeholder -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14211.833088501262!2d113.53143413643244!3d-7.755860070884327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd702e564380247%3A0x9add9170245cc05a!2sSukorejo%2C%20Kotaanyar%2C%20Probolinggo%20Regency%2C%20East%20Java!5e0!3m2!1sen!2sid!4v1776969342083!5m2!1sen!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
@endsection