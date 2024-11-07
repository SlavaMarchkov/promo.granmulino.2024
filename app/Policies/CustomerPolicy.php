<?php

declare(strict_types=1);

namespace App\Policies;


use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny()
    : bool
    {
        return true;
    }

    public function view(User $user, Customer $customer)
    : bool
    {
        return auth()->check()
            && auth()->user()->isManager()
            && $customer->user_id == $user->id;
    }

    public function create(User $user)
    : bool
    {
        return true;
    }

    public function update(User $user, Customer $customer)
    : bool
    {
        return auth()->check()
            && auth()->user()->isManager()
            && $customer->user_id == $user->id;
    }

    public function delete(User $user, Customer $customer)
    : bool
    {
        return true;
    }

    public function restore(User $user, Customer $customer)
    : bool
    {
        return true;
    }

    public function forceDelete(User $user, Customer $customer)
    : bool
    {
        return true;
    }
}
