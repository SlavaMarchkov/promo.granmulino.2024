<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Http\Requests\Promo;

use App\Enums\Promo\TypeEnum;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class PromoStatusUpdateRequest extends FormRequest
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
            'promo_type'  => ['required'],
            'discount'    => [
                'nullable',
                'numeric',
                'min:5',
                Rule::requiredIf(function () {
                    return $this->request->get('promo_type') == TypeEnum::DISCOUNT->value;
                }),
            ],
            'user_id'     => ['required', 'exists:users,id'],
            'channel_id'  => ['required', 'exists:channels,id'],
            'region_id'   => ['required', 'exists:regions,id'],
            'city_id'     => ['required', 'exists:cities,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'retailer_id' => [
                'nullable',
                Rule::requiredIf(function () {
                    return Customer::query()
                            ->where('id', $this->request->get('customer_id'))
                            ->withCount('retailers')
                            ->value('retailers_count') > 0
                        && to_boolean($this->request->get('promo_for_retail')) == true;
                }),
                'exists:retailers,id',
            ],
            'start_date'  => ['required', 'date_format:Y-m-d', 'date'],
            'end_date'    => ['required', 'date_format:Y-m-d', 'date', 'after:start_date'],
            'comments'    => ['nullable', 'string'],

            'total_sales_before' => ['required', 'numeric'],
            'total_sales_plan'   => ['required', 'numeric'],
            'total_sales_after' => ['nullable', 'numeric'],
            'total_budget_plan'  => ['required', 'numeric'],

            'products' => [
                'nullable',
                'array',
                Rule::requiredIf(function () {
                    return to_boolean($this->request->get('promo_for_retail')) == true;
                }),
            ],
            'sellers'  => [
                'nullable',
                'array',
                Rule::requiredIf(function () {
                    return to_boolean($this->request->get('promo_for_retail')) == false;
                }),
            ],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'promo_type'  => 'Вид промо-акции',
            'discount'    => 'Величина скидки',
            'user_id'     => 'Менеджер',
            'channel_id'  => 'Канал продаж',
            'region_id'   => 'Регион',
            'city_id'     => 'Город',
            'customer_id' => 'Дистрибутор',
            'retailer_id' => 'Торговая сеть',
            'start_date'  => 'Дата начала',
            'end_date'    => 'Дата окончания',
            'products'    => 'Ассортимент',
            'sellers'     => 'Команда ТП',
        ];
    }

    public function messages()
    : array
    {
        return [
            'end_date.after' => 'Дата окончания должна быть после даты начала.',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $sellers = request()->input('sellers');

        if ($sellers) {
            $this->merge([
                'sellers' => array_map(function ($seller) {
                    return [
                        ...$seller,
                        'is_supervisor' => to_boolean($seller['is_supervisor']),
                    ];
                }, $sellers),
            ]);
        }
    }
}
