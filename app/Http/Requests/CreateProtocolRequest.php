<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProtocolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ProductID'      => ['required'],
            'MarketID'       => ['required'],
            'ManufacturerID' => ['required'],
            'Title'          => ['required', 'string', 'max:255'],
        ];
    }
}
