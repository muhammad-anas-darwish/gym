<?php

namespace App\Models;

use App\Enums\ChatType;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'is_direct',
        'chat_type', // who can send messages in chat
    ];
    
    protected $casts = [
        'chat_type' => ChatType::class,
    ];

    public function scopeFilter($query, callable $callback)
    {
        return (new QueryFilter)->apply($query, $callback);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, UserChat::class)->withTimestamps();
    }

    public function group(): HasOne
    {
        return $this->hasOne(Group::class);
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}
