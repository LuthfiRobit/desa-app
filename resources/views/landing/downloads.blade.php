@extends('landing.layouts.app')

@section('title', 'Pusat Unduhan - Desa Sukorejo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/unduhan.css') }}">
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
        
        .category-list .list-group-item {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <!-- Sub-page Hero -->
    <header class="sub-hero">
        <div class="container sub-hero-content">
            <h1>Pusat Unduhan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Unduhan Dokumen</li>
                </ol>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="py-5 mt-3">
        <div class="container">
            <div class="row">
                <!-- Sidebar Kategori -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="category-list">
                        <h5>Kategori Dokumen</h5>
                        <ul class="list-group list-group-flush" id="category-list">
                            <li class="list-group-item {{ !request('category') ? 'active' : '' }}" data-category="">
                                <i class="fas fa-folder-open me-2"></i> Semua Dokumen
                            </li>
                            @foreach ($categories as $category)
                                <li class="list-group-item {{ request('category') == $category->id ? 'active' : '' }}" 
                                    data-category="{{ $category->id }}">
                                    <i class="fas fa-file-alt me-2"></i> {{ $category->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Area Dokumen -->
                <div class="col-lg-9">
                    <!-- Search Box -->
                    <div class="search-box">
                        <input type="text" id="search-input" value="{{ request('search') }}"
                            placeholder="Cari nama dokumen atau formulir (contoh: KTP)...">
                        <button type="button" id="search-button"><i class="fas fa-search"></i></button>
                    </div>

                    <!-- List of Documents -->
                    <div id="documents-container">
                        @include('landing.partials.download-items', ['documents' => $documents])
                    </div>

                    <!-- Load More Button -->
                    <div class="text-center mt-5" id="load-more-wrapper">
                        @if($documents->hasMorePages())
                            <button id="load-more" class="btn btn-outline-success rounded-pill px-5 py-2 d-inline-flex align-items-center">
                                <span>Muat Lebih Banyak</span>
                                <div class="loader" id="btn-loader"></div>
                            </button>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        let currentCategory = '';
        let currentSearch = '';
        let currentPage = 1;
        const container = document.getElementById('documents-container');
        const loadMoreWrapper = document.getElementById('load-more-wrapper');
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');

        // Handle Category Selection
        document.querySelectorAll('#category-list .list-group-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('#category-list .list-group-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                
                currentCategory = this.getAttribute('data-category');
                currentPage = 1;
                fetchDocuments(true);
            });
        });

        // Handle Search
        searchButton.addEventListener('click', function() {
            currentSearch = searchInput.value;
            currentPage = 1;
            fetchDocuments(true);
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                currentSearch = searchInput.value;
                currentPage = 1;
                fetchDocuments(true);
            }
        });

        // Handle Load More (Event Delegation)
        document.addEventListener('click', function(e) {
            if (e.target && (e.target.id === 'load-more' || e.target.parentElement.id === 'load-more')) {
                const btn = document.getElementById('load-more');
                if (btn.disabled) return;
                currentPage++;
                fetchDocuments(false);
            }
        });

        function fetchDocuments(isNewSearch) {
            const url = `{{ route('downloads') }}?category=${currentCategory}&search=${currentSearch}&page=${currentPage}`;
            const btn = document.getElementById('load-more');
            const loader = document.getElementById('btn-loader');

            if (isNewSearch) {
                container.style.opacity = '0.5';
            } else if (btn) {
                btn.disabled = true;
                loader.style.display = 'inline-block';
                btn.querySelector('span').textContent = 'Memuat...';
            }

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.style.opacity = '1';
                
                if (isNewSearch) {
                    container.innerHTML = html;
                } else {
                    container.insertAdjacentHTML('beforeend', html);
                }

                // Handle Load More Button Visibility based on marker
                const marker = container.querySelector('#next-page-marker:last-child');
                const hasMore = marker ? marker.getAttribute('data-has-more') === 'true' : false;
                
                // Remove old markers
                container.querySelectorAll('#next-page-marker').forEach(m => m.remove());

                if (!hasMore) {
                    loadMoreWrapper.innerHTML = '';
                } else {
                    loadMoreWrapper.innerHTML = `
                        <button id="load-more" class="btn btn-outline-success rounded-pill px-5 py-2 d-inline-flex align-items-center">
                            <span>Muat Lebih Banyak</span>
                            <div class="loader" id="btn-loader"></div>
                        </button>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                container.style.opacity = '1';
            });
        }
    </script>
@endpush
