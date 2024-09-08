<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'price',
        'duration', 
        'is_active',
        'stripe_product_id',
        'stripe_price_id',
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
