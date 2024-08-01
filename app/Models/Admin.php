<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'abilities',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
