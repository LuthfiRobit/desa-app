@foreach($galleries as $gallery)
    <div class="col-lg-4 col-md-6 gallery-item-container">
        <div class="gallery-item" style="cursor: pointer;" 
             onclick="openGalleryModal('{{ !empty($gallery->image_path) && Storage::disk('public')->exists($gallery->image_path) ? asset('storage/' . $gallery->image_path) : 'https://placehold.co/800x600?text=' . urlencode($gallery->title) }}', '{{ $gallery->title }}', '{{ $gallery->date_taken ? $gallery->date_taken->format('d M Y') : '-' }}')">
            <img src="{{ !empty($gallery->image_path) && Storage::disk('public')->exists($gallery->image_path) ? asset('storage/' . $gallery->image_path) : 'https://placehold.co/600x450?text=' . urlencode($gallery->title) }}"
                alt="{{ $gallery->title }}">
            <div class="gallery-overlay">
                <h4 class="gallery-title">{{ $gallery->title }}</h4>
                <span class="gallery-date"><i class="far fa-calendar-alt me-1"></i> {{ $gallery->date_taken ? $gallery->date_taken->format('d M Y') : '-' }}</span>
            </div>
        </div>
    </div>
@endforeach

@if($galleries->hasMorePages())
    <div id="next-page-marker" data-has-more="true" style="display:none;"></div>
@else
    <div id="next-page-marker" data-has-more="false" style="display:none;"></div>
@endif
