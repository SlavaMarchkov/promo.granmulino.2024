<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Product */
class ProductCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array
    {
        return [
            'products'      => $this->collection,
            'productsCount' => $this->count(),
        ];
    }
}
