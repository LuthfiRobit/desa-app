<!-- Hero Section -->
<section id="beranda" class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 hero-content">
                @if(isset($profile) && isset($profile->village_name))
                    <h1>Selamat Datang di Portal Digital Desa {{ $profile->village_name }}</h1>
                    <p>Pusat informasi dan layanan digital resmi Desa {{ $profile->village_name }}, Kecamatan Kotaanyar, Kabupaten Probolinggo. 
                        Wujudkan tata kelola desa yang transparan dan akuntabel!</p>
                @else
                    <h1>Selamat Datang di Portal Digital Desa Sukorejo</h1>
                    <p>Pusat informasi dan layanan digital resmi Desa Sukorejo, Kecamatan Kotaanyar, Kabupaten Probolinggo. 
                        Wujudkan tata kelola desa yang transparan dan akuntabel!</p>
                @endif
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
