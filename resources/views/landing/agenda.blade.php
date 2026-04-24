@extends('landing.layouts.app')

@section('title', 'Agenda Kegiatan - Desa Sukorejo')

@push('styles')
    <link rel="stylesheet" href="{{ asset('template/assets/css/agenda.css') }}">
@endpush

@section('content')
    <header class="sub-hero">
        <div class="container sub-hero-content text-center">
            <h1>Agenda Kegiatan Desa</h1>
            <p class="lead opacity-75">Jadwal acara dan kegiatan penting yang akan datang</p>
        </div>
    </header>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    @forelse($agendas as $agenda)
                        <div class="agenda-card">
                            <div class="agenda-date">
                                <span class="day">{{ $agenda->event_date->format('d') }}</span>
                                <span class="month-year">{{ $agenda->event_date->format('M Y') }}</span>
                            </div>
                            <div class="agenda-content">
                                <h3 class="agenda-title">{{ $agenda->title }}</h3>
                                <div class="agenda-meta">
                                    <span><i class="far fa-clock"></i> {{ $agenda->event_date->format('H.i') }} WIB - Selesai</span>
                                    <span><i class="fas fa-map-marker-alt"></i> {{ $agenda->location }}</span>
                                </div>
                                <p class="agenda-desc">{{ $agenda->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="far fa-calendar-times fa-4x text-muted opacity-25"></i>
                            </div>
                            <h4 class="text-muted">Belum ada agenda kegiatan yang terdaftar</h4>
                            <p class="text-muted">Silakan periksa kembali di lain waktu untuk informasi kegiatan terbaru.</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $agendas->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection
