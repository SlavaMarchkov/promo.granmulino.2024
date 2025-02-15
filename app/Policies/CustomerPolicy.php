<?php

declare(strict_types=1);

namespace App\Policies;


use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    : bool
    {
        return auth()->check() && auth()->user()->isManager();
    }

    public function view(User $user, Customer $customer)
    : bool
    {
        return auth()->check()
            && auth()->user()->isManager()
            && $customer->user_id == $user->id;
    }

    public function update(User $user, Customer $customer)
    : bool
    {
        return auth()->check()
            && auth()->user()->isManager()
            && $customer->user_id == $user->id;
    }
}
