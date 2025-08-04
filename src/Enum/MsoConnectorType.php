<?php

namespace Imoing\Pptx\Enum;

use Imoing\Pptx\Enum\Base\IBaseXmlEnum;
use Imoing\Pptx\Enum\Base\TraitXmlEnum;

enum MsoConnectorType: int implements IBaseXmlEnum
{
    use TraitXmlEnum;

    case CURVE = 3;
    case ELBOW = 2;
    case STRAIGHT = 1;
    case MIXED = -2;

    public static function getXmlValues(): array
    {
        return [
            self::CURVE->value => ["curvedConnector3", "Curved connector."],
            self::ELBOW->value => ["bentConnector3", "Elbow connector."],
            self::STRAIGHT->value => ["line", "Straight line connector."],
            self::MIXED->value => ["", "Return value only; indicates a combination of other states."],
        ];
    }
}