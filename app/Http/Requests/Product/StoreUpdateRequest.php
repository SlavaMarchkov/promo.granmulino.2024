<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use App\Enums\User\RoleEnum;
use App\Rules\BooleanRule;
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
            'name'        => ['required', 'string', 'min:8', 'max:64'],
            'weight'      => ['required', 'numeric', 'min:0', 'max:10000'],
            'price'       => [
                Rule::requiredIf(fn() => $this->user()->role->value == RoleEnum::PRICE_ADMIN->getValue()),
                'nullable',
                'numeric',
                'min:0',
                'max:199.99',
                'decimal:2',
                'regex:/\d{1,3}.\d{2}/',
            ],
            'is_active'   => ['required', new BooleanRule],
            'image'       => ['exclude_unless:image,null', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'category_id' => ['required', 'nullable', 'exists:categories,id'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'name'        => 'Название',
            'weight'      => 'Вес',
            'price'       => 'Цена',
            'is_active'   => 'В продаже',
            'category_id' => 'Группа товаров',
        ];
    }

    public function messages()
    : array
    {
        return [
            'price' => [
                'decimal' => 'Цена должна содержать две цифры после точки, напр. 30.00. Требование актуально и для целых чисел.',
            ],
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
