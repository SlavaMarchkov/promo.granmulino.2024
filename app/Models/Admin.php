<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Admin\RoleEnum;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'logged_in_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts()
    : array
    {
        return [
            'is_active' => 'boolean',
            'password'  => 'hashed',
            'role' => RoleEnum::class,
        ];
    }
}
