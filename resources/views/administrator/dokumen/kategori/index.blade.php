@extends('administrator.layouts.app')

@section('title', 'Kategori Dokumen')

@section('content')
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti ti-folder me-2"></i>Kategori Dokumen</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Layanan Publik</li>
                        <li class="breadcrumb-item active">Kategori Dokumen</li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-primary" onclick="addKategori()">
                <i class="ti ti-plus me-1"></i>Tambah Kategori
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="input-group" style="max-width:280px;">
                <span class="input-group-text"><i class="ti ti-search"></i></span>
                <input type="text" class="form-control" id="searchKatDok" placeholder="Cari nama kategori..." />
            </div>
        </div>
        <div class="card-body p-0" id="table-container">
            @include('administrator.dokumen.kategori.table')
        </div>
    </div>

    <!-- Modal Kategori Dokumen -->
    <div class="modal fade" id="modalKategoriDok" tabindex="-1" aria-labelledby="modalKategoriDokLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKategoriDokLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formKategori">
                    <div class="modal-body">
                        <input type="hidden" id="kategoriId">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="namaKatDok" required
                                placeholder="Contoh: Form Layanan Administrasi" />
                            <p class="form-text text-muted mt-1" style="font-size:0.75rem;">Gunakan nama yang jelas dan mudah dipahami warga.</p>
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
    <div class="modal fade" id="modalHapusKatDok" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Hapus Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-1">
                    <p>Hapus kategori ini? Dokumen yang ada di dalamnya tidak akan terhapus.</p>
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
    let kategoriModal;
    let deleteModal;
    let deleteId = null;
    let currentSearch = '';
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', function() {
        kategoriModal = new bootstrap.Modal(document.getElementById('modalKategoriDok'));
        deleteModal = new bootstrap.Modal(document.getElementById('modalHapusKatDok'));

        // Handle AJAX Pagination clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                const url = new URL(e.target.closest('.pagination a').href);
                currentPage = url.searchParams.get('page');
                fetchTable();
            }
        });

        // Handle Search
        let searchTimeout;
        document.getElementById('searchKatDok').addEventListener('input', function() {
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
        
        const url = `{{ route('admin.dokumen.kategori.index') }}?search=${currentSearch}&page=${currentPage}`;
        
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

    function addKategori() {
        document.getElementById('kategoriId').value = '';
        document.getElementById('formKategori').reset();
        document.getElementById('modalKategoriDokLabel').innerHTML = '<i class="ti ti-folder me-2 text-primary"></i>Tambah Kategori';
        kategoriModal.show();
    }

    function editKategori(category) {
        document.getElementById('kategoriId').value = category.id;
        document.getElementById('namaKatDok').value = category.name;
        document.getElementById('modalKategoriDokLabel').innerHTML = '<i class="ti ti-edit me-2 text-primary"></i>Edit Kategori';
        kategoriModal.show();
    }

    document.getElementById('formKategori').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('kategoriId').value;
        const btn = document.getElementById('btnSimpan');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        const url = id ? `{{ url('admin/dokumen/kategori') }}/${id}` : `{{ route('admin.dokumen.kategori.store') }}`;
        const method = id ? 'PUT' : 'POST';
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            const result = await response.json();
            if (!response.ok) throw result;
            return result;
        })
        .then(result => {
            btn.disabled = false;
            btn.innerHTML = '<i class="ti ti-device-floppy me-1"></i>Simpan';
            if (result.success) {
                kategoriModal.hide();
                fetchTable();
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<i class="ti ti-device-floppy me-1"></i>Simpan';
            alert(error.message || 'Terjadi kesalahan sistem');
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
        fetch(`{{ url('admin/dokumen/kategori') }}/${deleteId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            if (data.success) {
                deleteModal.hide();
                fetchTable();
            }
        })
        .catch(error => {
            btn.disabled = false;
            console.error('Error:', error);
        });
    });
</script>
@endpush
