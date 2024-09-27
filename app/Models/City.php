<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class City extends Model
{
    protected $fillable = [
        'name',
        'region_id',
        'longitude',
        'latitude',
    ];

    public function region()
    : BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function customers()
    : HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function retailers()
    : hasManyThrough
    {
        return $this->hasManyThrough(Retailer::class, Customer::class);
    }

    public function getCitiesWithRegion()
    : Collection
    {
        return $this->query()
            ->with('region')
            ->get();
    }
}
