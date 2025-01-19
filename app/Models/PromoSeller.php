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
        'supervisor_id',
        'is_supervisor',
        'sales_before',
        'sales_plan',
        'sales_after',
        'surplus_plan',
        'surplus_actual',
        'compensation',
        'budget_plan',
        'budget_actual',
    ];

    protected $casts = [
        'is_supervisor' => 'boolean',
    ];

    public function promo()
    : BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }
}
