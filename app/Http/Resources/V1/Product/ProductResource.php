<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Product;

use App\Enums\User\RoleEnum;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        $isPriceAdmin = $request->user()->role->slug === RoleEnum::PRICE_ADMIN->name;

        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'weight'       => $this->weight,
            'price'        => $this->when($isPriceAdmin, fn() => $this->price),
            'image'        => $this->image,
            'isActive'     => $this->is_active,
            'categoryId'   => $this->whenLoaded('category', fn() => $this->category->id),
            'categoryName' => $this->whenLoaded('category', fn() => $this->category->name),
        ];
    }
}
