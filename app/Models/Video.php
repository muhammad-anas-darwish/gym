<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'thumbnail_photo_path', 'video_path', 'views'];
    protected $hidden = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeFilterByUserName($query, $userName)
    {
        return $query->whereHas('user', function ($query) use ($userName) {
            $query->where('name', 'LIKE', '%' . $userName . '%');
        });
    }
}
