<?php

declare(strict_types=1);

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreUpdateRequest extends FormRequest
{
    public function authorize()
    : bool
    {
        return auth('admin')->check();
    }

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
            'region_id' => [
                'required',
                'integer',
                'exists:regions,id',
            ],
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
            'name.unique' => 'Такой город уже есть в базе данных.',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $name = $this->input('name', true);
        $this->merge([
            'name' => process_name($name),
        ]);
    }
}
