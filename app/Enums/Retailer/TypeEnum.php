<?php

declare(strict_types=1);

namespace App\Enums\Retailer;

use App\Attributes\BackgroundColor;
use App\Attributes\Description;
use App\Attributes\Label;
use App\Traits\Enums\HasAttributableEnum;

enum TypeEnum: string
{
    use HasAttributableEnum;

    #[Label('Локальная')]
    #[Description('Локальная сеть работает на местном рынке')]
    #[BackgroundColor('secondary')]
    case LOCAL = 'local';

    #[Label('Региональная')]
    #[Description('Региональная сеть работает на рынке региона')]
    #[BackgroundColor('primary')]
    case REGIONAL = 'regional';

    #[Label('Федеральная')]
    #[Description('Федеральная сеть работает на рынке всей страны')]
    #[BackgroundColor('success')]
    case FEDERAL = 'federal';

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
