<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
                'title' => 'required|string|max:100|unique:books,title',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|numeric|min:0',
                'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'author_id' => 'nullable|numeric',
                'category_id' => 'nullable|numeric'
        ];
    }
}
