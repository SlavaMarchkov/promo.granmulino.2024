<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
