<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Models\HasPreviousNext;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasPreviousNext;

    protected $fillable = [
        'name',
        'weight',
        'price',
        'image',
        'is_active',
        'category_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category()
    : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
