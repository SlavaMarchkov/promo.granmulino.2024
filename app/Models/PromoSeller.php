<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoSeller extends Model
{
    protected $table = 'promo_sellers';

    protected $fillable = [
        'promo_id',
        'customer_id',
        'seller_id',
        'sales_before',
        'sales_plan',
        'surplus_plan',
        'sales_after',
        'compensation',
        'budget_plan',
        'budget_actual',
    ];

    public function promo()
    : BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }
}
