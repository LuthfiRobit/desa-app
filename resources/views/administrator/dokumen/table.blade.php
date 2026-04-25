<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th style="width:50px;">Format</th>
                <th>Nama Dokumen</th>
                <th style="width:190px;">Kategori</th>
                <th style="width:90px;">Ukuran</th>
                <th style="width:120px;">Tgl. Update</th>
                <th style="width:140px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $document)
                <tr>
                    <td class="text-center">
                        @php
                            $ext = strtolower($document->file_extension);
                            $iconClass = 'ti-file-description';
                            $iconColor = 'text-muted';
                            if ($ext == 'pdf') { $iconClass = 'ti-file-type-pdf text-danger'; }
                            elseif (in_array($ext, ['doc', 'docx'])) { $iconClass = 'ti-file-type-doc text-primary'; }
                            elseif (in_array($ext, ['xls', 'xlsx'])) { $iconClass = 'ti-file-spreadsheet text-success'; }
                        @endphp
                        <i class="ti {{ $iconClass }}" style="font-size:24px;"></i>
                    </td>
                    <td>
                        <strong>{{ $document->title }}</strong>
                        @if($document->description)
                            <div class="text-muted" style="font-size:0.78rem;">{{ Str::limit($document->description, 60) }}</div>
                        @endif
                    </td>
                    <td><span class="badge bg-light-primary text-primary">{{ $document->category->name ?? 'Tanpa Kategori' }}</span></td>
                    <td><small class="rupiah-badge">{{ number_format($document->file_size / 1024, 0) }} KB</small></td>
                    <td><small>{{ $document->updated_at->format('d M Y') }}</small></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn btn-icon btn-light-success btn-sm" title="Download"><i class="ti ti-download"></i></a>
                            <button class="btn btn-icon btn-light-primary btn-sm" 
                                onclick="editDokumen({{ json_encode($document) }})" 
                                title="Edit"><i class="ti ti-edit"></i></button>
                            <button class="btn btn-icon btn-light-danger btn-sm" 
                                onclick="confirmDelete({{ $document->id }})" 
                                title="Hapus"><i class="ti ti-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada dokumen yang diunggah</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($documents->hasPages())
    <div class="d-flex justify-content-between align-items-center p-3 border-top flex-wrap gap-2">
        <div class="text-muted small">
            Menampilkan {{ $documents->firstItem() }} sampai {{ $documents->lastItem() }} dari {{ $documents->total() }} entri
        </div>
        <div class="pagination-wrapper">
            {{ $documents->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
