<?php

declare(strict_types=1);

namespace App\Http\Requests\Retailer;

use App\Rules\BooleanRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:64'],
            'type'        => ['required'],
            'description' => ['nullable'],

            'is_active' => ['required', new BooleanRule],
            'is_direct' => ['required', new BooleanRule],

            'customer_id' => ['required', 'exists:customers,id'],
            'city_id'     => ['nullable', 'exists:cities,id'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'name'        => 'Название компании',
            'type'        => 'Тип торговой сети',
            'customer_id' => 'Контрагент',
            'city_id'     => 'Город',
            'is_active'   => 'Активный',
            'is_direct'   => 'Прямой контракт',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $this->merge([
            'is_active' => to_boolean(request('is_active')),
            'is_direct' => to_boolean(request('is_direct')),
        ]);
    }
}
