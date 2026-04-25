<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th style="width:50px;">No</th>
                <th>Nama Kategori</th>
                <th style="width:160px;">Jumlah Dokumen</th>
                <th style="width:120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $colors = ['primary', 'success', 'warning', 'info', 'danger'];
            @endphp
            @forelse($categories as $category)
                <tr>
                    <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avtar avtar-s bg-light-{{ $colors[$loop->index % 5] }}">
                                <i class="ti ti-folder text-{{ $colors[$loop->index % 5] }}"></i>
                            </div>
                            <strong>{{ $category->name }}</strong>
                        </div>
                    </td>
                    <td><span class="badge bg-light-primary text-primary">{{ $category->documents_count }} dokumen</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-icon btn-light-primary btn-sm" 
                                onclick="editKategori({{ json_encode($category) }})" 
                                title="Edit"><i class="ti ti-edit"></i></button>
                            <button class="btn btn-icon btn-light-danger btn-sm" 
                                onclick="confirmDelete({{ $category->id }})" 
                                title="Hapus"><i class="ti ti-trash"></i></button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">Belum ada kategori dokumen yang terdaftar</td>
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
