<?php

declare(strict_types=1);

// 22.11.2024 at 22:11:58
namespace App\Services\Customers\Handlers;


use App\Models\CustomerSupervisor;
use App\Services\Customers\Repositories\CustomerRepositoryInterface;

final readonly class CreateCustomerSupervisorHandler
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
    )
    {
    }

    public function handle(array $data)
    : CustomerSupervisor
    {
        return $this->customerRepository->createSupervisorFromArray($data);
    }
}
