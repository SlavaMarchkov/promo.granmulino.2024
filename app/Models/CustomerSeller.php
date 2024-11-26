<?php

declare(strict_types=1);

// 15.11.2024 at 16:41:25
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSeller extends Model
{
    use SoftDeletes;

    protected $table = 'customer_sellers';

    protected $fillable = [
        'name',
        'customer_id',
        'supervisor_id',
        'is_active',
        'is_supervisor',
    ];

    protected function casts()
    : array
    {
        return [
            'is_active'     => 'boolean',
            'is_supervisor' => 'boolean',
        ];
    }

    public function shortName()
    : Attribute
    {
        return new Attribute(
            get: function () {
                $temp = explode(' ', $this->name);
                return count($temp) > 1 ? ($temp[0] . ' ' . $temp[1]) : $temp[0];
            },
        );
    }

    public function customer()
    : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
