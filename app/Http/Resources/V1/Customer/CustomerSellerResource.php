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
            'id'           => $this->id,
            'name'         => $this->name,
            'shortName'    => $this->short_name,
            'isActive'     => $this->is_active,
            'isSupervisor' => $this->is_supervisor,

            'customerId'   => $this->customer_id,
            'supervisorId' => $this->supervisor_id,

            'sellers' => [],

            'deletedAt' => $this->deleted_at,
        ];
    }
}
