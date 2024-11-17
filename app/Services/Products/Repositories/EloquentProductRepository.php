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
        return Product::query()->where('id', $product->id)->first();
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
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    : int
    {
        // TODO: связать с продуктами в брифе ПА
        return 1;
        /*$cities_count = $product->

        if ($cities_count == 0) {
            $region->delete();
        }

        return $cities_count;*/
    }

    private function applyFilters(Builder $qb, array $params)
    : void
    {
        $qb->when(
            isset($params['is_active']) && to_boolean($params['is_active']),
            fn($qb) => $qb->where('is_active', true),
        );
    }
}
