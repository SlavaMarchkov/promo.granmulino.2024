<?php

declare(strict_types=1);

namespace App\Http\Requests\Customer;

use App\Rules\BooleanRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'name'        => ['required', 'string', 'min:8', 'max:64'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['required', new BooleanRule],

            'region_id' => ['required', 'nullable', 'exists:regions,id'],
            'city_id'   => ['required', 'nullable', 'exists:cities,id'],
            'user_id'   => ['nullable'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'name'        => 'Название',
            'region_id'   => 'Регион',
            'city_id'     => 'Город',
            'user_id'     => 'Менеджер',
            'is_active'   => 'Активный',
            'description' => 'Описание',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $this->merge([
            'is_active' => to_boolean(request('is_active')),
            'user_id'   => check_id_for_empty_array(request('user_id')),
        ]);
    }
}
