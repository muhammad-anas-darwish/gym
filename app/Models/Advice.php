<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    use HasFactory;

    protected $table = 'advices';
    protected $fillable = ['category_id', 'title'];

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter($query)
    {
        return (new QueryFilter)->apply($query, function ($filter) {
            $filter->search('title', request()->q)
                ->where('category_id', request()->category_id);
        });
    }
}
