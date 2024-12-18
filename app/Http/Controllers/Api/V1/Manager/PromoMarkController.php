<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Promo\PromoMarkUpdateRequest;
use App\Http\Resources\V1\Promo\PromoFullResource;
use App\Models\PromoMark;
use App\Services\Promos\PromoService;
use Illuminate\Http\JsonResponse;

final class PromoMarkController extends ApiController
{
    public function __construct(
        private readonly PromoService $promoService,
    ) {
    }

    public function update(int $promo_id, PromoMark $mark, PromoMarkUpdateRequest $request)
    : JsonResponse {
        $data = $request->validated();

        $promo = $this->promoService->updatePromoMark($promo_id, $mark, $data);

        return $this->successResponse(
            new PromoFullResource($promo),
            'success',
            __('crud.promos.updated'),
        );
    }
}
