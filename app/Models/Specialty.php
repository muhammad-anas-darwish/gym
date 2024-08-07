<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $hidden = ['pivot'];

    public function coaches(): BelongsToMany
    {
        return $this->belongsToMany(Coach::class, CoachSpecialty::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, PackageSpecialty::class);
    }
}
