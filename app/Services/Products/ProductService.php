<?php

declare(strict_types=1);

// 30.09.2024 at 18:05:32
namespace App\Services\Products;


use App\Models\Product;
use App\Services\Products\Handlers\CreateProductHandler;
use App\Services\Products\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class ProductService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CreateProductHandler $createProductHandler,
    ) {
    }

    public function findProduct(Product $product, array $params = [])
    : ?Product {
        return $this->productRepository->find($product, $params);
    }

    public function getProducts(array $params)
    : Collection {
        return $this->productRepository->get($params);
    }

    public function storeProduct(array $data)
    : Product {
        return $this->createProductHandler->handle($data);
    }

    public function updateProduct(Product $product, array $data)
    : Product {
        return $this->productRepository->updateFromArray($product, $data);
    }

    public function deleteProduct(Product $product)
    : int {
        return $this->productRepository->delete($product);
    }
}
