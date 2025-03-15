<?php

declare(strict_types=1);

// 12.03.2025 at 20:58:29
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerSales extends Model
{

    protected $table = 'customer_sales';

    protected $fillable = [
        'sales_plan',
        'sales_actual',
        'sales_date',
        'comments',
        'user_id',
        'customer_id',
        'category_id',
    ];

    public function user()
    : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer()
    : BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function category()
    : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    protected function casts()
    : array
    {
        return [
            'sales_date' => 'date',
        ];
    }
}
