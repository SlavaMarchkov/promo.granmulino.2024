<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Customer */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'id'          => $this->id,
            'name'        => $this->name,
            'is_active'   => $this->is_active,
            'description' => $this->description,

            'region_id' => $this->region_id,
            'city_id'   => $this->city_id,
            'user_id'   => $this->user_id,

            'region' => new RegionResource($this->whenLoaded('region')),
            'city'   => new CityResource($this->whenLoaded('city')),
            'user'   => new UserResource($this->whenLoaded('user')),
        ];
    }
}
