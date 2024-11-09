<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Http\Requests\Promo;

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
            'promo_type'  => ['required'],
            'discount'    => ['nullable', 'numeric'],
            'user_id'     => ['required', 'exists:users,id'],
            'region_id'   => ['required', 'exists:regions,id'],
            'city_id'     => ['required', 'exists:cities,id'],
            'channel_id'  => ['required', 'exists:channels,id'],
            'customer_id' => ['required', 'exists:customers,id'],
            'retailer_id' => ['required', 'exists:retailers,id'],
            'start_date'  => ['required', 'date_format:Y-m-d', 'date'],
            'end_date'    => ['required', 'date_format:Y-m-d', 'date', 'after:start_date'],
            'comments'    => ['nullable', 'string'],
        ];
    }
}
