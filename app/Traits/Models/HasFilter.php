<?php

namespace App\Traits\Models;

use App\Contracts\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    public function scopeFilter(Builder $builder, FilterInterface $filter)
    : Builder {
        $filter->applyFilter($builder);
        return $builder;
    }
}
