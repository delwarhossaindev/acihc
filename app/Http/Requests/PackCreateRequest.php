<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'PackValue' => ['required'],
        ];
    }
}
