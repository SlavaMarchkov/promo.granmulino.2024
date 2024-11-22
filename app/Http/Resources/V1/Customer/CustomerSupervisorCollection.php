<?php

declare(strict_types=1);

// 22.11.2024 at 18:56:52
namespace App\Http\Resources\V1\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\CustomerSupervisor */
class CustomerSupervisorCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array {
        return [
            'supervisors'      => $this->collection,
            'supervisorsCount' => $this->count(),
        ];
    }
}
