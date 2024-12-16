<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Promo\PromoProductUpdateRequest;
use App\Http\Resources\V1\Promo\PromoProductResource;
use App\Models\Promo;
use App\Models\PromoProduct;
use App\Services\Promos\PromoService;
use Illuminate\Http\JsonResponse;

final class PromoProductController extends ApiController
{
    public function __construct(
        private readonly PromoService $promoService,
    ) {
    }

    public function index(Promo $promo)
    : JsonResponse {
        $products = $this->promoService->getPromoProducts(
            $promo,
            [...request()->all()],
        );

        return $this->successResponse(
            PromoProductResource::collection($products),
            'success',
            __('crud.products.all'),
        );
    }

    public function update(int $promo_id, PromoProduct $product, PromoProductUpdateRequest $request)
    : JsonResponse {
        $data = $request->validated();
        $product = $this->promoService->updatePromoProduct($promo_id, $product, $data);

        return $this->successResponse(
            new PromoProductResource($product),
            'success',
            __('crud.products.updated'),
        );
    }

    public function destroy(PromoProduct $promoProduct)
    {
    }
}
