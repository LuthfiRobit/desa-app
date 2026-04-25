@extends('administrator.layouts.app')

@section('title', 'Berita / Artikel')

@section('content')
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti ti-news me-2"></i>Berita / Artikel</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Manajemen Konten</li>
                        <li class="breadcrumb-item active">Berita / Artikel</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.berita.artikel.create') }}" class="btn btn-primary">
                <i class="ti ti-pencil-plus me-1"></i>Tulis Berita Baru
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="input-group" style="max-width:240px;">
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" id="searchBerita" placeholder="Cari judul berita..." />
                </div>
                <select class="form-select" style="width:160px;" id="filterKategori">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select class="form-select" style="width:140px;" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0" id="table-container">
            @include('administrator.berita.table')
        </div>
    </div>

    <!-- Modal Hapus Berita -->
    <div class="modal fade" id="modalHapusBerita" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Hapus Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-1">
                    <p>Apakah Anda yakin ingin menghapus berita ini secara permanen?</p>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmDelete"><i class="ti ti-trash me-1"></i>Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let deleteModal;
    let deleteId = null;
    let currentSearch = '';
    let currentCategory = '';
    let currentStatus = '';
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', function() {
        deleteModal = new bootstrap.Modal(document.getElementById('modalHapusBerita'));
        
        // Handle AJAX Pagination clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                const url = new URL(e.target.closest('.pagination a').href);
                currentPage = url.searchParams.get('page');
                fetchTable();
            }
        });
        
        // Handle Search with debounce
        let searchTimeout;
        document.getElementById('searchBerita').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = this.value;
                currentPage = 1;
                fetchTable();
            }, 500);
        });

        // Handle Filters
        document.getElementById('filterKategori').addEventListener('change', function() {
            currentCategory = this.value;
            currentPage = 1;
            fetchTable();
        });

        document.getElementById('filterStatus').addEventListener('change', function() {
            currentStatus = this.value;
            currentPage = 1;
            fetchTable();
        });
    });

    function fetchTable() {
        const container = document.getElementById('table-container');
        container.style.opacity = '0.5';
        
        const url = `{{ route('admin.berita.artikel.index') }}?search=${currentSearch}&category=${currentCategory}&status=${currentStatus}&page=${currentPage}`;
        
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            container.innerHTML = html;
            container.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error:', error);
            container.style.opacity = '1';
        });
    }

    function confirmDelete(id) {
        deleteId = id;
        deleteModal.show();
    }

    document.getElementById('btnConfirmDelete').addEventListener('click', function() {
        if (!deleteId) return;
        
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...';

        fetch(`{{ url('admin/berita/artikel') }}/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="ti ti-trash me-1"></i>Ya, Hapus';
            
            if (data.success) {
                deleteModal.hide();
                fetchTable();
            } else {
                alert(data.message);
                deleteModal.hide();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.innerHTML = '<i class="ti ti-trash me-1"></i>Ya, Hapus';
        });
    });
</script>
@endpush
