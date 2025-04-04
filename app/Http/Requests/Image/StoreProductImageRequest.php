<?php

declare(strict_types=1);

// 30.03.2025 at 12:01:22
namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

final class StoreProductImageRequest extends FormRequest
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
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'images'  => ['nullable', 'array'],
        ];
    }
}
