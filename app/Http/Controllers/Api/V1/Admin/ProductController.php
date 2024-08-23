<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\StoreUpdateRequest;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductController extends ApiController
{
    public function index()
    : JsonResponse
    {
        $products = Product::all();

        return $this->successResponse(
            new ProductCollection($products),
            'success',
            __('crud.products.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        $product = new ProductResource(Product::create($request->validated()));

        return $this->successResponse(
            $product,
            'success',
            __('crud.products.created'),
            Response::HTTP_CREATED,
        );
    }

    // TODO: how to show one item
    public function show(Product $product)
    : ProductResource {
        return new ProductResource($product);
    }

    public function update(StoreUpdateRequest $request, Product $product)
    : JsonResponse
    {
        $product->update($request->validated());

        return $this->successResponse(
            new ProductResource($product),
            'success',
            __('crud.products.updated'),
        );
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return $this->successResponse(
            new ProductResource($product),
            'success',
            __('crud.products.deleted'),
        );
    }
}
