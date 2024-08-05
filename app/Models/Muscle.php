<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Muscle extends Model
{
    use HasFactory;

    protected $table = 'muscles';
    protected $fillable = ['name'];

    public $timestamps = false;
    
    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, MuscleExercise::class);
    }
}
