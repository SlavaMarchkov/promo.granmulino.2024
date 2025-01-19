<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Http\Requests\Promo;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'promo_type'  => ['required'],
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

            'total_sales_before'      => ['required', 'numeric'],
            'total_sales_plan'        => ['required', 'numeric'],
            'total_sales_after'       => ['nullable', 'numeric'],
            'total_budget_plan'       => ['required', 'numeric'],
            'total_promo_profit_plan' => ['nullable', 'numeric'],

            'products'                           => [
                'nullable',
                'array',
                Rule::requiredIf(function () {
                    return to_boolean($this->request->get('promo_for_retail')) == true;
                }),
            ],
            'sellers'                            => [
                'nullable',
                'array',
                Rule::requiredIf(function () {
                    return to_boolean($this->request->get('promo_for_retail')) == false;
                }),
            ],
            'products.*.category_id'             => ['required', 'integer'],
            'products.*.product_id'              => ['required', 'integer'],
            'products.*.discount'                => ['required', 'numeric', 'integer'],
            'products.*.promo_price'             => ['required', 'numeric'],
            'products.*.sales_before'            => ['nullable', 'numeric'],
            'products.*.sales_plan'              => ['required', 'numeric'],
            'products.*.surplus_plan'            => ['required', 'numeric'],
            'products.*.budget_plan'             => ['required', 'numeric'],
            'products.*.compensation'            => ['required', 'numeric'],
            'products.*.profit_per_unit'         => ['required', 'numeric'],
            'products.*.profit_per_product_plan' => ['required', 'numeric'],
            'products.*.net_profit'              => ['required', 'numeric', 'integer'],
            'products.*.revenue_plan'            => ['required', 'numeric', 'integer'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'promo_type'  => 'Вид промо-акции',
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
