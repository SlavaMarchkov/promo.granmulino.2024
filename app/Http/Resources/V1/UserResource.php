<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request)
    : array
    {
        return [
            'id'          => $this->id,
            'lastName'    => $this->last_name,
            'firstName'   => $this->first_name,
            'middleName'  => $this->middle_name,
            'fullName'    => $this->full_name,
            'displayName' => $this->display_name,
            'email'       => $this->email,
            'isAdmin'     => $this->is_admin,
            'isActive'    => $this->is_active,
            'roleName'    => $this->role->name,
            'role'        => $this->role->slug,
            'loggedInAt'  => Carbon::make($this->logged_in_at)?->diffForHumans(),
        ];
    }
}
