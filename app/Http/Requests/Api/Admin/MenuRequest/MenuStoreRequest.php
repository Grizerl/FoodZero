<?php

namespace App\Http\Requests\Api\Admin\MenuRequest;

use Illuminate\Foundation\Http\FormRequest;

class MenuStoreRequest extends FormRequest
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
            'images' => 'required',
            'name' => 'string|required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
