<?php 

namespace App\Services\Coupons;

use App\DTOs\CouponDTO;
use App\Models\Coupon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CouponService implements CouponServiceInterface
{
    public function getCouponsWithPagination(int $countPerPage = 20): LengthAwarePaginator
    {
        return Coupon::paginate($countPerPage);
    }

    public function createCoupon(CouponDTO $couponDTO): Coupon
    {
        return Coupon::create([
            'stripe_id' => $couponDTO->couponCode,
            'percent_off' => $couponDTO->percentOff,
            'duration' => $couponDTO->duration,
            'duration_in_months' => $couponDTO->durationInMonths,
        ]);
    }

    public function deleteCoupon(Coupon $coupon): void 
    {
        $coupon->delete();
    }
}