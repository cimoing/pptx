<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STLblOffset extends XsdUnsignedShort
{
    public static function convertFromXml($xmlValue): int
    {
        if (str_ends_with($xmlValue, '%')) {
            return static::convertFromPercentLiteral($xmlValue);
        }

        return intval($xmlValue);
    }

    public static function validate($value): void
    {
        static::validateIntInRange($value, 0, 1000);
    }
}