<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin City */
class CityResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'regionId'   => $this->region_id,
            'regionName' => $this->region->name,
        ];
    }
}
