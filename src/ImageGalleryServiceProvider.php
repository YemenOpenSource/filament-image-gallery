<?php

namespace Alsaloul\ImageGallery;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ImageGalleryServiceProvider extends PackageServiceProvider
{
    public static string $name = 'image-gallery';

    public static string $viewNamespace = 'image-gallery';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasViews(static::$viewNamespace)
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        // Register assets
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );
    }

    protected function getAssetPackageName(): ?string
    {
        return 'al-saloul/filament-image-gallery';
    }

    /**
     * @return array<\Filament\Support\Assets\Asset>
     */
    protected function getAssets(): array
    {
        return [
            Css::make('image-gallery-styles', __DIR__ . '/../resources/dist/image-gallery.css'),
            Js::make('image-gallery-scripts', __DIR__ . '/../resources/dist/image-gallery.js'),
        ];
    }
}
