<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5><i class="fas fa-landmark me-2"></i>Desa Sukorejo</h5>
                <p>Portal digital resmi Desa Sukorejo, Kecamatan Kotaanyar, Kabupaten Probolinggo. Memberikan pelayanan terbaik untuk masyarakat.
                </p>
                <div class="social-links">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h5>Menu</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}#beranda"><i class="fas fa-chevron-right"></i>Beranda</a></li>
                    <li><a href="{{ url('/') }}#layanan"><i class="fas fa-chevron-right"></i>Layanan</a></li>
                    <li><a href="{{ url('/') }}#berita"><i class="fas fa-chevron-right"></i>Berita</a></li>
                    <li><a href="{{ url('profil-desa') }}"><i class="fas fa-chevron-right"></i>Profil Desa</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5>Layanan</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('unduhan') }}"><i class="fas fa-chevron-right"></i>Pusat Unduhan</a></li>
                    <li><a href="{{ url('transparansi') }}"><i class="fas fa-chevron-right"></i>Transparansi Keuangan</a>
                    </li>
                    <li><a href="{{ url('galeri') }}"><i class="fas fa-chevron-right"></i>Galeri Kegiatan</a></li>
                    <li><a href="{{ url('agenda') }}"><i class="fas fa-chevron-right"></i>Agenda Desa</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5>Kontak Kami</h5>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Raya Kotaanyar, Desa Sukorejo, Kec. Kotaanyar</li>
                    <li><i class="fas fa-phone"></i> (0335) 123-4567</li>
                    <li><i class="fas fa-envelope"></i> info@sukorejo-probolinggo.desa.id</li>
                    <li><i class="fas fa-clock"></i> Senin - Jumat: 08.00 - 15.00</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Desa Sukorejo, Probolinggo. All Rights Reserved. | Built with <i
                    class="fas fa-heart text-danger"></i> for the Community</p>
        </div>
    </div>
</footer>
