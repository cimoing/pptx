<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STTextSpacingPercentOrPercentString extends BaseFloatType
{
    public static function convertFromXml(string $xmlValue): float
    {
        if (str_ends_with($xmlValue, '%')) {
            return self::convertFromPercentLiteral($xmlValue);
        }

        return intval($xmlValue) / 100000.0;
    }

    private static function convertFromPercentLiteral($xmlValue): float
    {
        $percentValue = floatval(substr($xmlValue, 0, -1));
        return $percentValue / 100.0;
    }

    public static function convertToXml($value): string
    {
        return strval(intval(round($value * 100000.0)));
    }

    public static function validate($value): void
    {
        self::validateFloatInRange($value, 0.0, 132.0);
    }
}