<?php

declare(strict_types=1);

// 27.02.2025 at 13:45:19
namespace App\Services\Cities\Filters;


use App\Contracts\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

final class CityFilter extends AbstractFilter
{

    private const REGION    = 'region';
    private const CUSTOMERS = 'customers';
    private const RETAILERS = 'retailers';

    public function getCallbacks()
    : array
    {
        return [
            self::REGION    => 'region',
            self::CUSTOMERS => 'customers',
            self::RETAILERS => 'retailers',
        ];
    }

    public function region(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('region');
        }
    }

    public function customers(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('customers');
        }
    }

    public function retailers(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('retailers');
        }
    }
}
