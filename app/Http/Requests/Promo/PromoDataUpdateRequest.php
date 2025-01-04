<?php

declare(strict_types=1);

// 27.12.2024 at 21:26:21
namespace App\Http\Requests\Promo;

use Illuminate\Foundation\Http\FormRequest;

final class PromoDataUpdateRequest extends FormRequest
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
            'promo'                     => ['array'],
            'promo.total_sales_after'   => ['required'],
            'promo.total_budget_actual' => ['required'],

            'sellers'                 => ['array'],
            'sellers.*.seller_id'     => ['required', 'numeric'],
            'sellers.*.sales_after'   => ['required', 'numeric'],
            'sellers.*.budget_actual' => ['required', 'numeric'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'promo.total_sales_after'   => 'Продажи, факт',
            'promo.total_budget_actual' => 'Бюджет, факт',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $promo = request()->input('promo');
        $sellers = request()->input('sellers');

        $this->merge([
            'promo'   => array_map(function ($value) {
                return convert_string_to_number($value);
            }, $promo),
            'sellers' => array_map(function ($seller) {
                return [
                    'seller_id'     => $seller['seller_id'],
                    'sales_after'   => convert_string_to_number($seller['sales_after']),
                    'budget_actual' => convert_string_to_number($seller['budget_actual']),
                ];
            }, $sellers),
        ]);
    }
}
