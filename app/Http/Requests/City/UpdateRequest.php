<?php

declare(strict_types=1);

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateRequest extends FormRequest
{
    public function rules()
    : array
    {
        return [
            'name'      => [
                'required',
                'string',
                'max:64',
                Rule::unique('cities')->ignore($this->request->get('id')),
            ],
            'region_id' => ['required', 'integer', 'exists:regions,id'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'name'      => 'Город',
            'region_id' => 'Регион',
        ];
    }

    public function messages()
    : array
    {
        return [
            'required'    => 'Поле ":attribute" нужно заполнить.',
            'max'         => [
                'string' => 'Поле ":attribute" должно иметь не более :max символов.',
            ],
            'name.unique' => 'Такой город уже есть в базе данных.'
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
