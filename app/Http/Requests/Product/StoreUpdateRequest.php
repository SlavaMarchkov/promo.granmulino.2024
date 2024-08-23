<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

final class StoreUpdateRequest extends FormRequest
{
    public function rules()
    : array
    {
        return [
            'name'        => ['required', 'string', 'min:8', 'max:64'],
            'weight' => ['required', 'numeric', 'min:0', 'max:10000'],
            'price'       => ['required', 'numeric', 'min:0', 'max:199.99', 'decimal:2', 'regex:/\d{1,3}.\d{2}/'],
            'is_active'   => ['boolean'],
            'image'       => ['exclude_unless:image,null', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'category_id' => ['required', 'nullable', 'exists:categories,id'],
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
