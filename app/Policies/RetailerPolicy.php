<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Admin\RoleEnum;
use App\Models\Admin;
use App\Models\Retailer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RetailerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    : bool {
    }

    public function view(User $user, Retailer $retailer)
    : bool {
    }

    public function create(User $user)
    : bool {
    }

    public function update(User $user, Retailer $retailer)
    : bool {
    }

    public function delete(Admin $admin, Retailer $retailer)
    : bool {
        // TODO: check delete method
        dump($retailer);
        dump($admin);
        dump(RoleEnum::SUPER_ADMIN->getValue());
        dd($admin->role);
//        return $admin->role === RoleEnum::SUPER_ADMIN->getValue();
    }

    public function restore(User $user, Retailer $retailer)
    : bool {
    }

    public function forceDelete(User $user, Retailer $retailer)
    : bool {
    }
}
