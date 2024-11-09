<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Http\Resources\V1;

use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Promo */
class PromoResource extends JsonResource
{
    public function toArray(Request $request)
    : array
    {
        return [
            'id'          => $this->id,
            'status'      => $this->status,
            'promo_type'  => $this->promo_type,
            'discount'    => $this->discount,
            'user_id'     => $this->user_id,
            'region_id'   => $this->region_id,
            'city_id'     => $this->city_id,
            'channel_id'  => $this->channel_id,
            'customer_id' => $this->customer_id,
            'retailer_id' => $this->retailer_id,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'comments'    => $this->comments,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
