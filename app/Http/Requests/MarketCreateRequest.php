<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'MarketName' => ['required', 'string', 'max:255', 'unique:Market,MarketName'],
        ];
    }
}
