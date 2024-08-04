<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreUpdateRequest;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductController extends Controller
{
    public function index()
    : ProductCollection
    {
        return new ProductCollection(Product::all());
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        return response()->json([
            'item'    => new ProductResource(Product::create($request->validated())),
            'status'  => 'success',
            'message' => 'Продукт создан.',
        ], Response::HTTP_CREATED);
    }

    public function show(Product $product)
    : ProductResource {
        return new ProductResource($product);
    }

    public function update(StoreUpdateRequest $request, Product $product)
    : JsonResponse
    {
        $product->update($request->validated());
        return response()->json([
            'item'    => new ProductResource($product),
            'status'  => 'success',
            'message' => 'Продукт обновлён.',
        ], Response::HTTP_OK);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json();
    }
}
