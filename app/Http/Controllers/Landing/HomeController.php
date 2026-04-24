<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Profile;
use App\Models\Article;
use App\Models\Agenda;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama landing page.
     */
    public function index()
    {
        // 1. Ambil slider yang aktif dan urutkan
        $sliders = Slider::where('is_active', true)->orderBy('order', 'asc')->get();
        
        // 2. Ambil data profil desa tunggal
        $profile = Profile::first();
        
        // 3. Ambil 3 artikel terbaru dengan Eager Loading untuk 'category' dan 'user'
        $articles = Article::with(['category', 'user'])
                            ->where('is_published', true)
                            ->latest('published_at')
                            ->take(3)
                            ->get();

        // 4. Ambil agenda terdekat (misal: mulai hari ini ke depan)
        $agendas = Agenda::where('event_date', '>=', now()->startOfDay())
                         ->orderBy('event_date', 'asc')
                         ->take(3)
                         ->get();

        // Passing semua data ke view landing.home.index
        return view('landing.home.index', compact('sliders', 'profile', 'articles', 'agendas'));
    }
}
