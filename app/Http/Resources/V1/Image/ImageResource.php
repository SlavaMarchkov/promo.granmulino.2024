<?php

declare(strict_types=1);

// 23.02.2025 at 16:44:48
namespace App\Http\Resources\V1\Image;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Image */
class ImageResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'        => $this->id,
            'file'      => $this->file,
            'thumbnail' => $this->thumbnail,
            //            'size' => $this->path ? Storage::mimeType(storage_path(config('image.path_to_user_thumbnails') . $this->url)) : null,
            //            'name' => str_replace('images/', '', $this->path),
        ];
    }
}
