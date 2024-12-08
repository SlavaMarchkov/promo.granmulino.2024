<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Product;

use App\Http\Resources\V1\Category\CategoryResource;
use App\Models\Product;
use Illuminate\Http\Request;

/** @mixin Product */
class ProductFullResource extends ProductResource
{
    public function toArray(Request $request)
    : array {
        return [
            ...parent::toArray($request),

            'category' => new CategoryResource($this->whenLoaded('category')),

            'next' => $this->findNext($this->id),
            'prev' => $this->findPrevious($this->id),
        ];
    }
}
