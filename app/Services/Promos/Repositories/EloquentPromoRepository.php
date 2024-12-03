<?php

declare(strict_types=1);

// 09.11.2024 at 21:54:41
namespace App\Services\Promos\Repositories;


use App\Enums\Promo\TypeEnum;
use App\Models\Promo;
use Exception;
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
}
