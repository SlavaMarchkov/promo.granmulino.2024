<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Customer;
use App\Models\CustomerSeller;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerSellerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, Customer $customer)
    : bool
    {
        return auth()->check()
            && auth()->user()->isManager()
            && $customer->user_id == $user->id;
    }

    public function view(User $user, CustomerSeller $customerSeller)
    : bool {
    }

    public function create(User $user, int $request_customer_id, int $customer_id)
    : bool {
        return auth()->check()
            && auth()->user()->isManager()
            && $request_customer_id === $customer_id;
    }

    public function update(User $user, CustomerSeller $customerSeller)
    : bool {
    }

    public function delete(User $user, CustomerSeller $customerSeller)
    : bool {
    }

    public function restore(User $user, CustomerSeller $customerSeller)
    : bool {
    }

    public function forceDelete(User $user, CustomerSeller $customerSeller)
    : bool {
    }
}
