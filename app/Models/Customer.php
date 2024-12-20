<?php

declare(strict_types=1);

namespace App\Models;

use App\Events\Customer\CreatedEvent;
use App\Traits\Models\HasFilter;
use App\Traits\Models\HasPreviousNext;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasPreviousNext;
    use HasFilter;

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

    protected static function booted()
    : void
    {
        self::created(function (Customer $customer) {
            event(new CreatedEvent($customer));
        });
    }

    public function profile()
    : HasOne
    {
        return $this->hasOne(CustomerProfile::class, 'customer_id', 'id');
    }

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

    public function customer_sellers()
    : HasMany
    {
        return $this->hasMany(CustomerSeller::class);
    }
}
