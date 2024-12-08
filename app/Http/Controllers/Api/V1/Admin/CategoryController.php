<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Category\StoreUpdateRequest;
use App\Http\Resources\V1\Category\CategoryCollection;
use App\Http\Resources\V1\Category\CategoryFullResource;
use App\Http\Resources\V1\Category\CategoryResource;
use App\Models\Category;
use App\Services\Categories\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

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
        $key = 'categories-list-admin';
        // Cache::forget($key);

        $categories = Cache::remember($key, now()->addDay(), function () {
            return $this->categoryService->getCategories([...request()->all()]);
        });

        return $this->successResponse(
            new CategoryCollection($categories),
            'success',
            __('crud.categories.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        $data = $request->validated();
        $category = $this->categoryService->storeCategory($data);

        return $this->successResponse(
            new CategoryResource($category),
            'success',
            __('crud.categories.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Category $category)
    : JsonResponse
    {
        $category = $this->categoryService->findCategory($category);

        return $this->successResponse(
            new CategoryFullResource($category),
            'success',
            __('crud.categories.one'),
        );
    }

    public function update(StoreUpdateRequest $request, Category $category)
    : JsonResponse
    {
        $data = $request->validated();
        $category = $this->categoryService->updateCategory($category, $data);

        return $this->successResponse(
            new CategoryResource($category),
            'success',
            __('crud.categories.updated'),
        );
    }

    public function destroy(Category $category)
    : JsonResponse
    {
        $result = $this->categoryService->deleteCategory($category);

        return ($result == 0)
            ? $this->successResponse(
                new CategoryResource($category),
                'success',
                __('crud.categories.deleted'),
            )
            : $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.categories.not_deleted'),
            );
    }
}
