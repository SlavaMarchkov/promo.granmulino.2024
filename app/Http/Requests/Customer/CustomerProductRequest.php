<?php

declare(strict_types=1);

// 05.01.2025 at 19:22:49
namespace App\Http\Requests\Customer;

use App\Rules\BooleanRule;
use Illuminate\Foundation\Http\FormRequest;

final class CustomerProductRequest extends FormRequest
{
    public function authorize()
    : bool
    {
        return auth()->user()->isManager();
    }

    public function rules()
    : array
    {
        return [
            'products'                  => ['array'],
            'products.*.customer_id'    => ['required', 'exists:customers,id'],
            'products.*.category_id'    => ['required', 'exists:categories,id'],
            'products.*.product_id'     => ['required', 'exists:products,id'],
            'products.*.customer_price' => ['required', 'numeric'],
            'products.*.is_listed'      => ['required', new BooleanRule()],
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $products_arr = request()->all();
        $this->merge([
            'products' => array_map(function ($product) {
                return [
                    ...$product,
                    'customer_price' => convert_string_to_number($product['customer_price']),
                    'is_listed'      => to_boolean($product['is_listed']),
                ];
            }, $products_arr),
        ]);
    }
}
