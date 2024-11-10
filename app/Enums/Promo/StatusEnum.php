<?php

declare(strict_types=1);

namespace App\Enums\Promo;

use App\Attributes\BackgroundColor;
use App\Traits\Enums\HasAttributableEnum;

enum StatusEnum: string
{
    use HasAttributableEnum;

    #[BackgroundColor('warning')]
    case ON_APPROVAL = 'ON_APPROVAL';

    #[BackgroundColor('success')]
    case IN_PROCESS = 'IN_PROCESS';

    #[BackgroundColor('danger')]
    case WAITING_FOR_REPORT = 'WAITING_FOR_REPORT';

    #[BackgroundColor('primary')]
    case DONE = 'DONE';

    #[BackgroundColor('secondary')]
    case DECLINED = 'DECLINED';

    public function label()
    : string
    {
        return match ($this) {
            self::ON_APPROVAL => 'На согласовании',
            self::IN_PROCESS => 'В работе',
            self::WAITING_FOR_REPORT => 'В ожидании отчета',
            self::DONE => 'Завершенные',
            self::DECLINED => 'Отклоненные',
        };
    }

    public static function keyLabels()
    : array
    {
        return array_reduce(self::cases(), function ($carry, StatusEnum $item) {
            $carry[$item->value] = $item->label();
            return $carry;
        }, []);
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
