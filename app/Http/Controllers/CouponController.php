<?php

namespace App\Http\Controllers;

use App\DTOs\CouponDTO;
use App\Models\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Resources\CouponResource;
use App\Services\Coupons\CouponProcessorInterface;
use App\Services\Coupons\CouponServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    public function __construct(protected CouponServiceInterface $couponService, protected CouponProcessorInterface $couponProcessor) 
    { 
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 20);

        $coupons = $this->couponService->getCouponsWithPagination($perPage);

        return $this->successResponse(CouponResource::collection($coupons));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $couponDTO = CouponDTO::fromArray($validatedData);

        $coupon = $this->couponProcessor->createCoupon($couponDTO);

        return $this->successResponse(new CouponResource($coupon));
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon): JsonResponse
    {
        return $this->successResponse(new CouponResource($coupon), message: 'Coupon retrieved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon): JsonResponse
    {
        $this->couponProcessor->deleteCoupon($coupon);

        return $this->successResponse([], 204, 'Coupon deleted successfully.');
    }
}
