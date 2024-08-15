<?php

declare(strict_types=1);

namespace App\Enums\Retailer;

enum TypeEnum: string
{
    case LOCAL = 'local';
    case REGIONAL = 'regional';
    case FEDERAL = 'federal';

    public function toText()
    : string
    {
        return match ($this->value) {
            self::LOCAL->value => 'Локальная',
            self::REGIONAL->value => 'Региональная',
            self::FEDERAL->value => 'Федеральная',
        };
    }

    /**
     * @return string
     */
    public function getValue()
    : string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName()
    : string
    {
        return $this->name;
    }
}
