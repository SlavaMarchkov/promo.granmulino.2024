<?php

declare(strict_types=1);

namespace App\Policies;


use App\Enums\User\RoleEnum;
use App\Models\Retailer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RetailerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    : bool
    {
        return true;
    }

    public function view(User $user, Retailer $retailer)
    : bool
    {
        return auth()->check()
            && auth()->user()->isManager()
            && $retailer->customer->user_id == $user->id;
    }

    public function create(User $user)
    : bool
    {
        return true;
    }

    public function update(User $user, Retailer $retailer)
    : bool
    {
        return true;
    }

    public function delete(User $user, Retailer $retailer)
    : bool
    {
        // TODO: check delete method
        dump($retailer);
        dump($user);
        dump(RoleEnum::SUPER_ADMIN->getValue());
        dd($user->role);
//        return $admin->role === RoleEnum::SUPER_ADMIN->getValue();
    }

    public function restore(User $user, Retailer $retailer)
    : bool
    {
        return true;
    }

    public function forceDelete(User $user, Retailer $retailer)
    : bool
    {
        return true;
    }
}
