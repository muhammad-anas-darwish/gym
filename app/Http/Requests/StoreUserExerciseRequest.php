<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Psy\CodeCleaner\ValidFunctionNamePass;

class StoreUserExerciseRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'muscle_id' => ['required', 'exists:muscles,id'],
            'exercise_id' => ['required', 'exists:exercises,id'],
            'training_session_id' => ['required', 'exists:training_sessions,id'],
            'sets' => ['required', 'between:1,128'],
            'reps' => ['required', 'string', 'max:128'],
            'order' => ['required', 'between:-32,64'],
            'note' => ['string'],
        ];
    }
}
