<?php

declare(strict_types=1);

// 05.01.2025 at 22:29:39
namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\CustomerProduct */
class CustomerProductCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array {
        return [
            'products'      => $this->collection,
            'productsCount' => $this->count(),
        ];
    }
}
