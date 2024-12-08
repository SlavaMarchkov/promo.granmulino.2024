<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Customer;

use App\Http\Resources\V1\City\CityResource;
use App\Http\Resources\V1\Region\RegionResource;
use App\Http\Resources\V1\Retailer\RetailerResource;
use App\Http\Resources\V1\User\UserResource;
use App\Models\Customer;
use Illuminate\Http\Request;

/** @mixin Customer */
class CustomerFullResource extends CustomerResource
{
    public function toArray(Request $request)
    : array {
        return [
            ...parent::toArray($request),

            'description' => $this->description ?? '',

            'user'      => new UserResource($this->whenLoaded('user')),
            'region'    => new RegionResource($this->whenLoaded('region')),
            'city'      => new CityResource($this->whenLoaded('city')),

            'retailers' => RetailerResource::collection($this->whenLoaded('retailers')),
            'sellers'   => CustomerSellerResource::collection($this->whenLoaded('customer_sellers')),

            'next' => $this->findNext($this->id),
            'prev' => $this->findPrevious($this->id),
        ];
    }
}
