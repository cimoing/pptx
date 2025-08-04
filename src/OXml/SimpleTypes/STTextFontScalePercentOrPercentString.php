<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STTextFontScalePercentOrPercentString extends BaseFloatType
{
    public static function convertFromXml(string $xmlValue): float
    {
        if (str_ends_with($xmlValue, '%')) {
            return floatval(substr($xmlValue, 0, -1));
        }

        return intval($xmlValue) / 1000.0;
    }

    public static function convertToXml($value): string
    {
        return strval(intval($value * 1000.0));
    }

    public static function validate($value): void
    {
        parent::validate($value);
        if ($value < 1.0 || $value > 100.0) {
            throw new \ValueError("Value must be in range 1.0 to 100.0 (percent), got $value");
        }
    }
}