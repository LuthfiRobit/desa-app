Product Requirements Document (PRD): Website Portal & Transparansi Desa
1. Ringkasan Proyek
Membangun platform digital sebagai media informasi resmi, transparansi publik, dan pusat unduhan dokumen untuk meningkatkan kualitas layanan informasi desa.
2. Tech Stack & Infrastruktur
Framework: Laravel (v10/11).
Database: MySQL.
Admin Panel: FilamentPHP (Direkomendasikan untuk percepatan CRUD).
Domain: .desa.id.
Hosting: Shared Hosting (Min. 2GB SSD).
3. Fitur Utama (Scope)
A. Fitur Publik (Frontend)
Beranda (Landing Page):
Slider Hero (Foto kegiatan desa).
Widget Statistik Singkat (Jumlah penduduk, luas wilayah, jumlah dusun).
Highlight Berita Terbaru.
Sambutan Kepala Desa.
Profil Desa:
Halaman Visi & Misi.
Halaman Sejarah Desa.
Struktur Organisasi (Tampilan bagan statis/gambar).
Pusat Informasi:
Blog/Berita: Daftar kategori berita dan detail berita.
Agenda: Daftar kegiatan desa mendatang.
Galeri: Foto-foto dokumentasi kegiatan.
Transparansi Keuangan:
Halaman grafik batang/pie untuk realisasi APBDes (Data diinput manual oleh admin).
Pusat Unduhan (Middle Ground):
Daftar dokumen publik (PDF/Doc) yang bisa diunduh warga (Contoh: Form Permohonan KTP, Form Surat Pengantar).
B. Fitur Admin (Backend)
Dashboard: Ringkasan jumlah postingan dan statistik kunjungan sederhana.
Manajemen Konten: CRUD untuk Berita, Agenda, Galeri, dan Slider.
Manajemen Profil: Edit teks Visi-Misi, Sejarah, dan Upload Bagan Organisasi.
Manajemen Dokumen: Upload dan kelola file formulir untuk diunduh warga.
Input Data Transparansi: Form sederhana untuk memasukkan angka pendapatan dan pengeluaran desa.
Pengaturan User: Kelola akun admin (Ganti password & profil).
4. User Journey (Non-Kompleks)
Warga buka web -> Pilih menu Unduhan -> Cari formulir yang dibutuhkan -> Download -> Isi manual di rumah.
Warga ingin tahu anggaran -> Klik menu Transparansi -> Lihat grafik APBDes tahun berjalan.
Admin masuk login -> Pilih menu Berita -> Isi judul, konten, upload foto -> Publish.
5. Estimasi Jadwal Pengerjaan (Target 10 Hari)
Hari 1-2: Setup Project, Database Schema, & Admin Panel (Filament).
Hari 3-6: Slicing Frontend (Tailwind/Bootstrap) & Integrasi CMS.
Hari 7-8: Pengisian Data Dummy, Testing Bug, & Optimasi Mobile.
Hari 9: Deployment ke Hosting & Konfigurasi Domain .desa.id.
Hari 10: Pelatihan Operator (Satu kali sesi).
6. Keluar dari Scope (Out of Scope)
Sistem Generator Surat Otomatis (PDF Generator).
Sistem Login Warga.
Integrasi Pembayaran Pajak Online (PBB).
E-commerce/Lapak Desa.