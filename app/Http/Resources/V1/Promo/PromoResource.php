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
            'id'                => $this->id,
            'status'            => $this->status,
            'statusColor' => $this->status?->backgroundColor(),
            'statusLabel' => $this->status?->label(),
            'discount'          => $this->discount,
            'totalBudgetPlan'   => $this->total_budget_plan,
            'totalBudgetActual' => $this->total_budget_actual,
            'totalMark'         => $this->total_mark,

            'promoType'    => $this->promo_type,
            'promoLabel'   => $this->promo_type?->label(),
            'promoBgColor' => $this->promo_type?->backgroundColor(),
            'promoCode'    => $this->promo_type?->promoTypeCode(),

            'customerName' => $this->whenLoaded('customer', fn() => $this->customer->name),
            'retailerName' => $this->whenLoaded('retailer', fn() => $this->retailer->name),

            'startDate' => $this->start_date->format('d.m.Y'),
            'endDate'   => $this->end_date->format('d.m.Y'),
        ];
    }
}
