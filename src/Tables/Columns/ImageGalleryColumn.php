<?php

namespace Alsaloul\ImageGallery\Tables\Columns;

use Closure;
use Filament\Tables\Columns\Column;

class ImageGalleryColumn extends Column
{
    protected string $view = 'image-gallery::columns.image-gallery';

    protected int | Closure $thumbWidth = 40;

    protected int | Closure $thumbHeight = 40;

    protected int | Closure | null $limit = 3;

    protected bool | Closure $isStacked = false;

    protected int | Closure $stackedOverlap = 2;

    protected bool | Closure $isSquare = false;

    protected bool | Closure $isCircle = false;

    protected int | Closure $ringWidth = 1;

    protected string | Closure | null $ringColor = null;

    protected bool | Closure $showRemainingText = true;

    protected string | Closure $emptyText = 'No images';

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

    public function limit(int | Closure | null $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->evaluate($this->limit);
    }

    public function stacked(int | bool | Closure $overlap = true): static
    {
        if (is_int($overlap)) {
            $this->isStacked = true;
            $this->stackedOverlap = $overlap;
        } else {
            $this->isStacked = $overlap;
        }

        return $this;
    }

    public function isStacked(): bool
    {
        return $this->evaluate($this->isStacked);
    }

    public function getStackedOverlap(): int
    {
        return $this->evaluate($this->stackedOverlap);
    }

    public function square(bool | Closure $condition = true): static
    {
        $this->isSquare = $condition;

        return $this;
    }

    public function isSquare(): bool
    {
        return $this->evaluate($this->isSquare);
    }

    public function circle(bool | Closure $condition = true): static
    {
        $this->isCircle = $condition;

        return $this;
    }

    public function isCircle(): bool
    {
        return $this->evaluate($this->isCircle);
    }

    public function ring(int | Closure $width = 2, string | Closure | null $color = null): static
    {
        $this->ringWidth = $width;
        
        if ($color !== null) {
            $this->ringColor = $color;
        }

        return $this;
    }

    public function ringColor(string | Closure | null $color): static
    {
        $this->ringColor = $color;

        return $this;
    }

    public function getRingWidth(): int
    {
        return $this->evaluate($this->ringWidth);
    }

    public function getRingColor(): ?string
    {
        return $this->evaluate($this->ringColor);
    }

    public function limitedRemainingText(bool | Closure $condition = true): static
    {
        $this->showRemainingText = $condition;

        return $this;
    }

    public function shouldShowRemainingText(): bool
    {
        return $this->evaluate($this->showRemainingText);
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
