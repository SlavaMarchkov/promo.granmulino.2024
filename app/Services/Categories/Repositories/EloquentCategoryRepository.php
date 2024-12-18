<?php

declare(strict_types=1);

// 30.09.2024 at 13:09:57
namespace App\Services\Categories\Repositories;


use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentCategoryRepository implements CategoryRepositoryInterface
{

    public function find(Category $category)
    : ?Category {
        return Category::query()->where('id', $category->id)->first();
    }

    public function get(array $params = [], bool $isAdmin = false)
    : Collection {
        $categoriesSql = Category::query();
        $isAdmin ? $this->applyAdminFilters($categoriesSql, $params) : $this->applyFilters($categoriesSql, $params);
        return $categoriesSql->get();
    }

    public function createFromArray(array $data)
    : Category {
        return Category::query()->create($data);
    }

    public function updateFromArray(Category $category, array $data)
    : Category {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    : int {
        $products_count = $category->products->count();

        if ($products_count == 0) {
            $category->delete();
        }

        return $products_count;
    }

    private function applyFilters(Builder $qb, array $params)
    : void {
        $qb->when(
            isset($params['category_is_active']) && to_boolean($params['category_is_active']),
            fn(Builder $query) => $query->where('is_active', true)
                ->when(
                    isset($params['products']) && to_boolean($params['products']),
                    fn(Builder $query) => $query->with(
                        'products',
                        fn($qb) => $qb->when(
                            isset($params['product_is_active']) && to_boolean($params['product_is_active']),
                            fn(Builder $query) => $query->where('is_active', true),
                        ),
                    ),
                )->withCount([
                    'products' => fn(Builder $query) => $query->when(
                        isset($params['product_is_active']) && to_boolean($params['product_is_active']),
                        fn($qb) => $qb->where('is_active', true),
                    ),
                ]),
        );
    }

    private function applyAdminFilters(Builder $qb, array $params)
    : void {
        $qb->when(
            isset($params['category_is_active']) && to_boolean($params['category_is_active']),
            fn(Builder $query) => $query->where('is_active', true),
        )
            ->when(
                isset($params['products']) && to_boolean($params['products']),
                fn(Builder $query) => $query->with('products'),
            )
            ->withCount([
                'products' => fn(Builder $query) => $query->when(
                    isset($params['product_is_active']) && to_boolean($params['product_is_active']),
                    fn($qb) => $qb->where('is_active', true),
                ),
            ]);
    }
}
