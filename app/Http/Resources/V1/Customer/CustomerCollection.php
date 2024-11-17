<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Customer */
class CustomerCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array
    {
        return [
            'customers'      => $this->collection,
            'customersCount' => $this->count(),
        ];
    }
}
