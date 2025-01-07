<?php

declare(strict_types=1);

// 05.01.2025 at 19:22:48
namespace App\Http\Resources\V1\Customer;

use App\Http\Resources\V1\Product\ProductResource;
use App\Models\CustomerProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CustomerProduct */
class CustomerProductResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'customerPrice' => $this->customer_price,
            'isListed'      => $this->is_listed,
            'updatedAt'     => $this->updated_at->format('d.m.Y в H:i:s'),

            'customerId' => $this->customer_id,
            'productId'  => $this->product_id,
            'categoryId' => $this->category_id,

            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'product'  => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
