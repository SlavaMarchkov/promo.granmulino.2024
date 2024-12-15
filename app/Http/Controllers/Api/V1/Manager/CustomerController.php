<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Customer\CustomerCollection;
use App\Http\Resources\V1\Customer\CustomerFullResource;
use App\Models\Customer;
use App\Services\Customers\CustomerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

final class CustomerController extends ApiController
{
    use AuthorizesRequests;

    private const CACHE_KEY = 'customers-list-manager';

    public function __construct(
        private readonly CustomerService $customerService,
    )
    {}

    public function index()
    : JsonResponse
    {
        Cache::forget(self::CACHE_KEY); // TODO: delete

        $customers = Cache::remember(self::CACHE_KEY, now()->addHour(), function () {
            return $this->customerService->getCustomers([
                'user_id' => auth()->id(),
                ...request()->all(),
            ]);
        });

        return $this->successResponse(
            new CustomerCollection($customers),
            'success',
            __('crud.customers.all'),
        );
    }

    public function show(Customer $customer)
    : JsonResponse
    {
        $this->authorize('view', $customer);

        $customer = $this->customerService->findCustomer($customer, [
            'user_id' => auth()->id(),
            ...request()->all()
        ]);

        return $this->successResponse(
            new CustomerFullResource($customer),
            'success',
            __('crud.customers.one'),
        );
    }
}
