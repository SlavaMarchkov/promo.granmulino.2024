<?php

declare(strict_types=1);

// 08.11.2024 at 00:24:23
namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Promo\PromoStatusUpdateRequest;
use App\Http\Resources\V1\Promo\PromoCollection;
use App\Http\Resources\V1\Promo\PromoFullResource;
use App\Models\Promo;
use App\Services\Promos\PromoService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

final class PromoController extends ApiController
{
    use AuthorizesRequests;

    public function __construct(
        private readonly PromoService $promoService,
    ) {
    }

    public function index()
    : JsonResponse
    {
        $this->authorize('viewAny', Promo::class);

        $promos = $this->promoService->getPromos([
            'customer' => true,
            'retailer' => true,
        ]);

        return $this->successResponse(
            new PromoCollection($promos),
            'success',
            __('crud.promos.all'),
        );
    }

    public function show(Promo $promo)
    : JsonResponse {
        $this->authorize('view', $promo);

        $promo = $this->promoService->findPromo($promo, [
            'customer'       => true,
            'retailer'       => true,
            'city'           => true,
            'channel'        => true,
            'mark'           => true,
            'promo_products' => false,
            'promo_sellers'  => false,
        ]);

        return $this->successResponse(
            new PromoFullResource($promo),
            'success',
            __('crud.promos.one'),
        );
    }

    public function update(PromoStatusUpdateRequest $request, Promo $promo)
    : JsonResponse {
        $data = $request->validated();

        $promo = $this->promoService->updatePromo($promo, $data);

        return $this->successResponse(
            new PromoFullResource($promo),
            'success',
            __('crud.promos.updated'),
        );
    }
}
