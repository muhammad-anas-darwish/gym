<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealFood extends Model
{
    use HasFactory;

    protected $fillable = ['food_id', 'meal_id', 'amount'];
    protected $hidden = ['food_id', 'meal_id',];

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }
}
