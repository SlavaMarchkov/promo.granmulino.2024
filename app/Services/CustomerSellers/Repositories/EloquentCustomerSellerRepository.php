<?php

declare(strict_types=1);

// 15.11.2024 at 18:05:20
namespace App\Services\CustomerSellers\Repositories;


use App\Models\CustomerSeller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentCustomerSellerRepository implements CustomerSellerRepositoryInterface
{
    public function find(CustomerSeller $customerSeller)
    : ?CustomerSeller {
        $customerSellerSql = CustomerSeller::query()->where('id', $customerSeller->id);
        return $customerSellerSql->first();
    }

    public function get(array $params = [])
    : Collection {
        $customerSellersSql = CustomerSeller::query();
        $this->applyFilters($customerSellersSql, $params);
        return $customerSellersSql->get();
    }

    public function createFromArray(array $data)
    : CustomerSeller {
        return CustomerSeller::query()->create($data);
    }

    public function updateFromArray(CustomerSeller $customerSeller, array $data)
    : CustomerSeller {
        $customerSeller->update($data);
        return $customerSeller;
    }

    private function applyFilters(Builder $qb, array $params)
    : void {
        $qb->when(
            isset($params['customer_id']),
            fn(Builder $query) => $query->where('customer_id', (int)$params['customer_id']),
        )
            ->when(
                isset($params['customer']) && to_boolean($params['customer']),
                fn(Builder $query) => $query->with('customer'),
            )
            ->orderBy('is_active', 'desc')
            ->orderBy('name');
    }
}
