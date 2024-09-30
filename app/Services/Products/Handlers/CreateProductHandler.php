<?php

declare(strict_types=1);

// 30.09.2024 at 18:05:13
namespace App\Services\Products\Handlers;


use App\Models\Product;
use App\Models\Role;
use App\Services\Products\Repositories\ProductRepositoryInterface;

final readonly class CreateProductHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private Role                       $role,
    )
    {
    }

    public function handle(array $data)
    : Product
    {
        if ($data['price'] == null && auth()->user()->isSuperAdmin($this->role)) {
            $data['price'] = 0.00;
        }

        return $this->productRepository->createFromArray($data);
    }
}
