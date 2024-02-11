<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuscleExercise extends Model
{
    use HasFactory;

    protected $table = 'muscle_exercise';
    protected $fillable = ['muscle_id', 'exercise_id'];
}
