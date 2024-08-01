<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Retailer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Retailer */
class RetailerResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'id'          => $this->id,
            'name'        => $this->name,
            'type'        => $this->type,
            'is_active'   => $this->is_active,
            'description' => $this->description,

            'customer_id' => $this->customer_id,
            'city_id'     => $this->city_id,

            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'city'     => new CityResource($this->whenLoaded('city')),
        ];
    }
}
