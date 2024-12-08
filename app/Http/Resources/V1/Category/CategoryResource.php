<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Category;

use App\Http\Resources\V1\Product\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Category */
class CategoryResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'isActive'      => $this->is_active,
            'products'      => ProductResource::collection($this->whenLoaded('products')),
            'productsCount' => $this->whenLoaded('products', fn() => $this->products_count),
        ];
    }
}
