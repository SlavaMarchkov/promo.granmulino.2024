<?php

declare(strict_types=1);

// 09.11.2024 at 21:54:41
namespace App\Services\Promos\Repositories;


use App\Enums\Promo\TypeEnum;
use App\Models\Promo;
use Illuminate\Support\Facades\Log;

final class EloquentPromoRepository implements PromoRepositoryInterface
{

    public function createFromArray(array $data)
    : Promo
    {
        $promo = new Promo();
        $promo->fill($data);
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

        Log::info('Promo ID={id}, type={type} was created.', [
            'id' => $promo->id,
            'type' => $data['promo_type'],
        ]);

        return $promo;
    }
}
