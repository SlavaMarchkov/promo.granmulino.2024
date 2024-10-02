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
        return auth()->user()->isAdmin();
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
            'latitude'  => ['nullable', 'sometimes', 'numeric'],
            'longitude' => ['nullable', 'sometimes', 'numeric'],
            'country'   => ['nullable', 'sometimes', 'string', 'max:16'],
            'state'     => ['nullable', 'sometimes', 'string', 'max:64'],
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
}
