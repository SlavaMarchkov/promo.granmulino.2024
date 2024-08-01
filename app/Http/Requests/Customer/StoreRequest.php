<?php

declare(strict_types=1);

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    : array
    {
        return [
            'name'        => ['required'],
            'is_active'   => ['boolean'],
            'description' => ['nullable'],
            'region_id'   => ['nullable', 'exists:regions'],
            'city_id'     => ['nullable', 'exists:cities'],
            'user_id'     => ['nullable', 'exists:users'],
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
