<?php

declare(strict_types=1);

// 21.02.2025 at 12:11:14
namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
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
            'customer_id'               => ['required', 'numeric', 'exists:customers,id'],
            'sales_date'                => ['required', 'date'],
            'sales_plans'               => ['array'],
            'sales_plans.*.sales_date'  => ['required', 'date'],
            'sales_plans.*.sales_plan'  => ['required', 'numeric'],
            'sales_plans.*.user_id'     => ['required', 'numeric', 'exists:users,id'],
            'sales_plans.*.customer_id' => ['required', 'numeric', 'exists:customers,id'],
            'sales_plans.*.category_id' => ['required', 'numeric', 'exists:categories,id'],
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $sales_plan_array = request()->input('sales_plan');

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
