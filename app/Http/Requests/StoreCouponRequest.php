<?php

namespace App\Http\Requests;

use App\Enums\CouponDuration;
use App\Rules\ValidDurationInMonths;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'coupon_code' => ['required', 'string', 'max:255'],
            'percent_off' => ['required', 'numeric', 'min:0', 'max:100'],
            'duration' => ['required', 'string', Rule::enum(CouponDuration::class)],
            'duration_in_months' => ['nullable', 'integer', new ValidDurationInMonths(request('duration'))],
            'max_redemptions' => ['nullable', 'integer', 'min:1'],
            'redeem_by' => ['nullable', 'date_format:Y-m-d H:i:s', 'after:now'],
        ];
    }
}
