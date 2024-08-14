<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'name',
        'region_id',
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
    : HasMany
    {
        return $this->hasMany(Retailer::class);
    }
}
