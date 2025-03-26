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
        return auth()->user()->isAdmin();
    }

    public function rules()
    : array
    {
        return [
            'name'           => ['required', 'string', 'min:8', 'max:64'],
            'code'           => ['nullable', 'string'],
            'barcode'        => ['nullable', 'string'],
            'barcode_box'    => ['nullable', 'string'],
            'weight'         => ['required', 'numeric', 'min:0', 'max:50000'],
            'gross_weight'   => ['nullable', 'numeric', 'min:0', 'max:50000'],
            'width'          => ['nullable', 'numeric', 'min:0', 'max:50'],
            'depth'          => ['nullable', 'numeric', 'min:0', 'max:50'],
            'height'         => ['nullable', 'numeric', 'min:0', 'max:50'],
            'width_box'      => ['nullable', 'numeric', 'min:0', 'max:99'],
            'depth_box'      => ['nullable', 'numeric', 'min:0', 'max:99'],
            'height_box'     => ['nullable', 'numeric', 'min:0', 'max:99'],
            'capacity'       => ['nullable', 'integer', 'min:0', 'max:99'],
            'boxes_in_layer' => ['nullable', 'integer', 'min:0', 'max:50'],
            'price'          => [
                Rule::requiredIf(fn() => $this->user()->role->value == RoleEnum::PRICE_ADMIN->getValue()),
                'nullable',
                'numeric',
                'min:0',
                'max:999.99',
                'decimal:2',
                'regex:/\d{1,3}.\d{2}/',
            ],
            'is_active'      => ['required', new BooleanRule()],
            'category_id'    => ['required', 'exists:categories,id'],
            'image'          => ['nullable', 'string', 'starts_with:data:image'],
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
        $image = $this->input('image', null);
        $code = $this->input('code');
        $barcode = $this->input('barcode');
        $barcode_box = $this->input('barcode_box');

        $this->merge([
            'is_active'   => to_boolean($is_active),
            'image'       => check_item_for_empty_array($image),
            'code'        => check_item_for_empty_array($code),
            'barcode'     => check_item_for_empty_array($barcode),
            'barcode_box' => check_item_for_empty_array($barcode_box),
        ]);
    }
}
