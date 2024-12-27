<?php

declare(strict_types=1);

// 08.11.2024 at 00:31:07
namespace App\Services\Promos;


use App\Models\Promo;
use App\Models\PromoMark;
use App\Models\PromoProduct;
use App\Services\Promos\Handlers\CreatePromoHandler;
use App\Services\Promos\Handlers\UpdatePromoMarkHandler;
use App\Services\Promos\Handlers\UpdatePromoProductHandler;
use App\Services\Promos\Repositories\PromoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class PromoService
{
    public function __construct(
        private PromoRepositoryInterface $promoRepository,
        private CreatePromoHandler $createPromoHandler,
        private UpdatePromoProductHandler $updatePromoProductHandler,
        private UpdatePromoMarkHandler $updatePromoMarkHandler,
    ) {
    }

    public function storePromo(array $data)
    : Promo {
        return $this->createPromoHandler->handle($data);
    }

    public function getPromos(array $params = [])
    : Collection {
        return $this->promoRepository->get($params);
    }

    public function findPromo(Promo $promo, array $params = [])
    : ?Promo {
        return $this->promoRepository->find($promo, $params);
    }

    public function getPromoProducts(Promo $promo, array $params = [])
    : Collection {
        return $this->promoRepository->getProducts($promo, $params);
    }

    public function getPromoSellers(int $promo_id)
    : Collection {
        return $this->promoRepository->getSellers($promo_id);
    }

    public function updatePromoProduct(int $promo_id, PromoProduct $promoProduct, array $data)
    : array {
        return $this->updatePromoProductHandler->handle($promo_id, $promoProduct, $data);
    }

    public function updatePromoMark(int $promo_id, PromoMark $promoMark, array $data)
    : ?Promo {
        return $this->updatePromoMarkHandler->handle($promo_id, $promoMark, $data);
    }

    public function updatePromo(Promo $promo, array $data)
    : Promo {
        return $this->promoRepository->updatePromoFromArray($promo, $data);
    }
}
