<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\ProductObserver;
use App\Traits\Models\HasPreviousNext;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    use HasPreviousNext;

    protected $fillable = [
        'name',
        'weight',
        'price',
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

    public function customers()
    : BelongsToMany
    {
        return $this->belongsToMany(
            Customer::class,
            'customer_product',
            'customer_id',
            'product_id',
        );
    }

    public function images()
    : MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
