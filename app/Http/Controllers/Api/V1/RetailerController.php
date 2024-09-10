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

    protected Retailer $retailer;

    public function __construct(Retailer $retailer)
    {
        $this->retailer = $retailer;
    }

    public function index()
    : JsonResponse
    {
        // $this->authorize('viewAny', Retailer::class);

        $retailers = $this->retailer->getRetailersWithCityAndCustomer();

        return $this->successResponse(
            new RetailerCollection($retailers),
            'success',
            __('crud.retailers.all'),
        );
    }

    public function store(StoreRequest $request)
    : JsonResponse
    {
        // $this->authorize('create', Retailer::class);
        return $this->successResponse(
            new RetailerResource(Retailer::create($request->validated())),
            'success',
            __('crud.retailers.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Retailer $retailer)
    : JsonResponse
    {
        return $this->successResponse(
            new RetailerResource($retailer),
            'success',
            __('crud.retailers.one'),
        );
    }

    public function update(StoreRequest $request, Retailer $retailer)
    : JsonResponse
    {
        // $this->authorize('update', $retailer);
        $retailer->update($request->validated());

        return $this->successResponse(
            new RetailerResource($retailer),
            'success',
            __('crud.retailers.updated'),
        );
    }

    public function destroy(Retailer $retailer)
    : JsonResponse
    {
        $canBeDeleted = true; // TODO

        if ($canBeDeleted) {
            $retailer->delete();

            return $this->successResponse(
                new RetailerResource($retailer),
                'success',
                __('crud.retailers.deleted'),
            );
        } else {
            return $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.retailers.not_deleted'),
            );
        }
    }
}
