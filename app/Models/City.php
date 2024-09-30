<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Models\HasPreviousNext;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class City extends Model
{
    use HasPreviousNext;

    protected $fillable = [
        'name',
        'region_id',
        'longitude',
        'latitude',
        'country',
        'state',
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
}
