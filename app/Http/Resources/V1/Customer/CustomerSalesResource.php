<?php

declare(strict_types=1);

// 12.03.2025 at 20:58:29
namespace App\Http\Resources\V1\Customer;

use App\Models\CustomerSales;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CustomerSales */
class CustomerSalesResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'          => $this->id,
            'salesPlan'   => $this->sales_plan,
            'salesActual' => $this->sales_actual,
            'salesYear'   => $this->sales_date->format('Y'),
            'salesMonth'  => $this->sales_date->format('m'),
            'salesDate'   => $this->sales_date->format('Y-m-d'),
            'comments'    => $this->comments,

            'userId'       => $this->user_id,
            'customerId'   => $this->customer_id,
            'categoryId'   => $this->category_id,
            'categoryName' => $this->whenLoaded('category', fn() => $this->category->name),
        ];
    }
}
