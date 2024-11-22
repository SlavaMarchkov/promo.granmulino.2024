<?php

declare(strict_types=1);

// 22.11.2024 at 22:23:03
namespace App\Http\Resources\V1\Customer;

use App\Models\CustomerSupervisor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CustomerSupervisor */
class CustomerSupervisorResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'shortName'    => $this->short_name,
            'isActive'     => $this->is_active,
            'sellersCount' => $this->sellers_count,

            'customerId' => $this->customer_id,

            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'sellers'  => CustomerSellerCollection::collection($this->whenLoaded('sellers')),
        ];
    }
}
