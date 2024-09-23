<?php

namespace App\Services\Coupons;

use App\DTOs\CouponDTO;
use App\Exceptions\ServiceException;
use App\Models\Coupon;
use App\Services\Coupons\CouponServiceInterface;
use App\Services\Stripe\StripeManagerService;

class CouponProcessor implements CouponProcessorInterface
{

    public function __construct(
        protected StripeManagerService $stripeManagement, 
        protected CouponServiceInterface $couponService
    ) { }

    public function createCoupon(CouponDTO $couponDTO): Coupon
    {
        $this->stripeManagement->createCoupon($couponDTO);

        try {
            return $this->couponService->createCoupon($couponDTO);
        } catch (\Exception $e) {
            $this->stripeManagement->deleteCoupon($couponDTO->couponCode); // delete created stripe coupon 

            throw ServiceException::CouponCreationException($e);
        }
    }

    public function deleteCoupon(Coupon $coupon): void
    {
        $this->stripeManagement->deleteCoupon($coupon->stripe_id);

        try {
            $this->couponService->deleteCoupon($coupon);
        } catch (\Exception $e) {
            throw ServiceException::CouponDeletionException($e);
        }
    }
}
