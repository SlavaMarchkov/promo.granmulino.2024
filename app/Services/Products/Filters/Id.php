<?php

declare(strict_types=1);

namespace App\Services\Products\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class Id
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('id')) {
            $builder->where('id', request('id'));
        }

        return $next($builder);
    }
}
