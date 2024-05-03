<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoachSpecialtyRequest extends FormRequest
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
            'coach_id' => ['required', 'exists:coaches,id'],
            'specialty_id' => [
                'required',
                'exists:specialties,id'
            ],
            'coach_id' => 'unique:coach_specialties,coach_id,NULL,id,specialty_id,'.$this->specialty_id
        ];
    }
}
