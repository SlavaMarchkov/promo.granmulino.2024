<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Retailer\StoreRequest;
use App\Http\Resources\V1\RetailerCollection;
use App\Http\Resources\V1\RetailerResource;
use App\Models\Retailer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class RetailerController extends ApiController
{
    use AuthorizesRequests;

    public function index()
    : JsonResponse
    {
        // $this->authorize('viewAny', Retailer::class);

        $retailers = Retailer::query()
            ->with('city')
            ->with('customer')
            ->get();

        return $this->successResponse(
            new RetailerCollection($retailers),
            'success',
            'Получена коллекция Торговых сетей.',
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        // $this->authorize('create', Retailer::class);

        $retailer = new RetailerResource(Retailer::create($request->validated()));

        return $this->successResponse(
            $retailer,
            'success',
            'Торговая сеть создана.',
            Response::HTTP_CREATED,
        );
    }

    public function show(Retailer $retailer): RetailerResource
    {
        // $this->authorize('view', $retailer);

        return new RetailerResource($retailer);
    }

    public function update(StoreRequest $request, Retailer $retailer)
    {
        // $this->authorize('update', $retailer);

        $retailer->update($request->validated());

        return $this->successResponse(
            new RetailerResource($retailer),
            'success',
            'Торговая сеть обновлена.',
        );
    }
}
