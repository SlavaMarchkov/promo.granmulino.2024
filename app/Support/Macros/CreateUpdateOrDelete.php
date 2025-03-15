<?php

declare(strict_types=1);

// 13.03.2025 at 13:27:18
namespace App\Support\Macros;


use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

final class CreateUpdateOrDelete
{

    protected HasMany $query;
    private int       $customer_id;
    private string    $date;
    private iterable  $sales;

    public function __construct(HasMany $query, iterable $array)
    {
        $this->query = $query;
        $this->customer_id = (int)$array['customer_id'];
        $this->date = $array['sales_date'];
        $this->sales = collect($array['sales_plans']);
    }

    /**
     * @throws Throwable
     */
    public function __invoke()
    : void
    {
        try {
            DB::transaction(function () {
                $this->deleteMissingRecords();
                $this->updateOrCreateRecords();
            });
        } catch (Throwable $exception) {
            Log::error('Error creating or updating SalesPlan: {error}', [
                'error' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    private function deleteMissingRecords()
    : void
    {
        $recordKeyName = 'category_id';
        $existingRecordIds = $this->sales->pluck($recordKeyName);

        (clone $this->query)
            ->where('sales_date', $this->date)
            ->whereNotIn($recordKeyName, $existingRecordIds)
            ->delete();
    }

    private function updateOrCreateRecords()
    : void
    {
        $this->sales->each(function ($record) {
            (clone $this->query)->updateOrCreate([
                'sales_date'  => $this->date,
                'customer_id' => $this->customer_id,
                'category_id' => $record['category_id'],
            ], $record);
        });
    }
}
