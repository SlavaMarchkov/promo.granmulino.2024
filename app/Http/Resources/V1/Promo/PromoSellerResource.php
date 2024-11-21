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
            'id'            => $this->id,
            'promo_id'      => $this->promo_id,
            'customer_id'   => $this->customer_id,
            'seller_id'     => $this->seller_id,
            'sales_before'  => $this->sales_before,
            'sales_plan'    => $this->sales_plan,
            'surplus_plan'  => $this->surplus_plan,
            'sales_after'   => $this->sales_after,
            'compensation'  => $this->compensation,
            'budget_plan'   => $this->budget_plan,
            'budget_actual' => $this->budget_actual,
        ];
    }
}
