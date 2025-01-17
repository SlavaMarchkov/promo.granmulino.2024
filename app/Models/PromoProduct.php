<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoProduct extends Model
{
    protected $table = 'promo_products';

    protected $fillable = [
        'discount',
        'net_profit',
        'promo_price',
        'promo_id',
        'category_id',
        'product_id',
        'sales_before',
        'sales_plan',
        'sales_on_time',
        'sales_after',
        'compensation',
        'budget_plan',
        'budget_actual',
        'profit_per_unit',
        'profit_per_product',
        'surplus_plan',
        'surplus_actual',
        'revenue_plan',
        'revenue_actual',
    ];

    public function promo()
    : BelongsTo
    {
        return $this->belongsTo(Promo::class);
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
}
