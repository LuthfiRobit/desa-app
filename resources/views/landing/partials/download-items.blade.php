@forelse($documents as $document)
    <div class="doc-item-container">
        <div class="doc-item">
            @php
                $ext = strtolower($document->file_extension);
                $iconClass = 'secondary';
                if ($ext == 'pdf') {
                    $iconClass = 'pdf';
                } elseif (in_array($ext, ['doc', 'docx'])) {
                    $iconClass = 'word';
                } elseif (in_array($ext, ['xls', 'xlsx'])) {
                    $iconClass = 'excel';
                }
                
                $iconName = 'file-alt';
                if ($ext == 'pdf') {
                    $iconName = 'file-pdf';
                } elseif (in_array($ext, ['doc', 'docx'])) {
                    $iconName = 'file-word';
                } elseif (in_array($ext, ['xls', 'xlsx'])) {
                    $iconName = 'file-excel';
                }
            @endphp
            <div class="doc-icon {{ $iconClass }}"><i class="fas fa-{{ $iconName }}"></i></div>
            <div class="doc-info">
                <h4 class="doc-title">{{ $document->title }}</h4>
                <div class="doc-meta">
                    <span><i class="fas fa-file-alt"></i> Format: {{ strtoupper($ext) }}</span>
                    <span><i class="fas fa-weight-hanging"></i> {{ $document->file_size }} KB</span>
                    <span><i class="far fa-calendar-alt"></i> Update: {{ $document->updated_at->format('d M Y') }}</span>
                    @if($document->category)
                        <span><i class="fas fa-tag"></i> {{ $document->category->name }}</span>
                    @endif
                </div>
            </div>
            <a href="{{ asset('storage/' . $document->file_path) }}" class="btn-download" title="Unduh File" download>
                <i class="fas fa-download"></i> Download
            </a>
        </div>
    </div>
@empty
    <div class="text-center py-5 bg-light rounded-4 empty-state">
        <i class="fas fa-folder-open fa-4x text-muted mb-3 opacity-50"></i>
        <h5 class="text-muted fw-bold">Belum ada dokumen yang tersedia</h5>
        <p class="text-muted small mb-0">Coba pilih kategori lain atau gunakan kata kunci pencarian yang berbeda.</p>
    </div>
@endforelse

@if($documents->hasMorePages())
    <div id="next-page-marker" data-has-more="true" style="display:none;"></div>
@else
    <div id="next-page-marker" data-has-more="false" style="display:none;"></div>
@endif
