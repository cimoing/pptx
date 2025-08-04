<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

use Imoing\Pptx\Util\Emu;

class STCoordinate32 extends BaseSimpleType
{
    public static function convertFromXml($xmlValue): Emu
    {
        if (str_contains($xmlValue, 'i') || str_contains($xmlValue, 'm') || str_contains($xmlValue, 'p')) {
            return STCoordinate32Unqualified::convertFromXml($xmlValue);
        }

        return new Emu(intval($xmlValue));
    }

    public static function convertToXml($value): string
    {
        return STCoordinate32Unqualified::convertToXml($value);
    }

    public static function validate($value): void
    {
        STCoordinate32Unqualified::validate($value);
    }
}