@extends('landing.layouts.app')

@section('title', 'Transparansi APBDes Desa Sukorejo - Kotaanyar, Probolinggo')
@section('meta_description', 'Transparansi pengelolaan dana desa dan realisasi APBDes Desa Sukorejo, Kecamatan Kotaanyar, Kabupaten Probolinggo. Pantau rincian anggaran kami.')


@push('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/transparansi.css') }}">
@endpush

@section('content')
    <!-- Sub-page Hero -->
    <header class="sub-hero">
        <div class="container sub-hero-content">
            <h1>Transparansi Keuangan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Transparansi</li>
                </ol>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="py-5 mt-3">
        <div class="container">
            <div class="section-title">
                <h2>Realisasi APBDes Tahun {{ date('Y') }}</h2>
                <p class="text-muted">Mewujudkan pemerintahan desa yang akuntabel dan transparan.</p>
            </div>

            <!-- Summary Stats -->
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <div class="finance-stat-card pendapatan">
                        <div class="icon"><i class="fas fa-wallet"></i></div>
                        <p>Total Pendapatan</p>
                        <h3>Rp {{ number_format($income->sum('realized_amount'), 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="finance-stat-card belanja">
                        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                        <p>Total Belanja</p>
                        <h3>Rp {{ number_format($expenditure->sum('realized_amount'), 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="finance-stat-card pembiayaan">
                        <div class="icon"><i class="fas fa-piggy-bank"></i></div>
                        <p>Selisih (Surplus/Defisit)</p>
                        @php
                            $diff = $income->sum('realized_amount') - $expenditure->sum('realized_amount');
                        @endphp
                        <h3 class="{{ $diff < 0 ? 'text-danger' : '' }}">Rp {{ number_format($diff, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

            <!-- Detailed Table Row -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="finance-table-wrapper">
                        <h4 class="chart-title text-start mb-4">Rincian Anggaran Pendapatan dan Belanja Desa (APBDes)</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Uraian / Bidang</th>
                                        <th class="text-end">Anggaran (Rp)</th>
                                        <th class="text-end">Realisasi (Rp)</th>
                                        <th class="text-center" style="width: 20%;">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-light">
                                        <td colspan="4" class="fw-bold text-success"><i class="fas fa-plus-circle me-2"></i>PENDAPATAN DESA</td>
                                    </tr>
                                    @forelse($income as $item)
                                        <tr>
                                            <td class="ps-4">{{ $item->title }}</td>
                                            <td class="text-end">{{ number_format($item->budget_amount, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($item->realized_amount, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $percentage = $item->budget_amount > 0 ? ($item->realized_amount / $item->budget_amount) * 100 : 0;
                                                @endphp
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="small">{{ number_format($percentage, 1) }}%</span>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Data pendapatan belum tersedia</td>
                                        </tr>
                                    @endforelse

                                    <tr class="table-light mt-4">
                                        <td colspan="4" class="fw-bold text-danger"><i class="fas fa-minus-circle me-2"></i>BELANJA DESA</td>
                                    </tr>
                                    @forelse($expenditure as $item)
                                        <tr>
                                            <td class="ps-4">{{ $item->title }}</td>
                                            <td class="text-end">{{ number_format($item->budget_amount, 0, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($item->realized_amount, 0, ',', '.') }}</td>
                                            <td>
                                                @php
                                                    $percentage = $item->budget_amount > 0 ? ($item->realized_amount / $item->budget_amount) * 100 : 0;
                                                @endphp
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="small">{{ number_format($percentage, 1) }}%</span>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-danger" style="width: {{ $percentage }}%"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Data belanja belum tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
