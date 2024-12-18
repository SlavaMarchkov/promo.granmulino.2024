<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Promo;

use App\Models\PromoSeller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PromoSeller */
class PromoSellerResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'           => $this->id,
            'promoId'      => $this->promo_id,
            'customerId'   => $this->customer_id,
            'sellerId'     => $this->seller_id,
            'salesBefore'  => $this->sales_before,
            'salesPlan'    => $this->sales_plan,
            'surplusPlan'  => $this->surplus_plan,
            'salesAfter'   => $this->sales_after,
            'compensation' => $this->compensation,
            'budgetPlan'   => $this->budget_plan,
            'budgetActual' => $this->budget_actual,
        ];
    }
}
