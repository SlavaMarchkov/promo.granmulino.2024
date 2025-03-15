<?php

declare(strict_types=1);

// 12.03.2025 at 21:14:09
namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;

/** @see \App\Models\CustomerSales */
class CustomerSalesCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array {
        return [
            'data' => $this->collection->groupBy(function($val) {
                return Carbon::parse($val->sales_date)->format('m');
            }),
            'salesCount' => $this->count(),
        ];
    }
}
