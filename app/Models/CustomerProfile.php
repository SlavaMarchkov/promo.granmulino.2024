<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerProfile extends Model
{
    protected $table = 'customer_profiles';

    protected $fillable = [
        'customer_id',
        'address',
        'phone',
        'website',
        'email',
    ];

    public function customer()
    : BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
