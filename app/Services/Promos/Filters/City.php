<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class City
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('city') && to_boolean(request('city'))) {
            $builder->with('city');
        }

        return $next($builder);
    }
}
