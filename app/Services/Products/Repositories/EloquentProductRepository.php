<?php

declare(strict_types=1);

// 30.09.2024 at 18:04:51
namespace App\Services\Products\Repositories;

use App\Models\Product;
use App\Services\Products\Filters\Category;
use App\Services\Products\Filters\Id;
use App\Services\Products\Filters\IsActive;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

final class EloquentProductRepository implements ProductRepositoryInterface
{

    /**
     * @throws BindingResolutionException
     */
    public function find(Product $product, array $params = [])
    : ?Product {
        request()->merge(['id' => $product->id, ...$params]);
        $product = app()->make(Pipeline::class)
            ->send(Product::query())
            ->through([
                Id::class,
                IsActive::class,
                Category::class,
            ])
            ->thenReturn();
        return $product->first();
    }

    /**
     * @throws BindingResolutionException
     */
    public function get(array $params = [])
    : Collection {
        request()->merge($params);
        $products = app()->make(Pipeline::class)
            ->send(Product::query())
            ->through([
                IsActive::class,
                Category::class,
            ])
            ->thenReturn();
        return $products->get();
    }

    public function createFromArray(array $data)
    : Product {
        return Product::query()->create($data);
    }

    public function updateFromArray(Product $product, array $data)
    : Product {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    : int {
        $customers_count = DB::scalar(
            '
select count(*)
    as customers_count
from customer_product
where product_id = ?
',
            [$product->id],
        );

        if ($customers_count == 0) {
            $product->delete();
        }

        return $customers_count;
    }
}
