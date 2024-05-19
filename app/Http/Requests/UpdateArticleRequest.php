<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'category_id' => ['sometimes', 'exists:categories,id'],
            'title' => ['filled', 'string', 'max:64'],
            'description' => ['nullable', 'string', 'max:10000'],
            'article_photo' => ['sometimes', 'image', 'mimes:jpg,png,jpeg,gif', 'max:2048'],
        ];
    }
}
