<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Region */
final class RegionCollection extends ResourceCollection
{
    public function toArray(Request $request)
    : array {
        return [
            'data' => $this->collection,
        ];
    }
}
