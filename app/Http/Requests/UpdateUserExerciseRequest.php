<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserExerciseRequest extends FormRequest
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
            'muscle_id' => ['exists:muscles,id'],
            'exercise_id' => ['exists:exercises,id'],
            'sets' => ['between:1,128'],
            'reps' => ['string', 'max:128'],
            'order' => ['between:-32,64'],
            'note' => ['string'],
        ];
    }
}
