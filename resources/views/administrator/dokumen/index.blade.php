@extends('administrator.layouts.app')

@section('title', 'Pusat Unduhan')

@section('content')
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti ti-file-description me-2"></i>Pusat Unduhan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Layanan Publik</li>
                        <li class="breadcrumb-item active">Pusat Unduhan</li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-primary" onclick="addDokumen()">
                <i class="ti ti-upload me-1"></i>Upload Dokumen
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="input-group" style="max-width:240px;">
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" id="searchDokumen" placeholder="Cari nama dokumen..." />
                </div>
                <select class="form-select" style="width:220px;" id="filterCategory">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body p-0" id="table-container">
            @include('administrator.dokumen.table')
        </div>
    </div>

    <!-- Modal Upload Dokumen -->
    <div class="modal fade" id="modalDokumen" tabindex="-1" aria-labelledby="modalDokumenLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDokumenLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formDokumen">
                    <div class="modal-body">
                        <input type="hidden" id="dokumenId">
                        <div class="mb-3">
                            <label class="form-label">Judul / Nama Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="judulDokumen" required placeholder="Contoh: Form Permohonan Surat Keterangan Domisili" />
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori Dokumen <span class="text-danger">*</span></label>
                                <select class="form-select" name="document_category_id" id="kategoriDokumen" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">File Dokumen <span class="text-danger" id="fileReq">*</span></label>
                                <input type="file" class="form-control" name="file" id="fileDokumen" accept=".pdf,.doc,.docx,.xls,.xlsx" />
                                <p class="form-text text-muted mt-1" style="font-size:0.75rem;">Format: PDF, DOC, DOCX, XLS, XLSX — Maks. 10MB</p>
                            </div>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Deskripsi Singkat <span class="text-muted fw-normal">(opsional)</span></label>
                            <textarea class="form-control" name="description" id="deskripsiDokumen" rows="2" placeholder="Jelaskan isi atau kegunaan dokumen ini..."></textarea>
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
    <div class="modal fade" id="modalHapusDokumen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Hapus Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-1">
                    <p>Hapus dokumen ini? File yang sudah diunggah juga akan dihapus dari server.</p>
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
    let dokumenModal;
    let deleteModal;
    let deleteId = null;
    let currentSearch = '';
    let currentCategory = '';
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', function() {
        dokumenModal = new bootstrap.Modal(document.getElementById('modalDokumen'));
        deleteModal = new bootstrap.Modal(document.getElementById('modalHapusDokumen'));

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
        document.getElementById('searchDokumen').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = this.value;
                currentPage = 1;
                fetchTable();
            }, 500);
        });

        // Handle Category Filter
        document.getElementById('filterCategory').addEventListener('change', function() {
            currentCategory = this.value;
            currentPage = 1;
            fetchTable();
        });
    });

    function fetchTable() {
        const container = document.getElementById('table-container');
        container.style.opacity = '0.5';
        
        const url = `{{ route('admin.dokumen.pusat-unduhan.index') }}?search=${currentSearch}&category=${currentCategory}&page=${currentPage}`;
        
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

    function addDokumen() {
        document.getElementById('dokumenId').value = '';
        document.getElementById('formDokumen').reset();
        document.getElementById('fileReq').classList.remove('d-none');
        document.getElementById('modalDokumenLabel').innerHTML = '<i class="ti ti-upload me-2 text-primary"></i>Upload Dokumen';
        dokumenModal.show();
    }

    function editDokumen(doc) {
        document.getElementById('dokumenId').value = doc.id;
        document.getElementById('judulDokumen').value = doc.title;
        document.getElementById('kategoriDokumen').value = doc.document_category_id;
        document.getElementById('deskripsiDokumen').value = doc.description;
        document.getElementById('fileReq').classList.add('d-none');
        document.getElementById('modalDokumenLabel').innerHTML = '<i class="ti ti-edit me-2 text-primary"></i>Edit Dokumen';
        dokumenModal.show();
    }

    document.getElementById('formDokumen').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('dokumenId').value;
        const btn = document.getElementById('btnSimpan');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        const url = id ? `{{ url('admin/dokumen/pusat-unduhan') }}/${id}` : `{{ route('admin.dokumen.pusat-unduhan.store') }}`;
        
        const formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');

        fetch(url, {
            method: 'POST', // Use POST with _method PUT for multipart
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
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
                dokumenModal.hide();
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
        fetch(`{{ url('admin/dokumen/pusat-unduhan') }}/${deleteId}`, {
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
