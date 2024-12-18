<?php

declare(strict_types=1);

// 16.12.2024 at 22:32:56
namespace App\Services\Promos\Handlers;


use App\Models\Promo;
use App\Models\PromoMark;
use App\Services\Promos\Repositories\PromoRepositoryInterface;

final readonly class UpdatePromoMarkHandler
{
    public function __construct(
        private PromoRepositoryInterface $promoRepository,
    ) {
    }

    public function handle(int $promo_id, PromoMark $promoMark, array $data)
    : ?Promo {
        return $this->promoRepository->updatePromoMarkFromArray($promo_id, $promoMark, $data);
    }
}
