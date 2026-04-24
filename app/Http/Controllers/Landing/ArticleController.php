<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    /**
     * Tampilkan daftar semua berita (dengan pagination).
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('name', 'asc')->get();

        $query = Article::with(['category', 'user'])
            ->where('is_published', true);

        // Filter berdasarkan kategori jika ada
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $articles = $query->latest('published_at')->paginate(6);

        if ($request->ajax()) {
            return view('landing.partials.article-items', compact('articles'))->render();
        }

        return view('landing.article.index', compact('articles', 'categories'));
    }

    /**
     * Tampilkan detail berita spesifik.
     */
    public function show($slug)
    {
        // Eager load relasi saat mencari artikel
        $article = Article::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Ambil berita terbaru untuk sidebar
        $recentArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('landing.article.show-article', compact('article', 'recentArticles'));
    }
}
