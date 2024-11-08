<?php

declare(strict_types=1);

// 08.11.2024 at 20:52:17
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'slug',
        'name',
    ];
}
