<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\City;

use App\Http\Resources\V1\Region\RegionResource;
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
            'regionId'   => $this->whenLoaded('region', fn() => $this->region->id),
            'regionName' => $this->whenLoaded('region', fn() => $this->region->name),
            'longitude'  => $this->longitude,
            'latitude'   => $this->latitude,
            'country'    => $this->country,
            'state'      => $this->state,

            'region' => new RegionResource($this->whenLoaded('region')),
        ];
    }
}
