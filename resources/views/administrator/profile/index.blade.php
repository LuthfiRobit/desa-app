@extends('administrator.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="page-header-desa mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="ti ti-user me-2"></i>Profil Saya</h4>
            <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Akun</li>
                <li class="breadcrumb-item active">Profil Saya</li>
            </ol></nav>
        </div>
    </div>
</div>

<div class="row">
    <!-- Sidebar Profil Kiri -->
    <div class="col-xl-4 col-md-5">
        <div class="card shadow-sm border-0 mb-4 text-center">
            <div class="card-body">
                <div class="mb-3 position-relative d-inline-block">
                    <img src="{{ asset('admin-template/assets/images/user/avatar-2.jpg') }}" alt="Admin" class="img-fluid rounded-circle" style="width: 130px; height: 130px; object-fit: cover;" id="profileImgPreview" />
                    <div class="position-absolute bottom-0 end-0">
                        <button class="btn btn-primary btn-icon rounded-circle btn-sm shadow" onclick="document.getElementById('uploadFoto').click()" title="Ubah Foto">
                            <i class="ti ti-camera"></i>
                        </button>
                        <input type="file" id="uploadFoto" class="d-none" accept="image/*" onchange="previewProfile(this)">
                    </div>
                </div>
                <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                <p class="text-muted mb-0">{{ auth()->user()->roles->pluck('name')->first() ?? 'Admin' }}</p>
                <p class="text-muted mt-2 mb-3" style="font-size:0.85rem;"><i class="ti ti-mail me-1"></i>{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    <!-- Form Profil Kanan -->
    <div class="col-xl-8 col-md-7">
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            <!-- Card Informasi Pribadi -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-bottom">
                    <h6 class="mb-0"><i class="ti ti-user-edit me-2 text-primary"></i>Informasi Pribadi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-desa">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', auth()->user()->name) }}" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-desa">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', auth()->user()->email) }}" required />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i>Simpan Profil</button>
                </div>
            </div>
        </form>

        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf
            <!-- Card Ganti Password -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-bottom">
                    <h6 class="mb-0"><i class="ti ti-lock me-2 text-primary"></i>Ganti Password</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label-desa">Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="current_password" placeholder="Masukkan password lama" required />
                    </div>
                    <div class="row border-top pt-3 mt-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-desa">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" placeholder="Minimal 8 karakter" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-desa">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password baru" required />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning"><i class="ti ti-key me-1"></i>Update Password</button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewProfile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImgPreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
