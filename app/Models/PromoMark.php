<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PromoMark extends Model
{
    protected $table = 'promo_marks';

    protected $fillable = [
        'promo_id',
        'goals',
        'sales',
        'staff',
        'comments',
    ];

    public function promo()
    : HasOne
    {
        return $this->hasOne(Promo::class, 'id', 'promo_id');
    }
}
