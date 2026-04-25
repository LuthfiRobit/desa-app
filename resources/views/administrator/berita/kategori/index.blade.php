@extends('administrator.layouts.app')

@section('title', 'Kategori Berita')

@section('content')
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti ti-tag me-2"></i>Kategori Berita</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Manajemen Konten</li>
                        <li class="breadcrumb-item active">Kategori Berita</li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-primary" onclick="addCategory()">
                <i class="ti ti-plus me-1"></i>Tambah Kategori
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="input-group" style="max-width:280px;">
                <span class="input-group-text"><i class="ti ti-search"></i></span>
                <input type="text" class="form-control" id="searchKategori" placeholder="Cari nama kategori..." />
            </div>
        </div>
        <div class="card-body p-0" id="table-container">
            @include('administrator.berita.kategori.table')
        </div>
    </div>

    <!-- Modal Kategori -->
    <div class="modal fade" id="modalKategori" tabindex="-1" aria-labelledby="modalKategoriLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKategoriLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="categoryForm">
                    <div class="modal-body">
                        <input type="hidden" id="categoryId">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="namaKategori" name="name" placeholder="Contoh: Pemerintahan" required oninput="generateSlug(this.value)" />
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Slug (otomatis)</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted" style="font-size:0.8rem;">/berita/</span>
                                <input type="text" class="form-control" id="slugKategori" placeholder="pemerintahan" readonly style="background:#f9f9f9;" />
                            </div>
                            <p class="form-text text-muted" style="font-size:0.75rem;">Slug dibuat otomatis dari nama kategori.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan"><i class="ti ti-device-floppy me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="modalHapusKategori" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Hapus Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-1">
                    <p>Hapus kategori ini? Kategori tidak dapat dihapus jika masih digunakan oleh artikel.</p>
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
    let categoryModal;
    let deleteModal;
    let deleteId = null;
    let currentSearch = '';
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', function() {
        categoryModal = new bootstrap.Modal(document.getElementById('modalKategori'));
        deleteModal = new bootstrap.Modal(document.getElementById('modalHapusKategori'));
        
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
        document.getElementById('searchKategori').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = this.value;
                currentPage = 1;
                fetchTable();
            }, 500);
        });
    });

    function fetchTable() {
        const container = document.getElementById('table-container');
        container.style.opacity = '0.5';
        
        const url = `{{ route('admin.berita.kategori.index') }}?search=${currentSearch}&page=${currentPage}`;
        
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

    function generateSlug(val) {
        var slug = val.toLowerCase().trim()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9\-]/g, '');
        document.getElementById('slugKategori').value = slug;
    }

    function addCategory() {
        document.getElementById('categoryId').value = '';
        document.getElementById('categoryForm').reset();
        document.getElementById('modalKategoriLabel').innerHTML = '<i class="ti ti-tag me-2 text-primary"></i>Tambah Kategori';
        document.getElementById('namaKategori').classList.remove('is-invalid');
        categoryModal.show();
    }

    function editCategory(id, name) {
        document.getElementById('categoryId').value = id;
        document.getElementById('namaKategori').value = name;
        generateSlug(name);
        document.getElementById('modalKategoriLabel').innerHTML = '<i class="ti ti-edit me-2 text-primary"></i>Edit Kategori';
        document.getElementById('namaKategori').classList.remove('is-invalid');
        categoryModal.show();
    }

    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('categoryId').value;
        const name = document.getElementById('namaKategori').value;
        const btn = document.getElementById('btnSimpan');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        const url = id ? `{{ url('admin/berita/kategori') }}/${id}` : `{{ route('admin.berita.kategori.store') }}`;
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name: name })
        })
        .then(async response => {
            const data = await response.json();
            if (!response.ok) {
                throw data;
            }
            return data;
        })
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="ti ti-device-floppy me-1"></i>Simpan';

            if (data.success) {
                categoryModal.hide();
                fetchTable();
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<i class="ti ti-device-floppy me-1"></i>Simpan';
            
            if (error.message) {
                document.getElementById('namaKategori').classList.add('is-invalid');
                document.getElementById('nameError').innerText = error.message;
            } else {
                console.error('Error:', error);
            }
        });
    });

    function confirmDelete(id) {
        deleteId = id;
        deleteModal.show();
    }

    document.getElementById('btnConfirmDelete').addEventListener('click', function() {
        if (!deleteId) return;
        
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...';

        fetch(`{{ url('admin/berita/kategori') }}/${deleteId}`, {
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
