<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeOrderRequest extends FormRequest
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
            'name' => 'required|alpha|string',
            'surname' => 'nullable|alpha|string',
            'phone' => ['required','regex:/^\+375(25|29|33|44|17)\d{7}$/'],
            'addressId' => 'exists:addresses,id',

        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Номер телефона должен начинаться с +375 и содержать 7 цифр после кода оператора. 25|29|33|44|17',
        ];
    }
}
