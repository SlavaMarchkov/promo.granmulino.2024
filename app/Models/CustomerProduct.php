<?php

declare(strict_types=1);

// 05.01.2025 at 19:22:48
namespace App\Models;

use App\Traits\Models\HasFilter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProduct extends Pivot
{
    use HasFilter;

    private const VAT_RATE = 1.10;

    protected $table        = 'customer_product';
    public    $incrementing = true;

    protected $fillable = [
        'customer_id',
        'product_id',
        'category_id',
        'customer_price',
        'is_listed',
    ];

    protected function casts()
    : array
    {
        return [
            'is_listed' => 'boolean',
        ];
    }

    public function customer()
    : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function category()
    : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productInitialPrice()
    : Attribute
    {
        return new Attribute(
            get: function () {
                return Product::query()->where('id', $this->product_id)->value('price');
            },
        );
    }

    public function customerPriceNoVAT()
    : Attribute
    {
        return new Attribute(
            get: function () {
                return $this->customer_price / self::VAT_RATE;
            },
        );
    }
}
