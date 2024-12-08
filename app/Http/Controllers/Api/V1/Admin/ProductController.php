<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\StoreUpdateRequest;
use App\Http\Resources\V1\Product\ProductCollection;
use App\Http\Resources\V1\Product\ProductFullResource;
use App\Http\Resources\V1\Product\ProductResource;
use App\Models\Product;
use App\Services\Products\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final class ProductController extends ApiController
{
    public function __construct(
        private readonly ProductService $productService,
    ) {
    }

    public function index()
    : JsonResponse
    {
        $key = 'products-list-admin';

        $products = Cache::remember($key, now()->addDay(), function () {
            return $this->productService->getProducts([...request()->all()]);
        });

        return $this->successResponse(
            new ProductCollection($products),
            'success',
            __('crud.products.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        $data = $request->validated();

        if ($data['image']) {
            $data['image'] = upload_image($data['image']);
        }

        $product = $this->productService->storeProduct($data);

        return $this->successResponse(
            new ProductResource($product),
            'success',
            __('crud.products.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Product $product)
    : JsonResponse {
        $product = $this->productService->findProduct($product);

        return $this->successResponse(
            new ProductFullResource($product),
            'success',
            __('crud.products.one'),
        );
    }

    public function update(StoreUpdateRequest $request, Product $product)
    : JsonResponse {
        $data = $request->validated();

        if ($data['image'] && $data['image'] !== $product->image) {
            remove_image($product->image);
            $data['image'] = upload_image($data['image']);
        }

        $product = $this->productService->updateProduct($product, $data);

        return $this->successResponse(
            new ProductResource($product),
            'success',
            __('crud.products.updated'),
        );
    }

    public function destroy(Product $product)
    : JsonResponse {
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
