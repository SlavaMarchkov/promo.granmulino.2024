<?php

declare(strict_types=1);

// 21.02.2025 at 21:41:38
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    protected $fillable = [
        'path',
        'imageable_id',
        'imageable_type',
    ];

    public function imageable()
    : MorphTo
    {
        return $this->morphTo();
    }
}
