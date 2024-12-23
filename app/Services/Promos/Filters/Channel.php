<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class Channel
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('channel') && to_boolean(request('channel'))) {
            $builder->with('channel');
        }

        return $next($builder);
    }
}
