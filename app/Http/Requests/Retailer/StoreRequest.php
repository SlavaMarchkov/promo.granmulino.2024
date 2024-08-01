<?php

declare(strict_types=1);

namespace App\Http\Requests\Retailer;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    : array
    {
        return [
            'name'        => ['required'],
            'type'        => ['required'],
            'is_active'   => ['boolean'],
            'description' => ['nullable'],
            'customer_id' => ['required', 'exists:customers'],
            'city_id'     => ['nullable', 'exists:cities'],
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
