@extends('administrator.layouts.app')

@section('title', 'Data APBDes')

@section('content')
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti ti-cash me-2"></i>Data APBDes</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Keuangan &amp; Transparansi</li>
                        <li class="breadcrumb-item active">Data APBDes</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <select class="form-select" style="width: 150px;" id="filterYear">
                    @forelse($years as $y)
                        <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @empty
                        <option value="{{ date('Y') }}">Tahun {{ date('Y') }}</option>
                    @endforelse
                </select>
                <button class="btn btn-primary" onclick="addApbdes()">
                    <i class="ti ti-plus me-1"></i>Tambah Data
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row" id="summary-cards">
        <div class="col-md-4 mb-4">
            <div class="card bg-light-primary border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="text-primary mb-0">Total Pendapatan</h6>
                        <div class="text-primary"><i class="ti ti-arrow-down-circle" style="font-size: 24px;"></i></div>
                    </div>
                    <h3 class="mb-1 fw-bold text-primary" id="sum-pendapatan-budget">Rp {{ number_format($summary['pendapatan']['budget'], 0, ',', '.') }}</h3>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <small class="text-muted">Realisasi:</small>
                        <small class="fw-bold text-primary" id="sum-pendapatan-real">Rp {{ number_format($summary['pendapatan']['realization'], 0, ',', '.') }} ({{ $summary['pendapatan']['budget'] > 0 ? round(($summary['pendapatan']['realization'] / $summary['pendapatan']['budget']) * 100) : 0 }}%)</small>
                    </div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-primary" id="prog-pendapatan" role="progressbar" style="width: {{ $summary['pendapatan']['budget'] > 0 ? min(100, round(($summary['pendapatan']['realization'] / $summary['pendapatan']['budget']) * 100)) : 0 }}%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-light-success border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="text-success mb-0">Total Belanja</h6>
                        <div class="text-success"><i class="ti ti-arrow-up-circle" style="font-size: 24px;"></i></div>
                    </div>
                    <h3 class="mb-1 fw-bold text-success" id="sum-belanja-budget">Rp {{ number_format($summary['belanja']['budget'], 0, ',', '.') }}</h3>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <small class="text-muted">Realisasi:</small>
                        <small class="fw-bold text-success" id="sum-belanja-real">Rp {{ number_format($summary['belanja']['realization'], 0, ',', '.') }} ({{ $summary['belanja']['budget'] > 0 ? round(($summary['belanja']['realization'] / $summary['belanja']['budget']) * 100) : 0 }}%)</small>
                    </div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-success" id="prog-belanja" role="progressbar" style="width: {{ $summary['belanja']['budget'] > 0 ? min(100, round(($summary['belanja']['realization'] / $summary['belanja']['budget']) * 100)) : 0 }}%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-light-warning border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="text-warning mb-0">Total Pembiayaan</h6>
                        <div class="text-warning"><i class="ti ti-refresh" style="font-size: 24px;"></i></div>
                    </div>
                    <h3 class="mb-1 fw-bold text-warning" id="sum-pembiayaan-budget">Rp {{ number_format($summary['pembiayaan']['budget'], 0, ',', '.') }}</h3>
                    <div class="d-flex align-items-center justify-content-between mt-3">
                        <small class="text-muted">Realisasi:</small>
                        <small class="fw-bold text-warning" id="sum-pembiayaan-real">Rp {{ number_format($summary['pembiayaan']['realization'], 0, ',', '.') }} ({{ $summary['pembiayaan']['budget'] > 0 ? round(($summary['pembiayaan']['realization'] / $summary['pembiayaan']['budget']) * 100) : 0 }}%)</small>
                    </div>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-warning" id="prog-pembiayaan" role="progressbar" style="width: {{ $summary['pembiayaan']['budget'] > 0 ? min(100, round(($summary['pembiayaan']['realization'] / $summary['pembiayaan']['budget']) * 100)) : 0 }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Row -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">Grafik Anggaran vs Realisasi (<span id="chart-year">{{ $currentYear }}</span>)</h5>
                </div>
                <div class="card-body">
                    <div id="apbdes-chart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <div class="input-group" style="max-width:240px;">
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" id="searchApbdes" placeholder="Cari uraian..." />
                </div>
                <select class="form-select" style="width:180px;" id="filterTipe">
                    <option value="">Semua Tipe</option>
                    <option value="income">Pendapatan</option>
                    <option value="expense">Belanja</option>
                    <option value="financing">Pembiayaan</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0" id="table-container">
            @include('administrator.apbdes.table')
        </div>
    </div>

    <!-- Modal Create/Edit -->
    <div class="modal fade" id="modalApbdes" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalApbdesLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formApbdes">
                    <div class="modal-body">
                        <input type="hidden" id="apbdesId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Anggaran <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="year" id="apbdesTahun" value="{{ date('Y') }}" required />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipe <span class="text-danger">*</span></label>
                                <select class="form-select" name="type" id="apbdesTipe" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="income">Pendapatan</option>
                                    <option value="expense">Belanja</option>
                                    <option value="financing">Pembiayaan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Uraian <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="apbdesUraian" required placeholder="Contoh: Dana Desa (DD)" />
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah Anggaran (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control input-rupiah" id="apbdesAnggaran" placeholder="0" required />
                                    <input type="hidden" name="budget_amount" id="apbdesAnggaranReal">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah Realisasi (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control input-rupiah" id="apbdesRealisasi" placeholder="0" />
                                    <input type="hidden" name="realized_amount" id="apbdesRealisasiReal">
                                </div>
                                <small class="form-text text-muted mt-1">Kosongkan jika belum ada realisasi.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan"><i class="ti ti-device-floppy me-1"></i>Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="ti ti-alert-triangle me-2"></i>Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-1">
                    <p>Hapus data APBDes ini? Tindakan ini tidak dapat dibatalkan.</p>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    let apbdesModal;
    let deleteModal;
    let deleteId = null;
    let currentSearch = '';
    let currentType = '';
    let currentYear = '{{ $currentYear }}';
    let currentPage = 1;
    let chart;

    document.addEventListener('DOMContentLoaded', function() {
        apbdesModal = new bootstrap.Modal(document.getElementById('modalApbdes'));
        deleteModal = new bootstrap.Modal(document.getElementById('modalHapus'));

        // Init ApexCharts
        var options = {
            series: [{
                name: 'Anggaran',
                data: [{{ $summary['pendapatan']['budget'] }}, {{ $summary['belanja']['budget'] }}, {{ $summary['pembiayaan']['budget'] }}]
            }, {
                name: 'Realisasi',
                data: [{{ $summary['pendapatan']['realization'] }}, {{ $summary['belanja']['realization'] }}, {{ $summary['pembiayaan']['realization'] }}]
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '55%'
                }
            },
            colors: ['#2e7d32', '#a5d6a7'],
            dataLabels: { enabled: false },
            xaxis: {
                categories: ['Pendapatan', 'Belanja', 'Pembiayaan'],
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return 'Rp ' + (val / 1000000).toFixed(0) + ' Jt';
                    }
                }
            },
            legend: { position: 'top' },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            }
        };

        chart = new ApexCharts(document.querySelector("#apbdes-chart"), options);
        chart.render();

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
        document.getElementById('searchApbdes').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = this.value;
                currentPage = 1;
                fetchTable();
            }, 500);
        });

        // Handle Type Filter
        document.getElementById('filterTipe').addEventListener('change', function() {
            currentType = this.value;
            currentPage = 1;
            fetchTable();
        });

        // Handle Year Filter
        document.getElementById('filterYear').addEventListener('change', function() {
            currentYear = this.value;
            document.getElementById('chart-year').innerText = currentYear;
            currentPage = 1;
            fetchTable();
        });

        // Format Rupiah Input
        document.querySelectorAll('.input-rupiah').forEach(function(input) {
            input.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });
        });
    });

    function fetchTable() {
        const container = document.getElementById('table-container');
        container.style.opacity = '0.5';
        
        const url = `{{ route('admin.apbdes.index') }}?search=${currentSearch}&type=${currentType}&year=${currentYear}&page=${currentPage}`;
        
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            container.innerHTML = data.html;
            container.style.opacity = '1';

            // Update Summaries
            updateSummaryCards(data.summary);

            // Update Chart
            chart.updateSeries([{
                name: 'Anggaran',
                data: data.chart_data.budget
            }, {
                name: 'Realisasi',
                data: data.chart_data.realization
            }]);
        })
        .catch(error => {
            console.error('Error:', error);
            container.style.opacity = '1';
        });
    }

    function updateSummaryCards(summary) {
        // Pendapatan
        document.getElementById('sum-pendapatan-budget').innerText = 'Rp ' + summary.pendapatan.budget.toLocaleString('id-ID');
        let progPendapatan = summary.pendapatan.budget > 0 ? Math.round((summary.pendapatan.realization / summary.pendapatan.budget) * 100) : 0;
        document.getElementById('sum-pendapatan-real').innerText = `Rp ${summary.pendapatan.realization.toLocaleString('id-ID')} (${progPendapatan}%)`;
        document.getElementById('prog-pendapatan').style.width = progPendapatan + '%';

        // Belanja
        document.getElementById('sum-belanja-budget').innerText = 'Rp ' + summary.belanja.budget.toLocaleString('id-ID');
        let progBelanja = summary.belanja.budget > 0 ? Math.round((summary.belanja.realization / summary.belanja.budget) * 100) : 0;
        document.getElementById('sum-belanja-real').innerText = `Rp ${summary.belanja.realization.toLocaleString('id-ID')} (${progBelanja}%)`;
        document.getElementById('prog-belanja').style.width = progBelanja + '%';

        // Pembiayaan
        document.getElementById('sum-pembiayaan-budget').innerText = 'Rp ' + summary.pembiayaan.budget.toLocaleString('id-ID');
        let progPembiayaan = summary.pembiayaan.budget > 0 ? Math.round((summary.pembiayaan.realization / summary.pembiayaan.budget) * 100) : 0;
        document.getElementById('sum-pembiayaan-real').innerText = `Rp ${summary.pembiayaan.realization.toLocaleString('id-ID')} (${progPembiayaan}%)`;
        document.getElementById('prog-pembiayaan').style.width = progPembiayaan + '%';
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function cleanRupiah(rupiah) {
        return rupiah.replace(/[^,\d]/g, '');
    }

    function addApbdes() {
        document.getElementById('apbdesId').value = '';
        document.getElementById('formApbdes').reset();
        document.getElementById('apbdesTahun').value = currentYear || new Date().getFullYear();
        document.getElementById('modalApbdesLabel').innerHTML = '<i class="ti ti-cash me-2 text-primary"></i>Tambah Data APBDes';
        apbdesModal.show();
    }

    function editApbdes(finance) {
        document.getElementById('apbdesId').value = finance.id;
        document.getElementById('apbdesTahun').value = finance.year;
        document.getElementById('apbdesTipe').value = finance.type;
        document.getElementById('apbdesUraian').value = finance.title;
        document.getElementById('apbdesAnggaran').value = formatRupiah(finance.budget_amount.toString());
        document.getElementById('apbdesRealisasi').value = finance.realized_amount ? formatRupiah(finance.realized_amount.toString()) : '';
        document.getElementById('modalApbdesLabel').innerHTML = '<i class="ti ti-edit me-2 text-primary"></i>Edit Data APBDes';
        apbdesModal.show();
    }

    document.getElementById('formApbdes').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clean values before sending
        document.getElementById('apbdesAnggaranReal').value = cleanRupiah(document.getElementById('apbdesAnggaran').value) || 0;
        document.getElementById('apbdesRealisasiReal').value = cleanRupiah(document.getElementById('apbdesRealisasi').value) || 0;

        const id = document.getElementById('apbdesId').value;
        const btn = document.getElementById('btnSimpan');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        const url = id ? `{{ url('admin/apbdes') }}/${id}` : `{{ route('admin.apbdes.store') }}`;
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
            btn.innerHTML = '<i class="ti ti-device-floppy me-1"></i>Simpan Data';
            if (result.success) {
                apbdesModal.hide();
                fetchTable();
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<i class="ti ti-device-floppy me-1"></i>Simpan Data';
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
        fetch(`{{ url('admin/apbdes') }}/${deleteId}`, {
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
