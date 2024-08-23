<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Category\StoreUpdateRequest;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends ApiController
{
    public function index()
    : JsonResponse
    {
        $categories = Category::withCount([
            'products' => function (Builder $query) {
                $query->where('is_active', true);
            },
        ])
            ->with('products')
            ->get();

        return $this->successResponse(
            new CategoryCollection($categories),
            'success',
            __('crud.categories.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        $category = new CategoryResource(Category::create($request->validated()));

        return $this->successResponse(
            $category,
            'success',
            __('crud.categories.created'),
            Response::HTTP_CREATED,
        );
    }

    // TODO: how to show one item
    public function show(Category $category)
    : CategoryResource {
        return new CategoryResource($category);
    }

    public function update(StoreUpdateRequest $request, Category $category)
    : JsonResponse {
        $category->update($request->validated());

        return $this->successResponse(
            new CategoryResource($category),
            'success',
            __('crud.categories.updated'),
        );
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return $this->successResponse(
            new CategoryResource($category),
            'success',
            __('crud.categories.deleted'),
        );
    }
}
