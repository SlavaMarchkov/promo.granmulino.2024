<?php

namespace App\Models;

use App\Enums\User\RoleEnum;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function getRoleId(string $role)
    : int
    {
        return $this->query()
            ->where('slug', $role)
            ->value('id');
    }

    public function superAdminRoleId()
    : int
    {
        return $this->getRoleId(RoleEnum::SUPER_ADMIN->getName());
    }

    public function priceAdminRoleId()
    : int
    {
        return $this->getRoleId(RoleEnum::PRICE_ADMIN->getName());
    }

    public function plainAdminRoleId()
    : int
    {
        return $this->getRoleId(RoleEnum::ADMIN->getName());
    }
}
