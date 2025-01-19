<?php

declare(strict_types=1);

// 16.12.2024 at 22:17:33
namespace App\Http\Requests\Promo;

use Illuminate\Foundation\Http\FormRequest;

final class PromoProductUpdateRequest extends FormRequest
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
            'sales_on_time'             => ['required', 'numeric'],
            'budget_actual'             => ['required', 'numeric'],
            'surplus_actual'            => ['required', 'numeric'],
            'profit_per_product_actual' => ['required', 'numeric'],
            'revenue_actual'            => ['required', 'numeric'],
        ];

        /*TODO: delete return [

            'sales_before'              => ['required', 'numeric'],
            'sales_plan'                => ['required', 'numeric'],
            'sales_on_time'             => ['required', 'numeric'],
            'sales_after'               => ['nullable', 'numeric'],
            'budget_plan'               => ['required', 'numeric'],
            'budget_actual'             => ['required', 'numeric'],
            'surplus_actual'            => ['required', 'numeric'],
            'profit_per_product_plan'   => ['required', 'numeric'],
            'profit_per_product_actual' => ['required', 'numeric'],
            'revenue_actual'            => ['required', 'numeric'],
        ];*/
    }

    public function attributes()
    : array
    {
        return [
            'sales_before'            => 'Продажи "До акции"',
            'sales_plan'              => 'План продаж',
            'sales_on_time'           => 'Продажи "Во время"',
            'sales_after'             => 'Продажи "После"',
            'compensation'            => 'Компенсация на 1 шт.',
            'budget_plan'             => 'Бюджет, план',
            'budget_actual'           => 'Бюджет, факт',
            'profit_per_unit'         => 'Прибыль на 1 шт.',
            'profit_per_product_plan' => 'Прибыль на продукт',
        ];
    }
}
