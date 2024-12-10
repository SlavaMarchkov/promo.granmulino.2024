<?php

declare(strict_types=1);

// 09.11.2024 at 21:54:41
namespace App\Services\Promos\Repositories;


use App\Enums\Promo\TypeEnum;
use App\Models\Promo;
use App\Models\PromoProduct;
use App\Models\PromoSeller;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class EloquentPromoRepository implements PromoRepositoryInterface
{
    public function get(array $params = [])
    : Collection {
        $promosSql = Promo::query();
        $this->applyFilters($promosSql, $params);
        return $promosSql->get();
    }

    public function find(Promo $promo, array $params = [])
    : ?Promo {
        $promosSql = Promo::query()->where('id', $promo->id);
        $this->applyFilters($promosSql, $params);
        return $promosSql->first();
    }

    /**
     * @throws Exception
     */
    public function createFromArray(array $data)
    : Promo
    {
        try {
            $promo = new Promo();
            $promo->fill($data);

            DB::beginTransaction();

            $promo->save();

            switch ($data['promo_type']) {
                case TypeEnum::DISCOUNT->getName():
                    $products = $data['products'];
                    $promo->promo_products()->createMany($products);
                    break;
                case TypeEnum::SALES_PEOPLE_BOOST->getName():
                    $sellers = $data['sellers'];
                    $promo->promo_sellers()->createMany($sellers);
                    break;
                case TypeEnum::RETAILERS_BOOST->getName():
                    dump('RETAILERS_BOOST');
                    break;
                case TypeEnum::GIFT_FOR_PURCHASE->getName():
                    dump('GIFT_FOR_PURCHASE');
                    break;
                case TypeEnum::COVERAGE_INCREASE->getName():
                    dump('COVERAGE_INCREASE');
                    break;
                case TypeEnum::IN_OUT->getName():
                    dump('IN_OUT');
                    break;
            }

            DB::commit();

            return $promo;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Error saving a new Promo: {error}', [
                'error' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    private function applyFilters(Builder $qb, array $params)
    : void {
        $qb->when(
            isset($params['user_id']),
            fn(Builder $query) => $query->where('user_id', (int)$params['user_id'])
        )->when(
            isset($params['category']) && to_boolean($params['category']),
            fn(Builder $query) => $query->with('category'),
        )->when(
            isset($params['product']) && to_boolean($params['product']),
            fn(Builder $query) => $query->with('product'),
        );
    }

    public function getProducts(Promo $promo, array $params = [])
    : Collection {
        $productsSql = PromoProduct::query()->where('promo_id', $promo->id);
        $this->applyFilters($productsSql, $params);
        return $productsSql->get();
    }

    public function getSellers(int $promo_id)
    : Collection {
        $sellersSql = PromoSeller::query()
            ->where('promo_id', $promo_id);
        return $sellersSql->get();
    }
}
