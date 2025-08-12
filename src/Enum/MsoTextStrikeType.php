<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseXmlEnum;
use Imoing\Pptx\Enum\Base\TraitXmlEnum;

enum MsoTextStrikeType: int implements IBaseXmlEnum
{
    use TraitXmlEnum;

    case DOUBLE = 2;
    case NO = 0;
    case SINGLE = 1;
    case MIXED = -2;

    public static function getXmlValues(): array
    {
        return [
            self::DOUBLE->value => ['dblStrike', 'Specifies a double strike.'],
            self::NO->value => ['noStrike', 'Specifies no strike.'],
            self::SINGLE->value => ['sngStrike', 'Specifies a single strike.'],
            self::MIXED->value => ['', 'Specifies a mix of strike types (read-only).'],
        ];
    }
}