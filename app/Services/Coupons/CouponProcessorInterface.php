<?php

namespace App\Services\Coupons;

use App\DTOs\CouponDTO;
use App\Models\Coupon;

interface CouponProcessorInterface
{
    public function createCoupon(CouponDTO $couponDTO): Coupon;

    public function deleteCoupon(Coupon $coupon): void;
}
