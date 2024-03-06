<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advice extends Model
{
    use HasFactory;

    protected $table = 'advices';
    protected $fillable = ['category_id', 'title'];
    protected $hidden = ['category_id'];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
