<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreUpdateRequest;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;

final class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function store(StoreUpdateRequest $request)
    {
        return new ProductResource(Product::create($request->validated()));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(StoreUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json();
    }
}
