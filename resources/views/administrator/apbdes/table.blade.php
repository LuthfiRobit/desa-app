<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th>Uraian</th>
                <th style="width:140px;">Tipe</th>
                <th class="text-end" style="width:180px;">Anggaran</th>
                <th class="text-end" style="width:180px;">Realisasi</th>
                <th style="width:200px;">Progress</th>
                <th class="text-center" style="width:120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($finances as $finance)
                <tr>
                    <td>
                        <strong>{{ $finance->title }}</strong>
                    </td>
                    <td>
                        @php
                            $badgeClass = 'bg-light-primary text-primary';
                            $typeLabel = 'Pendapatan';
                            if ($finance->type == 'expense') { $badgeClass = 'bg-light-success text-success'; $typeLabel = 'Belanja'; }
                            if ($finance->type == 'financing') { $badgeClass = 'bg-light-warning text-warning'; $typeLabel = 'Pembiayaan'; }
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $typeLabel }}</span>
                    </td>
                    <td class="text-end">Rp {{ number_format($finance->budget_amount, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($finance->realized_amount, 0, ',', '.') }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @php
                                $progress = $finance->budget_amount > 0 ? min(100, round(($finance->realized_amount / $finance->budget_amount) * 100)) : 0;
                                $progressClass = 'bg-primary';
                                if ($finance->type == 'expense') $progressClass = 'bg-success';
                                if ($finance->type == 'financing') $progressClass = 'bg-warning';
                            @endphp
                            <div class="progress flex-grow-1" style="height: 6px;">
                                <div class="progress-bar {{ $progressClass }}" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="fw-bold">{{ $progress }}%</small>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-1 justify-content-center">
                            <button class="btn btn-icon btn-light-primary btn-sm" onclick="editApbdes({{ json_encode($finance) }})" title="Edit"><i class="ti ti-edit"></i></button>
                            <button class="btn btn-icon btn-light-danger btn-sm" onclick="confirmDelete({{ $finance->id }})" title="Hapus"><i class="ti ti-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data APBDes</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($finances->hasPages())
    <div class="d-flex justify-content-between align-items-center p-3 border-top flex-wrap gap-2">
        <div class="text-muted small">
            Menampilkan {{ $finances->firstItem() }} sampai {{ $finances->lastItem() }} dari {{ $finances->total() }} entri
        </div>
        <div class="pagination-wrapper">
            {{ $finances->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
