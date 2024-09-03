<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Admin */
class AdminResource extends JsonResource
{
    public function toArray(Request $request)
    : array
    {
        parent::$wrap = null; // TODO: check for UserResource
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'role'       => $this->role->value,
            'isAdmin'    => true,
            'loggedInAt' => $this->logged_in_at,
        ];
    }
}
