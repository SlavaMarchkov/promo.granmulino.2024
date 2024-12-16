<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Customer;

use App\Http\Resources\V1\City\CityResource;
use App\Http\Resources\V1\Region\RegionResource;
use App\Http\Resources\V1\Retailer\RetailerResource;
use App\Http\Resources\V1\User\UserResource;
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

            'user'      => new UserResource($this->whenLoaded('user')),
            'region'    => new RegionResource($this->whenLoaded('region')),
            'city'      => new CityResource($this->whenLoaded('city')),
            'retailers' => RetailerResource::collection($this->whenLoaded('retailers')),

            'userName'   => $this->whenLoaded('user', fn() => $this->user->full_name),
            'regionName' => $this->whenLoaded('region', fn() => $this->region->name),
            'cityName'   => $this->whenLoaded('city', fn() => $this->city->name),
        ];
    }
}
