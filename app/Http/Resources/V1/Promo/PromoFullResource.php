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

            'promoType'  => $this->promo_type,
            'discount'   => $this->discount,
            'userId'     => $this->user_id,
            'regionId'   => $this->region_id,
            'cityId'     => $this->city_id,
            'channelId'  => $this->channel_id,
            'customerId' => $this->customer_id,
            'retailerId' => $this->retailer_id,

            'comments' => $this->comments,

            'totalSalesBefore'  => $this->total_sales_before,
            'totalSalesPlan'    => $this->total_sales_plan,
            'totalSalesOnTime'  => $this->total_sales_on_time,
            'totalSalesAfter'   => $this->total_sales_after,
            'totalBudgetPlan'   => $this->total_budget_plan,
            'totalBudgetActual' => $this->total_budget_actual,

            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'promoProductsCount' => $this->promo_products_count,
            'promoSellersCount'  => $this->promo_sellers_count,

            'products' => PromoProductResource::collection($this->whenLoaded('promo_products')),
            'sellers'  => PromoSellerResource::collection($this->whenLoaded('promo_sellers')),
        ];
    }
}
