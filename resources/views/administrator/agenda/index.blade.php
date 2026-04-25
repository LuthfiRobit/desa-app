@extends('administrator.layouts.app')

@section('title', 'Agenda Desa')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush

@section('content')
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti ti-calendar-event me-2"></i>Agenda Desa</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Manajemen Konten</li>
                        <li class="breadcrumb-item active">Agenda Desa</li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-primary" onclick="addAgenda()">
                <i class="ti ti-plus me-1"></i>Tambah Agenda
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <div class="input-group" style="max-width:240px;">
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" id="searchAgenda" placeholder="Cari judul agenda..." />
                </div>
                <select class="form-select" style="width:180px;" id="filterRange">
                    <option value="">Semua Agenda</option>
                    <option value="bulan-ini">Bulan Ini</option>
                    <option value="akan-datang">Akan Datang</option>
                    <option value="sudah-lewat">Sudah Lewat</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0" id="table-container">
            @include('administrator.agenda.table')
        </div>
    </div>

    <!-- Modal Agenda -->
    <div class="modal fade" id="modalAgenda" tabindex="-1" aria-labelledby="modalAgendaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgendaLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formAgenda">
                    <div class="modal-body">
                        <input type="hidden" id="agendaId">
                        <div class="mb-3">
                            <label class="form-label">Judul Agenda <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="agendaJudul" required placeholder="Contoh: Posyandu Balita Dusun Krajan" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi / Rincian Acara</label>
                            <textarea class="form-control" name="description" id="agendaDeskripsi" rows="3" placeholder="Jelaskan rincian kegiatan..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal & Waktu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="event_date" id="agendaTanggal" required placeholder="Pilih tanggal dan jam..." />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi / Tempat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="location" id="agendaLokasi" required placeholder="Contoh: Balai Desa Sukorejo" />
                            </div>
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
    <div class="modal fade" id="modalHapusAgenda" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Hapus Agenda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-1">
                    <p>Apakah Anda yakin ingin menghapus agenda ini?</p>
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
    let agendaModal;
    let deleteModal;
    let deleteId = null;
    let currentSearch = '';
    let currentRange = '';
    let currentPage = 1;

    document.addEventListener('DOMContentLoaded', function() {
        agendaModal = new bootstrap.Modal(document.getElementById('modalAgenda'));
        deleteModal = new bootstrap.Modal(document.getElementById('modalHapusAgenda'));

        flatpickr("#agendaTanggal", {
            locale: "id",
            enableTime: true,
            time_24hr: true,
            dateFormat: "d M Y H:i"
        });

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
        document.getElementById('searchAgenda').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = this.value;
                currentPage = 1;
                fetchTable();
            }, 500);
        });

        // Handle Filter
        document.getElementById('filterRange').addEventListener('change', function() {
            currentRange = this.value;
            currentPage = 1;
            fetchTable();
        });
    });

    function fetchTable() {
        const container = document.getElementById('table-container');
        container.style.opacity = '0.5';
        
        const url = `{{ route('admin.agenda.index') }}?search=${currentSearch}&range=${currentRange}&page=${currentPage}`;
        
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

    function addAgenda() {
        document.getElementById('agendaId').value = '';
        document.getElementById('formAgenda').reset();
        document.getElementById('modalAgendaLabel').innerHTML = '<i class="ti ti-calendar-event me-2 text-primary"></i>Tambah Agenda';
        agendaModal.show();
    }

    function editAgenda(agenda) {
        document.getElementById('agendaId').value = agenda.id;
        document.getElementById('agendaJudul').value = agenda.title;
        document.getElementById('agendaDeskripsi').value = agenda.description;
        document.getElementById('agendaLokasi').value = agenda.location;
        
        // Format date for flatpickr
        const date = new Date(agenda.event_date);
        const day = ("0" + date.getDate()).slice(-2);
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();
        const hours = ("0" + date.getHours()).slice(-2);
        const minutes = ("0" + date.getMinutes()).slice(-2);
        document.getElementById('agendaTanggal').value = `${day} ${month} ${year} ${hours}:${minutes}`;

        document.getElementById('modalAgendaLabel').innerHTML = '<i class="ti ti-edit me-2 text-primary"></i>Edit Agenda';
        agendaModal.show();
    }

    document.getElementById('formAgenda').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('agendaId').value;
        const btn = document.getElementById('btnSimpan');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        const url = id ? `{{ url('admin/agenda') }}/${id}` : `{{ route('admin.agenda.store') }}`;
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
                agendaModal.hide();
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
        fetch(`{{ url('admin/agenda') }}/${deleteId}`, {
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
