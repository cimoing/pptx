<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class BaseStringType extends BaseSimpleType
{
    public static function convertFromXml(string $xmlValue): string
    {
        return $xmlValue;
    }

    public static function convertToXml($value): string
    {
        return strval($value);
    }

    public static function validate(mixed $value): void
    {
        static::validateString($value);
    }
}