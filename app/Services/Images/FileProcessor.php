<?php

namespace App\Services\Images;

use App\Jobs\ProcessMediaFile;
use App\Models\TemporaryUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FileProcessor
{
    public static function storeFiles(Model $model, string $field, array $tokens)
    {
        $result = self::getTemporaryMedia($tokens);
        $temporaryUploads = $result['temporary_uploads'];
        $media = $result['media'];

        self::processFile($model, $field, $media);

        foreach ($temporaryUploads as $temporaryUpload) {
            $temporaryUpload->delete();
        }
    }

    public static function storeFile(Model $model, string $field, string $token)
    {
        self::storeFiles($model, $field, [$token]);
    }

    public static function getPhotosByQuality(Model $model, string $field, string $quality = null): array|string
    {
        $fieldRules = $model->fileRules[$field] ?? null;

        if (!$fieldRules) {
            throw new \Exception("Field rules not defined for field: {$field}");
        }

        $cacheKey = "media_urls_{$model->id}_{$field}_{$quality}";
        info($cacheKey);
        $cachedUrls = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($model, $field, $quality, $fieldRules) {
            if ($fieldRules['type'] === 'single') {
                return $quality
                    ? $model->getFirstMediaUrl($field, $quality)
                    : $model->getFirstMediaUrl($field);
            } else {
                return $model->getMedia($field)->map(function ($item) use ($quality) {
                    return $quality ? $item->getUrl($quality) : $item->getUrl();
                })->toArray();
            }
        });
        
        return $cachedUrls;

        // if ($fieldRules['type'] === 'single') { // single media
        //     return $quality
        //         ? $model->getFirstMediaUrl($field, $quality)
        //         : $model->getFirstMediaUrl($field);
        // }

        // // multiple media
        // return $model->getMedia($field)->map(function ($item) use ($quality) {
        //     return $quality ? $item->getUrl($quality) : $item->getUrl();
        // })->toArray();
    }


    protected static function processFile(Model $model, $field, $media)
    {
        $fieldRules = $model->fileRules[$field] ?? null;

        if (!$fieldRules) {
            throw new \Exception("Field rules not defined for field: {$field}");
        }

        if ($fieldRules['type'] === 'single') {
            self::processSingleFile($model, $field, $media);
        } elseif ($fieldRules['type'] === 'multiple') {
            self::processMultipleFiles($model, $field, $media);
        }
    }

    protected static function processSingleFile(Model $model, string $field, $media)
    {
        $model->clearMediaCollection($field);
        $mediaItem = $media->first();

        self::addMediaFile($model, $field, $mediaItem);
    }

    protected static function processMultipleFiles(Model $model, string $field, $media)
    {
        foreach ($media as $mediaItem) {
            self::addMediaFile($model, $field, $mediaItem);
        }
    }

    protected static function addMediaFile(Model $model, string $field, $mediaItem)
    {
        ProcessMediaFile::dispatch($model, $field, $mediaItem);
    }

    protected static function getTemporaryMedia(array $tokens): array
    {
        $temporaryUploads = TemporaryUpload::whereIn('token', $tokens)->get();

        if ($temporaryUploads->isEmpty()) {
            throw new \Exception("No media found for the provided tokens.");
        }

        $media = $temporaryUploads->flatMap(fn($upload) => $upload->getMedia());

        if ($media->isEmpty()) {
            throw new \Exception("No media files found for the provided tokens.");
        }

        return [
            'temporary_uploads' => $temporaryUploads,
            'media' => $media,
        ];
    }
}