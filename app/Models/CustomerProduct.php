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

    private const OFFICE_EXPENSES    = 0.075;
    private const MARKETING_EXPENSES = 0.05;

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

    public function grossProfit()
    : Attribute
    {
        return new Attribute(
            get: function () {
                $product_price = Product::query()->where('id', $this->product_id)->value('price');
                return round(($this->customer_price - $product_price), 2);
            },
        );
    }

    public function officeExpenses()
    : Attribute
    {
        return new Attribute(
            get: fn() => round(($this->customer_price * self::OFFICE_EXPENSES), 2),
        );
    }

    public function marketingExpenses()
    : Attribute
    {
        return new Attribute(
            get: fn() => round(($this->customer_price * self::MARKETING_EXPENSES), 2),
        );
    }
}
