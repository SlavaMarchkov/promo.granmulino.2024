<?php

declare(strict_types=1);

// 15.11.2024 at 16:41:25
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerSeller extends Model
{
    protected $table = 'customer_sellers';

    protected $fillable = [
        'name',
        'is_active',
        'customer_id',
    ];

    protected function casts()
    : array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function shortName()
    : Attribute
    {
        return new Attribute(
            get: function () {
                $temp = explode(' ', $this->name);
                return $temp[0] . ' ' . $temp[1];
            },
        );
    }

    public function customer()
    : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
