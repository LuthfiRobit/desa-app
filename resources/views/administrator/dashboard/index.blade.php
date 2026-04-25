@extends('administrator.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Header -->
    <div class="page-header-desa mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="ti ti-dashboard me-2"></i>Dashboard</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size:0.83rem;">
                        <li class="breadcrumb-item active">Beranda</li>
                    </ol>
                </nav>
            </div>
            <div class="text-muted" style="font-size:0.82rem;">
                <i class="ti ti-calendar me-1"></i>
                <span id="tanggal-hari-ini"></span>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card dashnum-card card-desa-primary text-white overflow-hidden">
                <span class="round small"></span><span class="round big"></span>
                <div class="card-body">
                    <div class="avtar avtar-lg bg-light-primary mb-2">
                        <i class="ti ti-news text-white"></i>
                    </div>
                    <span class="text-white d-block f-34 f-w-500 my-2">{{ $stats['total_articles'] }}</span>
                    <p class="mb-0 opacity-75">Berita Dipublikasikan</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card dashnum-card card-desa-success text-white overflow-hidden">
                <span class="round small"></span><span class="round big"></span>
                <div class="card-body">
                    <div class="avtar avtar-lg bg-light-success mb-2">
                        <i class="ti ti-calendar-event text-white"></i>
                    </div>
                    <span class="text-white d-block f-34 f-w-500 my-2">{{ $stats['total_agendas'] }}</span>
                    <p class="mb-0 opacity-75">Agenda Terdaftar</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card dashnum-card card-desa-accent text-white overflow-hidden">
                <span class="round small"></span><span class="round big"></span>
                <div class="card-body">
                    <div class="avtar avtar-lg mb-2" style="background:rgba(255,255,255,0.2);">
                        <i class="ti ti-file-description text-white"></i>
                    </div>
                    <span class="text-white d-block f-34 f-w-500 my-2">{{ $stats['total_documents'] }}</span>
                    <p class="mb-0 opacity-75">Dokumen Publik</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card dashnum-card card-desa-info text-white overflow-hidden">
                <span class="round small"></span><span class="round big"></span>
                <div class="card-body">
                    <div class="avtar avtar-lg mb-2" style="background:rgba(255,255,255,0.2);">
                        <i class="ti ti-camera text-white"></i>
                    </div>
                    <span class="text-white d-block f-34 f-w-500 my-2">{{ $stats['total_galleries'] }}</span>
                    <p class="mb-0 opacity-75">Foto Galeri</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <!-- APBDes Chart -->
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-cash me-2 text-primary"></i>Ringkasan APBDes {{ $chartData['year'] }}</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                </div>
                <div class="card-body">
                    <div id="apbdesChart"></div>
                </div>
            </div>
        </div>
        <!-- Info Desa Singkat -->
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ti ti-building-community me-2 text-primary"></i>Info Desa</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="ti ti-users me-2"></i>Penduduk</span>
                            <strong>{{ number_format($profile->population ?? 0, 0, ',', '.') }} jiwa</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="ti ti-map-2 me-2"></i>Luas Wilayah</span>
                            <strong>{{ $profile->area ?? '0' }} km²</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="ti ti-home me-2"></i>Jumlah Dusun</span>
                            <strong>{{ $profile->total_dusuns ?? '0' }} Dusun</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="ti ti-user-star me-2"></i>Kepala Desa</span>
                            <strong>{{ $profile->head_of_village_name ?? '-' }}</strong>
                        </li>
                    </ul>
                    <div class="mt-3">
                        <a href="#" class="btn btn-primary btn-sm w-100">
                            <i class="ti ti-edit me-1"></i>Edit Profil Desa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-clock me-2 text-primary"></i>Aktivitas Terbaru</h5>
                    <a href="#" class="btn btn-sm btn-primary">Lihat Semua Berita</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Tipe</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avtar avtar-s">
                                                <i class="{{ $activity['icon'] }}" style="font-size:16px;"></i>
                                            </div>
                                            <span>{{ $activity['title'] }}</span>
                                        </div>
                                    </td>
                                    <td><span class="badge {{ $activity['badge'] }}">{{ $activity['type'] }}</span></td>
                                    <td><span class="{{ $activity['status_class'] }}">{{ $activity['status'] }}</span></td>
                                    <td>{{ $activity['date'] }}</td>
                                    <td>
                                        <a href="#" class="btn btn-icon btn-light-primary btn-sm"><i class="ti ti-edit"></i></a>
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
@endsection

@push('scripts')
    <!-- ApexCharts -->
    <script src="{{ asset('admin-template/assets/js/plugins/apexcharts.min.js') }}"></script>

    <script>
        // Tanggal hari ini
        document.getElementById('tanggal-hari-ini').textContent = new Date().toLocaleDateString('id-ID', {
            weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
        });

        // APBDes Bar Chart
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                var options = {
                    series: [
                        { name: 'Anggaran', data: [{{ $chartData['income_budget'] }}, {{ $chartData['expense_budget'] }}, {{ $chartData['financing_budget'] }}] },
                        { name: 'Realisasi', data: [{{ $chartData['income_realized'] }}, {{ $chartData['expense_realized'] }}, {{ $chartData['financing_realized'] }}] }
                    ],
                    chart: { type: 'bar', height: 280, toolbar: { show: false } },
                    plotOptions: { bar: { borderRadius: 6, columnWidth: '55%' } },
                    colors: ['#2e7d32', '#a5d6a7'],
                    dataLabels: { enabled: false },
                    xaxis: { categories: ['Pendapatan', 'Belanja', 'Pembiayaan'] },
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
                new ApexCharts(document.querySelector("#apbdesChart"), options).render();
            }, 400);
        });
    </script>
@endpush
