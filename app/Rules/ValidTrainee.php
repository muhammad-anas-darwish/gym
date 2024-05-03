<?php

namespace App\Rules;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidTrainee implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if user exists and user_role is 'trainee'
        $user = User::where('id', $value)->where('user_role', UserRole::TRAINEE);
        if (! $user->exists()) {
            $fail('The selected user is not a valid trainee.');
        }
    }
}
