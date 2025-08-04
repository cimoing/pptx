<?php

namespace Imoing\Pptx\OXml\SimpleTypes;

use Imoing\Pptx\Util\Emu;

class STCoordinate extends BaseSimpleType
{
    public static function convertFromXml($xmlValue)
    {
        if (str_contains($xmlValue, 'i') || str_contains($xmlValue, 'm') || str_contains($xmlValue, 'p')) {
            return STUniversalMeasure::convertFromXml($xmlValue);
        }

        return new Emu(intval($xmlValue));
    }

    public static function convertToXml($value): string
    {
        return strval($value);
    }

    public static function validate($value): void
    {
        STCoordinateUnqualified::validate($value);
    }
}