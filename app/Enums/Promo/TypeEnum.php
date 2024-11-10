<?php

declare(strict_types=1);

namespace App\Enums\Promo;

use App\Attributes\BackgroundColor;
use App\Attributes\Description;
use App\Attributes\Label;
use App\Attributes\PromoTypeCode;
use App\Traits\Enums\HasAttributableEnum;

enum TypeEnum: string
{
    use HasAttributableEnum;

    #[Label('Скидка в цене')]
    #[Description('Желтый или красный ценник')]
    #[BackgroundColor('warning')]
    #[PromoTypeCode('ЖЦ')]
    case DISCOUNT = 'DISCOUNT';

    #[Label('Мотивация торгового персонала')]
    #[Description('Мотивация торговых менеджеров, супервайзеров и торговых представителей дистрибьютора')]
    #[BackgroundColor('primary')]
    #[PromoTypeCode('МТП')]
    case SALES_PEOPLE_BOOST = 'SALES_PEOPLE_BOOST';

    #[Label('Мотивация розничных точек')]
    #[Description('Мотивация розничных точек')]
    #[BackgroundColor('danger')]
    #[PromoTypeCode('МРТ')]
    case RETAILERS_BOOST = 'RETAILERS_BOOST';

    #[Label('Подарок за покупку')]
    #[Description('При покупке определенного количества или наименования выдается подарок')]
    #[BackgroundColor('success')]
    #[PromoTypeCode('ПП')]
    case GIFT_FOR_PURCHASE = 'GIFT_FOR_PURCHASE';

    #[Label('Увеличение покрытия')]
    #[Description('Увеличение покрытия территории')]
    #[BackgroundColor('secondary')]
    #[PromoTypeCode('УП')]
    case COVERAGE_INCREASE = 'COVERAGE_INCREASE';

    #[Label('In-Out')]
    #[Description('Временная залистовка ассортимента в матрицу торговой сети')]
    #[BackgroundColor('info')]
    #[PromoTypeCode('IN-OUT')]
    case IN_OUT = 'IN_OUT';

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
