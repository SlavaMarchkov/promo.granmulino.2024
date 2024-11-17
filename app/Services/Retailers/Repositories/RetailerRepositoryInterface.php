<?php

declare(strict_types=1);

// 03.10.2024 at 23:08:13
namespace App\Services\Retailers\Repositories;

use App\Models\Retailer;
use Illuminate\Database\Eloquent\Collection;

interface RetailerRepositoryInterface
{
    public function find(Retailer $retailer)
    : ?Retailer;

    public function get(array $params = [])
    : Collection;

    public function getByUserId(int $user_id)
    : Collection;

    public function createFromArray(array $data)
    : Retailer;

    public function updateFromArray(Retailer $retailer, array $data)
    : Retailer;

    public function delete(Retailer $retailer)
    : int;
}
