<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

class STHexColorRGB extends BaseStringType
{
    public static function convertFromXml($xmlValue): string
    {
        return strtoupper($xmlValue);
    }

    public static function validate($value): void
    {
        $strValue = static::validateString($value);

        if (strlen($strValue) != 6) {
            throw new \ValueError("Value must be a 6-character hexadecimal string, got $strValue");
        }
        try {
            $_ = intval($strValue, 16);
        }catch (\Exception $e) {
            throw new \ValueError("Value must be a 6-character hexadecimal string, got $strValue");
        }
    }
}