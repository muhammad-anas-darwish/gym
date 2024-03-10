<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'is_private', 'description', 'chat_photo_path'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_chat');
    }
}
