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
            'muscle_id' => ['filled', 'exists:muscles,id'],
            'exercise_id' => ['filled', 'exists:exercises,id'],
            'training_session_id' => ['filled', 'exists:training_sessions,id'],
            'sets' => ['filled', 'integer', 'between:1,128'],
            'reps' => ['filled', 'string', 'max:128'],
            'order' => ['filled', 'integer', 'between:-32,64'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
