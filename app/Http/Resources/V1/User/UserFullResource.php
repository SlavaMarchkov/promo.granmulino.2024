<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\User;

use App\Http\Resources\V1\Customer\CustomerResource;
use App\Http\Resources\V1\Image\ImageResource;
use App\Http\Resources\V1\Retailer\RetailerResource;
use App\Models\User;
use Illuminate\Http\Request;

/** @mixin User */
class UserFullResource extends UserResource
{
    public function toArray(Request $request)
    : array {
        return [
            ...parent::toArray($request),

            'images' => ImageResource::collection($this->whenLoaded('images')),
            'avatar' => new ImageResource($this->whenLoaded('latestImage')),

            'customers' => CustomerResource::collection($this->whenLoaded('customers')),
            'retailers' => RetailerResource::collection($this->whenLoaded('retailers')),
        ];
    }
}
