<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\City;

use App\Models\City;
use Illuminate\Http\Request;

/** @mixin City */
class CityFullResource extends CityResource
{
    public function toArray(Request $request)
    : array {
        return [
            ...parent::toArray($request),

            'next' => $this->findNext($this->id),
            'prev' => $this->findPrevious($this->id),
        ];
    }
}
