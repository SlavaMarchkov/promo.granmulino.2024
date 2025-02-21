<?php

declare(strict_types=1);

// 21.02.2025 at 12:11:14
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Sales\StoreRequest;
use App\Http\Resources\V1\Sales\SalesCollection;
use App\Http\Resources\V1\Sales\SalesResource;
use App\Models\Sales;
use App\Services\Sales\SalesService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SalesController extends ApiController
{

    public function __construct(
        private readonly SalesService $salesService,
    ) {
    }

    public function index()
    {
        return SalesResource::collection(Sales::all());
    }

    public function store(StoreRequest $request)
    : JsonResponse {
        $data = $request->validated();

        $sales_plans = $this->salesService->createSalesPlan($data);

        return $this->successResponse(
            new SalesCollection($sales_plans),
            'success',
            __('crud.sales_plan.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(Sales $sales)
    {
        return new SalesResource($sales);
    }

    public function update(StoreRequest $request, Sales $sales)
    {
        $sales->update($request->validated());

        return new SalesResource($sales);
    }

    public function destroy(Sales $sales)
    {
        $sales->delete();

        return response()->json();
    }
}
