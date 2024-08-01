<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'description',
        'region_id',
        'city_id',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function region()
    : BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function city()
    : BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function user()
    : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
