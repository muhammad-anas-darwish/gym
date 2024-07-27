<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'name', 
        'slug', 
        'description', 
        'chat_photo_path',
        'is_private',
    ];

    protected $appends = [
        'chat_photo_url',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function setSlugAttribute($value) 
    {
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }
    
        $this->attributes['slug'] = $slug;
    }

    private function incrementSlug($slug) 
    {
        $original = $slug;
        $count = 2;
    
        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }
    
        return $slug;
    }

    public function getChatPhotoUrlAttribute()
    {
        return $this->chat_photo_path
                    ? asset('storage/' . $this->chat_photo_path)
                    : $this->defaultChatPhotoUrl();
    }

    protected function defaultChatPhotoUrl()
    {
        return asset('storage/images/default-group-photo.png'); // TODO add image in this path
    }
}
