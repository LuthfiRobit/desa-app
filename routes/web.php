<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Landing\ArticleController;
use App\Http\Controllers\Landing\DownloadController;

use App\Http\Controllers\Landing\ProfileController;
use App\Http\Controllers\Landing\TransparencyController;

use App\Http\Controllers\Landing\AgendaController;

use App\Http\Controllers\Landing\GalleryController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/berita', [ArticleController::class, 'index'])->name('articles.index');

Route::get('/unduhan', [DownloadController::class, 'index'])->name('downloads');

Route::get('/profil-desa', [ProfileController::class, 'index'])->name('profile');
Route::get('/transparansi', [TransparencyController::class, 'index'])->name('transparency');

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');
