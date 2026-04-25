@extends('administrator.layouts.app')

@section('title', isset($article) ? 'Edit Berita' : 'Tulis Berita Baru')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
        .upload-zone {
            border: 2px dashed #e2e5e8;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .upload-zone:hover {
            border-color: #2e7d32;
            background: #f1f8f1;
        }
        .upload-icon {
            font-size: 40px;
            color: #2e7d32;
        }
    </style>
@endpush

@section('content')
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti {{ isset($article) ? 'ti-edit' : 'ti-pencil-plus' }} me-2"></i>{{ isset($article) ? 'Edit Berita' : 'Tulis Berita Baru' }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.berita.artikel.index') }}">Berita / Artikel</a></li>
                        <li class="breadcrumb-item active">{{ isset($article) ? 'Edit' : 'Tulis Baru' }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.berita.artikel.index') }}" class="btn btn-light">
                <i class="ti ti-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($article) ? route('admin.berita.artikel.update', $article->id) : route('admin.berita.artikel.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif

        <div class="row g-3">
            <!-- Kolom Konten Utama (kiri) -->
            <div class="col-xl-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" name="title" id="judulBerita"
                                value="{{ old('title', $article->title ?? '') }}"
                                placeholder="Masukkan judul berita yang menarik..."
                                required oninput="generateSlugBerita(this.value)" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label text-muted">Slug URL</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted" style="font-size:0.8rem;">/berita/</span>
                                <input type="text" class="form-control" id="slugBerita"
                                    value="{{ old('slug', $article->slug ?? '') }}"
                                    placeholder="judul-berita-anda" readonly style="background:#f9f9f9;" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="ti ti-align-left me-2 text-primary"></i>Konten Berita</h6>
                    </div>
                    <div class="card-body p-0">
                        <textarea name="content" id="kontenBerita" class="ckeditor-classic">{{ old('content', $article->content ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Kolom Sidebar Form (kanan) -->
            <div class="col-xl-4">
                <!-- Aksi -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="ti ti-send me-2 text-primary"></i>Publikasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" name="is_published" value="0" class="btn btn-light border" onclick="document.getElementById('statusPublikasi').checked = false">
                                <i class="ti ti-device-floppy me-1"></i>Simpan sebagai Draft
                            </button>
                            <button type="submit" name="is_published" value="1" class="btn btn-primary" onclick="document.getElementById('statusPublikasi').checked = true">
                                <i class="ti ti-world-upload me-1"></i>Publikasikan Sekarang
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Status & Jadwal -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="ti ti-settings me-2 text-primary"></i>Pengaturan</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status Publikasi</label>
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" name="is_published" id="statusPublikasi" value="1" {{ old('is_published', $article->is_published ?? false) ? 'checked' : '' }} />
                                <label class="form-check-label" for="statusPublikasi">Publik (Ditayangkan)</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" name="category_id" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Tanggal Publikasi</label>
                            <input type="text" class="form-control" name="published_at" id="tglPublikasi"
                                value="{{ old('published_at', isset($article->published_at) ? $article->published_at->format('d M Y H:i') : '') }}"
                                placeholder="Pilih tanggal..." />
                            <p class="form-text text-muted" style="font-size:0.75rem;">Kosongkan untuk publish langsung saat ini.</p>
                        </div>
                    </div>
                </div>

                <!-- Cover / Thumbnail -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="ti ti-photo me-2 text-primary"></i>Cover / Thumbnail</h6>
                    </div>
                    <div class="card-body">
                        <div class="upload-zone mb-2" onclick="document.getElementById('coverBerita').click()">
                            <i class="ti ti-cloud-upload upload-icon"></i>
                            <p class="mb-1 mt-2" style="font-size:0.88rem;">Klik untuk upload gambar cover</p>
                            <small class="text-muted">JPG/PNG/WEBP, maks. 2MB</small>
                        </div>
                        <input type="file" name="image" id="coverBerita" class="d-none" accept="image/*"
                            onchange="previewCover(this)" />
                        <div id="previewContainer" class="{{ isset($article->image_path) ? '' : 'd-none' }}">
                            <img id="previewCoverImg" src="{{ isset($article->image_path) ? asset('storage/' . $article->image_path) : '' }}" alt="" class="img-fluid rounded mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // CKEditor
            ClassicEditor
                .create(document.querySelector('#kontenBerita'), {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
                })
                .catch(error => {
                    console.error(error);
                });

            // Flatpickr
            flatpickr("#tglPublikasi", {
                locale: "id",
                dateFormat: "d M Y H:i",
                enableTime: true,
                time_24hr: true,
            });
        });

        // Auto slug
        function generateSlugBerita(val) {
            document.getElementById('slugBerita').value = val.toLowerCase().trim()
                .replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '');
        }

        // Preview cover image
        function previewCover(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = document.getElementById('previewCoverImg');
                    img.src = e.target.result;
                    document.getElementById('previewContainer').classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
