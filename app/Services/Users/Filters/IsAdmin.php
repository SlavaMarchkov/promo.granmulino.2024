<?php

declare(strict_types=1);

namespace App\Services\Users\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class IsAdmin
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('is_admin') && to_boolean(request('is_admin'))) {
            $builder->where('is_admin', true);
        }

        return $next($builder);
    }
}
