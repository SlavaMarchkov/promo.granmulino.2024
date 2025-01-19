<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Promo;

use App\Models\PromoProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PromoProduct */
class PromoProductResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'           => $this->id,
            'promoId'      => $this->promo_id,
            'categoryName' => $this->whenLoaded('category', fn() => $this->category->name),
            'productName'  => $this->whenLoaded('product', fn() => $this->product->name),

            'salesBefore'            => $this->sales_before,
            'salesPlan'              => $this->sales_plan,
            'salesOnTime'            => $this->sales_on_time,
            'salesAfter'             => $this->sales_after,
            'compensation'           => $this->compensation,
            'budgetPlan'             => $this->budget_plan,
            'budgetActual'           => $this->budget_actual,
            'profitPerUnit'          => $this->profit_per_unit,
            'profitPerProductPlan'   => $this->profit_per_product_plan,
            'profitPerProductActual' => $this->profit_per_product_actual,

            'discount'   => $this->discount,
            'netProfit'  => $this->net_profit,
            'promoPrice' => $this->promo_price,

            'surplusPlan'   => $this->surplus_plan,
            'surplusActual' => $this->surplus_actual,
            'revenuePlan'   => $this->revenue_plan,
            'revenueActual' => $this->revenue_actual,
        ];
    }
}
