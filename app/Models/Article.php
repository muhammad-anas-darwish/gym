<?php

namespace App\Models;

use App\Filters\QueryFilter;
use App\Traits\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;

class Article extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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

    public static function boot() 
    {
        parent::boot();

        static::creating(function (Article $article) {
            $article->user_id = Auth::id();
        });
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

    public array $fileRules = [
        'thumbnail' => [
            'type' => 'single', 
            'sizes' => [
                'small' => [100, 100],
                'medium' => [300, 300],
                'large' => [600, 600],
            ],
        ],
        'gallery' => [
            'type' => 'multiple',
            'sizes' => [
                'small' => [200, 200],
                'medium' => [400, 400],
                'large' => [800, 800],
            ],
        ],
    ];
}
