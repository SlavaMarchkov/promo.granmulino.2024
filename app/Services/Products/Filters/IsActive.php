<?php

declare(strict_types=1);

namespace App\Services\Products\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class IsActive
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('is_active') && to_boolean(request('is_active'))) {
            $builder->where('is_active', true);
        }

        return $next($builder);
    }
}
