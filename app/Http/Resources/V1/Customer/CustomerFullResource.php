<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Customer;

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

            'sellers'   => CustomerSellerResource::collection($this->whenLoaded('customer_sellers')),

            'next' => $this->findNext($this->id),
            'prev' => $this->findPrevious($this->id),
        ];
    }
}
