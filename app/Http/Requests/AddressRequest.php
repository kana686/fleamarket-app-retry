<?php

namespace App\Http\Requests;

use App\Traits\TrimsInput;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    use TrimsInput;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'post_code.required' => '郵便番号を入力してください。',
            'post_code.regex' => '郵便番号は「000-0000」の形式で入力してください。',
            'address.required' => '住所を入力してください。',
            'address.max' => '住所は255文字以内で入力してください。',
            'building.max' => '建物名は255文字以内で入力してください。',
        ];
    }
}
