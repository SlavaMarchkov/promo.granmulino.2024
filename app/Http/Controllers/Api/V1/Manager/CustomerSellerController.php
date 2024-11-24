<?php

declare(strict_types=1);

// 15.11.2024 at 16:41:25
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\SellerStoreRequest;
use App\Http\Requests\Customer\SellerUpdateRequest;
use App\Http\Resources\V1\Customer\CustomerSellerCollection;
use App\Http\Resources\V1\Customer\CustomerSellerResource;
use App\Models\Customer;
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

    public function index(Customer $customer)
    : JsonResponse {
        $sellers = $this->customerService->getCustomerSellers($customer->id);

        return $this->successResponse(
            new CustomerSellerCollection($sellers),
            'success',
            __('crud.sellers.all'),
        );
    }

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

    public function update(SellerUpdateRequest $request)
    : JsonResponse {
        $customerSeller = $this->customerService->findCustomerSeller($request->id);
        $data = $request->validated();
        $customerSeller = $this->customerService->updateCustomerSeller($customerSeller, $data);
        Log::info('Customer Seller ID={id} updated', ['id' => $request->id]);

        return $this->successResponse(
            new CustomerSellerResource($customerSeller),
            'success',
            __('crud.sellers.updated'),
        );
    }

    public function destroy(CustomerSeller $customerSeller)
    {
        $customerSeller->delete();

        return response()->json();
    }
}
