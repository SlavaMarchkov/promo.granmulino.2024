<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Promo\PromoSellerResource;
use App\Models\Promo;
use App\Services\Promos\PromoService;
use Illuminate\Http\JsonResponse;

final class PromoSellerController extends ApiController
{
    public function __construct(
        private readonly PromoService $promoService,
    ) {
    }

    public function index(Promo $promo)
    : JsonResponse {
        $sellers = $this->promoService->getPromoSellers($promo->id);

        return $this->successResponse(
            PromoSellerResource::collection($sellers),
            'success',
            __('crud.sellers.all'),
        );
    }
}
