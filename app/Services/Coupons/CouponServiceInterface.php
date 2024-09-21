<?php 

namespace App\Services\Coupons;

use App\DTOs\CouponDTO;
use App\Models\Coupon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CouponServiceInterface
{
    public function getCouponsWithPagination(int $countPerPage = 20): LengthAwarePaginator;

    public function createCoupon(CouponDTO $couponDTO): Coupon;

    public function deleteCoupon(Coupon $coupon): void;
}