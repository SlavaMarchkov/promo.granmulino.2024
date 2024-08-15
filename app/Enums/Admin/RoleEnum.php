<?php

declare(strict_types=1);

namespace App\Enums\Admin;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'super_admin';
    case PRICE_ADMIN = 'price_admin';
    case ADMIN = 'admin';
}
