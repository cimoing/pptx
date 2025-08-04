<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STOverlap extends BaseIntType
{
    public static function convertFromXml(string $xmlValue): int
    {
        if (str_contains($xmlValue, '%')) {
            return parent::convertFromPercentLiteral($xmlValue);
        }
        return parent::convertFromXml($xmlValue);
    }

    public static function validate($value): void
    {
        self::validateIntInRange($value, -100, 100);
    }
}