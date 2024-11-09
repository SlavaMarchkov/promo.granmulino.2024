<?php

declare(strict_types=1);

// 08.11.2024 at 00:24:23
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Promo\StoreRequest;
use App\Http\Resources\V1\PromoResource;
use App\Services\Promos\PromoService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class PromoController extends ApiController
{
    public function __construct(
        private readonly PromoService $promoService,
    )
    {
    }

    public function index()
    {

    }

    public function store(StoreRequest $request)
    : JsonResponse
    {
        $data = $request->validated();
        $promo = $this->promoService->storePromo($data);

        return $this->successResponse(
            new PromoResource($promo),
            'success',
            __('crud.promos.created'),
            Response::HTTP_CREATED,
        );
    }
}
