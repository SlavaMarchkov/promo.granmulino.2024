<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Retailer extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'is_active',
        'is_direct',
        'customer_id',
        'city_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_direct' => 'boolean',
    ];

    public function customer()
    : HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function city()
    : BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
