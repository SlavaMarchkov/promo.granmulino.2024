<?php

declare(strict_types=1);

// 15.02.2025 at 15:00:57
namespace App\Policies;

use App\Enums\Promo\StatusEnum;
use App\Models\PromoProduct;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromoProductPolicy
{
    use HandlesAuthorization;

    public function view(User $user, PromoProduct $promoProduct)
    : bool {
        return false;
    }

    public function update(User $user, PromoProduct $promoProduct)
    : bool {
        return $user->isManager()
            && $promoProduct->promo->status->getName() === StatusEnum::WAITING_FOR_REPORT->getName();
    }

    public function delete(User $user, PromoProduct $promoProduct)
    : bool {
        return false;
    }
}
