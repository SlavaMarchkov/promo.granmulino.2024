<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Region */
class RegionResource extends JsonResource
{
    public static $wrap = 'region';

    public function toArray(Request $request)
    : array
    {
        return [
            'id'          => $this->id,
            'code'        => $this->code,
            'name'        => $this->name,
            'citiesCount' => $this->cities_count,
            'cities'      => CityResource::collection($this->whenLoaded('cities')),

            'next' => $this->findNext($this->id),
            'prev' => $this->findPrevious($this->id),
        ];
    }
}
