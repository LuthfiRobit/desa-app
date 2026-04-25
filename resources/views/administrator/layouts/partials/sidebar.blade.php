<!-- [ Sidebar ] -->
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
                <div class="d-flex align-items-center gap-2">
                    <div
                        style="width:36px;height:36px;background:linear-gradient(135deg,#2e7d32,#66bb6a);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="ti ti-building-community text-white" style="font-size:20px;"></i>
                    </div>
                    <div>
                        <div class="desa-brand-text">Desa Sukorejo</div>
                        <div class="desa-brand-sub">Panel Administrasi</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <!-- Home -->
                <li class="pc-item pc-caption"><label>Beranda</label></li>
                <li class="pc-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <!-- Manajemen Konten -->
                @can('manage_content')
                <li class="pc-item pc-caption"><label>Manajemen Konten</label></li>
                <li class="pc-item {{ request()->routeIs('admin.berita.kategori.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.berita.kategori.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-tag"></i></span>
                        <span class="pc-mtext">Kategori Berita</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.berita.artikel.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.berita.artikel.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-news"></i></span>
                        <span class="pc-mtext">Berita / Artikel</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.agenda.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.agenda.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                        <span class="pc-mtext">Agenda Desa</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.galeri.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.galeri.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-camera"></i></span>
                        <span class="pc-mtext">Galeri Kegiatan</span>
                    </a>
                </li>

                <!-- Layanan Publik -->
                <li class="pc-item pc-caption"><label>Layanan Publik</label></li>
                <li class="pc-item {{ request()->routeIs('admin.dokumen.kategori.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.dokumen.kategori.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-folder"></i></span>
                        <span class="pc-mtext">Kategori Dokumen</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.dokumen.pusat-unduhan.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.dokumen.pusat-unduhan.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-download"></i></span>
                        <span class="pc-mtext">Pusat Unduhan</span>
                    </a>
                </li>

                <!-- Keuangan -->
                <li class="pc-item pc-caption"><label>Keuangan &amp; Transparansi</label></li>
                <li class="pc-item {{ request()->routeIs('admin.apbdes.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.apbdes.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-cash"></i></span>
                        <span class="pc-mtext">Data APBDes</span>
                    </a>
                </li>
                @endcan

                <!-- Pengaturan -->
                <li class="pc-item pc-caption"><label>Pengaturan Sistem</label></li>
                @can('manage_settings')
                <li class="pc-item {{ request()->routeIs('admin.profildesa.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.profildesa.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-building-community"></i></span>
                        <span class="pc-mtext">Profil &amp; Info Desa</span>
                    </a>
                </li>
                @endcan
                @can('manage_users')
                <li class="pc-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Manajemen Pengguna</span>
                    </a>
                </li>
                @endcan

                <!-- Akun -->
                <li class="pc-item pc-caption"><label>Akun</label></li>
                <li class="pc-item {{ request()->routeIs('admin.profile.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.profile.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user"></i></span>
                        <span class="pc-mtext">Profil Saya</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>