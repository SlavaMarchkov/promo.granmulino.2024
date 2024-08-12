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
        dd($this->input());
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

    public function messages()
    : array
    {
        return [
            'required' => 'Поле ":attribute" нужно заполнить.',
            'exists'   => 'Поле ":attribute" нужно выбрать из списка.',
        ];
    }

    /**
     * Prepare inputs for validation.
     *
     * @return void
     */
    /*protected function prepareForValidation()
    : void
    {
        $is_active = $this->input('is_active', true);
        $this->merge([
            'is_active' => $this->toBoolean($is_active),
        ]);
    }*/

    /**
     * Convert to boolean
     *
     * @param string|null $booleable
     * @return boolean
     */
    private function toBoolean(string|null $booleable)
    : bool {
        return filter_var($booleable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
