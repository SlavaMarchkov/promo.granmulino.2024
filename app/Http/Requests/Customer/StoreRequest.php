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
            'name'        => ['required', 'string', 'min:8', 'max:64'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['boolean'],

            'region_id' => ['nullable', 'exists:regions,id'],
            'city_id'   => ['nullable', 'exists:cities,id'],
            'user_id'   => ['nullable', 'exists:users,id'],
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
