<?php

declare(strict_types=1);

// 12.03.2025 at 20:58:30
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\CustomerSalesStoreRequest;
use App\Http\Requests\Customer\CustomerSalesUpdateRequest;
use App\Http\Resources\V1\Customer\CustomerSalesCollection;
use App\Http\Resources\V1\Customer\CustomerSalesResource;
use App\Models\Customer;
use App\Models\CustomerSales;
use App\Services\Customers\CustomerService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CustomerSalesController extends ApiController
{
    public function __construct(
        private readonly CustomerService $customerService,
    ) {
    }

    public function index()
    : JsonResponse
    {
        $customers = $this->customerService->getCustomers([
            'user_id' => auth()->id(),
        ]);

        $collection = $customers->map(function (Customer $customer) {
            $sales = $this->customerService->getSales([
                'user_id'     => auth()->id(),
                'customer_id' => $customer->id,
                ...request()->all(),
            ]);

            return collect([
                'customerId'   => $customer->id,
                'customerName' => $customer->name,
                'sales'        => CustomerSalesCollection::make($sales),
            ]);
        });

        return $this->successResponse(
            $collection->toJson(),
            'success',
            __(''),
        );
    }

    public function show()
    {
        // TODO: реализовать и выводить план продаж при вводе в модальном окне
    }

    public function store(CustomerSalesStoreRequest $request, Customer $customer)
    : JsonResponse {
        $data = $request->validated();
        $this->customerService->storeSalesPlan($customer, $data);

        return $this->successResponse(
            null,
            'success',
            __('crud.sales_plans.created'),
            Response::HTTP_CREATED,
        );
    }

    public function update(CustomerSalesUpdateRequest $request, CustomerSales $sales)
    : JsonResponse {
        $data = $request->validated();
        $sales = $this->customerService->updateSalesPlan($sales, $data);

        return $this->successResponse(
            new CustomerSalesResource($sales),
            'success',
            __('crud.sales_plans.updated'),
        );
    }

    public function getSalesYears()
    {
        $years = $this->customerService->getSalesYears();

        return $this->successResponse(
            json_encode($years),
        );
    }
}
