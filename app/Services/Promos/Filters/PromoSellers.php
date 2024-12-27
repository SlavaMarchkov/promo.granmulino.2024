<?php

declare(strict_types=1);

namespace App\Services\Promos\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class PromoSellers
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has('promo_sellers') && to_boolean(request('promo_sellers'))) {
            $builder->with('promo_sellers')->withCount('promo_sellers');
        }

        return $next($builder);
    }
}
