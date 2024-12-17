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
            'id'              => ['required', 'numeric', 'exists:promo_products,id'],
            'sales_before'    => ['required', 'numeric'],
            'sales_plan'      => ['required', 'numeric'],
            'sales_on_time'   => ['required', 'numeric'],
            'compensation'    => ['required', 'numeric'],
            'budget_plan'     => ['required', 'numeric'],
            'budget_actual'   => ['required', 'numeric'],
            'profit_per_unit' => ['required', 'numeric'],
            'promo_profit' => ['required', 'numeric'],
        ];
    }
}
