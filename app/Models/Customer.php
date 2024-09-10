<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends BaseModel
{
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
}
