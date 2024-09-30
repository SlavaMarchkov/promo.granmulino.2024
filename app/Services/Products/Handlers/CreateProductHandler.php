<?php

declare(strict_types=1);

// 30.09.2024 at 18:05:13
namespace App\Services\Products\Handlers;


use App\Models\Product;
use App\Services\Products\Repositories\ProductRepositoryInterface;

final readonly class CreateProductHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    )
    {
    }

    public function handle(array $data)
    : Product
    {
        dd ($data['price'] == null && auth()->user());
        return $this->productRepository->createFromArray($data);
    }
}
