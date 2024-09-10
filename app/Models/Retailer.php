<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Retailer\TypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Retailer extends BaseModel
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
        'type'      => TypeEnum::class,
        'data'      => 'array',
    ];

    public function customer()
    : BelongsTo
    {
        return $this->belongsTo(Customer::class)->withDefault();
    }

    public function city()
    : BelongsTo
    {
        return $this->belongsTo(City::class)->withDefault();
    }

    public function getRetailersWithCityAndCustomer()
    : Collection
    {
        return $this->query()
            ->with('city')
            ->with('customer')
            ->get();
    }
}
