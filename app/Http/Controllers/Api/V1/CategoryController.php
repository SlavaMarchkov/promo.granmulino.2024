<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreUpdateRequest;
use App\Http\Resources\V1\CategoryCollection;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CategoryController extends Controller
{
    public function index()
    {
        return new CategoryCollection(Category::all());
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        return response()->json([
            'item'    => new CategoryResource(Category::create($request->validated())),
            'status'  => 'success',
            'message' => 'Группа товаров создана.',
        ], Response::HTTP_CREATED);
    }

    public function show(Category $category)
    : CategoryResource {
        return new CategoryResource($category);
    }

    public function update(StoreUpdateRequest $request, Category $category)
    : JsonResponse {
        $category->update($request->validated());
        return response()->json([
            'item'    => new CategoryResource($category),
            'status'  => 'success',
            'message' => 'Группа товаров обновлена.',
        ], Response::HTTP_OK);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json();
    }
}
