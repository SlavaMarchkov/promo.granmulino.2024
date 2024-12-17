<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Http\Resources\V1\Promo;

use App\Models\Promo;
use Illuminate\Http\Request;

/** @mixin Promo */
class PromoFullResource extends PromoResource
{
    public function toArray(Request $request)
    : array {
        return [
            ...parent::toArray($request),

            'userId'     => $this->user_id,
            'channelName' => $this->whenLoaded('channel', fn() => $this->channel->name),
            'regionCode' => $this->whenLoaded('customer', fn() => $this->customer->region->code),
            'cityName'   => $this->whenLoaded('city', fn() => $this->city->name),

            'comments' => $this->comments,

            'totalSalesBefore' => $this->total_sales_before,
            'totalSalesPlan'   => $this->total_sales_plan,
            'totalSalesOnTime' => $this->total_sales_on_time,
            'totalPromoProfit' => $this->total_promo_profit,

            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'promoProductsCount' => $this->promo_products_count,
            'promoSellersCount'  => $this->promo_sellers_count,

            'products' => PromoProductResource::collection($this->whenLoaded('promo_products')),
            'sellers'  => PromoSellerResource::collection($this->whenLoaded('promo_sellers')),
        ];
    }
}
