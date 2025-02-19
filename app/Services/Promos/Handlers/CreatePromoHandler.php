<?php

declare(strict_types=1);

// 08.11.2024 at 00:33:16
namespace App\Services\Promos\Handlers;


use App\Models\Promo;
use App\Services\Promos\Repositories\PromoRepositoryInterface;

final readonly class CreatePromoHandler
{
    public function __construct(
        private PromoRepositoryInterface $promoRepository,
    ) {
    }

    public function handle(array $data)
    : Promo {
        $totals = [];

        if (isset($data['sellers'])) {
            $totals = $this->calcPromoTotalValues($data['sellers']);
        }
        if (isset($data['products'])) {
            $totals = $this->calcPromoTotalValues($data['products']);
            $totals['total_promo_profit_plan'] = collect($data['products'])
                ->reduce(function ($carry, $item) {
                    return $carry + (int)$item['profit_per_product_plan'];
                }, 0);
        }

        return $this->promoRepository->createFromArray(array_merge($data, $totals));
    }

    /**
     * @param array $data
     * @return array
     */
    private function calcPromoTotalValues(array $data)
    : array {
        $collection = collect($data);

        $totals = [];

        $totals['total_sales_before'] = $collection->reduce(function ($carry, $item) {
            return $carry + (int)$item['sales_before'];
        }, 0);
        $totals['total_sales_plan'] = $collection->reduce(function ($carry, $item) {
            return $carry + (int)$item['sales_plan'];
        }, 0);
        $totals['total_budget_plan'] = $collection->reduce(function ($carry, $item) {
            return $carry + (int)$item['budget_plan'];
        }, 0);

        return $totals;
    }
}
