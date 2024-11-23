<?php

namespace App\Http\Requests;

use App\Models\TemporaryUpload;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:64'],
            'description' => ['required', 'string', 'max:10000'],
            'thumbnail' => ['nullable', Rule::exists(TemporaryUpload::class, 'token')],
        ];
    }
}
