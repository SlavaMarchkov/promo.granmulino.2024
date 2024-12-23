<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class PromoId
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('promo_id')) {
            $builder->where('promo_id', request('promo_id'));
        }

        return $next($builder);
    }
}
