<?php

declare(strict_types=1);

// 30.09.2024 at 18:04:14
namespace App\Services\Products\Repositories;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function find(Product $product, array $params = [])
    : ?Product;

    public function get(array $params = [])
    : Collection;

    public function createFromArray(array $data)
    : Product;

    public function updateFromArray(Product $product, array $data)
    : Product;

    public function delete(Product $product)
    : int;

    public function createImageFromArray(
        string $file,
        string $thumbnail,
        int $product_id,
        string $class,
        bool $is_main,
    )
    : Image;
}
