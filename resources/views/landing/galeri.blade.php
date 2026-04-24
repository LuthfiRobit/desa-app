@extends('landing.layouts.app')

@section('title', 'Galeri Kegiatan - Desa Sukorejo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/galeri.css') }}">
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

        /* Modal Styles */
        .modal-gallery-img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background: #f8fdfa;
        }
        
        .modal-title {
            color: var(--dark-color);
            font-weight: 700;
        }
    </style>
@endpush

@section('content')
    <header class="sub-hero">
        <div class="container sub-hero-content text-center">
            <h1>Galeri Kegiatan Desa</h1>
            <p class="lead opacity-75">Dokumentasi momen dan aktivitas masyarakat desa</p>
        </div>
    </header>

    <main class="py-5">
        <div class="container">
            <div class="row g-4" id="gallery-container">
                @include('landing.partials.gallery-items', ['galleries' => $galleries])
            </div>

            @if($galleries->hasMorePages())
                <div class="text-center mt-5">
                    <button id="load-more" class="btn btn-outline-success rounded-pill px-5 py-2 d-inline-flex align-items-center"
                        data-url="{{ route('gallery') }}" data-page="1">
                        <span>Muat Lebih Banyak</span>
                        <div class="loader" id="btn-loader"></div>
                    </button>
                </div>
            @endif

            @if($galleries->isEmpty())
                <div class="col-12 text-center py-5">
                    <div class="mb-4">
                        <i class="far fa-images fa-4x text-muted opacity-25"></i>
                    </div>
                    <h4 class="text-muted">Belum ada koleksi foto galeri</h4>
                    <p class="text-muted">Dokumentasi kegiatan desa akan segera kami bagikan di sini.</p>
                </div>
            @endif
        </div>
    </main>

    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryModalLabel">Detail Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <img src="" id="modalImage" class="modal-gallery-img mb-3" alt="Gallery Detail">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <h4 id="modalTitle" class="mb-0 fw-bold text-dark"></h4>
                        <span id="modalDate" class="text-muted small"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Modal instance
        let galleryModal;
        
        document.addEventListener('DOMContentLoaded', function() {
             galleryModal = new bootstrap.Modal(document.getElementById('galleryModal'));
        });

        function openGalleryModal(imgSrc, title, date) {
            document.getElementById('modalImage').src = imgSrc;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalDate').innerHTML = '<i class="far fa-calendar-alt me-1"></i> ' + date;
            galleryModal.show();
        }

        // Load More Logic
        document.getElementById('load-more')?.addEventListener('click', function() {
            const btn = this;
            const loader = document.getElementById('btn-loader');
            const container = document.getElementById('gallery-container');
            let page = parseInt(btn.getAttribute('data-page'));
            const url = btn.getAttribute('data-url');

            page++;

            btn.disabled = true;
            loader.style.display = 'inline-block';
            btn.querySelector('span').textContent = 'Memuat...';

            fetch(`${url}?page=${page}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (html.trim() === '') {
                        btn.parentElement.remove();
                        return;
                    }

                    container.insertAdjacentHTML('beforeend', html);
                    btn.setAttribute('data-page', page);

                    btn.disabled = false;
                    loader.style.display = 'none';
                    btn.querySelector('span').textContent = 'Muat Lebih Banyak';
                    
                    // Handle Load More Button Visibility based on marker
                    const marker = container.querySelector('#next-page-marker:last-child');
                    const hasMore = marker ? marker.getAttribute('data-has-more') === 'true' : false;
                    
                    // Remove old markers
                    container.querySelectorAll('#next-page-marker').forEach(m => m.remove());

                    if (!hasMore) {
                         btn.parentElement.remove();
                    }
                })
                .catch(error => {
                    console.error('Error loading more gallery items:', error);
                    btn.disabled = false;
                    loader.style.display = 'none';
                    btn.querySelector('span').textContent = 'Gagal memuat. Coba lagi';
                });
        });
    </script>
@endpush
