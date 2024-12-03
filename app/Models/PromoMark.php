<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoMark extends Model
{
    protected $table = 'promo_marks';

    protected $fillable = [
        'promo_id',
        'goals',
        'sales',
        'outlets',
        'comments',
    ];

    public function promo()
    : BelongsTo
    {
        return $this->belongsTo(Promo::class, 'promo_id', 'id');
    }
}
