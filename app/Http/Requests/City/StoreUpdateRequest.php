<?php

declare(strict_types=1);

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
{
    public function rules()
    : array
    {
        return [
            'name'      => ['required', 'string', 'max:64', 'unique:cities,name'],
            'region_id' => ['required', 'integer', 'exists:regions,id'],
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
