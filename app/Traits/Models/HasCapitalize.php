<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasCapitalize
{
    protected static function bootHasCapitalize()
    : void
    {
        static::creating(function (Model $item) {
            $string = $item->{self::capitalizeOf()};
            $item->{self::capitalizeOf()} = mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr(
                    $string,
                    1,
                    mb_strlen($string)
                );
        });
    }

    public static function capitalizeOf()
    : string
    {
        return 'last_name';
    }
}
