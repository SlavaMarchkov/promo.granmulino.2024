<?php

declare(strict_types=1);

// 17.11.2024 at 22:09:38
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Retailer\RetailerCollection;
use App\Http\Resources\V1\Retailer\RetailerResource;
use App\Models\Retailer;
use App\Services\Retailers\RetailerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

final class RetailerController extends ApiController
{
    use AuthorizesRequests;

    public function __construct(
        private readonly RetailerService $retailerService,
    )
    {}

    public function index()
    : JsonResponse
    {
        $user_id = auth()->user()->id;
        $retailers = $this->retailerService->getRetailersForUser($user_id);

        return $this->successResponse(
            new RetailerCollection($retailers),
            'success',
            __('crud.retailers.all'),
        );
    }

    public function show(Retailer $retailer)
    : JsonResponse
    {
        $this->authorize('view', $retailer);
        $retailer = $this->retailerService->findRetailer($retailer, [
            ...request()->all()
        ]);

        return $this->successResponse(
            new RetailerResource($retailer),
            'success',
            __('crud.retailers.one'),
        );
    }
}
