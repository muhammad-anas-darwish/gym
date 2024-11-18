<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title'];
    public $timestamps = false;

    public function advice(): HasOne
    {
        return $this->hasOne(Advice::class, 'category_id');
    }

    public function article(): HasOne
    {
        return $this->hasOne(Article::class, 'category_id');
    }
}
