<?php

declare(strict_types=1);

// 22.11.2024 at 14:47:08
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Customer\SupervisorStoreRequest;
use App\Http\Resources\V1\Customer\CustomerSupervisorCollection;
use App\Http\Resources\V1\Customer\CustomerSupervisorResource;
use App\Models\Customer;
use App\Models\CustomerSupervisor;
use App\Services\Customers\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

final class CustomerSupervisorController extends ApiController
{
    use AuthorizesRequests;

    public function __construct(
        private readonly CustomerService $customerService,
    ) {
    }

    public function index(Customer $customer)
    : JsonResponse {
        $this->authorize('viewAny', [CustomerSupervisor::class, $customer]);

        $supervisors = $this->customerService->getCustomerSupervisors(
            $customer->id,
            [...request()->all()],
        );

        return $this->successResponse(
            new CustomerSupervisorCollection($supervisors),
            'success',
            __('crud.supervisors.all'),
        );
    }

    public function store(SupervisorStoreRequest $request, Customer $customer)
    : JsonResponse {
        $this->authorize('create', [CustomerSupervisor::class, $request->customer_id, $customer->id]);

        $data = $request->validated();
        $supervisor = $this->customerService->storeSupervisor($data);
        Log::info('Customer Supervisor created');

        return $this->successResponse(
            new CustomerSupervisorResource($supervisor),
            'success',
            __('crud.supervisors.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(CustomerSupervisor $customerSupervisor)
    {
    }

    public function update(Request $request, CustomerSupervisor $customerSupervisor)
    {
    }

    public function destroy(CustomerSupervisor $customerSupervisor)
    {
    }
}
