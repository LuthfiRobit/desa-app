<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-landmark"></i>
            <span>Desa Sukorejo</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}#beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}#layanan">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('berita') }}">Berita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('profil-desa') }}">Profil Desa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('transparansi') }}">Transparansi</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
