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

        if (isset($data['image']) && str_ends_with($data['image'], config('image.no_image'))) {
            unset($data['image']);
        }

        return $this->productRepository->createFromArray($data);
    }
}
