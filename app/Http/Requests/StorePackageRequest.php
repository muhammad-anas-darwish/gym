<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:128'],
            'description' => ['required', 'string', 'max:1024'],
            'price' => ['required', 'numeric', 'max:20000000000.99'],
            'duration' => ['required', 'integer', 'min:1'],
            'is_active' => ['filled', 'boolean'],
            'specialties' => ['array'],
            'specialties.*' => ['exists:specialties,id'],
        ];
    }
}
