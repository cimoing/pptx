<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class BaseIntType extends BaseSimpleType
{
    public static function convertFromPercentLiteral(string $xmlValue): int
    {
        $str = str_replace('%', '', $xmlValue);
        return intval($str);
    }

    public static function convertFromXml(string $xmlValue)
    {
        return intval($xmlValue);
    }

    public static function convertToXml($value): string
    {
        return strval($value);
    }

    public static function validate(mixed $value): void
    {
        static::validateInt($value);
    }
}