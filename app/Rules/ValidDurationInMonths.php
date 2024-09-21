<?php

namespace App\Rules;

use App\Enums\CouponDuration;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDurationInMonths implements ValidationRule
{
    protected $duration;

    /**
     * Create a new rule instance.
     *
     * @param string $duration
     * @return void
     */
    public function __construct($duration)
    {
        $this->duration = $duration;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->duration === 'REPEATING') {
            if (is_null($value) || $value < 1) {
                $fail('The ' . $attribute . ' field is required and must be greater than 1 when duration is ' . CouponDuration::REPEATING->value . '.');
            }
        } else {
            if (!is_null($value)) {
                $fail('The ' . $attribute . ' field must be null when duration is not ' . CouponDuration::REPEATING->value . '.');
            }
        }
    }
}
