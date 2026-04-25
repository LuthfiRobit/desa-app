<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th style="width:50px;">No</th>
                <th>Judul Agenda</th>
                <th style="width:180px;">Tanggal &amp; Waktu</th>
                <th style="width:180px;">Lokasi</th>
                <th style="width:120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agendas as $agenda)
                <tr>
                    <td>{{ ($agendas->currentPage() - 1) * $agendas->perPage() + $loop->iteration }}</td>
                    <td>
                        <strong>{{ $agenda->title }}</strong>
                        @if($agenda->description)
                            <div class="text-muted" style="font-size:0.8rem;">{{ Str::limit($agenda->description, 60) }}</div>
                        @endif
                    </td>
                    <td>
                        @php
                            $isPast = $agenda->event_date->isPast();
                            $isToday = $agenda->event_date->isToday();
                            $badgeClass = $isPast ? 'bg-light-secondary text-secondary' : ($isToday ? 'bg-light-success text-success' : 'bg-light-primary text-primary');
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            <i class="ti ti-clock me-1"></i>{{ $agenda->event_date->format('d M Y, H:i') }}
                        </span>
                    </td>
                    <td><small><i class="ti ti-map-pin me-1 text-muted"></i>{{ $agenda->location }}</small></td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-icon btn-light-primary btn-sm" 
                                onclick="editAgenda({{ json_encode($agenda) }})" 
                                title="Edit"><i class="ti ti-edit"></i></button>
                            <button class="btn btn-icon btn-light-danger btn-sm" 
                                onclick="confirmDelete({{ $agenda->id }})" 
                                title="Hapus"><i class="ti ti-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada agenda yang terdaftar</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($agendas->hasPages())
    <div class="d-flex justify-content-between align-items-center p-3 border-top flex-wrap gap-2">
        <div class="text-muted small">
            Menampilkan {{ $agendas->firstItem() }} sampai {{ $agendas->lastItem() }} dari {{ $agendas->total() }} entri
        </div>
        <div class="pagination-wrapper">
            {{ $agendas->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
