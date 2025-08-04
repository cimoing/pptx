<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class BaseFloatType extends BaseSimpleType
{
    public static function convertFromXml(string $xmlValue): float
    {
        return floatval($xmlValue);
    }

    public static function convertToXml($value): string
    {
        return (string) floatval($value);
    }

    public static function validate($value)
    {
        if (!is_int($value) && !is_float($value)) {
            throw new \TypeError("Value must be a number, got " . gettype($value));
        }
    }
}