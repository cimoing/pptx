<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STGapAmount extends BaseIntType
{
    public static function convertFromXml($xmlValue): int
    {
        if (str_contains($xmlValue, '%')) {
            return static::convertFromPercentLiteral($xmlValue);
        }

        return parent::convertFromXml($xmlValue);
    }

    public static function validate($value): void
    {
        static::validateIntInRange($value, 0, 500);
    }
}