@extends('landing.layouts.app')

@section('title', $article->title . ' - Desa Sukorejo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/detail-berita.css') }}">
@endpush

@section('content')
    <header class="sub-hero">
        <div class="container sub-hero-content">
            <h1>Berita & Artikel</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">{{ $article->title }}</li>
                </ol>
            </nav>
        </div>
    </header>

    <main class="py-5 mt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article>
                        <div class="article-header">
                            <span class="badge bg-success mb-3 px-3 py-2"
                                style="background-color: var(--primary-color) !important;">{{ $article->category->name ?? 'Umum' }}</span>
                            <h1 class="article-title">{{ $article->title }}</h1>
                            <div class="article-meta">
                                <span><i class="far fa-calendar"></i>
                                    {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</span>
                                <span><i class="far fa-user"></i> {{ $article->user->name ?? 'Admin Desa' }}</span>
                                <span><i class="far fa-folder"></i> {{ $article->category->name ?? 'Berita' }}</span>
                            </div>
                        </div>

                        <img src="{{ !empty($article->image_path) && Storage::disk('public')->exists($article->image_path) ? asset('storage/' . $article->image_path) : 'https://placehold.co/800x450?text=' . urlencode($article->title) }}"
                            alt="{{ $article->title }}" class="article-img-main">

                        <div class="article-content">
                            {!! nl2br($article->content) !!}
                        </div>
                    </article>

                    <div class="mt-5">
                        <a href="{{ route('articles.index') }}" class="btn btn-outline-success rounded-pill px-4">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Berita
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="sidebar-widget">
                        <h4 class="sidebar-title">Berita Terbaru</h4>

                        @foreach($recentArticles as $recent)
                            <div class="recent-post">
                                <img src="{{ !empty($recent->image_path) && Storage::disk('public')->exists($recent->image_path) ? asset('storage/' . $recent->image_path) : 'https://placehold.co/100x100?text=' . urlencode('Berita') }}"
                                    alt="{{ $recent->title }}" class="recent-post-img">
                                <div>
                                    <a href="{{ route('articles.show', $recent->slug) }}"
                                        class="recent-post-title">{{ $recent->title }}</a>
                                    <span class="recent-post-date"><i class="far fa-clock me-1"></i>
                                        {{ $recent->published_at ? $recent->published_at->format('d M Y') : '-' }}</span>
                                </div>
                            </div>
                        @endforeach

                        @if($recentArticles->isEmpty())
                            <p class="text-muted small">Tidak ada berita terbaru lainnya.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection