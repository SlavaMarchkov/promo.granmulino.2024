<?php

declare(strict_types=1);

// 07.11.2024 at 16:32:15
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\CategoryCollection;
use App\Services\Categories\CategoryService;
use Illuminate\Http\JsonResponse;

final class CategoryController extends ApiController
{
    public function __construct(
        private readonly CategoryService $categoryService,
    )
    {
    }

    public function index()
    : JsonResponse
    {
        $categories = $this->categoryService->getCategories([
            'category_is_active' => request()->boolean('is_active'),
            'product_is_active'  => true,
        ]);

        return $this->successResponse(
            new CategoryCollection($categories),
            'success',
            __('crud.categories.all'),
        );
    }
}
