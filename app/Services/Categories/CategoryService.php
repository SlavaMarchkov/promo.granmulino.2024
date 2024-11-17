<?php

declare(strict_types=1);

// 30.09.2024 at 13:12:03
namespace App\Services\Categories;


use App\Models\Category;
use App\Services\Categories\Handlers\CreateCategoryHandler;
use App\Services\Categories\Repositories\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CreateCategoryHandler       $createCategoryHandler,
    )
    {
    }

    public function findCategory(Category $category)
    : ?Category
    {
        return $this->categoryRepository->find($category);
    }

    public function getCategories(array $params = [])
    : Collection
    {
        return $this->categoryRepository->get($params);
    }

    public function storeCategory(array $data)
    : Category
    {
        return $this->createCategoryHandler->handle($data);
    }

    public function updateCategory(Category $category, array $data)
    : Category
    {
        return $this->categoryRepository->updateFromArray($category, $data);
    }

    public function deleteCategory(Category $category)
    : int
    {
        return $this->categoryRepository->delete($category);
    }
}
