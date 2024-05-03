<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachSpecialty extends Model
{
    use HasFactory;

    public $table = 'coach_specialties';
    protected $fillable = ['coach_id', 'specialty_id'];
    public $timestamps = false;
}
