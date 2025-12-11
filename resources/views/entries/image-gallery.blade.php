@php
    $urls = $getImageUrls();
    $width = $getThumbWidth();
    $height = $getThumbHeight();
    $gap = $getGap();
    $rounded = $getRounded();
    $zoomCursor = $hasZoomCursor();
    $wrapperClass = $getWrapperClass() ?? '';
    $galleryId = 'gallery-entry-' . str_replace(['{', '}', '-'], '', (string) \Illuminate\Support\Str::uuid());
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div
        id="{{ $galleryId }}"
        class="image-gallery flex overflow-x-auto {{ $gap }} my-2 pb-2 select-none {{ $wrapperClass }}"
        data-viewer-gallery
    >
        @forelse($urls as $src)
            <img
                src="{{ $src }}"
                loading="lazy"
                class="{{ $rounded }} shadow object-cover border border-gray-200 dark:border-gray-700 hover:scale-105 transition {{ $zoomCursor ? 'cursor-zoom-in' : '' }}"
                style="width: {{ $width }}px; height: {{ $height }}px; flex-shrink: 0;"
                alt="image"
            />
        @empty
            <span class="text-gray-400 dark:text-gray-500">{{ $getEmptyText() }}</span>
        @endforelse
    </div>
</x-dynamic-component>

@once
    @push('scripts')
        <x-image-gallery::viewer-script />
    @endpush
@endonce
