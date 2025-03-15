<?php

declare(strict_types=1);

// 12.03.2025 at 20:58:30
namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

final class CustomerSalesStoreRequest extends FormRequest
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
            'customer_id' => ['required', 'numeric', 'exists:customers,id'],
            'sales_date'  => ['required', 'date'],
            'sales_plans' => ['array', 'filled'],
        ];
    }

    public function messages()
    {
        return [
            'sales_plans.filled' => 'Введите план продаж хотя бы для одной группы товаров',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $sales_plan_array = request()->input('sales_plan') ?? [];

        $this->merge([
            'sales_plans' => array_map(function ($item) {
                return [
                    'user_id'     => request()->input('user_id'),
                    'sales_date'  => request()->input('sales_date'),
                    'customer_id' => request()->input('customer_id'),
                    'sales_plan'  => convert_string_to_number($item['sales_plan']),
                    'category_id' => $item['category_id'],
                ];
            }, $sales_plan_array),
        ]);
    }
}
