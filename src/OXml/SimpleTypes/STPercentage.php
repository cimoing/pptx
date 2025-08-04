<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STPercentage extends BaseIntType
{
    public static function convertFromXml(string $xmlValue): float
    {
        if (str_contains($xmlValue, '%')) {
            return self::_convertFromPercentLiteral($xmlValue);
        }
        return (int)$xmlValue / 100000.0;
    }

    public static function convertToXml($value): string
    {
        return (string)round($value * 100000.0);
    }

    public static function validate($value): void
    {
        static::validateFloatInRange($value, -21474.83648, 21474.83647);
    }

    protected static function _convertFromPercentLiteral(string $strValue): float
    {
        $floatPart = (float)substr($strValue, 0, -1); // 去掉 '%' 字符
        return $floatPart / 100.0;
    }
}