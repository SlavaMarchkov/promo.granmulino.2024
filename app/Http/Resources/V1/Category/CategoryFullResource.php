<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Category;

use App\Models\Category;
use Illuminate\Http\Request;

/** @mixin Category */
class CategoryFullResource extends CategoryResource
{
    public function toArray(Request $request)
    : array {
        return [
            ...parent::toArray($request),

            'next' => $this->findNext($this->id),
            'prev' => $this->findPrevious($this->id),
        ];
    }
}
