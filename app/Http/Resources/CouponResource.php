<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'coupon_code' => $this->stripe_id,
            'percent_off' => $this->percent_off,
            'duration' => $this->duration,
            'duration_in_months' => $this->duration_in_months,
            'max_redemptions' => $this->max_redemptions, 
            'redeem_by' => $this->redeem_by,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
