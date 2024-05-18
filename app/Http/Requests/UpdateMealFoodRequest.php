<?php

namespace App\Http\Requests;

use App\Models\MealFood;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMealFoodRequest extends FormRequest
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
            'food_id' => ['exists:foods,id'],
            'meal_id' => ['exists:meals,id'],
            'amount' => ['filled', 'string', 'max:64'],
            'meal_id' => Rule::unique(MealFood::class)->where(function ($query) {
                return $query->where('food_id', $this->food_id)
                    ->where('meal_id', $this->meal_id);
            }),
        ];
    }

    public function messages()
    {
        return [
            'meal_id.unique' => 'This combination of food and meal already exists.',
        ];
    }
}
