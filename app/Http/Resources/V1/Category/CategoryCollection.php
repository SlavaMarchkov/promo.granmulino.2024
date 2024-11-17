<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Category */
class CategoryCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array
    {
        return [
            'categories'      => $this->collection,
            'categoriesCount' => $this->count(),
        ];
    }
}
