<?php

declare(strict_types=1);

namespace App\Enums\Promo;

enum MarkEnum: string
{
    // TODO: оценка по итогам промо-акции
    /*case SUPER_ADMIN = 'Супер-Администратор';
    case PRICE_ADMIN = 'Прайс-Администратор';
    case ADMIN       = 'Администратор';
    case MANAGER     = 'Менеджер';*/

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
