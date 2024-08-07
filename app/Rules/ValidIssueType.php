<?php

namespace App\Rules;

use App\Enums\ReportType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidIssueType implements ValidationRule
{
    protected $validValues = [
        ReportType::TECHNICAL_ISSUE->value,
        ReportType::REQUEST_COACH_CHANGE->value,
    ];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isExists = in_array($value, $this->validValues, true);

        if (!$isExists) {
            $fail('The :value is not a valid $attribute.');
        }
    }
}
