<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Promo\PromoProductResource;
use App\Models\Promo;
use App\Models\PromoProduct;
use App\Services\Promos\PromoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
    }

    public function show(PromoProduct $promoProduct)
    {
    }

    public function update(Request $request, PromoProduct $promoProduct)
    {
    }

    public function destroy(PromoProduct $promoProduct)
    {
    }
}
