<?php

declare(strict_types=1);

// 07.01.2025 at 23:27:36
namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Customer $customer)
    : bool {
        return auth()->check()
            && auth()->user()->isManager()
            && $customer->user_id == $user->id;
    }

    public function create(User $user, int $request_customer_id, int $customer_id)
    : bool {
        return auth()->check()
            && auth()->user()->isManager()
            && $request_customer_id === $customer_id;
    }
}
