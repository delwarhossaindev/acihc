<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAPIDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ApiDetailName'   => ['required', 'string', 'max:255'],
            'APIDetailSource' => ['required', 'string', 'max:255'],
        ];
    }
}
