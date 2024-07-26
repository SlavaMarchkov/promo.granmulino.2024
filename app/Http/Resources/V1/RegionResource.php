<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Region */
final class RegionResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'        => $this->id,
            'code'      => $this->code,
            'name'      => $this->name,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
