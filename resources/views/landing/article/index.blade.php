@extends('landing.layouts.app')

@section('title', 'Berita & Artikel - Desa Sukorejo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/berita.css') }}">
    <style>
        .loader {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .category-pill {
            cursor: pointer;
            border: none;
            background: #f0fdf4;
            color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            margin: 0.25rem;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }
        
        .category-pill.active, .category-pill:hover {
            background: var(--primary-color);
            color: white;
        }
    </style>
@endpush

@section('content')
    <header class="sub-hero">
        <div class="container sub-hero-content text-center">
            <h1>Berita & Artikel</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Berita</li>
                </ol>
            </nav>
        </div>
    </header>

    <main class="section py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center" id="category-filters">
                    <button class="category-pill active" data-category="">Semua</button>
                    @foreach($categories as $category)
                        <button class="category-pill" data-category="{{ $category->slug }}">
                           {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="row g-4 mb-5" id="articles-container">
                @include('landing.partials.article-items', ['articles' => $articles])
            </div>

            <div class="text-center" id="load-more-wrapper">
                @if($articles->hasMorePages())
                    <button id="load-more" class="btn btn-outline-success rounded-pill px-5 py-2 d-inline-flex align-items-center"
                        data-url="{{ route('articles.index') }}" data-page="1">
                        <span>Muat Lebih Banyak</span>
                        <div class="loader" id="btn-loader"></div>
                    </button>
                @endif
            </div>

            <div id="empty-state" class="col-12 text-center py-5 {{ $articles->isEmpty() ? '' : 'd-none' }}">
                <div class="mb-4">
                    <i class="fas fa-newspaper fa-4x text-muted opacity-25"></i>
                </div>
                <h4 class="text-muted">Belum ada berita yang tersedia</h4>
                <p class="text-muted">Silakan periksa kembali nanti atau pilih kategori lain.</p>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        let currentCategory = '';
        let currentPage = 1;
        const container = document.getElementById('articles-container');
        const loadMoreBtn = document.getElementById('load-more');
        const loadMoreWrapper = document.getElementById('load-more-wrapper');
        const emptyState = document.getElementById('empty-state');
        const loader = document.getElementById('btn-loader');

        // Handle Category Filtering
        document.querySelectorAll('.category-pill').forEach(btn => {
            btn.addEventListener('click', function() {
                // Toggle active class
                document.querySelectorAll('.category-pill').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                currentCategory = this.getAttribute('data-category');
                currentPage = 1;
                
                // Show loading state in container
                container.style.opacity = '0.5';
                
                fetchArticles(true);
            });
        });

        // Handle Load More
        loadMoreBtn?.addEventListener('click', function() {
            currentPage++;
            fetchArticles(false);
        });

        function fetchArticles(isNewFilter) {
            const url = `{{ route('articles.index') }}?category=${currentCategory}&page=${currentPage}`;
            
            if (!isNewFilter) {
                loadMoreBtn.disabled = true;
                loader.style.display = 'inline-block';
                loadMoreBtn.querySelector('span').textContent = 'Memuat...';
            }

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.style.opacity = '1';
                
                if (isNewFilter) {
                    container.innerHTML = html;
                    if (html.trim() === '') {
                        emptyState.classList.remove('d-none');
                    } else {
                        emptyState.classList.add('d-none');
                    }
                } else {
                    container.insertAdjacentHTML('beforeend', html);
                }

                // Handle Load More Button Visibility based on marker
                const marker = container.querySelector('#next-page-marker:last-child');
                const hasMore = marker ? marker.getAttribute('data-has-more') === 'true' : false;
                
                // Remove old markers
                container.querySelectorAll('#next-page-marker').forEach(m => m.remove());

                if (!hasMore) {
                    if (loadMoreBtn) loadMoreBtn.classList.add('d-none');
                } else {
                    if (loadMoreBtn) {
                        loadMoreBtn.classList.remove('d-none');
                        loadMoreBtn.disabled = false;
                        loader.style.display = 'none';
                        loadMoreBtn.querySelector('span').textContent = 'Muat Lebih Banyak';
                        loadMoreBtn.setAttribute('data-page', currentPage);
                    } else if (isNewFilter) {
                        loadMoreWrapper.innerHTML = `
                            <button id="load-more" class="btn btn-outline-success rounded-pill px-5 py-2 d-inline-flex align-items-center"
                                data-url="{{ route('articles.index') }}" data-page="${currentPage}">
                                <span>Muat Lebih Banyak</span>
                                <div class="loader" id="btn-loader"></div>
                            </button>
                        `;
                    }
                }
                
                // Re-bind or use delegation for Load More if recreated
                if (isNewFilter) {
                     // Since we didn't recreate the button, just ensure it's hidden if needed
                }
            })
            .catch(error => {
                console.error('Error:', error);
                container.style.opacity = '1';
            });
        }
        
        // Use delegation for load more since it might be added/removed
        document.addEventListener('click', function(e) {
            if (e.target && (e.target.id === 'load-more' || e.target.parentElement.id === 'load-more')) {
                const btn = document.getElementById('load-more');
                if (btn.disabled) return;
                currentPage++;
                fetchArticles(false);
            }
        });
    </script>
@endpush
