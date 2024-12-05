<?php

declare(strict_types=1);

// 04.12.2024 at 22:00:46
namespace App\Policies;

use App\Models\Promo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PromoPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    : ?true {
        if ($user->isManager()) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user)
    : bool {
        return $user->isManager();
    }

    public function view(User $user, Promo $promo)
    : Response {
        return $user->isSuperAdmin($user->role)
            ? Response::allow()
            : Response::deny('Not allowed', \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
    }

    public function create(User $user)
    : bool {
    }

    public function update(User $user, Promo $promo)
    : bool {
    }

    public function delete(User $user, Promo $promo)
    : bool {
    }

    public function restore(User $user, Promo $promo)
    : bool {
    }

    public function forceDelete(User $user, Promo $promo)
    : bool {
    }
}
