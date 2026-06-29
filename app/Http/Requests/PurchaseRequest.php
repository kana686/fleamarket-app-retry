<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => ['required', 'integer', 'in:1,2'],
            'post_code' => ['required', 'string', 'max:8'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
            'payment_method.in' => '正しい支払い方法を選択してください。',
            'post_code.required' => '郵便番号を入力してください。',
            'address.required' => '住所を入力してください。',
        ];
    }
}
