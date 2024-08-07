<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'limit', 
        'price',
        'is_active',
    ];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function specialties(): BelongsToMany
    {
        return $this->belongsToMany(Specialty::class, PackageSpecialty::class);
    }
}
