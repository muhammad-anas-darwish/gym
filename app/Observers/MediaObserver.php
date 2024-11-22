<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaObserver
{
    public function updated(Media $media)
    {
        $cacheKey = "media_urls_{$media->model_id}_{$media->collection_name}_{$media->quality}";
        
        Cache::forget($cacheKey);
    }

    public function created(Media $media)
    {
        $cacheKey = "media_urls_{$media->model_id}_{$media->collection_name}_{$media->quality}";
        
        Cache::forget($cacheKey);
    }
}
