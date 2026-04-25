<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th style="width:70px;">Thumb</th>
                <th>Judul &amp; Kategori</th>
                <th style="width:120px;">Penulis</th>
                <th style="width:120px;">Tgl. Terbit</th>
                <th style="width:110px;">Status</th>
                <th style="width:130px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
                <tr>
                    <td>
                        <img src="{{ !empty($article->image_path) && Storage::disk('public')->exists($article->image_path) ? asset('storage/' . $article->image_path) : 'https://placehold.co/100x100?text=No+Image' }}"
                            alt="" class="table-img-thumb" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;" />
                    </td>
                    <td>
                        <strong>{{ $article->title }}</strong>
                        <div><span class="badge bg-light-info text-info" style="font-size:0.75rem;">{{ $article->category->name ?? 'Umum' }}</span></div>
                    </td>
                    <td><small>{{ $article->user->name ?? 'Admin' }}</small></td>
                    <td><small>{{ $article->published_at ? $article->published_at->format('d M Y') : '— (Draft)' }}</small></td>
                    <td>
                        @if($article->is_published)
                            <span class="badge-published">Published</span>
                        @else
                            <span class="badge-draft">Draft</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="btn btn-icon btn-light-info btn-sm" title="Preview"><i class="ti ti-eye"></i></a>
                            <a href="{{ route('admin.berita.artikel.edit', $article->id) }}" class="btn btn-icon btn-light-primary btn-sm" title="Edit"><i class="ti ti-edit"></i></a>
                            <button class="btn btn-icon btn-light-danger btn-sm" onclick="confirmDelete({{ $article->id }})" title="Hapus"><i class="ti ti-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada berita yang ditulis</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($articles->hasPages())
    <div class="d-flex justify-content-between align-items-center p-3 border-top flex-wrap gap-2">
        <div class="text-muted small">
            Menampilkan {{ $articles->firstItem() }} sampai {{ $articles->lastItem() }} dari {{ $articles->total() }} entri
        </div>
        <div class="pagination-wrapper">
            {{ $articles->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
