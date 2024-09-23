<?php 

namespace App\Services\Stripe\Coupons;

use App\DTOs\CouponDTO;
use App\Exceptions\StripeException;
use Stripe\Coupon as StripeCoupon;

class StripeCouponFacade implements StripeCouponFacadeInterface
{
    public function createCoupon(CouponDTO $couponDTO): StripeCoupon
    {
        try {
            return StripeCoupon::create([
                'id' => $couponDTO->couponCode,
                'percent_off' => $couponDTO->percentOff,
                'duration' => $couponDTO->duration,
                'duration_in_months' => $couponDTO->durationInMonths,
                'max_redemptions' => $couponDTO->maxRedemptions, 
                'redeem_by' => $couponDTO->redeemBy ? strtotime($couponDTO->redeemBy) : null,
            ]);
        } catch (\Exception $e) {
            throw StripeException::CouponCreationException($e);
        }
    }

    public function deleteCoupon(string $couponId): StripeCoupon
    {
        try {
            $coupon = $this->retrieveCoupon($couponId);
            
            return $coupon->delete();
        } catch (\Exception $e) {
            throw StripeException::CouponDeletionException($e);
        }
    }

    public function retrieveCoupon(string $couponId): StripeCoupon
    {
        return StripeCoupon::retrieve($couponId);
    }
}