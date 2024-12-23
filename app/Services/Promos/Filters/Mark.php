<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class Mark
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('mark') && to_boolean(request('mark'))) {
            $builder->with('mark');
        }

        return $next($builder);
    }
}
