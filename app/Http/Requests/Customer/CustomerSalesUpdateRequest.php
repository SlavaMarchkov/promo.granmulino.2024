<?php

declare(strict_types=1);

// 15.03.2025 at 15:18:37
namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

final class CustomerSalesUpdateRequest extends FormRequest
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
            'id'           => ['required', 'integer', 'exists:customer_sales,id'],
            'sales_actual' => ['required', 'integer'],
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $this->merge([
            'id'           => check_item_for_empty_array(request('id')),
            'sales_actual' => convert_string_to_number(request('sales_actual')),
        ]);
    }
}
