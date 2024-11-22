<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Models\HasPreviousNext;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Customer extends Model
{
    use HasPreviousNext;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'region_id',
        'city_id',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'data'      => 'array',
    ];

    public function region()
    : BelongsTo
    {
        return $this->belongsTo(Region::class)->withDefault();
    }

    public function city()
    : BelongsTo
    {
        return $this->belongsTo(City::class)->withDefault();
    }

    public function user()
    : BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function retailers()
    : HasMany
    {
        return $this->hasMany(Retailer::class);
    }

    public function customer_supervisors()
    : HasMany
    {
        return $this->hasMany(CustomerSupervisor::class);
    }

    public function customer_sellers()
    : HasManyThrough
    {
        return $this->hasManyThrough(CustomerSeller::class, CustomerSupervisor::class);
    }
}
