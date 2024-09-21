<?php 

namespace App\Services\Stripe\Coupons;

use App\DTOs\CouponDTO;
use Stripe\Coupon as StripeCoupon;

interface StripeCouponFacadeInterface
{
    public function createCoupon(CouponDTO $couponDTO): StripeCoupon;
    
    public function deleteCoupon(string $couponId): StripeCoupon;
}