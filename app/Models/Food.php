<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';
    protected $fillable = ['name', 'description'];
    public $timestamps = false;

    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, MealFood::class);
    }
}
