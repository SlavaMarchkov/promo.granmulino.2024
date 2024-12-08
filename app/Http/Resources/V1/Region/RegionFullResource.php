<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Region;

use App\Http\Resources\V1\Customer\CustomerResource;
use App\Models\Region;
use Illuminate\Http\Request;

/** @mixin Region */
class RegionFullResource extends RegionResource
{
    public function toArray(Request $request)
    : array {
        return [
            ...parent::toArray($request),

            'customers'      => CustomerResource::collection($this->whenLoaded('customers')),
            'customersCount' => $this->whenLoaded('customers', fn() => $this->customers_count),

            'next' => $this->findNext($this->id),
            'prev' => $this->findPrevious($this->id),
        ];
    }
}
