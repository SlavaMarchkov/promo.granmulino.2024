<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\City */
class CityCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request): array
    {
        return [
            'cities' => $this->collection,
            'citiesCount' => $this->count(),
        ];
    }
}
