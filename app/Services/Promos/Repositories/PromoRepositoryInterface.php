<?php

declare(strict_types=1);

// 08.11.2024 at 00:31:51
namespace App\Services\Promos\Repositories;

use App\Models\Promo;
use App\Models\PromoMark;
use App\Models\PromoProduct;
use Illuminate\Database\Eloquent\Collection;

interface PromoRepositoryInterface
{
    public function get(array $params = [])
    : Collection;

    public function createFromArray(array $data)
    : Promo;

    public function find(Promo $promo, array $params = [])
    : ?Promo;

    public function getProducts(Promo $promo, array $params = [])
    : Collection;

    public function getSellers(int $promo_id)
    : Collection;

    public function updatePromoProductFromArray(int $promo_id, PromoProduct $promoProduct, array $data)
    : array;

    public function updatePromoMarkFromArray(int $promo_id, PromoMark $promoMark, array $data)
    : ?Promo;

    public function updatePromoFromArray(Promo $promo, array $data)
    : array;
}
