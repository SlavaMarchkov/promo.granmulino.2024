<?php

declare(strict_types=1);

// 08.11.2024 at 20:56:38
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Channel */
class ChannelCollection extends ResourceCollection
{
    public function toArray(Request $request)
    : array
    {
        return [
            'channels' => $this->collection,
        ];
    }
}
