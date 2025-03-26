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
            'code'         => $this->code,
            'weight'       => $this->weight,
            'price'        => $this->when($isPriceAdmin, fn() => $this->price),
            'mainImage'    => $this->mainImage(),
            'isActive'     => $this->is_active,
            'categoryId'   => $this->whenLoaded('category', fn() => $this->category->id),
            'categoryName' => $this->whenLoaded('category', fn() => $this->category->name),
            'grossWeight'  => $this->gross_weight,
            'barcode'      => $this->barcode,
            'barcodeBox'   => $this->barcode_box,
            'width'        => $this->width,
            'depth'        => $this->depth,
            'height'       => $this->height,
            'widthBox'     => $this->width_box,
            'depthBox'     => $this->depth_box,
            'heightBox'    => $this->height_box,
            'capacity'     => $this->capacity,
            'boxesInLayer' => $this->boxes_in_layer,
            'packSize'     => $this->pack_size,
            'boxWeight'    => $this->box_weight,
            'boxSize'      => $this->box_size,
        ];
    }
}
