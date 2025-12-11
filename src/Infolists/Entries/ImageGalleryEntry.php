<?php

namespace Alsaloul\ImageGallery\Infolists\Entries;

use Closure;
use Filament\Infolists\Components\Entry;

class ImageGalleryEntry extends Entry
{
    protected string $view = 'image-gallery::entries.image-gallery';

    protected int | Closure $thumbWidth = 128;

    protected int | Closure $thumbHeight = 128;

    protected string | Closure $gap = 'gap-4';

    protected string | Closure $rounded = 'rounded-lg';

    protected bool | Closure $zoomCursor = true;

    protected string | Closure $emptyText = 'No images';

    protected string | Closure | null $wrapperClass = null;

    public function thumbWidth(int | Closure $width): static
    {
        $this->thumbWidth = $width;

        return $this;
    }

    public function getThumbWidth(): int
    {
        return $this->evaluate($this->thumbWidth);
    }

    public function thumbHeight(int | Closure $height): static
    {
        $this->thumbHeight = $height;

        return $this;
    }

    public function getThumbHeight(): int
    {
        return $this->evaluate($this->thumbHeight);
    }

    public function gap(string | Closure $gap): static
    {
        $this->gap = $gap;

        return $this;
    }

    public function getGap(): string
    {
        return $this->evaluate($this->gap);
    }

    public function rounded(string | Closure $rounded): static
    {
        $this->rounded = $rounded;

        return $this;
    }

    public function getRounded(): string
    {
        return $this->evaluate($this->rounded);
    }

    public function zoomCursor(bool | Closure $condition = true): static
    {
        $this->zoomCursor = $condition;

        return $this;
    }

    public function hasZoomCursor(): bool
    {
        return $this->evaluate($this->zoomCursor);
    }

    public function emptyText(string | Closure $text): static
    {
        $this->emptyText = $text;

        return $this;
    }

    public function getEmptyText(): string
    {
        return $this->evaluate($this->emptyText);
    }

    public function wrapperClass(string | Closure | null $class): static
    {
        $this->wrapperClass = $class;

        return $this;
    }

    public function getWrapperClass(): ?string
    {
        return $this->evaluate($this->wrapperClass);
    }

    /**
     * Get normalized image URLs from state
     */
    public function getImageUrls(): array
    {
        $state = $this->getState();

        if (empty($state)) {
            return [];
        }

        return collect($state)->map(function ($item) {
            if (is_string($item)) {
                return $item;
            }
            if (is_array($item)) {
                return $item['image'] ?? $item['url'] ?? null;
            }
            if (is_object($item)) {
                return $item->image ?? $item->url ?? null;
            }

            return null;
        })->filter()->values()->toArray();
    }
}
