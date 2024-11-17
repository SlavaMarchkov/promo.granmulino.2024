<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\User */
class UserCollection extends ResourceCollection
{
    public static $wrap = '';

    public function toArray(Request $request)
    : array
    {
        return [
            'users'      => $this->collection,
            'usersCount' => $this->count(),
        ];
    }
}
