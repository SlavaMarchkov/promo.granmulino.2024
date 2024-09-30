<?php

declare(strict_types=1);

// 30.09.2024 at 18:04:51
namespace App\Services\Products\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentProductRepository implements ProductRepositoryInterface
{

    public function find(Product $product)
    : ?Product
    {
        // TODO: Implement find() method.
    }

    public function get(array $params = [])
    : Collection
    {
        $productsSql = Product::query();
        $this->applyFilters($productsSql, $params);
        return $productsSql->get();
    }

    public function createFromArray(array $data)
    : Product
    {
        return Product::query()->create($data);
    }

    public function updateFromArray(Product $product, array $data)
    : Product
    {
        // TODO: Implement updateFromArray() method.
    }

    public function delete(Product $product)
    : void
    {
        // TODO: Implement delete() method.
    }

    private function applyFilters(Builder $qb, array $params)
    : void
    {
        $qb->when(
            $params['is_active'] == true,
            fn($qb) => $qb->where('is_active', true),
        );
    }
}
