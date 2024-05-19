<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
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
            'title' => ['filled', 'string', 'max:64'],
            'description' => ['filled', 'string', 'max:1024'],
            'limit' => ['filled', 'numeric', 'between:1,700'],
            'price' => ['filled', 'numeric', 'max:20000000000.99'],
        ];
    }
}
