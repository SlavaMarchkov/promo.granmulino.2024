<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Http\Requests\Promo;

use App\Enums\Promo\TypeEnum;
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
            'transport_rate'    => ['nullable', 'numeric'],

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

/*

"promo_type" => "DISCOUNT"
  "promo_for_retail" => "true"
  "discount" => "30"
  "user_id" => "1"
  "channel_id" => "1"
  "customer_id" => "46"
  "retailer_id" => "3"
  "region_id" => "6"
  "city_id" => "3"
  "start_date" => "2025-01-13"
  "end_date" => "2025-01-24"
  "comments" => "sdsdsdds"
  "total_sales_before" => "280"
  "total_sales_plan" => "500"
  "total_budget_plan" => "4053"
  "products" => array:2 [
    0 => array:15 [
      "category_id" => "2"
      "product_id" => "28"
      "category_name" => "Granmulino Стандарт"
      "product_name" => "Перья, 400 г"
      "sales_before" => "200"
      "sales_plan" => "400"
      "surplus_plan" => "100"
      "budget_plan" => "3215"
      "compensation" => "8.036363636363632"
      "profit_per_unit" => "4.818939393939394"
      "discount" => "20"
      "promo_price" => "32.14545454545455"
      "profit_per_product" => "1927.5757575757577"
      "net_profit" => "15"
      "revenue_plan" => "12858"
    ]

 *
 * */
