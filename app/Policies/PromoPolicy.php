<?php

declare(strict_types=1);

// 04.12.2024 at 22:00:46
namespace App\Policies;

use App\Enums\Promo\StatusEnum;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromoPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    : true|null {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user)
    : bool {
        return $user->isManager();
    }

    public function view(User $user, Promo $promo)
    : bool
    {
        return $promo->user_id === $user->id;
    }

    public function create(User $user)
    : bool {
        return $user->isManager();
    }

    public function update(User $user, Promo $promo)
    : bool {
        return $user->isAdmin()
            || ($user->isManager()
                && $promo->user_id === $user->id
                && $promo->status === StatusEnum::ON_APPROVAL
            );
    }

    public function delete(User $user, Promo $promo)
    : bool {
        return $user->isAdmin();
    }

    public function restore(User $user, Promo $promo)
    : bool {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Promo $promo)
    : bool {
        return $user->isAdmin();
    }
}
