<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Retailer;

use App\Models\Retailer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Retailer */
class RetailerResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'type'            => $this->type,
            'label'           => $this->type->label(),
            'typeDescription' => $this->type->description(),
            'typeBgColor'     => $this->type->backgroundColor(),

            'isActive' => $this->is_active,
            'isDirect' => $this->is_direct,

            'customerId' => $this->customer_id,
            'cityId'     => $this->city_id,
            'customer'   => $this->customer->name,
            'city'       => $this->city->name,
        ];
    }
}
