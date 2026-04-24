# Analisis Kebutuhan Data (Database Migrations)

Berdasarkan dokumen `PRD SEDERHANA.md` dan struktur halaman frontend yang telah dibangun, berikut adalah spesifikasi database yang dibutuhkan untuk membangun backend menggunakan Laravel. Spesifikasi ini dirancang untuk memastikan semua fitur (Berita, Agenda, Galeri, Transparansi, Unduhan, dan Profil Desa) dapat diakomodasi dengan baik.

## 1. Tabel `users` (Administrator)
Digunakan untuk mengelola akun admin yang dapat masuk ke panel FilamentPHP.

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID unik admin |
| `name` | String | Not Null | Nama lengkap admin |
| `email` | String | Unique, Not Null | Email untuk login |
| `password` | String | Not Null | Hash password |
| `remember_token` | String | Nullable | Token untuk "Remember Me" |
| `created_at`, `updated_at` | Timestamp | - | Waktu pembuatan & update data |

## 2. Tabel `sliders` (Hero Section)
Menyimpan data banner/foto slider di halaman utama.

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID unik slider |
| `title` | String | Not Null | Judul singkat slider |
| `description` | Text | Nullable | Deskripsi opsional |
| `image_path` | String | Not Null | Lokasi file gambar |
| `is_active` | Boolean | Default: true | Status tayang slider |
| `order` | Integer | Default: 0 | Urutan tampilan |
| `created_at`, `updated_at` | Timestamp | - | - |

## 3. Tabel `profiles` (Data Tunggal Profil Desa)
Menyimpan konfigurasi utama desa seperti statistik, sambutan kades, visi-misi, sejarah, dan struktur organisasi. Tabel ini umumnya hanya berisi 1 baris data (Singleton).

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID profil |
| `village_name` | String | Not Null | Nama desa (ex: Sukorejo) |
| `head_of_village_name`| String | Nullable | Nama Kepala Desa |
| `head_of_village_msg` | Text | Nullable | Teks sambutan Kades |
| `head_of_village_img` | String | Nullable | Foto Kepala Desa |
| `population` | Integer | Default: 0 | Jumlah penduduk (Statistik) |
| `area_size` | String | Nullable | Luas wilayah (ex: "12.5 km2") |
| `hamlet_count` | Integer | Default: 0 | Jumlah dusun (Statistik) |
| `vision` | Text | Nullable | Teks visi desa |
| `mission` | Text | Nullable | Teks misi desa |
| `history` | Text | Nullable | Sejarah singkat desa |
| `org_chart_image` | String | Nullable | Gambar struktur organisasi |
| `created_at`, `updated_at` | Timestamp | - | - |

## 4. Tabel `categories` (Kategori Berita)
Menyimpan kategori untuk berita/artikel.

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID unik kategori |
| `name` | String | Not Null | Nama kategori (ex: Kesehatan) |
| `slug` | String | Unique, Not Null | URL ramah SEO |
| `created_at`, `updated_at` | Timestamp | - | - |

## 5. Tabel `articles` (Berita / Blog)
Menyimpan postingan berita desa. Memiliki relasi ke tabel `categories` dan `users`.

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID unik artikel |
| `user_id` | BigInt / UUID | Foreign Key | Relasi ke `users` (Penulis) |
| `category_id` | BigInt / UUID | Foreign Key | Relasi ke `categories` |
| `title` | String | Not Null | Judul berita |
| `slug` | String | Unique, Not Null | URL unik untuk detail berita |
| `content` | Text | Not Null | Isi lengkap berita (Rich text) |
| `image_path` | String | Nullable | Cover/Thumbnail berita |
| `is_published` | Boolean | Default: false | Status publikasi berita |
| `published_at` | Timestamp | Nullable | Tanggal berita diterbitkan |
| `created_at`, `updated_at` | Timestamp | - | - |

## 6. Tabel `agendas` (Kegiatan Desa)
Menyimpan informasi kegiatan atau acara desa yang akan datang.

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID unik agenda |
| `title` | String | Not Null | Nama kegiatan/acara |
| `description` | Text | Nullable | Deskripsi atau rincian acara |
| `event_date` | DateTime | Not Null | Waktu pelaksanaan kegiatan |
| `location` | String | Nullable | Tempat pelaksanaan |
| `created_at`, `updated_at` | Timestamp | - | - |

## 7. Tabel `galleries` (Dokumentasi Kegiatan)
Menyimpan album atau foto kegiatan yang ditampilkan di halaman Galeri.

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID unik galeri |
| `title` | String | Not Null | Keterangan/Judul foto |
| `image_path` | String | Not Null | Lokasi file foto |
| `date_taken` | Date | Nullable | Tanggal momen tersebut |
| `created_at`, `updated_at` | Timestamp | - | - |

## 8. Tabel `finances` (Transparansi APBDes)
Menyimpan data ringkasan Anggaran Pendapatan dan Belanja Desa (APBDes) yang diinput secara manual.

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID unik data keuangan |
| `year` | Integer | Not Null | Tahun anggaran (ex: 2026) |
| `type` | Enum | Not Null | `income` (Pendapatan), `expense` (Belanja), `financing` (Pembiayaan) |
| `title` | String | Not Null | Uraian (ex: Dana Desa, Bidang Pembangunan) |
| `budget_amount` | Decimal / BigInt | Default: 0 | Jumlah Anggaran (Rupiah) |
| `realized_amount` | Decimal / BigInt | Default: 0 | Jumlah Realisasi (Rupiah) |
| `created_at`, `updated_at` | Timestamp | - | - |

## 9. Tabel `document_categories` (Kategori Unduhan)
*(Opsional namun direkomendasikan untuk kerapian data dokumen)*

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID unik kategori dokumen |
| `name` | String | Not Null | Nama kategori (ex: Form Layanan) |
| `created_at`, `updated_at` | Timestamp | - | - |

## 10. Tabel `documents` (Pusat Unduhan)
Menyimpan file yang dapat diunduh publik (PDF, Word, Excel).

| Nama Kolom | Tipe Data | Batasan (Constraint) | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt / UUID | Primary Key | ID unik dokumen |
| `document_category_id`| BigInt / UUID | Foreign Key, Nullable | Relasi ke `document_categories` |
| `title` | String | Not Null | Nama formulir/dokumen |
| `description` | Text | Nullable | Penjelasan singkat isi dokumen |
| `file_path` | String | Not Null | Lokasi path file yang diunggah |
| `file_extension` | String | Nullable | Format file (pdf, docx, xlsx) |
| `file_size` | Integer | Nullable | Ukuran file dalam KB/Bytes |
| `created_at`, `updated_at` | Timestamp | - | - |

---

## 3. Relasi Antar Tabel (Relationships)

Berikut adalah pendefinisian relasi di tingkat Model/Database (Mewakili Foreign Key constraints):

1.  **`users` ke `articles`** (One-to-Many)
    *   Satu **User** (Admin) dapat menulis banyak **Articles** (Berita).
    *   Setiap **Article** dimiliki secara spesifik oleh satu **User**.
2.  **`categories` ke `articles`** (One-to-Many)
    *   Satu **Category** dapat mencakup banyak **Articles**.
    *   Setiap **Article** termasuk dalam satu **Category** utama.
3.  **`document_categories` ke `documents`** (One-to-Many)
    *   Satu **Document Category** memiliki banyak **Documents**.
    *   Setiap **Document** masuk ke dalam satu **Document Category**.

*Catatan: Modul lain seperti Sliders, Profil, Agenda, Galeri, dan APBDes berdiri secara independen tanpa relasi yang kompleks untuk menyederhanakan arsitektur database, sesuai standar "Non-Kompleks" pada PRD.*
