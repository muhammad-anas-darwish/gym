<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'exercise_photo_path'];
    public $timestamps = false;

    public function muscles(): BelongsToMany
    {
        return $this->belongsToMany(Muscle::class, MuscleExercise::class)
            ->select('muscles.id', 'muscles.name');
    }

    public function scopeFilterByMuscle($query, $muscleId)
    {
        return $query->whereHas('muscles', function ($q) use ($muscleId) {
            $q->where('muscle_id', $muscleId);
        });
    }
}
