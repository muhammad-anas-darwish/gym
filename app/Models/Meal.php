<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'day'];

    public function coaches(): BelongsToMany
    {
        return $this->belongsToMany(Coach::class, CoachSpecialty::class);
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, MealFood::class);
    }
}
