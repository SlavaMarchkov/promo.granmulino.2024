<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Models\HasPreviousNext;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasPreviousNext;

    protected $fillable = [
        'code',
        'name',
    ];

    public function cities()
    : HasMany
    {
        return $this->hasMany(City::class);
    }

    public function customers()
    : HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
