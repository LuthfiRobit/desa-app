<?php

use Illuminate\Support\Facades\Route;

// Landing Controllers
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Landing\ArticleController; // Menggunakan nama asli untuk Landing
use App\Http\Controllers\Landing\DownloadController;
use App\Http\Controllers\Landing\ProfileController;
use App\Http\Controllers\Landing\TransparencyController;
use App\Http\Controllers\Landing\AgendaController;
use App\Http\Controllers\Landing\GalleryController;

// Administrator Controllers
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\CategoryController;
use App\Http\Controllers\Administrator\ArticleController as AdminArticleController;
use App\Http\Controllers\Administrator\AgendaController as AdminAgendaController;
use App\Http\Controllers\Administrator\GalleryController as AdminGalleryController;
use App\Http\Controllers\Administrator\DocumentCategoryController as AdminDocCategoryController;
use App\Http\Controllers\Administrator\DocumentController as AdminDocumentController;
use App\Http\Controllers\Administrator\ApbdesController as AdminApbdesController;
use App\Http\Controllers\Administrator\ProfileController as AdminProfileController;

// Landing Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/berita', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/unduhan', [DownloadController::class, 'index'])->name('downloads');
Route::get('/profil-desa', [ProfileController::class, 'index'])->name('profile');
Route::get('/transparansi', [TransparencyController::class, 'index'])->name('transparency');
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');

use App\Http\Controllers\AuthController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Administrator Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Konten
    Route::middleware(['can:manage_content'])->group(function () {
        // Berita Group
        Route::prefix('berita')->name('berita.')->group(function () {
            Route::resource('kategori', CategoryController::class)->except(['create', 'show', 'edit']);
            Route::resource('artikel', AdminArticleController::class);
        });

        Route::resource('agenda', AdminAgendaController::class)->except(['create', 'show', 'edit']);
        Route::resource('galeri', AdminGalleryController::class)->except(['create', 'show', 'edit']);
        
        // Dokumen Group
        Route::prefix('dokumen')->name('dokumen.')->group(function () {
            Route::resource('kategori', AdminDocCategoryController::class)->except(['create', 'show', 'edit']);
            Route::resource('pusat-unduhan', AdminDocumentController::class)->except(['create', 'show', 'edit']);
        });
        
        Route::resource('apbdes', AdminApbdesController::class)->except(['create', 'show', 'edit']);
    });

    // Pengaturan Sistem
    Route::middleware(['can:manage_settings'])->group(function () {
        Route::get('profil-desa', [AdminProfileController::class, 'index'])->name('profildesa.index');
        Route::post('profil-desa', [AdminProfileController::class, 'update'])->name('profildesa.update');
    });

    // User Management
    Route::middleware(['can:manage_users'])->group(function () {
        Route::resource('users', \App\Http\Controllers\Administrator\UserController::class)->except(['create', 'show', 'edit']);
        Route::put('users/{user}/reset-password', [\App\Http\Controllers\Administrator\UserController::class, 'resetPassword'])->name('users.reset-password');
    });

    // My Profile Routes
    Route::get('profil', [\App\Http\Controllers\Administrator\MyProfileController::class, 'index'])->name('profile.index');
    Route::post('profil', [\App\Http\Controllers\Administrator\MyProfileController::class, 'update'])->name('profile.update');
    Route::post('profil/password', [\App\Http\Controllers\Administrator\MyProfileController::class, 'updatePassword'])->name('profile.password');
});
