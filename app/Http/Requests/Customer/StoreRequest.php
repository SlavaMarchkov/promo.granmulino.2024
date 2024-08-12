<?php

declare(strict_types=1);

namespace App\Http\Requests\Customer;

use App\Rules\BooleanRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'is_active' => ['required', new BooleanRule],

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

    public function messages()
    : array
    {
        return [
            'required' => 'Поле ":attribute" нужно заполнить.',
            'exists'   => 'Поле ":attribute" нужно выбрать из списка.',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $is_active = $this->input('is_active', true);
        $this->merge([
            'is_active' => to_boolean($is_active),
        ]);
    }
}
