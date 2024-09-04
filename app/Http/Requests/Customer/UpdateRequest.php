<?php

declare(strict_types=1);

namespace App\Http\Requests\Customer;

use App\Rules\BooleanRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    : bool
    {
        return true;
    }

    public function rules()
    : array
    {
        return [
            'name'        => ['required', 'string', 'min:8', 'max:64'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['required', new BooleanRule],

            'region_id' => ['required', 'nullable', 'exists:regions,id'],
            'city_id'   => ['required', 'nullable', 'exists:cities,id'],
            'user_id'   => ['required', 'nullable', 'exists:users,id'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'name'      => 'Название компании',
            'region_id' => 'Регион',
            'city_id'   => 'Город',
            'user_id'   => 'Менеджер',
            'is_active' => 'Активный',
        ];
    }
}
