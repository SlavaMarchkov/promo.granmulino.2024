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
            'id'         => $this->id,
            'name'       => $this->name,
            'isActive'   => $this->is_active,
            'userId'     => $this->user_id,
            'userName'   => $this->user->full_name,
            'regionId'   => $this->region_id,
            'regionName' => $this->region->name,
            'cityId'     => $this->city_id,
            'cityName'   => $this->city->name,
        ];
    }
}
