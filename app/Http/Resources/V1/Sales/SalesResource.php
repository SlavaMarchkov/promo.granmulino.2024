<?php

declare(strict_types=1);

// 21.02.2025 at 12:11:14
namespace App\Http\Resources\V1\Sales;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sales */
class SalesResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'          => $this->id,
            'salesPlan'   => $this->sales_plan,
            'salesActual' => $this->sales_actual,
            'salesDate'   => $this->sales_date->format('M.Y'),
            'userId'     => $this->user_id,
            'customerId' => $this->customer_id,
            'categoryId' => $this->category_id,

            //            'user'     => new UserResource($this->whenLoaded('user')),
            //            'customer' => new CustomerResource($this->whenLoaded('customer')),
            //            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
