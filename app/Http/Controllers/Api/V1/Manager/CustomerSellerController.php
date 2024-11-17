<?php

declare(strict_types=1);

// 15.11.2024 at 16:41:25
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CustomerSeller\StoreUpdateRequest;
use App\Http\Resources\V1\CustomerSeller\CustomerSellerCollection;
use App\Http\Resources\V1\CustomerSeller\CustomerSellerResource;
use App\Models\CustomerSeller;
use App\Services\CustomerSellers\CustomerSellerService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CustomerSellerController extends ApiController
{
    public function __construct(
        private readonly CustomerSellerService $customerSellerService,
    ) {
    }

    public function index()
    : JsonResponse
    {
        $sellers = $this->customerSellerService->getCustomerSellers([
            ...request()->all(),
        ]);

        return $this->successResponse(
            new CustomerSellerCollection($sellers),
            'success',
            __('crud.sales_reps.all'),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse {
        $data = $request->validated();
        $customerSeller = $this->customerSellerService->storeCustomerSeller($data);

        return $this->successResponse(
            new CustomerSellerResource($customerSeller),
            'success',
            __('crud.sales_reps.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(CustomerSeller $customerSeller)
    : JsonResponse {
        $customerSeller = $this->customerSellerService->findCustomerSeller($customerSeller);
        return $this->successResponse(
            new CustomerSellerResource($customerSeller),
            'success',
            __('crud.sales_reps.one'),
        );
    }

    public function update(StoreUpdateRequest $request, CustomerSeller $customerSeller)
    : JsonResponse {
        $data = $request->validated();
        $customerSeller = $this->customerSellerService->updateCustomerSeller($customerSeller, $data);

        return $this->successResponse(
            new CustomerSellerResource($customerSeller),
            'success',
            __('crud.sales_reps.updated'),
        );
    }

    public function destroy(CustomerSeller $customerSeller)
    {
        $customerSeller->delete();

        return response()->json();
    }
}
