<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'article_photo_path',
        'views_count'
    ];

    /**
     * Get the post that owns the comment.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select(['id', 'name']);
    }

    public function scopeFilter($query)
    {
        return (new QueryFilter)->apply($query, function ($filter) {
            $filter->group(function ($filter) {
                $filter
                    ->search('title', request()->q)
                    ->orSearch('description', request()->q);
            })
                ->where('category_id', request()->category_id)
                ->where('user_id', request()->user_id)
                ->sort(request()->query('sort_by'), 'desc', ['created_at', 'views_count']);
        });
        
    }
}
