<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Retailer\StoreUpdateRequest;
use App\Http\Resources\V1\Retailer\RetailerCollection;
use App\Http\Resources\V1\Retailer\RetailerFullResource;
use App\Http\Resources\V1\Retailer\RetailerResource;
use App\Models\Retailer;
use App\Services\Retailers\RetailerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final class RetailerController extends ApiController
{
    private const CACHE_KEY = 'retailers-list-admin';

    public function __construct(
        private readonly RetailerService $retailerService,
    )
    {
    }

    public function index()
    : JsonResponse
    {
        Cache::forget(self::CACHE_KEY);

        $retailers = Cache::remember(self::CACHE_KEY, now()->addDay(), function () {
            return $this->retailerService->getRetailers([...request()->all()]);
        });

        return $this->successResponse(
            new RetailerCollection($retailers),
            'success',
            __('crud.retailers.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        $data = $request->validated();
        $retailer = $this->retailerService->storeRetailer($data);

        return $this->successResponse(
            new RetailerResource($retailer),
            'success',
            __('crud.retailers.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Retailer $retailer)
    : JsonResponse
    {
        $retailer = $this->retailerService->findRetailer($retailer);

        return $this->successResponse(
            new RetailerFullResource($retailer),
            'success',
            __('crud.retailers.one'),
        );
    }

    public function update(StoreUpdateRequest $request, Retailer $retailer)
    : JsonResponse
    {
        $data = $request->validated();
        $retailer = $this->retailerService->updateRetailer($retailer, $data);

        return $this->successResponse(
            new RetailerResource($retailer),
            'success',
            __('crud.retailers.updated'),
        );
    }

    public function destroy(Retailer $retailer)
    : JsonResponse
    {
        $result = $this->retailerService->deleteRetailer($retailer);

        return ($result == 0)
            ? $this->successResponse(
                new RetailerResource($retailer),
                'success',
                __('crud.retailers.deleted'),
            )
            : $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.retailers.not_deleted'),
            );
    }
}
