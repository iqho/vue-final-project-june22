<?php

namespace App\Http\Requests\PriceType;

use Illuminate\Foundation\Http\FormRequest;

class StorePriceTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}
