<?php

declare(strict_types=1);

// 15.11.2024 at 16:41:25
namespace App\Http\Resources\V1\Customer;

use App\Models\CustomerSeller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CustomerSeller */
class CustomerSellerResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'shortName' => $this->short_name,
            'isActive'  => $this->is_active,

            'customerId' => $this->customer_id,

            'customerSupervisorId' => $this->customer_supervisor_id,
            'supervisor'   => new CustomerSupervisorResource($this->whenLoaded('supervisor')),
        ];
    }
}
