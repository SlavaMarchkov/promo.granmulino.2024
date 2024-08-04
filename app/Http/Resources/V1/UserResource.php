<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request)
    : array {
        return [
            'id'         => $this->id,
            'firstName'  => $this->first_name,
            'lastName'   => $this->last_name,
            'middleName' => $this->middle_name,
            'fullName'   => $this->full_name,
            'email'      => $this->email,
            'isAdmin'    => false,
            'isActive'   => $this->is_active,
            'loggedInAt' => $this->logged_in_at,
        ];
    }
}
