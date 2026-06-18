<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'img_url' => ['nullable', 'image', 'mimes:jpeg,png'],
            'name' => ['required', 'string', 'max:20'],
            'post_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'img_url.image' => '画像ファイルをアップロードしてください',
            'img_url.mimes' => '画像はjpegまたはpng形式でアップロードしてください',
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は20文字以内で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => '郵便番号はハイフンありの8桁（例: 000-0000）で入力してください',
            'address.required' => '住所を入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'building.max' => '建物名は255文字以内で入力してください',
        ];
    }
}
