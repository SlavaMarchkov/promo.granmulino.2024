<?php

declare(strict_types=1);

// 27.02.2025 at 14:28:43
namespace App\Services\Regions\Filters;


use App\Contracts\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

final class RegionFilter extends AbstractFilter
{

    private const CITIES    = 'cities';
    private const CUSTOMERS = 'customers';
    private const RETAILERS = 'retailers';

    public function getCallbacks()
    : array
    {
        return [
            self::CITIES    => 'cities',
            self::CUSTOMERS => 'customers',
            self::RETAILERS => 'retailers',
        ];
    }

    public function cities(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('cities')->withCount('cities');
        }
    }

    public function customers(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('customers')->withCount('customers');
        }
    }

    public function retailers(Builder $builder, string $value)
    : void {
        if (to_boolean($value)) {
            $builder->with('retailers')->withCount('retailers');
        }
    }
}
