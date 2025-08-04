<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STBubbleScale extends BaseIntType
{
    public static function convertFromXml($xmlValue)
    {
        if (str_contains($xmlValue, '%')) {
            return static::convertFromPercentLiteral($xmlValue);
        }

        return parent::convertFromXml($xmlValue);
    }

    public static function validate($value): void
    {
        static::validateIntInRange($value, 0, 300);
    }
}