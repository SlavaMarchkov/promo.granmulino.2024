<?php

declare(strict_types=1);

// 21.02.2025 at 14:11:12
namespace App\Http\Resources\V1\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Sales */
class SalesCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array {
        return [
            'sales'      => $this->collection,
            'salesCount' => $this->count(),
        ];
    }
}
