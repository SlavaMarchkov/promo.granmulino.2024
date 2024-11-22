<?php

declare(strict_types=1);

// 15.11.2024 at 01:04:42
namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\CustomerSeller */
class CustomerSellerCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array {
        return [
            'sellers'      => $this->collection,
            'sellersCount' => $this->count(),
        ];
    }
}
