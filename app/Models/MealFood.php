<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealFood extends Model
{
    use HasFactory;

    protected $fillable = ['food_id', 'meal_id', 'amount'];
}
