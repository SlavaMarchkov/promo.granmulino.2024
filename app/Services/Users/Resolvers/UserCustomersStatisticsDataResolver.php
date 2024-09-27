<?php

declare(strict_types=1);

// 26.09.2024 at 19:59:15
namespace App\Services\Users\Resolvers;


use App\Models\User;

final class UserCustomersStatisticsDataResolver
{
    public function __construct()
    {
        // $this->customerService (inject)
    }

    public function resolve(User $user)
    : array
    {
        return [];
    }
}
