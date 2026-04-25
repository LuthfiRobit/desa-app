@extends('administrator.layouts.app')

@section('title', 'Galeri Kegiatan')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <style>
        .gallery-card {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }
        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            opacity: 1;
        }
        .gallery-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .gallery-card:hover .gallery-actions {
            opacity: 1;
        }
        .upload-zone {
            border: 2px dashed #e2e5e8;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .upload-zone:hover {
            border-color: #2e7d32;
            background: #f1f8f1;
        }
        .upload-icon {
            font-size: 32px;
            color: #2e7d32;
        }
    </style>
@endpush

@section('content')
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti ti-camera me-2"></i>Galeri Kegiatan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Manajemen Konten</li>
                        <li class="breadcrumb-item active">Galeri Kegiatan</li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-primary" onclick="addGallery()">
                <i class="ti ti-cloud-upload me-1"></i>Upload Foto
            </button>
        </div>
    </div>

    <!-- Toolbar Filter -->
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="input-group" style="max-width:230px;">
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" id="searchGaleri" placeholder="Cari judul foto..." />
                </div>
                <select class="form-select" style="width:140px;" id="filterYear">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $row)
                        <option value="{{ $row->year }}">{{ $row->year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div id="grid-container">
        @include('administrator.galeri.grid')
    </div>

    <!-- Modal Galeri -->
    <div class="modal fade" id="modalGaleri" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGaleriLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formGaleri">
                    <div class="modal-body">
                        <input type="hidden" id="galeriId">
                        <div class="mb-3">
                            <label class="form-label">Judul / Keterangan Foto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="galeriJudul" required placeholder="Contoh: Gotong Royong Bersih Desa April 2026" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Foto <span class="text-danger" id="photoReq">*</span></label>
                            <div class="upload-zone" onclick="document.getElementById('galeriFile').click()">
                                <i class="ti ti-camera upload-icon"></i>
                                <p class="mb-1 mt-2">Klik untuk pilih foto</p>
                                <small class="text-muted">Format: JPG, PNG, WEBP — Maks. 5MB</small>
                            </div>
                            <input type="file" name="image" id="galeriFile" class="d-none" accept="image/*" onchange="previewGaleri(this)" />
                            <div id="previewContainer" class="mt-2 d-none">
                                <img id="previewGaleriImg" src="" alt="" class="img-fluid rounded" style="max-height:200px;" />
                            </div>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Tanggal Pengambilan Gambar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="date_taken" id="galeriTanggal" required placeholder="Pilih tanggal..." />
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
    <div class="modal fade" id="modalHapusGaleri" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Hapus Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-1">
                    <p>Hapus foto ini dari galeri?</p>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    let galleryModal;
    let deleteModal;
    let deleteId = null;
    let currentSearch = '';
    let currentYear = '';
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', function() {
        galleryModal = new bootstrap.Modal(document.getElementById('modalGaleri'));
        deleteModal = new bootstrap.Modal(document.getElementById('modalHapusGaleri'));

        flatpickr("#galeriTanggal", {
            locale: "id",
            dateFormat: "d M Y"
        });

        // Handle AJAX Pagination
        document.addEventListener('click', function(e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();
                const url = new URL(e.target.closest('.pagination a').href);
                currentPage = url.searchParams.get('page');
                fetchGrid();
            }
        });

        // Handle Search
        let searchTimeout;
        document.getElementById('searchGaleri').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = this.value;
                currentPage = 1;
                fetchGrid();
            }, 500);
        });

        // Handle Year Filter
        document.getElementById('filterYear').addEventListener('change', function() {
            currentYear = this.value;
            currentPage = 1;
            fetchGrid();
        });
    });

    function fetchGrid() {
        const container = document.getElementById('grid-container');
        container.style.opacity = '0.5';
        
        const url = `{{ route('admin.galeri.index') }}?search=${currentSearch}&year=${currentYear}&page=${currentPage}`;
        
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

    function previewGaleri(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById('previewGaleriImg');
                img.src = e.target.result;
                document.getElementById('previewContainer').classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function addGallery() {
        document.getElementById('galeriId').value = '';
        document.getElementById('formGaleri').reset();
        document.getElementById('previewContainer').classList.add('d-none');
        document.getElementById('photoReq').classList.remove('d-none');
        document.getElementById('modalGaleriLabel').innerHTML = '<i class="ti ti-camera me-2 text-primary"></i>Upload Foto';
        galleryModal.show();
    }

    function editGallery(gallery) {
        document.getElementById('galeriId').value = gallery.id;
        document.getElementById('galeriJudul').value = gallery.title;
        document.getElementById('photoReq').classList.add('d-none');
        
        // Date formatting for flatpickr
        const date = new Date(gallery.date_taken);
        const day = ("0" + date.getDate()).slice(-2);
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();
        document.getElementById('galeriTanggal').value = `${day} ${month} ${year}`;

        const img = document.getElementById('previewGaleriImg');
        img.src = `{{ asset('storage') }}/${gallery.image_path}`;
        document.getElementById('previewContainer').classList.remove('d-none');

        document.getElementById('modalGaleriLabel').innerHTML = '<i class="ti ti-edit me-2 text-primary"></i>Edit Foto';
        galleryModal.show();
    }

    document.getElementById('formGaleri').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('galeriId').value;
        const btn = document.getElementById('btnSimpan');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        const url = id ? `{{ url('admin/galeri') }}/${id}` : `{{ route('admin.galeri.store') }}`;
        
        const formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');

        fetch(url, {
            method: 'POST', // Use POST with _method PUT for multipart form
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
                galleryModal.hide();
                fetchGrid();
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
        fetch(`{{ url('admin/galeri') }}/${deleteId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            if (data.success) {
                deleteModal.hide();
                fetchGrid();
            }
        })
        .catch(error => {
            btn.disabled = false;
            console.error('Error:', error);
        });
    });
</script>
@endpush
