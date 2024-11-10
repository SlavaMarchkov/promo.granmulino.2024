<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\PromoProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PromoProduct */
class PromoProductResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'            => $this->id,
            'promo_id'      => $this->promo_id,
            'category_id'   => $this->category_id,
            'product_id'    => $this->product_id,
            'sales_before'  => $this->sales_before,
            'sales_plan'    => $this->sales_plan,
            'sales_on_time' => $this->sales_on_time,
            'sales_after'   => $this->sales_after,
            'compensation'  => $this->compensation,
            'budget_plan'   => $this->budget_plan,
            'budget_actual' => $this->budget_actual,
            'profit_plan'   => $this->profit_plan,
            'profit_actual' => $this->profit_actual,
        ];
    }
}
