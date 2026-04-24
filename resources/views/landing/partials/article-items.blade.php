@foreach($articles as $article)
    <div class="col-lg-4 col-md-6 article-item-container">
        <div class="news-card">
            <div class="news-image">
                <img src="{{ !empty($article->image_path) && Storage::disk('public')->exists($article->image_path) ? asset('storage/' . $article->image_path) : 'https://placehold.co/600x400?text=' . urlencode($article->title) }}"
                    alt="{{ $article->title }}">
                <span class="news-badge">{{ $article->category->name ?? 'Umum' }}</span>
            </div>
            <div class="news-content">
                <div class="news-meta">
                    <span><i class="far fa-calendar"></i> {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</span>
                    <span><i class="far fa-user"></i> {{ $article->user->name ?? 'Admin' }}</span>
                </div>
                <h5>{{ $article->title }}</h5>
                <p>{{ Str::limit(strip_tags($article->content), 120) }}</p>
                <a href="{{ route('articles.show', $article->slug) }}" class="btn-read-more">
                    Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
@endforeach

@if($articles->hasMorePages())
    <div id="next-page-marker" data-has-more="true" style="display:none;"></div>
@else
    <div id="next-page-marker" data-has-more="false" style="display:none;"></div>
@endif
