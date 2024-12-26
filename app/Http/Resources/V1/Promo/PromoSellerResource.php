<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Promo;

use App\Models\PromoSeller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

/** @mixin PromoSeller */
class PromoSellerResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'                 => $this->id,
            'name'               => DB::table('customer_sellers')->where('id', $this->seller_id)->value('name'),
            'promoId'            => $this->promo_id,
            'customerId'         => $this->customer_id,
            'sellerId'           => $this->seller_id,
            'supervisorId'       => $this->supervisor_id,
            'isSupervisor'       => $this->is_supervisor,
            'salesBefore'        => $this->sales_before,
            'salesPlan'          => $this->sales_plan,
            'surplusPlan'        => $this->surplus_plan,
            'salesAfter'         => $this->sales_after,
            'compensationPlan'   => $this->compensation_plan,
            'compensationActual' => $this->compensation_actual,
            'budgetPlan'         => $this->budget_plan,
            'budgetActual'       => $this->budget_actual,
        ];
    }
}
