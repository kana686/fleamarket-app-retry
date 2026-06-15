<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keyword' => ['nullable', 'string', 'max:255'],
            'tab' => ['nullable', 'string', 'in:recommend,mylist'],
        ];
    }
}
