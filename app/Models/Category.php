<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Models\HasPreviousNext;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasPreviousNext;

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function products()
    : HasMany
    {
        return $this->hasMany(Product::class);
    }
}
