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
    : array {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'isAdmin'    => true,
            'isSuper'    => $this->is_super,
            'loggedInAt' => $this->logged_in_at,
        ];
    }
}
