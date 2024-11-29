<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Models;

use App\Enums\Promo\StatusEnum;
use App\Enums\Promo\TypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promo extends Model
{
    protected $fillable = [
        'status',
        'promo_type',
        'discount',
        'user_id',
        'region_id',
        'city_id',
        'channel_id',
        'customer_id',
        'retailer_id',
        'start_date',
        'end_date',
        'comments',
        'total_sales_before',
        'total_sales_plan',
        'total_sales_on_time',
        'total_sales_after',
        'total_budget_plan',
        'total_budget_actual',
    ];

    protected $casts = [
        'status'     => StatusEnum::class,
        'promo_type' => TypeEnum::class,
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function promo_products()
    : HasMany
    {
        return $this->hasMany(PromoProduct::class);
    }

    public function promo_sellers()
    : HasMany
    {
        return $this->hasMany(PromoSeller::class);
    }
}
