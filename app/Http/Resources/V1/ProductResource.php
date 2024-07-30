<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'price'    => $this->price,
            'image'    => $this->image,
            'isActive' => $this->is_active,
            'categoryId' => $this->category_id,
            'category' => $this->category->name,
        ];
    }
}
