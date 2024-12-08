<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Customer */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'isActive' => $this->is_active,

            'userId'   => $this->whenLoaded('user', fn() => $this->user->id),
            'userName' => $this->whenLoaded('user', fn() => $this->user->full_name),

            'regionId'   => $this->whenLoaded('region', fn() => $this->region->id),
            'regionName' => $this->whenLoaded('region', fn() => $this->region->name),

            'cityId'   => $this->whenLoaded('city', fn() => $this->city->id),
            'cityName' => $this->whenLoaded('city', fn() => $this->city->name),
        ];
    }
}
