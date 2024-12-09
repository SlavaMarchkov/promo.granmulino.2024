<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Http\Resources\V1\Promo;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Promo */
class PromoResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'              => $this->id,
            'status'          => $this->status,
            'promoType'       => $this->promo_type,
            'startDate'       => $this->start_date,
            'endDate'         => $this->end_date,
            'totalBudgetPlan' => $this->total_budget_plan,
        ];
    }
}
