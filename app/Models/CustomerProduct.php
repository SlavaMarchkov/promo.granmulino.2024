<?php

declare(strict_types=1);

// 05.01.2025 at 19:22:48
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProduct extends Pivot
{
    protected $table = 'customer_product';

    public $incrementing = true;

    protected $fillable = [
        'customer_id',
        'product_id',
        'category_id',
        'customer_price',
        'is_listed',
    ];

    public function customer()
    : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected function casts()
    : array
    {
        return [
            'is_listed' => 'boolean',
        ];
    }
}
