<?php

declare(strict_types=1);

// 08.11.2024 at 00:24:23
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Promo\PromoDataUpdateRequest;
use App\Http\Requests\Promo\StoreRequest;
use App\Http\Resources\V1\Promo\PromoCollection;
use App\Http\Resources\V1\Promo\PromoFullResource;
use App\Http\Resources\V1\Promo\PromoResource;
use App\Models\Promo;
use App\Services\Promos\PromoService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
            'user_id'  => auth()->id(),
            'customer' => true,
            'retailer' => true,
        ]);

        return $this->successResponse(
            new PromoCollection($promos),
            'success',
            __('crud.promos.all'),
        );
    }

    public function store(StoreRequest $request)
    : JsonResponse {
        $this->authorize('create', Promo::class);

        $data = $request->validated();

        $promo = $this->promoService->storePromo($data);

        return $this->successResponse(
            new PromoResource($promo),
            'success',
            __('crud.promos.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Promo $promo)
    : JsonResponse {
        $this->authorize('view', $promo);

        $promo = $this->promoService->findPromo($promo, [
            'user_id'        => auth()->id(),
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

    public function update(PromoDataUpdateRequest $request, Promo $promo)
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
