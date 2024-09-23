<?php

namespace App\Models;

use App\Enums\CouponDuration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'percent_off',
        'duration',
        'duration_in_months',
        'stripe_id',
        'max_redemptions', 
        'redeem_by',
    ];

    protected $casts = [
        'duration' => CouponDuration::class,
    ];
}
