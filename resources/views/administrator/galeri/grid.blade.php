<div class="row g-3">
    @forelse($galleries as $gallery)
        <div class="col-xl-4 col-md-6" id="gallery-item-{{ $gallery->id }}">
            <div class="card gallery-card h-100 mb-0">
                <div class="position-relative overflow-hidden" style="padding-top: 65%;">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                         alt="{{ $gallery->title }}"
                         class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" />
                </div>
                <div class="gallery-overlay">
                    <h6 class="text-white">{{ $gallery->title }}</h6>
                    <small class="text-white-50"><i class="ti ti-calendar me-1"></i>{{ $gallery->date_taken->format('d M Y') }}</small>
                </div>
                <div class="gallery-actions">
                    <button class="btn btn-sm btn-light-primary" 
                        onclick="editGallery({{ json_encode($gallery) }})" 
                        title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-sm btn-light-danger" 
                        onclick="confirmDelete({{ $gallery->id }})" 
                        title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card card-body text-center py-5">
                <i class="ti ti-photo-off mb-2 text-muted" style="font-size: 3rem;"></i>
                <h6 class="text-muted">Belum ada foto dalam galeri</h6>
            </div>
        </div>
    @endforelse
</div>

@if($galleries->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $galleries->links('pagination::bootstrap-5') }}
    </div>
@endif
