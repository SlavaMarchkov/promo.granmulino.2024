<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Retailer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Retailer */
class RetailerCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array
    {
        return [
            'retailers'      => $this->collection,
            'retailersCount' => $this->count(),
        ];
    }
}
