<?php

namespace App\Traits;

use Spatie\MediaLibrary\InteractsWithMedia as BaseInteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait InteractsWithMedia
{
    use BaseInteractsWithMedia;

    public function registerMediaConversions(Media $media = null): void
    {
        if (property_exists($this, 'fileRules')) {
            foreach ($this->fileRules as $collection => $fieldDetails) {
                foreach ($fieldDetails['sizes'] as $conversionName => $dimensions) {
                    $this->addMediaConversion($conversionName)
                        ->fit(Fit::Crop, $dimensions[0], $dimensions[1])
                        ->performOnCollections($collection);
                }
            }
        }
    }
}