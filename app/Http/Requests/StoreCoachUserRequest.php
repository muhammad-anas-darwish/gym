<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCoachUserRequest extends FormRequest
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
                    $query->where('user_role', 'coach');
                }),
                Rule::unique('coach_user')->where(function ($query) {
                    return $query->where('user_id', $this->user_id)
                        ->where('coach_id', $this->coach_id);
                }),
            ],
            'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('user_role', 'trainee');
                }),
                'different:coach_id'
            ],
        ];
    }
}
