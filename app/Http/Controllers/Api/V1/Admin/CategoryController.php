<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Category\StoreUpdateRequest;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends ApiController
{
    protected Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    : JsonResponse
    {
        $categories = $this->category->getCategoriesWithActiveProducts();

        return $this->successResponse(
            new CategoryCollection($categories),
            'success',
            __('crud.categories.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        return $this->successResponse(
            new CategoryResource(Category::create($request->validated())),
            'success',
            __('crud.categories.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Category $category)
    : JsonResponse
    {
        return $this->successResponse(
            new CategoryResource($category),
            'success',
            __('crud.regions.one'),
        );
    }

    public function update(StoreUpdateRequest $request, Category $category)
    : JsonResponse
    {
        $category->update($request->validated());

        return $this->successResponse(
            new CategoryResource($category),
            'success',
            __('crud.categories.updated'),
        );
    }

    public function destroy(Category $category)
    : JsonResponse
    {
        $canBeDeleted = false; // TODO: проверить на кол-во городов в регионе и у Customer

        if ($canBeDeleted) {
            $category->delete();

            return $this->successResponse(
                new CategoryResource($category),
                'success',
                __('crud.categories.deleted'),
            );
        } else {
            return $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.categories.not_deleted'),
            );
        }
    }
}
