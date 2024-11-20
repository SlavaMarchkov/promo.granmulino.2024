<?php

declare(strict_types=1);

// 08.11.2024 at 20:52:17
namespace App\Http\Resources\V1\Channel;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Channel */
class ChannelResource extends JsonResource
{
    public function toArray(Request $request)
    : array
    {
        return [
            'id'         => $this->id,
            'slug'       => $this->slug,
            'name'       => $this->name,
            'isForRetail' => $this->is_for_retail,
        ];
    }
}
