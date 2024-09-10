<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends BaseModel
{
    protected $fillable = [
        'code',
        'name',
    ];

    public function cities()
    : HasMany
    {
        return $this->hasMany(City::class);
    }

    public function getRegionsWithCities()
    : Collection
    {
        return $this->query()
            ->with('cities')
            ->withCount('cities')
            ->get();
    }
}
