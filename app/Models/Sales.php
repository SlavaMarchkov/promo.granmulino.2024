<?php

declare(strict_types=1);

// 21.02.2025 at 12:11:13
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sales extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'sales_plan',
        'sales_actual',
        'sales_date',
        'user_id',
        'customer_id',
        'category_id',
    ];

    public function user()
    : BelongsTo
    {
        return $this->belongsTo(User::class);
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

    protected function casts()
    : array
    {
        return [
            'sales_date' => 'date',
        ];
    }
}
