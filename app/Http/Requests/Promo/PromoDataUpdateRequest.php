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
            'total_sales_after'   => ['required'],
            'total_budget_actual' => ['required'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'total_sales_after'   => 'Продажи, факт',
            'total_budget_actual' => 'Бюджет, факт',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $arr = [];
        $inputArr = request()->only('total_sales_after', 'total_budget_actual');
        foreach ($inputArr as $key => $value) {
            $arr[$key] = convert_string_to_number($value);
        }
        $this->merge($arr);
    }
}
