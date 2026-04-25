@extends('administrator.layouts.app')

@section('title', 'Profil & Informasi Desa')

@push('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
@endpush

@section('content')
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti ti-building-community me-2"></i>Profil &amp; Informasi Desa</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Pengaturan Sistem</li>
                        <li class="breadcrumb-item active">Profil &amp; Informasi Desa</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button type="button" class="btn btn-primary" id="btnSimpanTop" onclick="submitForm()">
                    <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <form id="formProfil" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header border-bottom pb-0">
                        <ul class="nav nav-tabs border-0" id="profilTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="identitas-tab" data-bs-toggle="tab"
                                    data-bs-target="#identitas" type="button" role="tab">
                                    <i class="ti ti-id me-2"></i>Identitas &amp; Kades
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="statistik-tab" data-bs-toggle="tab"
                                    data-bs-target="#statistik" type="button" role="tab">
                                    <i class="ti ti-chart-bar me-2"></i>Statistik &amp; Narasi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="struktur-tab" data-bs-toggle="tab"
                                    data-bs-target="#struktur" type="button" role="tab">
                                    <i class="ti ti-hierarchy me-2"></i>Struktur Organisasi
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="profilTabsContent">

                            <!-- Tab Identitas & Kades -->
                            <div class="tab-pane fade show active" id="identitas" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-4">
                                            <h5 class="mb-3 border-bottom pb-2">Informasi Umum</h5>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Nama Desa <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="village_name" value="{{ $profile->village_name }}" required />
                                                </div>
                                                <!-- The template had Kecamatan, Kabupaten, Provinsi, Alamat, Email, No Telp. 
                                                     But our Profile model doesn't have these fields. We can just provide them as static text for now, 
                                                     or only use what's in the model. Since this is an admin panel for Sukorejo specifically,
                                                     we will only make dynamic the fields that exist in the database. -->
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-muted">Kecamatan</label>
                                                    <input type="text" class="form-control" value="Kotaanyar" disabled />
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label text-muted">Kabupaten</label>
                                                    <input type="text" class="form-control" value="Probolinggo" disabled />
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <h5 class="mb-3 border-bottom pb-2">Kepala Desa</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Kepala Desa <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="head_of_village_name" value="{{ $profile->head_of_village_name }}" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pesan Sambutan Kepala Desa</label>
                                                <textarea class="form-control" name="head_of_village_msg" id="pesanSambutan" rows="10">{{ $profile->head_of_village_msg }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border border-light">
                                            <div class="card-header bg-light-primary">
                                                <h6 class="mb-0 text-primary">Foto Kepala Desa</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    @if($profile->head_of_village_img)
                                                        <img src="{{ asset('storage/' . $profile->head_of_village_img) }}" id="previewKadesImg" alt="Foto Kades" class="img-thumbnail rounded" style="width: 200px; height: 250px; object-fit: cover;" />
                                                    @else
                                                        <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" id="previewKadesImg" alt="Foto Kades Default" class="img-thumbnail rounded" style="width: 200px; height: 250px; object-fit: cover;" />
                                                    @endif
                                                </div>
                                                <input type="file" class="form-control form-control-sm mb-2" name="head_of_village_img" id="head_of_village_img" accept="image/png, image/jpeg, image/jpg" onchange="previewKades(this)" />
                                                <small class="text-muted d-block">Format: JPG, PNG. Rekomendasi rasio 4:5 (Portrait).</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Statistik & Narasi -->
                            <div class="tab-pane fade" id="statistik" role="tabpanel">
                                <h5 class="mb-3 border-bottom pb-2">Statistik Desa</h5>
                                <div class="row mb-4">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Jumlah Penduduk (Jiwa)</label>
                                        <input type="number" class="form-control" name="population" value="{{ $profile->population }}" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Luas Wilayah (km²)</label>
                                        <input type="number" step="0.01" class="form-control" name="area_size" value="{{ $profile->area_size }}" />
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Jumlah Dusun</label>
                                        <input type="number" class="form-control" name="hamlet_count" value="{{ $profile->hamlet_count }}" />
                                    </div>
                                </div>

                                <h5 class="mb-3 border-bottom pb-2">Narasi Profil</h5>
                                <div class="mb-4">
                                    <label class="form-label">Visi Desa</label>
                                    <textarea class="form-control" name="vision" rows="3">{{ $profile->vision }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Misi Desa</label>
                                    <textarea class="form-control" name="mission" id="misiDesa" rows="6">{{ $profile->mission }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sejarah Desa</label>
                                    <textarea class="form-control" name="history" id="sejarahDesa" rows="10">{{ $profile->history }}</textarea>
                                </div>
                            </div>

                            <!-- Tab Struktur Organisasi -->
                            <div class="tab-pane fade" id="struktur" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-8 mx-auto">
                                        <div class="card border border-light">
                                            <div class="card-header bg-light-primary text-center">
                                                <h6 class="mb-0 text-primary">Bagan Struktur Organisasi Pemerintah Desa</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                <div class="mb-4 border rounded p-3 bg-light">
                                                    @if($profile->org_chart_image)
                                                        <img src="{{ asset('storage/' . $profile->org_chart_image) }}" id="previewOrgImg" alt="Struktur Organisasi" class="img-fluid rounded" />
                                                    @else
                                                        <div id="noOrgImg">
                                                            <i class="ti ti-photo text-muted" style="font-size: 64px;"></i>
                                                            <p class="mt-2 text-muted">Belum ada gambar struktur organisasi yang diunggah.</p>
                                                        </div>
                                                        <img src="" id="previewOrgImg" alt="Struktur Organisasi" class="img-fluid rounded d-none" />
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-start w-100">Upload Gambar Baru</label>
                                                    <input type="file" class="form-control" name="org_chart_image" accept="image/png, image/jpeg, image/jpg" onchange="previewOrg(this)" />
                                                    <div class="form-text text-start mt-1">Gunakan gambar resolusi tinggi (min. lebar 1200px) agar mudah dibaca oleh warga. Format: JPG, PNG. Maks. 5MB.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" id="btnSimpanBottom" onclick="submitForm()">
                            <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let editorSambutanInstance;
    let editorMisiInstance;
    let editorSejarahInstance;

    document.addEventListener('DOMContentLoaded', function () {
        ClassicEditor
            .create(document.querySelector('#pesanSambutan'))
            .then(editor => { editorSambutanInstance = editor; })
            .catch(error => { console.error(error); });

        ClassicEditor
            .create(document.querySelector('#misiDesa'))
            .then(editor => { editorMisiInstance = editor; })
            .catch(error => { console.error(error); });

        ClassicEditor
            .create(document.querySelector('#sejarahDesa'))
            .then(editor => { editorSejarahInstance = editor; })
            .catch(error => { console.error(error); });
    });

    function previewKades(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewKadesImg').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewOrg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewOrgImg').src = e.target.result;
                document.getElementById('previewOrgImg').classList.remove('d-none');
                const noImg = document.getElementById('noOrgImg');
                if (noImg) noImg.classList.add('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function submitForm() {
        const form = document.getElementById('formProfil');
        
        // Sync CKEditor values before creating FormData
        if (editorSambutanInstance) document.querySelector('#pesanSambutan').value = editorSambutanInstance.getData();
        if (editorMisiInstance) document.querySelector('#misiDesa').value = editorMisiInstance.getData();
        if (editorSejarahInstance) document.querySelector('#sejarahDesa').value = editorSejarahInstance.getData();

        const formData = new FormData(form);
        const btnTop = document.getElementById('btnSimpanTop');
        const btnBottom = document.getElementById('btnSimpanBottom');
        
        btnTop.disabled = true; btnTop.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
        btnBottom.disabled = true; btnBottom.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch(`{{ route('admin.profildesa.update') }}`, {
            method: 'POST', // We use POST for file uploads
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async response => {
            const result = await response.json();
            if (!response.ok) throw result;
            return result;
        })
        .then(result => {
            btnTop.disabled = false; btnTop.innerHTML = '<i class="ti ti-device-floppy me-2"></i>Simpan Perubahan';
            btnBottom.disabled = false; btnBottom.innerHTML = '<i class="ti ti-device-floppy me-2"></i>Simpan Perubahan';
            
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: result.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        })
        .catch(error => {
            btnTop.disabled = false; btnTop.innerHTML = '<i class="ti ti-device-floppy me-2"></i>Simpan Perubahan';
            btnBottom.disabled = false; btnBottom.innerHTML = '<i class="ti ti-device-floppy me-2"></i>Simpan Perubahan';
            
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: error.message || 'Terjadi kesalahan sistem'
            });
        });
    }
</script>
@endpush
