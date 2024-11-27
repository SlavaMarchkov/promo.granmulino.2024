<?php

declare(strict_types=1);

// 15.11.2024 at 16:41:25
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\SellerStoreUpdateRequest;
use App\Http\Resources\V1\Customer\CustomerSellerCollection;
use App\Http\Resources\V1\Customer\CustomerSellerResource;
use App\Models\Customer;
use App\Models\CustomerSeller;
use App\Services\Customers\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CustomerSellerController extends ApiController
{
    use AuthorizesRequests;

    public function __construct(
        private readonly CustomerService $customerService,
    ) {
    }

    public function index(Customer $customer)
    : JsonResponse {
        $this->authorize('viewAny', [CustomerSeller::class, $customer]);

        $sellers = $this->customerService->getCustomerSellers($customer->id);

        return $this->successResponse(
            new CustomerSellerCollection($sellers),
            'success',
            __('crud.sellers.all'),
        );
    }

    public function store(SellerStoreUpdateRequest $request, Customer $customer)
    : JsonResponse {
        $this->authorize('create', [CustomerSeller::class, $request->customer_id, $customer->id]);

        $data = $request->validated();
        $seller = $this->customerService->storeSeller($data);

        return $this->successResponse(
            new CustomerSellerResource($seller),
            'success',
            $data['is_supervisor'] ? __('crud.supervisors.created') : __('crud.sellers.created'),
            Response::HTTP_CREATED,
        );
    }

    public function update(int $customer_id, CustomerSeller $seller, SellerStoreUpdateRequest $request)
    : JsonResponse {
        $data = $request->validated();
        $seller = $this->customerService->updateCustomerSeller($seller, $data);

        return $this->successResponse(
            new CustomerSellerResource($seller),
            'success',
            $seller->is_supervisor ? __('crud.supervisors.updated') : __('crud.sellers.updated'),
        );
    }

    public function destroy(int $customer_id, CustomerSeller $seller)
    : JsonResponse
    {
        $result = $this->customerService->deleteSeller($seller);

        return ($result == 0)
            ? $this->successResponse(
                new CustomerSellerResource($seller),
                'success',
                $seller->is_supervisor ? __('crud.supervisors.deleted') : __('crud.sellers.deleted'),
            )
            : $this->errorResponse(
                Response::HTTP_OK,
                'error',
                $seller->is_supervisor ? __('crud.supervisors.not_deleted') : __('crud.sellers.not_deleted'),
            );
    }
}
