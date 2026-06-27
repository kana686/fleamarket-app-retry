<?php

namespace App\Http\Requests;

use App\Traits\TrimsInput;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    use TrimsInput;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'コメントを入力してください',
            'content.max' => 'コメントは255文字以内で入力してください',
        ];
    }
}
