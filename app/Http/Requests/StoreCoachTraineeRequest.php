<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCoachTraineeRequest extends FormRequest
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
            'coach_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('user_role', UserRole::COACH);
                }),
                Rule::unique('coach_trainee')->where(function ($query) {
                    return $query->where('trainee_id', $this->trainee_id)
                        ->where('coach_id', $this->coach_id);
                }),
            ],
            'trainee_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('user_role', UserRole::TRAINEE);
                }),
                'different:coach_id'
            ],
        ];
    }
}
