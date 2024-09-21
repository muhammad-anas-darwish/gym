<?php

namespace App\Enums;

enum CouponDuration: string
{
    case ONCE = 'once';
    case REPEATING = 'repeating';
    case FOREVER = 'forever';
}
