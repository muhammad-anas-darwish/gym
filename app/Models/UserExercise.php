<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserExercise extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'muscle_id', 'exercise_id', 'training_session_id', 'sets', 'reps', 'order', 'note'];
    protected $hidden = ['user_id', 'muscle_id', 'exercise_id', 'training_session_id'];

    public function muscle(): BelongsTo
    {
        return $this->belongsTo(Muscle::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Muscle::class);
    }

    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class);
    }
}
