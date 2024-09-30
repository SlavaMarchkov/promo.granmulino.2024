<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Category */
class CategoryResource extends JsonResource
{
    public function toArray(Request $request)
    : array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'isActive'      => $this->is_active,
            'productsCount' => $this->products_count,
            'products'      => ProductResource::collection($this->whenLoaded('products')),

            'next' => $this->findNext($this->id),
            'prev' => $this->findPrevious($this->id),
        ];
    }
}
