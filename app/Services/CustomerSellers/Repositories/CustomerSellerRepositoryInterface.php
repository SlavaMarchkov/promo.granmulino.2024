<?php

declare(strict_types=1);

// 15.11.2024 at 18:04:31
namespace App\Services\CustomerSellers\Repositories;

use App\Models\CustomerSeller;
use Illuminate\Database\Eloquent\Collection;

interface CustomerSellerRepositoryInterface
{
    public function find(CustomerSeller $customerSeller)
    : ?CustomerSeller;

    public function get(array $params = [])
    : Collection;

    public function createFromArray(array $data)
    : CustomerSeller;

    public function updateFromArray(CustomerSeller $customerSeller, array $data)
    : CustomerSeller;
}
