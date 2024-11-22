<?php

declare(strict_types=1);

// 15.11.2024 at 16:41:25
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\SellerStoreRequest;
use App\Http\Resources\V1\Customer\CustomerSellerResource;
use App\Models\CustomerSeller;
use App\Services\Customers\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

final class CustomerSellerController extends ApiController
{
    public function __construct(
        private readonly CustomerService $customerService,
    ) {
    }

    /*public function index()
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
    }*/

    public function store(SellerStoreRequest $request)
    : JsonResponse {
        $data = $request->validated();
        $seller = $this->customerService->storeSeller($data);
        Log::info('Customer Seller created');

        return $this->successResponse(
            new CustomerSellerResource($seller),
            'success',
            __('crud.sellers.created'),
            Response::HTTP_CREATED,
        );
    }

    /*public function show(CustomerSeller $customerSeller)
    : JsonResponse {
        $customerSeller = $this->customerSellerService->findCustomerSeller($customerSeller);
        return $this->successResponse(
            new CustomerSellerResource($customerSeller),
            'success',
            __('crud.sales_reps.one'),
        );
    }*/

    /*public function update(StoreUpdateRequest $request, CustomerSeller $customerSeller)
    : JsonResponse {
        $data = $request->validated();
        $customerSeller = $this->customerSellerService->updateCustomerSeller($customerSeller, $data);

        return $this->successResponse(
            new CustomerSellerResource($customerSeller),
            'success',
            __('crud.sales_reps.updated'),
        );
    }*/

    public function destroy(CustomerSeller $customerSeller)
    {
        $customerSeller->delete();

        return response()->json();
    }
}
