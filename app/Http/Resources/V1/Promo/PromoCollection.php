<?php

declare(strict_types=1);

// 05.12.2024 at 17:37:37
namespace App\Http\Resources\V1\Promo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Promo */
class PromoCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array {
        return [
            'promos'      => $this->collection,
            'promosCount' => $this->count(),
        ];
    }
}
