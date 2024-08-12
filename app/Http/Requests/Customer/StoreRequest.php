<?php

declare(strict_types=1);

namespace App\Http\Requests\Customer;

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
            'is_active' => ['required', 'boolean'],

            'region_id' => ['required', 'nullable', 'exists:regions,id'],
            'city_id'   => ['required', 'nullable', 'exists:cities,id'],
            'user_id'   => ['required', 'nullable', 'exists:users,id'],
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $is_active = $this->input('is_active', true);
        $this->merge([
            'is_active' => $this->toBoolean($is_active),
        ]);
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

    protected function toBoolean(string|null $key)
    : bool {
        return filter_var($key, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
