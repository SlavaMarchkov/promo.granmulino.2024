<?php

declare(strict_types=1);

// 22.11.2024 at 17:41:28
namespace App\Policies;

use App\Models\Customer;
use App\Models\CustomerSupervisor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerSupervisorPolicy
{
    use HandlesAuthorization;

    /*public function before(User $user)
    : ?true {
        if ($user->isManager()) {
            return true;
        }
        return null;
    }*/

    public function viewAny(User $user, Customer $customer)
    : bool
    {
        return auth()->check()
            && auth()->user()->isManager()
            && $customer->user_id == $user->id;
    }

    public function view(User $user, CustomerSupervisor $customerSupervisor)
    : bool {
    }

    public function create(User $user, int $request_customer_id, int $customer_id)
    : bool {
        return auth()->check()
            && auth()->user()->isManager()
            && $request_customer_id === $customer_id;
    }

    public function update(User $user, CustomerSupervisor $customerSupervisor)
    : bool {
    }

    public function delete(User $user, CustomerSupervisor $customerSupervisor)
    : bool {
    }

    public function restore(User $user, CustomerSupervisor $customerSupervisor)
    : bool {
    }

    public function forceDelete(User $user, CustomerSupervisor $customerSupervisor)
    : bool {
    }
}
