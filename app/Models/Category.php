<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    : HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getCategoriesWithActiveProducts()
    : Collection
    {
        return $this->query()
            ->withCount([
                'products' => function (Builder $query) {
                    $query->where('is_active', true);
                },
            ])
            ->with('products')
            ->get();
    }
}
