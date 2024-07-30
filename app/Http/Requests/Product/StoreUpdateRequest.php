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
            'name'        => ['required'],
            'price'       => ['required', 'numeric'],
            'is_active'   => ['boolean'],
            'category_id' => ['required', 'nullable', 'exists:categories,id'],
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
