# Arsitektur Authentication & User Management (Laravel 12)

Dokumen ini merinci arsitektur keamanan dan manajemen pengguna untuk portal Desa Sukorejo, dirancang secara kustom (tanpa Filament) berdasarkan kebutuhan PRD dan analisis tampilan administrasi.

## 1. High-Level Architecture

Sistem autentikasi dibangun secara kustom menggunakan pendekatan **Session-based Authentication** dengan standar Laravel, dipadukan dengan **Role-Based Access Control (RBAC)** untuk hierarki admin.

*   **Guard Utama**: `web` guard standar Laravel untuk autentikasi backend web.
*   **RBAC System**: Menggunakan package Spatie `laravel-permission` untuk pemisahan peran (Superadmin & Editor) secara dinamis.
*   **Custom Controllers**: Pengelolaan logika login, profil, dan manajemen pengguna menggunakan Controller khusus (`AuthController`, `ProfileController`, `UserController`) yang dihubungkan langsung ke *template* Blade (dari HTML yang disediakan).
*   **Rate Limiting**: Pembatasan percobaan login (maksimal 5 kali gagal dalam 1 menit) untuk mencegah serangan *Brute-force* / pencurian password.

### Alur Keamanan (Security Flow)
1. User memasukkan email dan password di halaman Login.
2. Middleware *Rate Limiter* memeriksa jumlah percobaan. Jika melebihi batas, akses ditahan sementara (Lockout).
3. Jika kredensial valid, *session* dibuat dan user diarahkan ke Dashboard.
4. Middleware `auth` dan RBAC (dari Spatie) mengecek hak akses setiap kali user berpindah halaman menu.

---

## 2. Database Schema (Migrations)

Kita akan memodifikasi tabel `users` bawaan Laravel dengan menghapus kolom verifikasi email dan menambahkan kolom status, serta mengintegrasikan tabel dari Spatie Permission.

### A. Tabel `users` (Modifikasi)
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    // Kolom untuk melacak status aktif/nonaktif akun (bisa dicegah login jika dinonaktifkan)
    $table->boolean('is_active')->default(true);
    
    $table->rememberToken();
    $table->timestamps();
});
```

### B. Tabel RBAC (Spatie Permission)
Otomatis di-generate oleh package Spatie, terdiri dari:
*   `roles` (id, name, guard_name) -> Data: 'Superadmin', 'Editor'
*   `permissions` (id, name, guard_name)
*   `model_has_roles`, `role_has_permissions`, `model_has_permissions`

---

## 3. Step-by-Step Implementation

Berikut adalah urutan teknis (Task Plan) untuk mengimplementasikan arsitektur ini ke dalam proyek.

### Langkah 1: Instalasi & Konfigurasi Package
```bash
# Install Spatie Permission untuk RBAC
composer require spatie/laravel-permission
```

### Langkah 2: Setup Database, Model & Seeder
1.  Hapus kolom `email_verified_at` di migration `users` bawaan Laravel.
2.  Jalankan `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`.
3.  Tambahkan trait `HasRoles` ke model `User`.
4.  Buat seeder `RoleAndPermissionSeeder` untuk men-generate role 'Superadmin' dan 'Editor', serta 1 akun 'Superadmin' default.

### Langkah 3: Konfigurasi Auth & Keamanan (Rate Limiting)
1.  Modifikasi `app/Providers/AppServiceProvider.php` untuk mendefinisikan Rate Limiter pada autentikasi:
```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('login', function ($request) {
    return Limit::perMinute(5)->by($request->email.$request->ip());
});
```
2.  Buat `AuthController` untuk menangani proses `login` dan `logout` dengan implementasi `RateLimiter`.

### Langkah 4: Tampilan Profil & Manajemen Pengguna (Custom MVC)
1.  **Profil**: Buat `ProfileController` untuk menangani halaman profil (`profil.html`). Buat method untuk mengubah data diri dan mengganti password.
2.  **Manajemen Pengguna**: Buat `UserController` dengan resource (index, store, update, destroy). Implementasikan halaman `user-mgmt.html` ke Blade.
3.  **Integrasi RBAC**: Tambahkan *middleware* `role:Superadmin` pada route `UserController` agar Editor tidak bisa mengakses halaman manajemen pengguna.

---

## 4. Security Checklist

Sebelum sistem naik ke tahap produksi (Production), checklist berikut wajib dipenuhi:

- [ ] **Password Hashing**: Menggunakan algoritma `Bcrypt` (Default Laravel).
- [ ] **Rate Limiting**: Uji coba login gagal 6 kali beruntun, pastikan sistem merespon error *throttle*.
- [ ] **Session Fixation**: Pastikan meregenerasi session ID setelah login berhasil (`$request->session()->regenerate()`).
- [ ] **CSRF Protection**: Terpasang `@csrf` pada semua form POST secara manual di Blade template.
- [ ] **RBAC Isolation**: Login sebagai 'Editor' dan pastikan mencoba akses rute untuk mengelola pengguna (`/admin/users`) akan diblokir (403 Forbidden).
- [ ] **XSS Prevention**: Gunakan selalu `{{ }}` di Blade untuk mencetak data user, hindari `{!! !!}` untuk input dari user.

---

## 🚀 Task Plan untuk Eksekusi Kode

Fase implementasi yang akan saya kerjakan selanjutnya:

1.  **Fase 1**: Mengatur Model User, Migration (Tanpa Email Verification), dan Seeder (Roles, Permissions, Akun Admin awal).
2.  **Fase 2**: Membangun `AuthController` kustom untuk sistem Login/Logout yang dilengkapi dengan *Rate Limiting*.
3.  **Fase 3**: Membangun `ProfileController` dan melakukan integrasi Blade `profil.blade.php` (Edit Profil & Ganti Password).
4.  **Fase 4**: Membangun `UserController` dan melakukan integrasi Blade `user-mgmt.blade.php` (CRUD User dengan proteksi Middleware Role).
