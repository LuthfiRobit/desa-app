@extends('administrator.layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="page-header-desa mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4><i class="ti ti-users me-2"></i>Manajemen Pengguna</h4>
            <nav aria-label="breadcrumb"><ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Pengaturan Sistem</li>
                <li class="breadcrumb-item active">Manajemen Pengguna</li>
            </ol></nav>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUser" onclick="resetForm()">
                <i class="ti ti-plus me-2"></i>Tambah Pengguna
            </button>
        </div>
    </div>
</div>

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

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header border-bottom">
                <h5 class="mb-0">Daftar Pengguna Sistem</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th style="width:150px;">Peran</th>
                                <th style="width:180px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avtar bg-light-primary text-primary wid-40 align-top m-r-15 rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h6 class="m-0">{{ $user->name }} {!! auth()->id() == $user->id ? '<span class="text-muted f-12">(Anda)</span>' : '' !!}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge bg-light-success text-success">Aktif</span>
                                    @else
                                        <span class="badge bg-light-danger text-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-light-{{ $role->name == 'Superadmin' ? 'primary' : 'success' }} text-{{ $role->name == 'Superadmin' ? 'primary' : 'success' }} px-3 py-2">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button class="btn btn-icon btn-sm btn-light-warning" title="Reset Password" data-bs-toggle="modal" data-bs-target="#modalReset" onclick="setResetId({{ $user->id }})"><i class="ti ti-key"></i></button>
                                        <button class="btn btn-icon btn-sm btn-light-primary" title="Edit" data-bs-toggle="modal" data-bs-target="#modalUser" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->roles->first()->name ?? '' }}', {{ $user->is_active ? 'true' : 'false' }})"><i class="ti ti-edit"></i></button>
                                        @if(auth()->id() != $user->id)
                                        <button class="btn btn-icon btn-sm btn-light-danger" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapus" onclick="setDeleteId({{ $user->id }})"><i class="ti ti-trash"></i></button>
                                        @else
                                        <button class="btn btn-icon btn-sm btn-light-secondary opacity-50" title="Tidak dapat dihapus" disabled><i class="ti ti-trash"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Create/Edit -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.users.store') }}" method="POST" id="userForm">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUserTitle"><i class="ti ti-user me-2 text-primary"></i>Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label-desa">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="userName" placeholder="Contoh: Budi Santoso" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label-desa">Email Login <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="userEmail" placeholder="admin@domain.com" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label-desa">Peran Akses <span class="text-danger">*</span></label>
                        <select class="form-select" name="role" id="userRole" required>
                            <option value="">-- Pilih Peran --</option>
                            <option value="Superadmin">Superadmin (Akses Penuh)</option>
                            <option value="Editor">Editor (Hanya Manajemen Konten)</option>
                        </select>
                    </div>
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" name="is_active" id="userActive" value="1" checked>
                        <label class="form-check-label" for="userActive">Akun Aktif</label>
                    </div>
                    
                    <div class="p-3 border rounded bg-light-secondary" id="passwordSection">
                        <h6 class="mb-3" style="font-size:0.9rem;"><i class="ti ti-lock me-1"></i>Pengaturan Password</h6>
                        <div class="mb-3">
                            <label class="form-label-desa">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="userPassword" placeholder="Min. 8 karakter" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label-desa">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password baru" />
                        </div>
                        <small class="text-muted" id="passwordHint" style="display:none;">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i>Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="modalReset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form action="" method="POST" id="resetPasswordForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title"><i class="ti ti-key me-2 text-warning"></i>Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-2">
                    <div class="mb-3">
                        <label class="form-label-desa">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan password baru" required minlength="8" />
                    </div>
                    <div class="mb-1">
                        <label class="form-label-desa">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password baru" required minlength="8" />
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light w-100 mb-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning w-100"><i class="ti ti-check me-1"></i>Reset Sekarang</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form action="" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Hapus Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-1">
                    <p>Hapus pengguna ini? Ia tidak akan bisa login lagi ke sistem.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger"><i class="ti ti-trash me-1"></i>Ya, Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function resetForm() {
        document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
        document.getElementById('formMethod').value = "POST";
        document.getElementById('modalUserTitle').innerHTML = '<i class="ti ti-user me-2 text-primary"></i>Tambah Pengguna';
        document.getElementById('userName').value = '';
        document.getElementById('userEmail').value = '';
        document.getElementById('userRole').value = '';
        document.getElementById('userActive').checked = true;
        document.getElementById('userPassword').required = true;
        document.getElementById('passwordHint').style.display = 'none';
    }

    function editUser(id, name, email, role, isActive) {
        document.getElementById('userForm').action = "/admin/users/" + id;
        document.getElementById('formMethod').value = "PUT";
        document.getElementById('modalUserTitle').innerHTML = '<i class="ti ti-user-edit me-2 text-primary"></i>Edit Pengguna';
        document.getElementById('userName').value = name;
        document.getElementById('userEmail').value = email;
        document.getElementById('userRole').value = role;
        document.getElementById('userActive').checked = isActive;
        document.getElementById('userPassword').required = false;
        document.getElementById('passwordHint').style.display = 'block';
    }

    function setResetId(id) {
        document.getElementById('resetPasswordForm').action = "/admin/users/" + id + "/reset-password";
    }

    function setDeleteId(id) {
        document.getElementById('deleteForm').action = "/admin/users/" + id;
    }
</script>
@endpush
