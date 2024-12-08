<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Retailer;

use App\Models\Retailer;
use Illuminate\Http\Request;

/** @mixin Retailer */
class RetailerFullResource extends RetailerResource
{
    public function toArray(Request $request)
    : array {
        return [
            ...parent::toArray($request),

            'description' => $this->description ?? '',

            'next' => $this->findNext($this->id),
            'prev' => $this->findPrevious($this->id),
        ];
    }
}
