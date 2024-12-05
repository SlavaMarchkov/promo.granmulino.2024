<?php

declare(strict_types=1);

// 09.11.2024 at 21:54:41
namespace App\Services\Promos\Repositories;


use App\Enums\Promo\TypeEnum;
use App\Models\Promo;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class EloquentPromoRepository implements PromoRepositoryInterface
{
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

    public function get(array $params = [])
    : Collection {
        $promosSql = Promo::query();
        $this->applyFilters($promosSql, $params);
        return $promosSql->get();
    }

    private function applyFilters(Builder $qb, array $params)
    : void {
        $qb->when(isset($params['user_id']), fn(Builder $query) => $query->where('user_id', (int)$params['user_id']))
            /*->when(
                isset($params['region']) && to_boolean($params['region']),
                fn(Builder $query) => $query->with('region'),
            )
            ->when(isset($params['city']) && to_boolean($params['city']), fn(Builder $query) => $query->with('city'))
            ->when(isset($params['user']) && to_boolean($params['user']), fn(Builder $query) => $query->with('user'))
            ->when(
                isset($params['retailers']) && to_boolean($params['retailers']),
                fn(Builder $query) => $query->with('retailers'),
            )
            ->when(
                isset($params['customer_sellers']) && to_boolean($params['customer_sellers']),
                fn(Builder $query) => $query->with('customer_sellers')->orderBy('name')->orderByDesc('is_active'),
            )*/;
    }
}
