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

    public function authorize()
    : bool
    {
        return true;
    }
}
