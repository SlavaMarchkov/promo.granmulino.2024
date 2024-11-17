<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\StoreUpdateRequest;
use App\Http\Resources\V1\Product\ProductCollection;
use App\Http\Resources\V1\Product\ProductResource;
use App\Models\Product;
use App\Services\Products\ProductService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductController extends ApiController
{
    public function __construct(
        private readonly ProductService $productService,
    )
    {
    }

    public function index()
    : JsonResponse
    {
        $products = $this->productService->getProducts([
            ...request()->all()
        ]);

        return $this->successResponse(
            new ProductCollection($products),
            'success',
            __('crud.products.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        $data = $request->validated();
        $product = $this->productService->storeProduct($data);

        return $this->successResponse(
            new ProductResource($product),
            'success',
            __('crud.products.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Product $product)
    : JsonResponse
    {
        $product = $this->productService->findProduct($product);

        return $this->successResponse(
            new ProductResource($product),
            'success',
            __('crud.products.one'),
        );
    }

    public function update(StoreUpdateRequest $request, Product $product)
    : JsonResponse
    {
        $data = $request->validated();
        $product = $this->productService->updateProduct($product, $data);

        return $this->successResponse(
            new ProductResource($product),
            'success',
            __('crud.products.updated'),
        );
    }

    public function destroy(Product $product)
    : JsonResponse
    {
        $result = $this->productService->deleteProduct($product);

        return ($result == 0)
            ? $this->successResponse(
                new ProductResource($product),
                'success',
                __('crud.products.deleted'),
            )
            : $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.products.not_deleted'),
            );
    }
}
