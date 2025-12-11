@php
    $urls = $getImageUrls();
    $limit = $getLimit();
    $visibleUrls = $limit ? array_slice($urls, 0, $limit) : $urls;
    $remaining = $limit ? max(0, count($urls) - $limit) : 0;
    $width = $getThumbWidth();
    $height = $isSquare() ? $width : $getThumbHeight();
    $isStacked = $isStacked();
    $stackedOverlap = $getStackedOverlap();
    $isSquare = $isSquare();
    $isCircle = $isCircle();
    $ringWidth = $getRingWidth();
    $ringColor = $getRingColor();
    $galleryId = 'gallery-col-' . str_replace(['{', '}', '-'], '', (string) \Illuminate\Support\Str::uuid());
    
    // Determine border radius class
    if ($isCircle) {
        $borderRadiusClass = 'rounded-full';
    } elseif ($isSquare) {
        $borderRadiusClass = 'rounded-lg';
    } else {
        $borderRadiusClass = 'rounded';
    }
    
    // Border/Ring styles - only add if ringWidth > 0
    $hasRing = $ringWidth > 0;
    if ($hasRing) {
        $ringStyle = "border-width: {$ringWidth}px; border-style: solid;";
        if ($ringColor) {
            $ringStyle .= " border-color: {$ringColor};";
            $borderColorClass = '';
        } else {
            $borderColorClass = 'border-white dark:border-gray-800';
        }
    } else {
        $ringStyle = '';
        $borderColorClass = '';
    }
    
    // Stacked spacing - use dynamic -space-x value
    if ($isStacked) {
        $stackedClass = "-space-x-{$stackedOverlap} rtl:space-x-reverse";
    } else {
        $stackedClass = 'gap-1';
    }
@endphp

<div
    id="{{ $galleryId }}"
    class="flex items-center {{ $stackedClass }}"
    data-viewer-gallery
    wire:ignore.self
>
    @forelse($visibleUrls as $src)
        <img
            src="{{ $src }}"
            loading="lazy"
            class="object-cover {{ $borderColorClass }} shadow-sm {{ $borderRadiusClass }} hover:scale-110 transition cursor-zoom-in"
            style="width: {{ $width }}px; height: {{ $height }}px; min-width: {{ $width }}px; {{ $ringStyle }}"
            alt="image"
        />
    @empty
        <span class="text-sm text-gray-400 dark:text-gray-500">{{ $getEmptyText() }}</span>
    @endforelse

    @if($shouldShowRemainingText() && $remaining > 0)
        <span class="flex items-center justify-center text-xs font-medium text-gray-600 dark:text-gray-200"
              style="width: {{ $width }}px; height: {{ $height }}px; min-width: {{ $width }}px;">
            +{{ $remaining }}
        </span>
    @endif
</div>

@once
    <x-image-gallery::viewer-script />
@endonce
