<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Retailer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RetailerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    : bool {
    }

    public function view(User $user, Retailer $directRetailer)
    : bool {
    }

    public function create(User $user)
    : bool {
    }

    public function update(User $user, Retailer $directRetailer)
    : bool {
    }

    public function delete(User $user, Retailer $directRetailer)
    : bool {
    }

    public function restore(User $user, Retailer $directRetailer)
    : bool {
    }

    public function forceDelete(User $user, Retailer $directRetailer)
    : bool {
    }
}
