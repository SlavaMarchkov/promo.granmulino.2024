<?php

declare(strict_types=1);

// 07.11.2024 at 17:13:27
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\RegionCollection;
use App\Services\Regions\RegionService;
use Illuminate\Http\JsonResponse;

final class RegionController extends ApiController
{
    public function __construct(
        private readonly RegionService $regionService,
    )
    {
    }

    public function index()
    : JsonResponse
    {
        $regions = $this->regionService->getRegions([
            'cities'    => true,
            'customers' => true,
        ]);

        return $this->successResponse(
            new RegionCollection($regions),
            'success',
            __('crud.regions.all'),
        );
    }
}
