<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class Retailer
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('retailer') && to_boolean(request('retailer'))) {
            $builder->with('retailer');
        }

        return $next($builder);
    }
}
