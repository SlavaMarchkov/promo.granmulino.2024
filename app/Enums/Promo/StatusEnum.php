<?php

declare(strict_types=1);

namespace App\Enums\Promo;

use App\Attributes\BackgroundColor;
use App\Traits\Enums\HasAttributableEnum;

enum StatusEnum: string
{
    use HasAttributableEnum;

    #[BackgroundColor('warning')]
    case ON_APPROVAL = 'На согласовании';

    #[BackgroundColor('success')]
    case IN_PROCESS = 'В работе';

    #[BackgroundColor('danger')]
    case WAITING_FOR_REPORT = 'В ожидании отчета';

    #[BackgroundColor('primary')]
    case DONE = 'Завершенные';

    #[BackgroundColor('secondary')]
    case DECLINED = 'Отклоненные';

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
