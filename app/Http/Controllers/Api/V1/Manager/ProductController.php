<?php

declare(strict_types=1);

// 07.11.2024 at 17:14:15
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Product\ProductCollection;
use App\Services\Products\ProductService;
use Illuminate\Http\JsonResponse;

final class ProductController extends ApiController
{
    public function __construct(
        private readonly ProductService $productService,
    )
    {
    }

    public function index()
    : JsonResponse
    {
        $products = $this->productService->getProducts([
            'is_active' => request()->boolean('is_active'),
        ]);

        return $this->successResponse(
            new ProductCollection($products),
            'success',
            __('crud.products.all'),
        );
    }
}
