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
            'post_code' => ['required', 'string', 'max:8', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'item_id' => ['required', 'exists:items,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
            'payment_method.in' => '正しい支払い方法を選択してください。',
            'post_code.required' => '郵便番号を入力してください。',
            'post_code.regex' => '郵便番号は「000-0000」の形式で入力してください。',
            'address.required' => '住所を入力してください。',
            'item_id.exists' => '指定された商品は存在しません。',
        ];
    }
}
