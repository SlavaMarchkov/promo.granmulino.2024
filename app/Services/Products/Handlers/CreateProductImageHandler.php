<?php

declare(strict_types=1);

// 24.03.2025 at 16:06:40
namespace App\Services\Products\Handlers;


use App\Models\Image;
use App\Services\Products\Repositories\ProductRepositoryInterface;

final readonly class CreateProductImageHandler
{

    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    public function handle(
        string $file,
        string $thumbnail,
        int $product_id,
        string $class,
        bool $is_main,
    )
    : Image {
        return $this->productRepository->createImageFromArray($file, $thumbnail, $product_id, $class, $is_main);
    }
}
