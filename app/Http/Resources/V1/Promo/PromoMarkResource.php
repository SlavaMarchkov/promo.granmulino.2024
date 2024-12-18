<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Promo;

use App\Models\PromoMark;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PromoMark */
class PromoMarkResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'       => $this->id,
            'promo_id' => $this->promo_id,
            'goals'    => $this->goals,
            'sales'    => $this->sales,
            'staff'    => $this->staff,
            'comments' => $this->comments,
        ];
    }
}
