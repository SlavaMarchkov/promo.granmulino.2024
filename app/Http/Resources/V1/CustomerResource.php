<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Customer */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'isActive' => $this->is_active,

            'regionId' => $this->region_id,
            'cityId'   => $this->city_id,
            'userId'   => $this->user_id,

            'regionCode' => $this->region?->code,
            'region'     => $this->region?->name,
            'city'       => $this->city?->name,
            'user'       => $this->user?->full_name,
        ];
    }
}
