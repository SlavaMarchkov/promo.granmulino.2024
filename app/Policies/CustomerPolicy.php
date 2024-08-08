<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User|Admin $user)
    : bool {
    }

    public function view(User $user, Customer $customer)
    : bool {
    }

    public function create(User $user)
    : bool {
    }

    public function update(User $user, Customer $customer)
    : bool {
    }

    public function delete(User $user, Customer $customer)
    : bool {
    }

    public function restore(User $user, Customer $customer)
    : bool {
    }

    public function forceDelete(User $user, Customer $customer)
    : bool {
    }
}
