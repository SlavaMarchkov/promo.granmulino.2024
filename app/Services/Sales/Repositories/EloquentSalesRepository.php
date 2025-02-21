<?php

declare(strict_types=1);

// 21.02.2025 at 12:57:36
namespace App\Services\Sales\Repositories;


use App\Models\Sales;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

final class EloquentSalesRepository implements SalesRepositoryInterface
{

    /**
     * @throws Throwable
     */
    public function createSalesPlanFromArray(array $data)
    : Collection {
        try {
            DB::transaction(function () use ($data) {
                foreach ($data['sales_plans'] as $item) {
                    Sales::create($item);
                }
            });

            return Sales::query()
                ->where('customer_id', $data['customer_id'])
                ->where('sales_date', $data['sales_date'])
                ->get();
        } catch (Throwable $exception) {
            Log::error('Error creating or updating SalesPlan: {error}', [
                'error' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }
}
