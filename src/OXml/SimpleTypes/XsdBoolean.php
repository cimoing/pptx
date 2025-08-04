<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class XsdBoolean extends BaseSimpleType
{
    public static function convertFromXml(string $xmlValue): bool
    {
        if (!in_array($xmlValue, ['true', 'false', '0', '1'])) {
            throw new \ValueError("Value must be one of true, false, 0, 1, got $xmlValue");
        }

        return $xmlValue === 'true' || $xmlValue === '1';
    }

    public static function convertToXml($value): string
    {
        return $value ? '1' : '0';
    }

    public static function validate(mixed $value): void
    {
        if (!in_array($value, [true, false])) {
            throw new \ValueError("only True or False (and possibly None) may be assigned, got $value");
        }
    }
}