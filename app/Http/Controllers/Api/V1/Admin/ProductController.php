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
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

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
    : JsonResponse
    {
        return $this->successResponse(
            new ProductResource(Product::create($request->validated())),
            'success',
            __('crud.products.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Product $product)
    : JsonResponse
    {
        return $this->successResponse(
            new ProductResource($product),
            'success',
            __('crud.regions.one'),
        );
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
    : JsonResponse
    {
        $canBeDeleted = false;

        if ($canBeDeleted) {
            $product->delete();

            return $this->successResponse(
                new ProductResource($product),
                'success',
                __('crud.products.deleted'),
            );
        } else {
            return $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.products.not_deleted'),
            );
        }
    }
}
