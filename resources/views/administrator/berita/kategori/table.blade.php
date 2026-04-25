<div class="table-responsive">
    <table class="table table-hover mb-0" id="tabelKategori">
        <thead class="table-light">
            <tr>
                <th style="width:50px;">No</th>
                <th>Nama Kategori</th>
                <th>Slug</th>
                <th style="width:120px;">Jml. Artikel</th>
                <th style="width:120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr id="category-row-{{ $category->id }}">
                    <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                    <td class="category-name"><strong>{{ $category->name }}</strong></td>
                    <td><span class="slug-preview">{{ $category->slug }}</span></td>
                    <td><span class="badge bg-light-primary text-primary">{{ $category->articles_count }} artikel</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-icon btn-light-primary btn-sm" onclick="editCategory({{ $category->id }}, '{{ $category->name }}')" title="Edit"><i class="ti ti-edit"></i></button>
                            <button class="btn btn-icon btn-light-danger btn-sm" onclick="confirmDelete({{ $category->id }})" title="Hapus"><i class="ti ti-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($categories->hasPages())
    <div class="d-flex justify-content-between align-items-center p-3 border-top flex-wrap gap-2">
        <div class="text-muted small">
            Menampilkan {{ $categories->firstItem() }} sampai {{ $categories->lastItem() }} dari {{ $categories->total() }} entri
        </div>
        <div class="pagination-wrapper">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endif
