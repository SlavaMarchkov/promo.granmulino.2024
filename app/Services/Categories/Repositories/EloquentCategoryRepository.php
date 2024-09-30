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
    : ?Category
    {
        return Category::query()->where('id', $category->id)->first();
    }

    public function get(array $params = [])
    : Collection
    {
        $categoriesSql = Category::query();
        $this->applyFilters($categoriesSql, $params);
        return $categoriesSql->get();
    }

    public function createFromArray(array $data)
    : Category
    {
        return Category::query()->create($data);
    }

    public function updateFromArray(Category $category, array $data)
    : Category
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    : void
    {
        // TODO: Implement delete() method.
    }

    private function applyFilters(Builder $qb, array $params)
    : void
    {
        $qb->withCount([
                'products' => function (Builder $query) use ($params) {
                    $query->when(
                        $params['product_is_active'] == true,
                        fn($qb) => $qb->where('is_active', true)
                    );
                },
            ])
            ->when(
                $params['category_is_active'] == true,
                fn($qb) => $qb->where('is_active', true)
            )
            ->with('products');
    }
}
