<?php

declare(strict_types=1);

// 30.09.2024 at 13:10:41
namespace App\Services\Categories\Handlers;


use App\Models\Category;
use App\Services\Categories\Repositories\CategoryRepositoryInterface;

final readonly class CreateCategoryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    public function handle(array $data)
    : Category
    {
        return $this->categoryRepository->createFromArray($data);
    }
}
