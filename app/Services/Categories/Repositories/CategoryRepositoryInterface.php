<?php

declare(strict_types=1);

// 30.09.2024 at 13:07:15
namespace App\Services\Categories\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function find(Category $category)
    : ?Category;

    public function get(array $params = [])
    : Collection;

    public function createFromArray(array $data)
    : Category;

    public function updateFromArray(Category $category, array $data)
    : Category;

    public function delete(Category $category)
    : void;
}
