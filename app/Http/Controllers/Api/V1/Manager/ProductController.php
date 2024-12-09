<?php

declare(strict_types=1);

// 07.11.2024 at 17:14:15
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Product\ProductCollection;
use App\Services\Products\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class ProductController extends ApiController
{
    private const CACHE_KEY = 'products-list-manager';

    public function __construct(
        private readonly ProductService $productService,
    )
    {
    }

    public function index()
    : JsonResponse
    {
        $products = Cache::remember(self::CACHE_KEY, now()->addHour(), function () {
            return $this->productService->getProducts([...request()->all()]);
        });

        return $this->successResponse(
            new ProductCollection($products),
            'success',
            __('crud.products.all'),
        );
    }
}
