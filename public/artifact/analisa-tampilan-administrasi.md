# Analisis Arsitektur Menu dan Tampilan Dashboard Admin

Berdasarkan `PRD SEDERHANA.md` dan skema database pada `analisa-kebutuhan-data.md`, berikut adalah rancangan arsitektur menu dan detail tampilan fitur administrasi untuk portal desa. Rancangan ini direkomendasikan untuk dibangun menggunakan **FilamentPHP** sesuai dengan tech stack pada PRD.

## 1. Sitemap Menu Admin
Penyusunan menu dikelompokkan secara logis agar alur kerja (user journey) perangkat desa/admin lebih mudah dan intuitif.

*   **Dashboard**
*   **Manajemen Konten** (Group)
    *   Slider Beranda
    *   Kategori Berita
    *   Berita / Artikel
    *   Agenda Desa
    *   Galeri Kegiatan
*   **Layanan Publik** (Group)
    *   Kategori Dokumen
    *   Manajemen Dokumen (Pusat Unduhan)
*   **Keuangan & Transparansi** (Group)
    *   Data APBDes
*   **Pengaturan Sistem** (Group)
    *   Profil & Informasi Desa
    *   Manajemen Pengguna (Admin)

---

## 2. Detail Fitur CRUD Per Menu

### A. Dashboard
*   **Informasi yang Ditampilkan:**
    *   Statistik Widget (Card): Jumlah Berita Publik, Jumlah Agenda Bulan Ini, Jumlah Dokumen Unduhan.
    *   Grafik sederhana statistik kunjungan (jika ada data analytic).
    *   Tabel *Recent Activity*: Menampilkan 5 berita terbaru atau dokumen yang terakhir diunggah.

### B. Profil & Informasi Desa
*Tampilan ini menggunakan halaman pengaturan khusus tunggal (Single Page Form), bukan tabel (Index).*
*   **Form Input (Edit):**
    *   **Identitas & Kades**: Nama Desa, Nama Kepala Desa, Foto Kepala Desa (File Upload), Pesan Sambutan Kades (Textarea).
    *   **Statistik Publik**: Jumlah Penduduk, Luas Wilayah (km2), Jumlah Dusun.
    *   **Narasi Profil**: Visi (Textarea), Misi (Rich Editor), Sejarah Desa (Rich Editor).
    *   **Struktur Organisasi**: Upload Gambar Bagan Organisasi.
*   **Aksi & Kontrol:** Tombol "Simpan Perubahan".

### C. Slider Beranda
*   **Informasi di Tabel (Index):** Gambar Thumbnail, Judul, Status (Tayang/Draft), Urutan.
*   **Aksi & Kontrol:** Cari Judul, Filter Status, Tombol *Reorder* (Geser urutan), Toggle Aktif/Non-aktif, Edit, Hapus.
*   **Form Input (Create/Edit):**
    *   Judul Slider (Text)
    *   Deskripsi Singkat (Textarea - opsional)
    *   Upload Gambar Slider (File Upload, batasan resolusi lanskap)
    *   Status Aktif (Toggle/Switch)
    *   Urutan Tampil (Number)

### D. Kategori Berita & Dokumen (Berlaku Sama)
*   **Informasi di Tabel (Index):** Nama Kategori, Slug (Dibuat otomatis).
*   **Aksi & Kontrol:** Cari Nama, Edit, Hapus.
*   **Form Input (Create/Edit):** Nama Kategori (Text, auto-generate Slug).

### E. Berita / Artikel
*   **Informasi di Tabel (Index):** Thumbnail Gambar, Judul Berita, Kategori, Penulis, Tanggal Rilis, Status Publikasi (Pill Badge: Published/Draft).
*   **Aksi & Kontrol:** Cari Judul, Filter Kategori, Filter Status, Tombol Tinjau (Preview Web), Edit, Hapus.
*   **Form Input (Create/Edit):**
    *   Judul (Text, auto-generate Slug)
    *   Kategori (Dropdown / Select)
    *   Penulis (Hidden/Auto - dari akun login saat ini, atau Dropdown jika bisa ubah penulis)
    *   Cover / Thumbnail (File Upload)
    *   Konten Berita (Rich Text Editor - TinyMCE/Trix)
    *   Status Publikasi (Toggle/Switch)
    *   Tanggal Publikasi (Date Time Picker - *opsional untuk penjadwalan*)

### F. Agenda Desa
*   **Informasi di Tabel (Index):** Judul Agenda, Tanggal & Waktu Pelaksanaan, Lokasi.
*   **Aksi & Kontrol:** Cari Judul, Filter Rentang Tanggal (Bulan ini/Akan datang), Edit, Hapus.
*   **Form Input (Create/Edit):**
    *   Judul Acara (Text)
    *   Deskripsi/Rincian Acara (Textarea)
    *   Tanggal & Waktu (Date Time Picker)
    *   Lokasi/Tempat (Text)

### G. Galeri Kegiatan
*   **Informasi di Tabel (Index):** Thumbnail Foto, Judul Foto, Tanggal Kegiatan.
*   **Aksi & Kontrol:** Cari Judul Foto, Filter Tahun, Edit, Hapus.
*   **Form Input (Create/Edit):**
    *   Judul/Keterangan Foto (Text)
    *   Upload Foto (File Upload)
    *   Tanggal Pengambilan Gambar (Date Picker)

### H. Data APBDes (Transparansi)
*   **Informasi di Tabel (Index):** Tahun Anggaran, Tipe (Pendapatan/Belanja/Pembiayaan), Uraian, Nominal Anggaran (Rp), Nominal Realisasi (Rp), Persentase Ketercapaian (Progress Bar mini).
*   **Aksi & Kontrol:** Cari Uraian, Filter Tahun Anggaran, Filter Tipe Keuangan, Edit, Hapus.
*   **Form Input (Create/Edit):**
    *   Tahun Anggaran (Number / Dropdown)
    *   Tipe Anggaran (Select: Pendapatan, Belanja, Pembiayaan)
    *   Uraian (Text, misal: "Dana Desa" atau "Pembangunan Jalan")
    *   Jumlah Anggaran (Number dengan format Rupiah)
    *   Jumlah Realisasi (Number dengan format Rupiah)

### I. Manajemen Dokumen (Pusat Unduhan)
*   **Informasi di Tabel (Index):** Nama Dokumen, Kategori, Format (Icon PDF/Word), Ukuran File, Tanggal Update.
*   **Aksi & Kontrol:** Cari Dokumen, Filter Kategori, Tombol Download File, Edit, Hapus.
*   **Form Input (Create/Edit):**
    *   Judul/Nama Formulir (Text)
    *   Kategori Dokumen (Select)
    *   Deskripsi Singkat (Textarea - opsional)
    *   Upload File (File Upload, batasan ektensi: pdf, doc, docx, xls, xlsx)

### J. Manajemen Pengguna (Admin)
*   **Informasi di Tabel (Index):** Nama Pengguna, Alamat Email, Peran (Jika diterapkan).
*   **Aksi & Kontrol:** Cari Nama, Reset Password, Edit, Hapus (Tidak bisa menghapus akun sendiri).
*   **Form Input (Create/Edit):**
    *   Nama Lengkap (Text)
    *   Alamat Email (Email)
    *   Kata Sandi (Password input) & Konfirmasi Kata Sandi

---

## 3. Rekomendasi Hak Akses (Role/Permissions)

Pada `PRD SEDERHANA.md` tidak disebutkan spesifik tentang hierarki admin yang kompleks (hanya tertera "Kelola akun admin"). Namun, untuk praktik keamanan terbaik (Best Practice) dalam lingkup portal pemerintahan desa, kami merekomendasikan pembagian **2 Level Hak Akses**:

1.  **Superadmin (Kepala Desa / Sekdes / Admin Utama)**
    *   *Akses Penuh*: Memiliki akses ke seluruh menu di atas tanpa batasan.
    *   *Kewenangan Khusus*: Hanya Superadmin yang boleh mengakses **Pengaturan Sistem** (Manajemen Pengguna untuk membuat admin baru) dan mengedit data **Profil & Informasi Desa**.
2.  **Editor / Perangkat Desa (Staf Operator)**
    *   *Akses Operasional Harian*: Memiliki akses penuh (Create, Read, Update, Delete) ke menu **Manajemen Konten** (Berita, Agenda, Galeri), **Layanan Publik** (Dokumen Unduhan), dan **Transparansi** (APBDes).
    *   *Batasan*: Tidak dapat melihat dan mengubah profil utama desa, tidak dapat menambah atau menghapus pengguna sistem.
