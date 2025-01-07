<?php

declare(strict_types=1);

// 07.11.2024 at 16:32:15
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Category\CategoryCollection;
use App\Services\Categories\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class CategoryController extends ApiController
{
    private const CACHE_KEY = 'categories-list-manager';

    public function __construct(
        private readonly CategoryService $categoryService,
    ) {
    }

    public function index()
    : JsonResponse
    {
        // TODO: Cache::forget(self::CACHE_KEY);

        $categories = Cache::remember(self::CACHE_KEY, now()->addHour(), function () {
            return $this->categoryService->getCategories([
                'category_is_active' => true,
                'product_is_active'  => true,
                'products'           => true,
            ]);
        });

        return $this->successResponse(
            new CategoryCollection($categories),
            'success',
            __('crud.categories.all'),
        );
    }
}
